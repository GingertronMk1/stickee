<?php

namespace App\Services;

use App\Models\PackCalculation;
use App\WidgetCounterInterface;

readonly class WidgetCounter implements WidgetCounterInterface
{
    /** @var array<int> */
    private array $packSizes;

    public function __construct(
        ?array $packSizes = null
    ) {
        $packSizes ??= config('widgets.packs');
        ksort($packSizes);
        $this->packSizes = $packSizes;
    }

    public function getWidgetPacks(int $widgetsOrdered): PackCalculation
    {
        try {
            $storedCalc = PackCalculation::where('pack_sizes', json_encode($this->getPackSizes()))
                ->where('widget_count', $widgetsOrdered)
                ->first();
        } catch (\Throwable $e) {
            $storedCalc = null;
        }

        if (! is_null($storedCalc)) {
            $packs = $storedCalc;
        } else {
            $packs = new PackCalculation([
                'pack_sizes' => $this->getPackSizes(),
                'widget_count' => $widgetsOrdered,
                'packs' => $this->recursiveGetPacks($widgetsOrdered, true),
            ]);
            $packs->save();
        }

        return $packs;
    }

    private function recursiveGetPacks(int $num, bool $firstRound)
    {
        $lookup = array_reverse($this->packSizes);
        $packsToSend = [];

        foreach ($lookup as $n) {
            while ($num >= $n) {
                $packsToSend[$n] = ($packsToSend[$n] ?? 0) + 1;
                $num -= $n;
            }
        }

        // Those cases where we don't quite get it
        if ($num > 0) {
            $smallest = min($lookup);
            $packsToSend[$smallest] = ($packsToSend[$smallest] ?? 0) + 1;
        }

        // Only doing one "round" of computation here
        if (! $firstRound) {
            return $packsToSend;
        }

        /**
         * Here we calculate the total number of widgets we're sending
         * We are confident that the above code works to send the least "extra" widgets
         * so we now run this total number of widgets back through the code to see if we
         * can send the same amount in fewer packs
         */
        $totalValue = 0;

        foreach ($packsToSend as $v => $n) {
            $totalValue += $v * $n;
        }

        $reDone = $this->recursiveGetPacks($totalValue, false);

        if (array_sum($reDone) < array_sum($packsToSend)) {
            return $reDone;
        }

        return $packsToSend;
    }

    public function getPackSizes(): array
    {
        return $this->packSizes;
    }
}

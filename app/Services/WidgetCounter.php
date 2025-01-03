<?php

namespace App\Services;

use App\WidgetCounterInterface;

readonly class WidgetCounter implements WidgetCounterInterface
{
    /** @var array<int> */
    private array $packCount;

    public function __construct(
        ?array $packCount = null
    ) {
        $packCount ??= config('widgets.packs');
        ksort($packCount);
        $this->packCount = $packCount;
    }

    public function getWidgetPacks(int $widgetsOrdered): array
    {
        return $this->recursiveGetPacks($widgetsOrdered, true);
    }

    private function recursiveGetPacks(int $num, bool $firstRound)
    {
        $lookup = array_reverse($this->packCount);
        $packsToSend = [];

        // Special case for those "exact match" situations
        if (in_array($num, $lookup)) {
            return [$num => 1];
        }

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
}

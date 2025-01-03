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
        $roman = [];

        // Special case for those "exact match" situations
        if (in_array($num, $lookup)) {
            return [$num => 1];
        }

        foreach ($lookup as $n) {
            while ($num > $n) {
                $roman[$n] = ($roman[$n] ?? 0) + 1;
                $num -= $n;
            }
        }

        // Those cases where we don't quite get it
        if ($num > 0) {
            $smallest = min($lookup);
            $roman[$smallest] = ($roman[$smallest] ?? 0) + 1;
        }

        if (! $firstRound) {
            return $roman;
        }

        $totalValue = 0;

        foreach ($roman as $v => $n) {
            $totalValue += $v * $n;
        }

        $reDone = $this->recursiveGetPacks($totalValue, false);

        if (array_sum($reDone) < array_sum($roman)) {
            return $reDone;
        }

        return $roman;
    }
}

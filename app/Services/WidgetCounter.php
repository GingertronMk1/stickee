<?php

namespace App\Services;

use App\WidgetCounterInterface;

class WidgetCounter implements WidgetCounterInterface
{

    public function getWidgetPacks(int $widgetsOrdered): array
    {
        return [];
    }
}

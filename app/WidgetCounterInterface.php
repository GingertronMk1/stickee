<?php

namespace App;

use App\Models\PackCalculation;

interface WidgetCounterInterface
{
    public function getWidgetPacks(int $widgetsOrdered): PackCalculation;

    public function getPackSizes(): array;
}

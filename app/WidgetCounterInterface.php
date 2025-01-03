<?php

namespace App;

interface WidgetCounterInterface
{
    public function getWidgetPacks(int $widgetsOrdered): array;
}

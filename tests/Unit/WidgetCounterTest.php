<?php

$counter = new \App\Services\WidgetCounter([
    250, 500, 1000, 2000, 5000,
]);

$results = [
    1 => [250 => 1],
    250 => [250 => 1],
    251 => [500 => 1],
    500 => [500 => 1],
    501 => [500 => 1, 250 => 1],
    1000 => [1000 => 1],
    2000 => [2000 => 1],
    3000 => [1000 => 1, 2000 => 1],
    4000 => [2000 => 2],
    12001 => [5000 => 2, 2000 => 1, 250 => 1],
];

foreach ($results as $widgets => $output) {
    test(
        "Test for {$widgets} widgets",
        function () use ($counter, $widgets, $output) {
            expect($counter->getWidgetPacks($widgets))->toBe($output);
        }
    );
}

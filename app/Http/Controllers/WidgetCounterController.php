<?php

namespace App\Http\Controllers;

use App\WidgetCounterInterface;
use Illuminate\Http\Request;

class WidgetCounterController extends Controller
{
    public function __construct(
        private readonly WidgetCounterInterface $counter
    )
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $widgets = $request->get('widgets', 0);
        $packs = null;
        if ($widgets > 0) {
            $packs = $this->counter->getWidgetPacks($widgets);
        }

        return inertia('Widgets/Counter', [
            'widgets' => $widgets,
            'packs' => $packs
        ]);
    }
}

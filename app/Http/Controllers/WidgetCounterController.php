<?php

namespace App\Http\Controllers;

use App\WidgetCounterInterface;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class WidgetCounterController extends Controller
{
    public function __construct(
        private readonly WidgetCounterInterface $counter
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response|ResponseFactory
    {
        $widgets = $request->get('widgets', 0);
        $packs = $this->counter->getWidgetPacks($widgets);

        return inertia('Widgets/Counter', [
            'widgets' => $widgets,
            'packs' => $packs,
            'lookedUp' => ! $packs->wasRecentlyCreated,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\WidgetCounterRequest;
use App\WidgetCounterInterface;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class WidgetCounterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(WidgetCounterRequest $request, WidgetCounterInterface $counter): Response|ResponseFactory
    {
        $widgets = $request->get('widgets', 0);
        $packs = $counter->getWidgetPacks($widgets);

        return inertia('Widgets/Counter', [
            'widgets' => $widgets,
            'packs' => $packs,
            'lookedUp' => ! $packs->wasRecentlyCreated,
        ]);
    }
}

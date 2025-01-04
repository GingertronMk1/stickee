<?php

namespace App\Providers;

use App\Services\WidgetCounter;
use App\WidgetCounterInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WidgetCounterInterface::class, WidgetCounter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        DB::listen(function ($query) {
            Log::info($query->sql, $query->bindings);
        });
    }
}

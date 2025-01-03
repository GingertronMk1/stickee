<?php

namespace App\Console\Commands;

use App\WidgetCounterInterface;
use Illuminate\Console\Command;

class WidgetCounterCommand extends Command
{
    public function __construct(
        private readonly WidgetCounterInterface $widgetCounter
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:widget-counter-command {widgets}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the packs for a given number of widgets';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $widgetCount = $this->argument('widgets');
        $result = $this->widgetCounter->getWidgetPacks($widgetCount);
        $table = [];

        foreach ($result as $pack => $number) {
            if ($number === 0) {
                continue;
            }
            $table[] = [$pack, $number];
        }

        $this->table(
            ['Pack Size', 'Count'],
            $table
        );

        return self::SUCCESS;
    }
}

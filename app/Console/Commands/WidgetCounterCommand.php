<?php

namespace App\Console\Commands;

use App\WidgetCounterInterface;
use Illuminate\Console\Command;

class WidgetCounterCommand extends Command
{
    public function __construct(
        private readonly WidgetCounterInterface $widgetCounter
    )
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:widget-counter-command';

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
        $this->getOutput()->listing($this->widgetCounter->getWidgetPacks(1));
        return self::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-event-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Event::chunk(100, function ($events) {
            foreach ($events as $event) {
                $event->updateStatus();
            }
        });
        
        $this->info('Event status updated successfully!');
    }
}

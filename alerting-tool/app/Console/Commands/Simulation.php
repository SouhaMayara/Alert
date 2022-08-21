<?php

namespace App\Console\Commands;

use App\Models\CoreAlarm;
use Illuminate\Console\Command;

class Simulation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Simulation:Monitor {--run=add_alarm}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate a new Alarm as it should be generated with an API!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $runMode = $this->option( 'run' );
        switch( strtolower($runMode) )
        {
            case 'add_alarm':
                CoreAlarm::create([
                    'message' => 'Generated Message from Simulation',
                ]);
                break;
        }
    }
}

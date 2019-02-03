<?php

namespace App\Console\Commands;

use App\Console\Crontabs\AlpacaDaemon;
use Illuminate\Console\Command;

class CrontabCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crontab';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'crontab is a efficient timing tasks';

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
     * @return mixed
     */
    public function handle()
    {
        (new AlpacaDaemon)->stop();
    }
}

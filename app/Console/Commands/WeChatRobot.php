<?php

namespace App\Console\Commands;

use App\Http\Controllers\V1\Admin\Wechat\Vbot\VbotController;
use Illuminate\Console\Command;

class WeChatRobot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vbot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        (new VbotController())->config();
    }
}

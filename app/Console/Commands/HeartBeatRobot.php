<?php

namespace App\Console\Commands;

use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Model\V1\Robot\WxRobotModel;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class HeartBeatRobot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heartBeatRobot';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function handle()
    {
        //
        Log::info("[" . date("Y-m-d H:i:s") . "]|error Info: test");
    }
}

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
        $heartBeatLists = (new WxRobotModel())->where("status",1)->getHump();
        foreach ($heartBeatLists as $item){
            $client = new Client();
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Login/CheckLogin/' . $item["uuid"], [
                'form_params' => ["uuid" => $item["uuid"]]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"] ==  false) {
                (new WxRobotModel())->where("wxid",$item["wxid"])->update(["status" => 0]);
                continue;
            }
            if (empty($res["Data"]["WxId"])){
                (new WxRobotModel())->where("wxid",$item["wxid"])->update(["status" => 0]);
                continue;
            }
            $client = new Client();
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Login/HeartBeat/' . $item["wxid"]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"] == false){
                Log::info("[" . date("Y-m-d H:i:s") . "]|error Info:" . $res["Message"]);
            }
        }
    }
}

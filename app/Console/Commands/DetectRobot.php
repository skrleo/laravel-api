<?php

namespace App\Console\Commands;

use App\Libraries\classes\JdUnion\FormatData;
use App\Libraries\classes\JdUnion\JdInterface;
use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Logic\V1\Common\Robot\InstructRobot;
use App\Model\V1\Robot\WxRobotModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DetectRobot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detectRobot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '微信机器人指令';

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
        for ($i = 1; $i <= 20; $i++) {
            $wxRobotModel = (new WxRobotModel())->where("status",0)->get()->toArray();
            foreach ($wxRobotModel as $item){
                $lists = (new MessageLogic())->syncMessage($item["wxid"]);
                foreach ($lists as $list) {
                    // 机器人指令
                    InstructRobot::basePoint($list, $item["wxid"]);
                    // 机器人群管理
                    InstructRobot::groupPoint($list, $item["wxid"]);
                    // 是否有新的好友
                    InstructRobot::friendVerify($list, $item["wxid"]);
                }
                sleep(3);
            }
        }
    }
}

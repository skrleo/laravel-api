<?php

namespace App\Console\Commands;

use App\Libraries\classes\JdUnion\FormatData;
use App\Libraries\classes\JdUnion\JdInterface;
use App\Logic\V1\Admin\Robot\MessageLogic;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class WeChatRobot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect-message';

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
     * 发送微信消息
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            $param = ["methodType" => 'jingfen'];
            $data = ['eliteId' => 21, 'pageIndex' => 1, 'pageSize' => 20];
            $param["param_json"]["goodsReq"] = $data;
            $data = JdInterface::getInstance($param)->setRequestParam()->execute();
            $lists = FormatData::getInit()->headleOptional($data["data"]);
            foreach ($lists as $k => $v){
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => ["18232990803@chatroom"],
                    "content" => $v["goods_name"] . "\n【原价】￥{$v["goods_price"]} \n【限时抢券后价】￥{$v["coupon_price"]}\n------------------\n【购买链接】{$v["material_url"]}\n【购买方式】长按图片『识别二维码』或点击『购买链接』即可领券下单",
                    "wxId" => "wxid_jn6rqr7sx35322"
                ]);
                // 发送微信图片消息
                (new MessageLogic())->sendImageMessage([
                    "toWxIds" => ["18232990803@chatroom"],
                    "imgUrl" => $v["goods_thumb"],
                    "wxId" => "wxid_jn6rqr7sx35322"
                ]);
            }
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}

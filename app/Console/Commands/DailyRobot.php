<?php

namespace App\Console\Commands;

use App\Libraries\classes\DuoduoUnion\DuoduoInterface;
use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Model\V1\Robot\WxRobotGoodsModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyRobot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyRobot';

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
     * @throws \ReflectionException
     */
    public function handle()
    {
        if (!in_array(Carbon::now()->hour, [0, 1, 2, 3, 4, 5, 6, 7])) {
            try {
                $wxRobotGoodsModel = (new WxRobotGoodsModel())->where('status',0)->firstHump();
                $couponPrice = bcsub($wxRobotGoodsModel["currentPrice"],$wxRobotGoodsModel["couponDiscount"],2);
                $params = ["p_id" => '9569620_127591192', "goods_id_list" => json_encode([$wxRobotGoodsModel["itemid"]])];
                $generate = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.promotion.url.generate');
                $generateLists = $generate["goods_promotion_url_generate_response"]["goods_promotion_url_list"];
                foreach ($generateLists as $key => $list){
                    //  发送微信文本消息
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => ["24306455304@chatroom"],
                        "content" => '『拼夕夕』' . $wxRobotGoodsModel["name"] . "\n【原价】￥{$wxRobotGoodsModel["currentPrice"]} \n【限时抢券后价】￥{$couponPrice}\n------------------\n【购买链接】{$list["short_url"]}\n【购买方式】点击『购买链接』即可领券下单",
                        "wxId" => "wxid_jn6rqr7sx35322"
                    ]);
                    // 发送微信图片消息
                    (new MessageLogic())->sendImageMessage([
                        "toWxIds" => ["24306455304@chatroom"],
                        "imgUrl" => $wxRobotGoodsModel["picUrl"],
                        "wxId" => "wxid_jn6rqr7sx35322"
                    ]);
                }
                (new WxRobotGoodsModel())->where("robot_goods_id",$wxRobotGoodsModel["robotGoodsId"])->update(["status" => 1]);
            } catch(\Throwable $e) {
                Log::info('Fail to call api');
            }
        }
    }
}

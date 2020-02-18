<?php

namespace App\Console\Commands;

use App\Libraries\classes\DuoduoUnion\DuoduoInterface;
use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Model\V1\Robot\WxRobotToGroupModel;
use App\Model\V1\Robot\WxRobotGoodsModel;
use App\Model\V1\Robot\WxRobotGroupModel;
use App\Model\V1\Robot\WxRobotModel;
use App\Model\V1\User\UserBaseModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
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
    protected $description = '每天固定时间-自动发单';

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
                $wxRobotGroupModel = (new WxRobotGroupModel())
                    ->where("status",0)
                    ->with([
                        'hasManyRobotToGroupModel' => function(HasOneOrMany $query){
                            $query->select('robot_id','group_id')->with([
                                'hasOneWxRobotModel' => function(HasOneOrMany $query){
                                    $query->select('id','uid','wxid',"status");
                                }
                            ]);
                        }
                    ])
                    ->getHump();
                $wxRobotGoodsModel = (new WxRobotGoodsModel())->where('status',0)->firstHump();
                $couponPrice = bcsub($wxRobotGoodsModel["currentPrice"],$wxRobotGoodsModel["couponDiscount"],2);
                foreach ($wxRobotGroupModel as $item){
                    $uids[] = $item["hasManyRobotToGroupModel"][0]["hasOneWxRobotModel"]["uid"];
                }
                $userBaseModel = (new UserBaseModel())->select("uid","p_id")->whereIn("uid",array_unique($uids))->getHump();
                foreach ($userBaseModel as $item){
                    $params = ["p_id" => $item["pId"], "goods_id_list" => json_encode([$wxRobotGoodsModel["itemid"]])];
                    $generate = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.promotion.url.generate');
                    $generateLists[$item["uid"]] = $generate["goods_promotion_url_generate_response"]["goods_promotion_url_list"];
                }
                foreach ($wxRobotGroupModel as $item){
                    foreach ($item["hasManyRobotToGroupModel"] as $v){
                        $shortUrl = $generateLists[$v["hasOneWxRobotModel"]["uid"]][0]["short_url"];
                        //  发送微信文本消息
                        (new MessageLogic())->sendTxtMessage([
                            "toWxIds" => [$item["groupAlias"]],
                            "content" => '『拼夕夕』' . $wxRobotGoodsModel["name"] . "\n【原价】￥{$wxRobotGoodsModel["currentPrice"]} \n【限时抢券后价】￥{$couponPrice}\n------------------\n【购买链接】{$shortUrl}\n【购买方式】点击『购买链接』即可领券下单",
                            "wxId" => $v["hasOneWxRobotModel"]["wxid"]
                        ]);
                        // 发送微信图片消息
                        (new MessageLogic())->sendImageMessage([
                            "toWxIds" => [$item["groupAlias"]],
                            "imgUrl" => $wxRobotGoodsModel["picUrl"],
                            "wxId" => $v["hasOneWxRobotModel"]["wxid"]
                        ]);
                    }
                }
                (new WxRobotGoodsModel())->where("robot_goods_id",$wxRobotGoodsModel["robotGoodsId"])->update(["status" => 1]);
            } catch(\Throwable $e) {
                Log::info('Fail to call api');
            }
        }
    }
}

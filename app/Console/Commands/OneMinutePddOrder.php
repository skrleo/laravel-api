<?php

namespace App\Console\Commands;

use App\Libraries\classes\DuoduoUnion\DuoduoInterface;
use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Model\V1\Order\WxRobotOrderModel;
use App\Model\V1\User\UserBaseModel;
use App\Model\V1\User\UserWalletsModel;
use Illuminate\Console\Command;

class OneMinutePddOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pddOrder:oneMinute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拼多多联盟-订单查询-每分钟跑一次';

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
        ini_set("memory_limit", "512M");

        $params = [
            "start_time" => date ('Y-m-d H:i:s', strtotime ('-20 minute', time())),
            "end_time" => date('Y-m-d H:i:s',time())
        ];
        $lists = DuoduoInterface::getInstance($params)->request('pdd.ddk.order.list.range.get');
        $orderLists = $lists["order_list_get_response"]["order_list"];
        // 判断数据是否存在
        $orderIds = collect($orderLists)->pluck('order_sn')->all();
        $getOrderIds = (new WxRobotOrderModel())->byOrderIdGetList($orderIds);
        $pidsArr = collect($orderLists)->pluck('p_id')->all();
        $userBaseModel = (new UserBaseModel())->whereIn("p_id",array_unique($pidsArr))->select("uid","p_id")->get()->toArray();
        $orderDatas = array();
        $orderUpdateDatas = array();
        foreach ($orderLists as $list){
            $subUid = array_search($list["p_id"],array_column($userBaseModel,"p_id"),true);
            $data = [
                "uid" => $userBaseModel[$subUid]["uid"],
                "itemid" => strval($list["goods_id"]),
                "goods_name" => $list["goods_name"],
                "buy_num" => $list["goods_quantity"],
                "cpa_new" => $list["cpa_new"],
                "goods_price" => bcdiv($list["goods_price"],100,2),
                "order_amount" => bcdiv($list["order_amount"],100,2),
                "thumb_url" => $list["goods_thumbnail_url"],
                "order_status" => $list["order_status"],
                "order_sn" => $list["order_sn"],
                "order_status_desc" => $list["order_status_desc"],
                "order_pay_time" => $list["order_pay_time"],
                "order_modify_at" => $list["order_modify_at"],
                "promotion_amount" => bcdiv($list["promotion_amount"],100,2),
                "promotion_rate" => $list["promotion_rate"],
                "p_id" => $list["p_id"],
                "type" => $list["type"],
                "created_at" => time(),
                "updated_at" => time()
            ];
            if (!isset($getOrderIds[$list['order_sn']])) {
                // 新增的数据
                $orderDatas[$userBaseModel[$subUid]["uid"]][] = $data;
            } else {
                // 更新的数据
                $orderUpdateDatas[] = $data;
            }

        }
        // 插入数据
        foreach ($orderDatas as $uid => $lists){
            // 更新个人账户收益
            $userWalletsModel = (new UserWalletsModel())->firstOrCreate(["uid" => $uid]);
            foreach ($lists as $item){
                $userWalletsModel->increment("balance",$item["promotion_amount"]);
                // 发送微信消息提醒
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => ["wxid_ibhxst4mklvj22"],
                    "content" => "恭喜你，又有一笔购物收入！订单号{$item["order_sn"]},预计收入{$item["promotion_amount"]}元~",
                    "wxId" => "wxid_jn6rqr7sx35322"
                ]);
            }
            // 插入订单数据
            (new WxRobotOrderModel())->batchInsertData($uid,$lists);
        }
        // 更新订单
        foreach ($orderUpdateDatas as $key => $value) {
            (new WxRobotOrderModel())->setTable($value['uid'])->where([['order_sn', '=', $value['order_sn']]])->update($value);
        }

    }
}

<?php
/**
 * 指令机器人
 * User: chen
 * Date: 2020/2/14
 * Time: 13:08
 */

namespace App\Logic\V1\Common\Robot;


use App\Libraries\classes\CreateUnion;
use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Model\V1\User\UserBaseModel;
use Illuminate\Support\Facades\Redis;

class InstructRobot
{
    /**
     *  机器人指令
     *
     * @param $list
     * @param $wxId
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public static function basePoint($list, $wxId)
    {
        if ($list["FromUserName"]["String"] <> $wxId && strpos($list["FromUserName"]["String"], '@chatroom') == false) {
            if (strpos($list["Content"]["String"], '查找') !== false) {
                $keyWord = mb_substr(strstr($list["Content"]["String"], '查找'), 3);
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "暂不支持查找商品！待开发中···",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"], '我想要发单机器人') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "--------如何躺赚--------\n\n首先你想拥有机器人必须绑定你的上级，所以你要发送上级邀请码，即可绑定你的上级。如：上级邀请码GF1314",
                    "wxId" => $wxId
                ]);
                $data = ["wxid" => $list["FromUserName"]["String"]];
                Redis::setex("applyRobot:" . $list["FromUserName"]["String"], 60 * 60 * 24, json_encode($data));
            }

            if (strpos($list["Content"]["String"], '上级邀请码') !== false) {
                // 判断是否申请微信机器人
                $applyRobot = Redis::get("applyRobot:" . $list["FromUserName"]["String"]);
                $userBaseModel = (new UserBaseModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                if (!empty($applyRobot) && empty($userBaseModel)) {
                    $invitationCode = CreateUnion::invitation_code(6);
                    (new UserBaseModel())->insert([
                        "wxid" => $list["Content"]["String"],
                        "name" => explode(":",$list["PushContent"])["0"],
                        "password" => md5($invitationCode),
                        "import_code" => mb_substr($list["Content"]["String"], 5),
                        "invitation_code" => $invitationCode,
                    ]);
                    $content = "已成功绑定你的上级" . $list["Content"]["String"];
                } elseif (!empty($userBaseModel)) {
                    $content = "你已经申请过发单机器人了，快拉群分享发单吧！";
                }else{
                    $content = "你还未申请发单机器人，请回复\"我想要发单机器人\"来获取吧！";
                }
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => $content,
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"], '我的邀请码') !== false) {
                $userBaseModel = (new UserBaseModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你的邀请码是：{$userBaseModel["invitation_code"]}, 快邀请好友一起来加入我们吧",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"], '余额') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你当前的余额为 18.00 元，可提现的金额为8.00元，快分享商品赚钱吧",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"], '提现') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你的提现申请已收到，将在24小时内发送到你微信账户",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"], '下级') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你当前有2个用户，预计为你赚到240.00元",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"], '关于结算') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你当前账户有28.00元待结算，每月的20月结算上个月的佣金金额，还请你耐心等候。",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"], '帮助') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "--------帮助--------\n\n发送 \"余额\"即可查询你的余额\n发送 \"提现\"即可提现你的余额\n发送 \"下级\"即可查询你的下级\n发送 \"关于结算\"即可查询结算明细\n\n----------------\n\n 如有疑问请留言:",
                    "wxId" => $wxId
                ]);
            }
        }

    }
}
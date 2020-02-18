<?php
/**
 * 指令机器人
 * User: chen
 * Date: 2020/2/14
 * Time: 13:08
 */

namespace App\Logic\V1\Common\Robot;


use App\Libraries\classes\CreateUnion;
use App\Logic\V1\Admin\Robot\FriendLogic;
use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Model\V1\User\UserBaseModel;
use App\Model\V1\User\UserToRobotModel;
use App\Model\V1\User\UserWalletsModel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
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
        if (!empty($list["Content"]["String"]) && !empty($list["PushContent"])) {
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
                    $userToRobotModel = (new UserToRobotModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                    if (empty($userToRobotModel)){
                        $content = "--------如何躺赚--------\n\n首先你想拥有机器人必须绑定你的上级，所以你要发送上级邀请码，即可绑定你的上级。如：上级邀请码GF1314";
                        $data = ["wxid" => $list["FromUserName"]["String"]];
                        Redis::setex("applyRobot:" . $list["FromUserName"]["String"], 60 * 60 * 24, json_encode($data));
                    } else {
                        $content = "你已经成功申请了发单机器人，快去设置微信群发单赚钱吧！";
                    }
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => $content,
                        "wxId" => $wxId
                    ]);
                }

                if (strpos($list["Content"]["String"], '上级邀请码') !== false) {
                    // 判断是否申请微信机器人
                    $applyRobot = Redis::get("applyRobot:" . $list["FromUserName"]["String"]);
                    $info = explode(":", $list["PushContent"]);
                    $userBaseModel = (new UserBaseModel())->where(["invitation_code" => mb_substr($info[1], 6)])->firstHump();
                    $userToRobotModel = (new UserToRobotModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                    if (empty($userBaseModel))  {
                        $content = "你输入的上级邀请码不存在，请查证之后再输入";
                    } elseif (!empty($applyRobot) && empty($userToRobotModel)){
                        $invitationCode = CreateUnion::invitation_code(6);
                        $userBaseModel = new UserBaseModel();
                        $userBaseModel->wxid = $list["FromUserName"]["String"];
                        $userBaseModel->name = $info["0"];
                        $userBaseModel->password = md5($invitationCode);
                        $userBaseModel->import_code = mb_substr($info[1], 6);
                        $userBaseModel->invitation_code = $invitationCode;
                        $userBaseModel->save();
                        (new UserToRobotModel())->insert([
                            "wxid" => $list["FromUserName"]["String"],
                            "nickname" => $info["0"],
                            "uid" => $userBaseModel->getQueueableId()
                        ]);
                        $content = "已成功绑定你的上级邀请码" . mb_substr($info[1], 6);
                    } elseif (!empty($userToRobotModel)) {
                        $content = "你已经申请过发单机器人了，快拉群分享发单吧！";
                    } else {
                        $content = "你还未申请发单机器人，请回复\"我想要发单机器人\"来获取吧！";
                    }
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => $content,
                        "wxId" => $wxId
                    ]);
                }

                if (strpos($list["Content"]["String"], '我的邀请码') !== false) {
                    $userToRobotModel = (new UserToRobotModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                    if(empty($userToRobotModel)){
                        $content = "你还未申请发单机器人，请回复\"我想要发单机器人\"来获取吧！";
                    }else {
                        $userBaseModel = (new UserBaseModel())->where("uid",$userToRobotModel->uid)->firstHump();
                        $content = "你的邀请码是：{$userBaseModel["invitationCode"]}, 快邀请好友一起来加入我们吧";
                    }
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => $content,
                        "wxId" => $wxId
                    ]);
                }

                if (strpos($list["Content"]["String"], '余额') !== false) {
                    $userToRobotModel = (new UserToRobotModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                    if(empty($userToRobotModel)){
                        $content = "你还未申请发单机器人，请回复\"我想要发单机器人\"来获取吧！";
                    }else {
                        $userWalletsModel = (new UserWalletsModel())->where("uid",$userToRobotModel->uid)->firstHump();
                        if (!empty($userWalletsModel)){
                            $userWalletsModel = $userWalletsModel->toArray();
                            $content = "你当前的余额为 {$userWalletsModel["balance"]} 元，可提现的金额为{$userWalletsModel["canWithdraw"]}元，快分享商品赚钱吧";
                        }else{
                            $content = "你当前还未有任何收入，赶紧去分享商品赚钱吧！";
                        }
                    }
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => $content,
                        "wxId" => $wxId
                    ]);
                }

                if (strpos($list["Content"]["String"], '提现') !== false) {
                    $userToRobotModel = (new UserToRobotModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                    if(empty($userToRobotModel)){
                        $content = "你还未申请发单机器人，请回复\"我想要发单机器人\"来获取吧！";
                    }else {
                        $content = "你的提现申请已收到，将在24小时内将通过微信红包发送到你微信账户";
                    }
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => $content,
                        "wxId" => $wxId
                    ]);
                }

                if (strpos($list["Content"]["String"], '下级') !== false) {
                    $userToRobotModel = (new UserToRobotModel())->where(["wxid" => $list["FromUserName"]["String"]])->firstHump();
                    if(empty($userToRobotModel)){
                        $content = "你还未申请发单机器人，请回复\"我想要发单机器人\"来获取吧！";
                    }else {
                        $content = "你当前有两个下级用户，累计为你赚到152.00元，快推荐好友来为你赚钱吧";
                    }
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => $content,
                        "wxId" => $wxId
                    ]);
                }

                if (strpos($list["Content"]["String"], '关于结算') !== false) {
                    //  发送微信文本消息
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => "每月的20月结算上个月的佣金金额，还请你耐心等候。",
                        "wxId" => $wxId
                    ]);
                }

                if (strpos($list["Content"]["String"], '帮助') !== false) {
                    //  发送微信文本消息
                    (new MessageLogic())->sendTxtMessage([
                        "toWxIds" => [$list["FromUserName"]["String"]],
                        "content" => "--------帮助--------\n\n发送 \"余额\"即可查询你的余额\n发送 \"提现\"即可提现你的余额\n发送 \"下级\"即可查询你的下级\n发送 \"关于结算\"即可查询结算",
                        "wxId" => $wxId
                    ]);
                }
            }
        }
    }

    /**
     * 微信群管理
     *
     * @param $list
     * @param $wxId
     */
    public static function groupPoint($list, $wxId)
    {

    }

    /**
     *  通过微信好友验证
     *
     * @param $list
     * @param $wxId
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public static function friendVerify($list, $wxId)
    {
        if ($list["ToUserName"]["String"] == $wxId && $list["MsgType"] == 37 ) {
            preg_match_all('/encryptusername=("[^"]*").*?ticket=("[^"]*")/i', $list["Content"]["String"], $matches);
            // 通过微信好友
            $res = (new FriendLogic())->passFriendVerify($wxId,$matches);
            if ($res["Success"]){
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$res["Data"]],
                    "content" => "你已经加我为好友！",
                    "wxId" => $wxId
                ]);
            }
        }
    }
}
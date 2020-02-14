<?php
/**
 * 指令机器人
 * User: chen
 * Date: 2020/2/14
 * Time: 13:08
 */

namespace App\Logic\V1\Common\Robot;


use App\Logic\V1\Admin\Robot\MessageLogic;

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
    public static function basePoint($list,$wxId)
    {
        if ($list["FromUserName"]["String"] <> $wxId && strpos($list["FromUserName"]["String"],'@chatroom') == false){
            if (strpos($list["Content"]["String"],'查找') !== false) {
                $keyWord = mb_substr(strstr($list["Content"]["String"], '查找'), 3);
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "暂不支持查找商品！待开发中···",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"],'我想要发单机器人') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "--------如何躺赚--------\n\n首先你想拥有机器人必须绑定你的上级，所以你得输入你的上级邀请码，即可绑定你的上级。",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"],'余额') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你当前的余额为 0 元，快分享商品赚钱吧",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"],'提现') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你的提现申请已收到，将在24小时内发送到你微信账户",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"],'下级') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "你当前有2个用户，预计为你赚到240.00元",
                    "wxId" => $wxId
                ]);
            }

            if (strpos($list["Content"]["String"],'帮助') !== false) {
                //  发送微信文本消息
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$list["FromUserName"]["String"]],
                    "content" => "--------帮助--------\n\n发送 \"余额\"即可查询你当前账户的余额\n发送 \"提现\"即可提现你当前账户的余额\n发送 \"下级\"即可查询你当前账户的下级\n------------\n 如有疑问请留言:",
                    "wxId" => $wxId
                ]);
            }
        }

    }
}
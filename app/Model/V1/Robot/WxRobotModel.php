<?php
/**
 * 微信信息
 * User: chen
 * Date: 2020/2/8
 * Time: 13:29
 */

namespace App\Model\V1\Robot;

use App\Model\Model;

class WxRobotModel extends Model
{
    protected $table = 'wx_robot';

    protected $primaryKey = 'id';

    protected $fillable = ["wxid"];

    /**
     * @param $data
     */
    public function checkWxInfo($data)
    {
        $heartBeatModel = (new self())->firstOrNew(["wxid" => $data["WxId"]]);
        $heartBeatModel->uuid = $data["Uuid"];
        $heartBeatModel->wxid = $data["WxId"];
        $heartBeatModel->nickname = $data["NickName"];
        $heartBeatModel->head_url = $data["HeadUrl"];
        $heartBeatModel->alias = $data["Alias"] ?? '';
        $heartBeatModel->status = 1;
        $heartBeatModel->save();
    }

}
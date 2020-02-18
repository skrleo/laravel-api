<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/17
 * Time: 12:20
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\V1\Admin\Base\BaseLogic;
use App\Model\V1\Robot\WxRobotGroupModel;
use App\Model\V1\Robot\WxRobotModel;
use App\Model\V1\Robot\WxRobotToGroupModel;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Log;

class RobotGroupLogic extends BaseLogic
{
    protected $groupUrl;

    protected $wxid;

    protected $name;

    protected $robotId;

    public $uid;

    public function lists()
    {
        $res = (new WxRobotGroupModel())
            ->whereHas('hasManyRobotToGroupModel', function (EloquentBuilder $query){
                $query->where('robot_id',$this->robotId);
            })
            ->latest('created_at')
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * 入群通知
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store()
    {
        $client = new Client();
        try {
            $wxRobotModel = (new WxRobotModel())->where("id",$this->robotId)->firstHump();
            if(empty($wxRobotModel)){
                throw new Exception("微信机器人不存在","NOT_FIND_ROBOT");
            }
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Group/ScanIntoGroupBase64', [
                'form_params' => [
                    "base64" => imgToBase64($this->groupUrl),
                    "wxId" => $wxRobotModel->wxid,
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]) {
                $wxRobotGroupModel = new WxRobotGroupModel();
                $wxRobotGroupModel->uid = $this->uid;
                $wxRobotGroupModel->name = $this->name;
                $wxRobotGroupModel->group_alias = $res["Data"];
                $wxRobotGroupModel->save();
                (new WxRobotToGroupModel())->insert([
                    "robot_id" => $this->robotId,
                    "group_id" => $wxRobotGroupModel->getQueueableId()
                ]);
                // 入群通知
                (new MessageLogic())->sendTxtMessage([
                    "toWxIds" => [$res["Data"]],
                    "content" => "大家好，我是『自购省钱，分享赚钱』的小助手,我将分享许多的优惠商品给大家~",
                    "wxId" => $wxRobotModel->wxid
                ]);
                return [];
            }
            return ["code" => $res["Code"], "message" => $res['Message']];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}
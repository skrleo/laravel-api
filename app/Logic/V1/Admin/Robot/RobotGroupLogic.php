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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RobotGroupLogic extends BaseLogic
{
    protected $groupUrl;

    protected $wxid;

    protected $name;

    public function lists()
    {
        $res = (new WxRobotGroupModel())
//            ->where("robot_id",$this->robotId)
//            ->when(!empty($this->uid),function (EloquentBuilder $query){
//                $query->where('uid',$this->uid);
//            })
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
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Group/ScanIntoGroupBase64', [
                'form_params' => [
                    "base64" => imgToBase64($this->groupUrl),
                    "wxId" => $this->wxid,
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]) {
                (new WxRobotGroupModel())->insert([
                    "name" => $this->name,
                    "group_alias" => $res["Data"],
                    "created_at" =>time()
                ]);
                return [];
            }
            return ["code" => $res["Code"], "message" => $res['Message']];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}
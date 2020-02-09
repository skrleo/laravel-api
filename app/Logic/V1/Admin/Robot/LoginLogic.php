<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/1/28
 * Time: 10:27
 */

namespace App\Logic\V1\Admin\Robot;


use App\Http\Middleware\ClientIp;
use App\Jobs\HeartBeatRobot;
use App\Libraries\classes\ProxyIP\GetProxyIP;
use App\Logic\V1\Admin\Base\BaseLogic;
use App\Model\V1\Robot\WxRobotModel;
use DdvPhp\DdvUtil\Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class LoginLogic extends BaseLogic
{
    protected $uuid = '';

    protected $wxId = '';

    /**
     * 获取QRCode
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function getQrcode()
    {
        $client = new Client();
            $res = $client->request('POST', 'http://114.55.164.90/api/Login/GetQrCode', [
                'form_params' => [
                    "proxyIp" => "113.64.197.190:4287",
                    "proxyUserName" => "zhima",
                    "proxyPassword" => "zhima",
                    "deviceId" => "243d854c-aaaf-4f4d-8c95-222825867ee8",
                    "deviceMac" => "iPad Pro",
                    "deviceName" => "iPad"
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"] ==  false){
                throw new Exception($res["Message"],'PROXY_TIME_OUT');
            }
            return $res["Data"];
    }

    /**
     * 检查是否登录
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkLogin()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/Login/CheckLogin/' . $this->uuid, [
                'form_params' => ["uuid" => $this->uuid]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]) {
                if (empty($res["Data"]["WxId"])){
                    return ["code" => "402", "message" => "等待微信扫描"];
                }
                // 更新微信信息
                (new WxRobotModel())->checkWxInfo($res["Data"]);
                // 心跳队列
                $client = new Client();
                $client->request('POST', 'http://114.55.164.90/api/HeartBeat/StartHeartBeat/' .$res["Data"]["WxId"]);
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"], "message" => $res['Message']];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 退出登录
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function loginOut()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/Login/LogOut/' . $this->wxId);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 启动自动心跳
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function startHeartBeat()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/HeartBeat/StartHeartBeat/' . $this->wxId);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function closeHeartBeat()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/HeartBeat/CloseHeartBeat/' . $this->wxId);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 心跳状态
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stateHeartBeat()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/HeartBeat/StateHeartBeat/' . $this->wxId);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 二次登录
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function twiceLogin()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/Login/TwiceLogin', [
                'form_params' => ["wxId" => $this->wxId]
            ]);
            $res = $res->getBody()->getContents();
            return $res;
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 初始化好友
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function initUser()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/Login/InitUser', [
                'form_params' => ["initMsg" => $this->initMsg]
            ]);
            $res = $res->getBody()->getContents();
            return $res;
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 初始化用户
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function newInit()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/Login/NewInit', [
                'form_params' => ["wxId" => $this->wxId]
            ]);
            $res = $res->getBody()->getContents();
            return $res;
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }


}
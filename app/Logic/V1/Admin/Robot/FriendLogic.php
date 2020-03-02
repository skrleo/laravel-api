<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/5
 * Time: 1:23
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\Exception;
use App\Logic\V1\Admin\Base\BaseLogic;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FriendLogic extends BaseLogic
{
    protected $wxId;

    protected $searchWxName;

    protected $friends = [];

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchWxName()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Friend/Search/'. $this->wxId .'/'.$this->searchWxName);
            $res = json_decode($res->getBody()->getContents(),true);
            return $res["Data"]["AddMsgs"];
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function contractList()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Friend/GetContractList',[
                'form_params' => [
                    "currentWxcontactSeq" => "0",
                    "currentChatRoomContactSeq" => "0",
                    "wxId" => $this->wxId,
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(),true);
            return $res["Data"]["AddMsgs"];
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * @return mixed
     */
    public function getContractDetail()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Message/Sync/'. $this->wxId);
            $res = json_decode($res->getBody()->getContents(),true);
            return $res["Data"]["AddMsgs"];
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 通过好友验证
     *
     * @param $wxId
     * @param $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function passFriendVerify($wxId,$data)
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Friend/PassFriendVerify', [
                'form_params' => [
                    "userNameV1" => str_replace('"', '', $data[1][0]),
                    "antispamTicket" => str_replace('"', '', $data[2][0]),
                    "content" => "测试",
                    "origin" => 3,
                    "wxId" => $wxId,
                ]
            ]);
            return json_decode($res->getBody()->getContents(), true);
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 批量添加微信好友
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function batchAddFriend()
    {
        try {
            $friendDates = $this->getFriendDetail($this->wxId,$this->friends);
            $client = new Client();
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/Friend/AddFriendRequestList', [
                'form_params' => [
                    "content" => $this->content ?? '添加你为好友',
                    "origin" => $this->origin ?? 3,
                    "friends" => $friendDates,
                    "wxId" => $this->wxId,
                ]
            ]);
            $res =  json_decode($res->getBody()->getContents(), true);
            if ($res["Success"] ==  false){
                throw new Exception("添加微信好友失败","ADD_FRIEND_FAIL");
            }
            return true;
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 获取微信好友信息
     *
     * @param $wxId
     * @param $friends
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFriendDetail($wxId,$friends)
    {
        foreach ($friends as $key => $friend){
            $client = new Client();
            $res = $client->request('POST', "http://114.55.164.90:1697/api/Friend/SearchContract/{$wxId}/{$friend["account"]}", [
                'form_params' => [
                    "WxId" => $wxId,
                    "SearchWxName" => $friend["account"]
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            $data[$key]["userNameV1"] = $res["Data"]["userName"]["string"];
            $data[$key]["antispamTicket"] = $res["Data"]["antispamTicket"];
            $data[$key]["origin"] = 3;
        }
        return $data;
    }

}
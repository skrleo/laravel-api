<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/5
 * Time: 1:23
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\V1\Admin\Base\BaseLogic;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FriendLogic extends BaseLogic
{
    protected $wxId;

    protected $searchWxName;

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchWxName()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90/api/Friend/Search/'. $this->wxId .'/'.$this->searchWxName);
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
            $res = $client->request('POST', 'http://114.55.164.90/api/Friend/GetContractList',[
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
            $res = $client->request('POST', 'http://114.55.164.90/api/Message/Sync/'. $this->wxId);
            $res = json_decode($res->getBody()->getContents(),true);
            return $res["Data"]["AddMsgs"];
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

}
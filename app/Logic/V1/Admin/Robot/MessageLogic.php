<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/1/30
 * Time: 21:52
 */

namespace App\Logic\V1\Admin\Robot;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Logic\V1\Admin\Base\BaseLogic;

class MessageLogic extends BaseLogic
{
    protected $wxId = '';

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function syncMessage()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://106.15.235.187:1925/api/Message/Sync/'. $this->wxId);
            $res = json_decode($res->getBody()->getContents(),true);
            return $res["Data"]["AddMsgs"];
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 发送微信文本消息
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendTxtMessage($param)
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://106.15.235.187:1925/api/Message/SendTxtMessage',[
                'form_params' => [
                    "toWxIds" => $param["toWxIds"],
                    "content" => $param["content"],
                    "wxId" => $param["wxId"]
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(),true);
            if ($res["Code"] == 0){
                return true;
            }
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     *  发送图片消息
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendImageMessage($param = [])
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://106.15.235.187:1925/api/Message/SendImageMessage',[
                'form_params' => [
                    "toWxIds" => $param["toWxIds"],
                    "base64" => imgToBase64($param["imgUrl"]),
                    "wxId" => $param["wxId"],
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(),true);
            if ($res["Code"] == 0){
                return true;
            }
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}
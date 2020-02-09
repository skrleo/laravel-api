<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/9
 * Time: 21:25
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\V1\Admin\Base\BaseLogic;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PayLogic extends BaseLogic
{

    protected $wxId;

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stateRedEnvelopes()
    {
        $client = new Client();
        try {
            $res = $client->request('GET', 'http://114.55.164.90/api/Pay/StateOpenRedEnvelopes/' . $this->wxId);
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
    public function startRedEnvelopes()
    {
        $client = new Client();
        try {
            $res = $client->request('GET', 'http://114.55.164.90/api/Pay/StartOpenRedEnvelopes/' . $this->wxId);
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
    public function closeRedEnvelopes()
    {
        $client = new Client();
        try {
            $res = $client->request('GET', 'http://114.55.164.90/api/Pay/CloseOpenRedEnvelopes/' . $this->wxId);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}
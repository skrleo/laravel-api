<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/18
 * Time: 21:08
 */

namespace App\HelpTrait;


use GuzzleHttp\Client;

trait BroadcastHttpPush
{
    public function push($data)
    {
        $baseUrl = env('WEBSOCKET_BASEURL', 'http://localhost:6001/');
        $appId = env('WEBSOCKET_APPID', '0688b5f012108662');
        $key = env('WEBSOCKET_KEY', 'b2444f629035135ff3cdd1d9a7422aa7');
        $httpUrl = $baseUrl . 'apps/' . $appId . '/events?auth_key=' . $key;

        $client = new Client([
            'base_uri' => $httpUrl,
            'timeout' => 2.0,
        ]);
        $response = $client->post($httpUrl, [
            'json' => $data
        ]);
        $code = $response->getStatusCode();
    }
}
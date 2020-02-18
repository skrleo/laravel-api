<?php
/**
 * 好单库接口
 */
namespace App\Libraries\classes\Haodanku;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class HaodankuApi
{
    private static $objInit;

    const APP_KEY = "avsnkaoflasdu";

    const API_URL = "http://v2.api.haodanku.com";

    private function __construct()
    {
    }

    /**
     * 单例
     */
    public static function getInit()
    {
        if (isset(self::$objInit)) {
            return self::$objInit;
        }

        self::$objInit = new self();
        return self::$objInit;
    }

    /**
     * 今日值得买
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDeserveItem()
    {
        $client = new Client();
        try {
            $res = $client->request('GET', "http://v2.api.haodanku.com/get_deserve_item/apikey/avsnkaoflasdu");
            return json_decode($res->getBody()->getContents(),true);
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}

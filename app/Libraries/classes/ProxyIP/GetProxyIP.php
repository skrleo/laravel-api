<?php
/**
 * 芝麻代理IP
 * User: chen
 * Date: 2020/1/31
 * Time: 13:47
 */

namespace App\Libraries\classes\ProxyIP;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GetProxyIP
{

    /**
     * @var self[私有化实例]
     */
    protected static $instance;

    /**
     * 参数
     *
     * @var array
     */
    protected static $param = [];

    /**
     * 构造函数
     *
     * GetProxyIP constructor.
     */
    public function __construct()
    {

    }

    /**
     * 实例化对象
     *
     * @param $param
     * @return GetProxyIP
     */
    public static function getInstance($param)
    {
        self::$param = $param;

        if (!(self::$instance instanceof self)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute()
    {
        $client = new Client(['timeout' => 0]);
        $response = $client->request('get', 'http://webapi.http.zhimacangku.com/getip', [
            'query' => self::$param
        ]);
        $response = json_decode($response->getBody()->getContents(), true);
        if ($response["code"] <> 0) {
            Log::info("[" . date("Y-m-d H:i:s") . "]|error Info:" . $response["msg"]);
        }
        return $response["data"];
    }
}
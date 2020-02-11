<?php
/**
 * 拼多多联盟
 * User: chen
 * Date: 2020/1/22
 * Time: 19:26
 */

namespace App\Libraries\classes\DuoduoUnion;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DuoduoInterface
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
     * DuoduoInterface constructor.
     */
    public function __construct()
    {
        self::$param['client_id'] = Config::baseConfig()["client_id"];
        self::$param['sign_method'] = 'md5';
        self::$param['timestamp'] = strval(time());
    }

    /**
     * 实例化对象
     *
     * @param $param
     * @return DuoduoInterface
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
     * @param $params
     * @return string
     */
    private function signature($params) {
        $paramsStr = '';
        array_walk($params, function ($item, $key) use (&$paramsStr) {
            $paramsStr .= sprintf('%s%s', $key, $item);
        });

        $sign = strtoupper(md5(sprintf('%s%s%s',
            Config::baseConfig()["client_secret"],
            $paramsStr,
            Config::baseConfig()["client_secret"]
        )));

        return $sign;
    }

    /**
     * @param $method
     * @param $params
     * @param string $data_type
     * @return mixed|\Psr\Http\Message\ResponseInterface|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $data_type = 'JSON') {
        self::$param['type'] = $method;
        self::$param['data_type'] = $data_type;
        ksort(self::$param);		// 按照键名对关联数组进行升序排序
        self::$param['sign'] = $this->signature(self::$param);
        $client = new Client();
        try {
            $res = $client->request('POST', Config::API_URL, [
                'form_params' => self::$param,
                'timeout' => 1.5,
            ]);
            return json_decode($res->getBody(),true);
        } catch(\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}
<?php
/**
 * 京东联盟
 * User: chen
 * Date: 2020/1/6
 * Time: 22:44
 */

namespace App\Libraries\classes\JdUnion;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class JdInterface
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
     * JdInterface constructor.
     */
    public function __construct()
    {
         $baseConfig = Config::baseConfig();
         self::$param['app_key'] = $baseConfig["app_key"];
         self::$param['timestamp'] = date("Y-m-d H:i:s");
         self::$param['format'] = $baseConfig["format"];
         self::$param['sign_method'] = $baseConfig["sign_method"];
         self::$param['v'] = $baseConfig["version"];
    }

    /**
     * 实例化对象
     *
     * @param $param
     * @return JdInterface
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
     * 设置参数
     *
     * @return JdInterface
     */
    public function setRequestParam()
    {
        // 获取请求类型
        self::$param["method"] = Config::getMethodType()[self::$param['methodType']];
        unset(self::$param['methodType']);
        // 格式化参数
        self::$param["param_json"] = json_encode(self::$param["param_json"]);
        // 签名加密
        self::$param["sign"] = $this->generateSign(self::$param);
        return self::$instance;
    }

    /**
     * 生成加密签名
     *
     * @param $params
     * @return string
     */
    public function generateSign($params)
    {
        ksort($params);
        $stringToBeSigned = Config::baseConfig()["secret_key"];
        foreach ($params as $k => $v) {
            if (!is_array($v) && "@" != substr($v, 0, 1)) {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= Config::baseConfig()["secret_key"];
        return strtoupper(md5($stringToBeSigned));
    }

    /**
     * 执行接口请求
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute()
    {
        $client = new Client(['timeout' => 0]);
        $response = $client->request('POST', Config::API_URL, [
            'form_params' => self::$param
        ]);
        $response = json_decode($response->getBody()->getContents(), true);
        if (isset($response["error_response"])) {
            Log::info("[" . date("Y-m-d H:i:s") . "]|error Info:" . $response["error_response"]["zh_desc"]);
        }
        $result = $response[strtr(self::$param["method"], '.', '_') . '_response']['result'];
        return json_decode($result, true);
    }
}
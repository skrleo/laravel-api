<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/18
 * Time: 21:58
 */

namespace App\Libraries\classes\TbUnion;


use TbkTpwdCreateRequest;
use TopClient;

class TaobaoOptional
{
    private static $objInit;

    private $session;

    private $adzoneId;

    private $siteId;

    private $objClient;

    private function __construct($config = [])
    {
        $this->objClient = new TopClient;

        $this->objClient->appkey = $config['appkey'];

        $this->objClient->secretKey = $config['secretKey'];

        $this->objClient->format = 'json';
    }

    /**
     * 单例
     *
     * @return TaobaoOptional
     */
    public static function getInit()
    {
        if (isset(self::$objInit)) {
            return self::$objInit;
        }
        $config = Config::openConfig();
        self::$objInit = new self($config);
        return self::$objInit;
    }

    /**
     * 获取淘口令
     *
     * @param array $param
     * @return mixed
     */
    public function getTkl($param = [])
    {
        $req = new TbkTpwdCreateRequest;
        $req->setText(empty($param['txt']) ? "领取专属优惠券" : $param['txt']);
        $req->setUrl($param['tklUrl']);
        $req->setLogo($param['image']);
        $result = $this->objClient->execute($req);
        return json_decode(json_encode($result), true);
    }
}
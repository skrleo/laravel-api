<?php
/**
 * 用于处理好单库获取的数据
 */
namespace App\Libraries\classes\Haodanku;

use Illuminate\Support\Facades\Redis;

class HeadleHaodanku
{

    private static $objInit;

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
     * 处理列表
     */
    public function handleList($lists)
    {
        if (empty($lists)) {
            return [];
        }
        foreach ($lists as $key => $value) {
            $data[$key]['coupon_price'] = $value['couponmoney'];
            $data[$key]['itemid'] = $value['itemid'];
            $data[$key]['name'] = $value['itemtitle'];
            $data[$key]['description'] = $value['itemdesc'];
            $data[$key]['goods_price'] = strval(floatval($value['itemprice']));
            $data[$key]['pic_url'] = $value['itempic'];
            $data[$key]['coupon_url'] = $value['couponurl'];
            $data[$key]['thumb_url'] = $value['taobao_image'];
            $data[$key]['coupon_discount'] = $value['couponmoney'];
            $data[$key]['coupon_price'] = $value['itemendprice'];
        }
        return $data;
    }
}

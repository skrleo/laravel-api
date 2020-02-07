<?php
/**
 * 多多联盟
 * User: chen
 * Date: 2020/2/8
 * Time: 0:35
 */

namespace App\Libraries\classes\DuoduoUnion;


class FormatData
{
    private static $objInit;

    /**
     * 构造函数
     * FormatData constructor.
     */
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
     * 数据格式化
     *
     * @param $lists
     * @return array
     */
    public function headleOptional($lists)
    {
        $data = [];
        foreach ($lists as $k=>$v){
            $data[$k]["goods_id"] = $v["goods_id"];
            $data[$k]["goods_name"] = $v["goods_name"];
            $data[$k]["has_mall_coupon"] = $v["has_mall_coupon"];
            $data[$k]["mall_coupon_id"] = $v["mall_coupon_id"];
            $data[$k]["goods_desc"] = $v["goods_desc"];
            $data[$k]["goods_thumbnail_url"] = $v["goods_thumbnail_url"];
            $data[$k]["goods_image_url"] = $v["goods_image_url"];
            $data[$k]["goods_gallery_urls"] = $v["goods_gallery_urls"];
            $data[$k]["mall_name"] = $v["mall_name"];
            $data[$k]["merchant_type"] = $v["merchant_type"];
            $data[$k]["has_coupon"] = $v["has_coupon"];
        }
        return $data;
    }
}
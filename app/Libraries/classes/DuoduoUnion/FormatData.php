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
//            $data[$k]["has_mall_coupon"] = $v["has_mall_coupon"];
//            $data[$k]["mall_coupon_id"] = $v["mall_coupon_id"];
            $data[$k]["min_group_price"] = bcdiv($v["min_group_price"],100,2);
            $data[$k]["min_normal_price"] = bcdiv($v["min_normal_price"],100,2);
            $data[$k]["goods_desc"] = $v["goods_desc"];
            $data[$k]["goods_thumbnail_url"] = $v["goods_thumbnail_url"];
            $data[$k]["goods_image_url"] = $v["goods_image_url"];
//            $data[$k]["goods_gallery_urls"] = $v["goods_gallery_urls"];
            $data[$k]["mall_name"] = $v["mall_name"];
            $data[$k]["merchant_type"] = $v["merchant_type"];
            $data[$k]["has_coupon"] = $v["has_coupon"];
            $data[$k]["coupon_discount"] = bcdiv($v["coupon_discount"],100,2);

        }
//        $goodsIds = array_column($data.$v["goods_id"]);
//        dd($goodsIds);
//        $params = ["p_id" => '9569620_127591192', "goods_id_list" => [$goodsIds]];
//        $generate = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.promotion.url.generate');
////            dd($generate);
//        $data[$k]["goods_url"] = $generate["goods_promotion_url_generate_response"]["goods_promotion_url_list"][0]["short_url"];


        return $data;
    }

    public function goodsGenerate()
    {
        $params = ["p_id" => '9569620_127591192', "goods_id_list" => []];
        $data = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.promotion.url.generate');
    }
}
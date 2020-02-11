<?php
/**
 * 京东联盟
 * User: chen
 * Date: 2020/1/6
 * Time: 22:43
 */

namespace App\Libraries\classes\JdUnion;


class Config
{
    const API_URL = "https://router.jd.com/api";

    /**
     * 京东联盟接口配置
     *
     * @return array
     */
    public static function baseConfig()
    {
        $baseConfig['app_key'] = '3a82cacdef23dee9cb3dc7ab46c3e3f5';

        $baseConfig['secret_key'] = 'da6d7609a8db45c79f5efb9e4657ac7e';
        // 响应格式，暂时只支持json
        $baseConfig['format'] = 'json';
        // 签名的摘要算法，暂时只支持md5
        $baseConfig['sign_method'] = 'md5';
        // API协议版本
        $baseConfig['version'] = '1.0';

        return $baseConfig;
    }

    /**
     * 获取接口请求类型
     *
     * @return array
     */
    public static function getMethodType()
    {
        return [
            // 京粉精选商品查询接口
            'jingfen' => 'jd.union.open.goods.jingfen.query',
            // 关键词商品查询接口
            'inquire' => 'jd.union.open.goods.query',
            // 获取推广商品信息
            'info' => 'jd.union.open.goods.promotiongoodsinfo.query',
            // 大字段商品查询接口
            'bigfield' => 'jd.union.open.goods.bigfield.query',
            // 通过subUnionId获取推广链接
            'promote' => 'jd.union.open.promotion.bysubunionid.get',
            // 订单查询接口
            'order' => 'jd.union.open.order.query',
            // 商品类目查询
            'category' => 'jd.union.open.category.goods.get',
            // 优惠券领取情况查询接口
            'coupon' => 'jd.union.open.coupon.query'
        ];
    }

    /**
     * 京东详情地址
     *
     * @return string
     */
    public static function getJdDetailUrl()
    {
        return 'https://wqitem.jd.com/item/view?sku=';
    }
}
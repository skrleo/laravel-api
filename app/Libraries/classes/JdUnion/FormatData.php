<?php
/**
 * 京东联盟
 * User: chen
 * Date: 2020/1/6
 * Time: 23:03
 */

namespace App\Libraries\classes\JdUnion;


use Illuminate\Support\Facades\Redis;

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
     * 京东数据处理
     *
     * @param $lists
     * @return array
     */
    public function headleOptional($lists)
    {
        $data = [];
        foreach ($lists as $key => &$list) {
            // 商品价格
            $goodsPrice = strval(floatval($list["priceInfo"]["price"]));
            // 券信息
            $couponInfo = $this->getIsBestCoupon($list["couponInfo"], $goodsPrice);
            // 券后价
            $couponPrice = bcsub($goodsPrice, $couponInfo["discount"], 2);
            // 佣金金额
            $commissionPrice = $this->getCommission($list, $couponPrice);
            // 商品ID
            $data[$key]["sku_id"] = $list["skuId"];
            // 商品名称
            $data[$key]["goods_name"] = $list["skuName"];
            // 店铺名称
            $data[$key]["shop_name"] = $list["shopInfo"]["shopName"];
            // 券金额
            $data[$key]["coupon_discount"] = strval($couponInfo["discount"]) ?? 0;
            // 券地址
            $data[$key]["coupon_link"] = $this->fix_url($couponInfo["link"]) ?? '';
            // 券结束时间
            $data[$key]["coupon_end_time"] = $couponInfo["getEndTime"] ?? '';
            // 佣金金额
            $data[$key]["commission_price"] = $commissionPrice;
            // 商品封面图
            $data[$key]["goods_thumb"] = $list["imageInfo"]["imageList"][0]["url"];
            // 销售量
            $data[$key]["sale_num"] = $list["inOrderCount30Days"];
            // 商品价格
            $data[$key]["goods_price"] = $goodsPrice;
            // 商品落地页
            $data[$key]["material_url"] = $list["materialUrl"];
            // 券后价
            $data[$key]["coupon_price"] = bcsub($list["priceInfo"]["price"], $couponInfo["discount"], 2);
            // 是否自营
            $data[$key]["owner"] = $list["owner"]; // g=自营，p=pop


            /**--------------缓存数据--------------**/

            // 商品ID
            $cache[$key]["sku_id"] = $list["skuId"];
            // 商品名称
            $cache[$key]["goods_name"] = $list["skuName"];
            // 商品价格
            $cache[$key]["goods_price"] = $goodsPrice;
            // 券金额
            $cache[$key]["coupon_discount"] = strval($couponInfo["discount"]) ?? 0;
            // 券地址
            $cache[$key]["coupon_link"] = $this->fix_url($couponInfo["link"]) ?? '';
            // 券结束时间
            $cache[$key]["coupon_end_time"] = $couponInfo["getEndTime"] ?? '';
            // 店铺名称
            $cache[$key]["shop_name"] = $list["shopInfo"]["shopName"] ?? '';
            // 佣金金额
            $cache[$key]["commission_price"] = $commissionPrice;
            // 商品封面图
            $cache[$key]["goods_thumb"] = json_encode($this->getGoodsThumb($list["imageInfo"]["imageList"]), true);
            // 是否自营
            $cache[$key]["owner"] = $list["owner"]; // g=自营，p=pop
            // 券后价
            $cache[$key]["coupon_price"] = $couponPrice;
            // 销售量
            $cache[$key]["sale_num"] = $list["inOrderCount30Days"];
            // 加入缓存
            $this->addRedis($cache[$key]);
        }
        return $data;
    }

    /**
     * 获取商品实际的佣金金额
     *
     * @param $data
     * @param $couponPrice
     * @return int|string
     */
    public function getCommission($data, $couponPrice)
    {
        if (empty($data["commissionInfo"])) {
            return 0;
        }
        // 佣金比率
        $commissionRate = bcdiv($data["commissionInfo"]["commissionShare"], 100, 2);
        if ($data["owner"] == "g") {
            // 券后价✖佣金比例=总佣金
            $commission = bcmul($commissionRate, $couponPrice, 2);
        } elseif ($data["owner"] == "p") {
            // 券后价✖佣金比例✖90%的技术服务费=总佣金
            $commission = bcmul(bcmul($commissionRate, $couponPrice, 2), 0.9, 2);
        }
        return $commission ?? 0;
    }

    /**
     * 格式化 图片列表
     *
     * @param $imgLists
     * @return array
     */
    public function getGoodsThumb($imgLists)
    {
        foreach ($imgLists as $key => &$list) {
            $data[] = $list["url"];
        }
        return $data ?? [];
    }

    /**
     * 获取最优券面值
     *
     * @param $couponInfo
     * @param $goodsPrice
     * @return array
     */
    public static function getIsBestCoupon($couponInfo, $goodsPrice)
    {
        if (empty($couponInfo["couponList"])) {
            return [
                "discount" => 0,
                "link" => '',
                "getEndTime" => ''
            ];
        }
        // 默认值
        $data = ["discount" => 0, "link" => '', "getEndTime" => ''];
        foreach ($couponInfo["couponList"] as &$item) {
            // 优惠券过期
            if (time() > $item["getEndTime"] / 1000) {
                continue;
            }
            if (isset($item["isBest"]) && $item["isBest"] == 1) {
                return [
                    "discount" => $item["discount"],
                    "link" => $item["link"],
                    "getEndTime" => date('Y-m-d H:i:s', $item["getEndTime"] / 1000),
                ];
            }
            if ($item["discount"] >= 0 && $item["quota"] < $goodsPrice) {
                $data = [
                    "discount" => $item["discount"],
                    "link" => $item["link"],
                    "getEndTime" => date('Y-m-d H:i:s', $item["getEndTime"] / 1000),
                ];
            }
        }
        return $data ?? [];
    }

    /**
     * 修正图片/链接地址格式
     *
     * @param $url
     * @return string
     */
    public function fix_url($url)
    {
        if (empty($url)) {
            return '';
        }

        $match = '/^[a-zA-Z]+:\\/\\//';
        $result = preg_match($match, $url, $matches);
        if ($result == 1) {
            return $url;
        } else {
            return 'https:' . $url;
        }
    }

    /**
     * 商品缓存设置
     *
     * @param $data
     */
    private function addRedis($data)
    {
        Redis::connection('redis_jd')->hmset("goods:info:where:" . strval($data['sku_id']), $data);
        Redis::connection('redis_jd')->expire("goods:info:where:" . strval($data['sku_id']), 60 * 60 * 2);
    }
}
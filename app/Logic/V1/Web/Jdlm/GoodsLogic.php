<?php
/**
 * 京东联盟-商品
 * User: chen
 * Date: 2020/1/6
 * Time: 23:15
 */

namespace App\Logic\V1\Web\Jdlm;


use App\Libraries\classes\JdUnion\Config;
use App\Libraries\classes\JdUnion\FormatData;
use App\Libraries\classes\JdUnion\JdInterface;
use App\Logic\LoadDataLogic;
use DdvPhp\DdvUtil\Exception;

class GoodsLogic extends LoadDataLogic
{
    /**
     * 获取京东商品列表
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getJdGoodsLists()
    {
        $param = ["methodType" => 'jingfen'];
        $data = [
            'eliteId' => 21,
            'pageIndex' => 1,
            'pageSize' => 20
        ];
        $param["param_json"]["goodsReq"] = $data;

        $data = JdInterface::getInstance($param)->setRequestParam()->execute();
        $lists = FormatData::getInit()->headleOptional($data["data"]);
        return [
            'lists' => $lists
        ];
    }

    /**
     * 商品转链
     * info ：商品链接、领券链接、活动链接获取普通推广链接或优惠券二合一推广链接
     *
     * @return array
     * @throws Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function revolveSprocket()
    {
        // 是否有券
        if (!empty($this->couponUrl)) {
            $param["couponUrl"] = $this->couponUrl;
        }
        // 活动转链接
        if (!empty($this->jumpUrl)) {
            $materialId = $this->jumpUrl;
        }
        // 商品转链
        if (!empty($this->skuId)) {
            $materialId = Config::getJdDetailUrl() . $this->skuId;
        }
        if (!empty($materialId)){
            throw new Exception('转链失败','ERROR_materialId_NOT_FIND');
        }
        // 合并参数
        $data["methodType"] = 5;
        $param = array_merge($param ?? [], [
            'materialId' => $materialId,
//            'subUnionId' => $subUnionId, // 用户子联盟ID
        ]);
        $data["param_json"]["promotionCodeReq"] = $param;
        // 请求接口
        $response = JdInterface::getInstance($param)->setRequestParam()->execute();
        if ($response["code"] <> 200) {
            throw new Exception('转链失败','ERROR_FAIL');
        }
        if (!isset($response["data"])) {
            return [];
        }
        return $response["data"];
    }
}
<?php
/**
 * 多多联盟
 * User: chen
 * Date: 2020/2/7
 * Time: 23:43
 */

namespace App\Logic\V1\Web\DuoDuolm;


use App\Libraries\classes\DuoduoUnion\DuoduoInterface;
use App\Libraries\classes\DuoduoUnion\FormatData;
use App\Logic\LoadDataLogic;

class GoodsLogic extends LoadDataLogic
{
    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchGoods()
    {
        $params = ["keyword" =>"手机"];
        $data = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.search');
        $response = $data["goods_search_response"]["goods_list"];
        $lists = FormatData::getInit()->headleOptional($response);
        return ['lists' => $lists];
    }
}
<?php
/**
 * 多多联盟
 * User: chen
 * Date: 2020/2/7
 * Time: 23:43
 */

namespace App\Logic\V1\Web\DuoDuolm;


use App\Libraries\classes\DuoduoUnion\DuoduoInterface;
use App\Logic\LoadDataLogic;

class GoodsLogic extends LoadDataLogic
{
    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchGoods()
    {
        $params = ["goods_id_list" =>["86904979089"]];
        $data = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.basic.info.get');
        return $data;
    }
}
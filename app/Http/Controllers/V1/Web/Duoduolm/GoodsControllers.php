<?php
/**
 * 拼多多联盟 获取商品
 * User: chen
 * Date: 2020/1/22
 * Time: 19:51
 */

namespace App\Http\Controllers\V1\Web\Duoduolm;


use App\Http\Controllers\Controller;
use App\Libraries\classes\DuoduoUnion\DuoduoInterface;

class GoodsControllers extends Controller
{

    public function getGoodsLists()
    {
        $params = [];
        $data = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.basic.info.get');
        return $data;
    }
}
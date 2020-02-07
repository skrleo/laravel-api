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
use App\Logic\V1\Web\DuoDuolm\GoodsLogic;

class GoodsController extends Controller
{
    public function getGoodsLists()
    {
        $params = [];
        $data = DuoduoInterface::getInstance($params)->request('pdd.ddk.goods.basic.info.get');
        return $data;
    }

    /**
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function searchGoods()
    {
        $this->validate(null, [
            'keyword' => 'string'
        ]);
        $goodsLogic = new GoodsLogic();
        $goodsLogic->load($this->verifyData);
        return  $goodsLogic->searchGoods();
    }
}
<?php
/**
 * 京东联盟-商品
 * User: chen
 * Date: 2020/1/6
 * Time: 23:13
 */

namespace App\Http\Controllers\V1\Web\Jdlm;


use App\Http\Controllers\Controller;
use App\Logic\V1\Web\Jdlm\GoodsLogic;

class GoodsController extends Controller
{
    /**
     * 京东商品列表
     *
     * @return mixed
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function getJdGoodsLists()
    {
        $this->validate(null, [
            'keyword' => 'string'
        ]);
        $goodsLogic = new GoodsLogic();
        $goodsLogic->load($this->verifyData);
        return  $goodsLogic->getJdGoodsLists();
    }
}
<?php
/**
 * 首页控制器
 * User: ChenGuanghui
 * Date: 2019/8/24
 * Time: 23:21
 */

namespace App\Http\Controllers\V1\Web\Home;



use App\Http\Controllers\Controller;
use App\Logic\V1\Web\Home\HomeLogic;

class HomeController extends Controller
{
    /**
     * 首页banner图
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function lists(){
        $this->validate(null, [
            'categoryId' => 'integer'
        ]);
        $homeLogic = new HomeLogic();
        $homeLogic->load($this->verifyData);
        return  $homeLogic->lists();
    }

    /**
     * 商品列表
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function goodsLists(){
        $this->validate(null, [
            'categoryId' => 'integer'
        ]);
        $homeLogic = new HomeLogic();
        $homeLogic->load($this->verifyData);
        return  $homeLogic->goodsLists();
    }
}
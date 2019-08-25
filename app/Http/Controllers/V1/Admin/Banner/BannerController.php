<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/8/25
 * Time: 11:33
 */

namespace App\Http\Controllers\V1\Admin\Banner;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Banner\BannerLogic;

class BannerController extends Controller
{
    /**
     * 轮播图列表
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'name' => 'string',
        ]);
        $bannerLogic = new BannerLogic();
        $bannerLogic->load($this->verifyData);
        return $bannerLogic->lists();
    }

    /**
     * 添加轮播图
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'thumb' => 'string',
            'jumpUrl' => 'required|string',
            'jumpType' => 'required|string',
            'status' =>  'integer'
        ]);
        $bannerLogic = new BannerLogic();
        $bannerLogic->load($this->verifyData);
        if ($bannerLogic->store()){
            return[];
        }
    }

    /**
     * 轮播图详情
     * @param $bannerId
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($bannerId){
        $this->validate(['bannerId' => $bannerId], [
            'bannerId' => 'required|integer',
        ]);
        $bannerLogic = new BannerLogic();
        $bannerLogic->load($this->verifyData);
        return [
            'data' => $bannerLogic->show()
        ];
    }

    /**
     * 编辑轮播图
     * @param $bannerId
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($bannerId){
        $this->validate(['bannerId' => $bannerId], [
            'bannerId' => 'required|integer',
            'name' => 'required|string',
            'thumb' => 'string',
            'jumpUrl' => 'required|string',
            'jumpType' => 'required|string',
            'status' =>  'integer'
        ]);
        $bannerLogic = new BannerLogic();
        $bannerLogic->load($this->verifyData);
        if ($bannerLogic->update()){
            return[];
        }
    }

    /**
     * 删除轮播图
     * @param $bannerId
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($bannerId){
        $this->validate(['bannerId' => $bannerId], [
            'bannerId' => 'required|integer',
        ]);
        $bannerLogic = new BannerLogic();
        $bannerLogic->load($this->verifyData);
        if ($bannerLogic->destroy()){
            return[];
        }
    }
}
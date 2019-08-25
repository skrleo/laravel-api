<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/8/25
 * Time: 11:35
 */

namespace App\Logic\V1\Admin\Banner;

use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use App\Model\V1\Base\BannerModel;

class BannerLogic extends LoadDataLogic
{
    public $bannerId = 0;

    public $name = '';

    public $thumb = '';

    public $jump_url = '';

    /**
     * 轮播图列表
     * @return \DdvPhp\DdvPage
     */
    public function lists(){
        $res =  (new BannerModel())
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * 添加轮播图
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $bannerModel = new BannerModel();
        $articleData = $this->getAttributes(['name', 'thumb', 'jump_url'], ['', null]);
        $bannerModel->setDataByHumpArray($articleData);
        if (!$bannerModel->save()){
            throw new Exception('添加轮播图失败','ERROR_STORE_FAIL');
        }
        return true;
    }

    /**
     * 轮播图详情
     * @return \DdvPhp\DdvUtil\Laravel\Model
     * @throws Exception
     */
    public function show(){
        $bannerModel = (new BannerModel())->where('banner_id',$this->bannerId)->first();
        if (empty($bannerModel)){
            throw new Exception('文章不存在','ARTICLE_NOT_FIND');
        }
        return $bannerModel->toHump();
    }

    /**
     * 编辑轮播图
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function update(){
        $bannerModel = (new BannerModel())->where('banner_id',$this->bannerId)->first();
        if (empty($bannerModel)){
            throw new Exception('轮播图不存在','ARTICLE_NOT_FIND');
        }
        $bannerData = $this->getAttributes(['name', 'thump', 'jumpType', 'jumpUrl','status'], ['', null]);
        $bannerModel->setDataByHumpArray($bannerData);
        if (!$bannerModel->save()){
            throw new Exception('修改文章失败','UPDATE_ARTICLE_ERROR');
        }
        return true;
    }

    /**
     * 删除轮播图
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $bannerModel = (new BannerModel())->where('banner_id',$this->bannerId)->first();
        if (empty($bannerModel)){
            throw new Exception('轮播图不存在','ARTICLE_NOT_FIND');
        }
        if (!$bannerModel->delete()){
            throw new Exception('删除轮播图失败','DESTROY_BANNER_FAIL');
        }
        return true;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/8/24
 * Time: 23:23
 */

namespace App\Logic\V1\Web\Home;


use App\Logic\LoadDataLogic;
use App\Model\V1\Base\BannerModel;

class HomeLogic extends LoadDataLogic
{
    /**
     * 首页Banner图
     * @return \DdvPhp\DdvPage
     */
    public function lists(){
        $bannerModel = (new BannerModel())
            ->getDdvPage();
        return $bannerModel->toHump();
    }

}
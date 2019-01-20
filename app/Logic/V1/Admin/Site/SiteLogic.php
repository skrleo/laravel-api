<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/19
 * Time: 14:52
 */

namespace App\Logic\V1\Admin\Site;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Site\SiteConfigModel;

class SiteLogic extends LoadDataLogic
{
    protected $siteId = 0;

    protected $title = '';

    protected $keywords = '';

    protected $description = '';

    protected $icpBeian = '';

    protected $cover = '';

    protected $logo = '';

    /**
     * @return array
     * @throws Exception
     * @throws \ReflectionException
     */
    public function update(){
        $SiteConfigModel = (new SiteConfigModel())->where('site_id',$this->siteId)->first();
        if (empty($SiteConfigModel)){
            throw new Exception('站点配置不存在','NOT_FIND_SITE');
        }
        $siteData = $this->getAttributes(['title', 'keywords', 'description', 'icpBeian', 'cover', 'logo'], ['', null]);
        $SiteConfigModel->setDataByHumpArray($siteData);
        if (!$SiteConfigModel->save()){
            throw new Exception('添加节点失败','ERROR_STORE_FAIL');
        }
        return [];
    }

    /**
     * @return \DdvPhp\DdvUtil\Laravel\Model
     * @throws Exception
     */
    public function show(){
        $SiteConfigModel = (new SiteConfigModel())->where('site_id',$this->siteId)->first();
        if (empty($SiteConfigModel)){
            throw new Exception('站点配置不存在','NOT_FIND_SITE');
        }
        return $SiteConfigModel->toHump();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/1
 * Time: 14:39
 */

namespace App\Http\Controllers\V1\Admin\Site;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Site\SiteLogic;

class SiteController extends Controller
{
    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($siteId){
        $this->validate(['siteId' => $siteId], [
            'siteId' => 'required|integer',
            'title' => 'required|string',
            'keywords' => 'required|string',
            'description' => 'required|string',
            'icpBeian' => 'required|string',
            'cover' => 'required|string',
            'logo' => 'required|string',
        ]);
        $siteLogic = new SiteLogic();
        $siteLogic->load($this->verifyData);
        if ($siteLogic->update()){
            return [];
        }
    }

    /**
     * @param $siteId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($siteId){
        $this->validate(['siteId' => $siteId], [
            'siteId' => 'required|integer'
        ]);
        $siteLogic = new SiteLogic();
        $siteLogic->load($this->verifyData);
        return [
            'data' => $siteLogic->show()
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 17:59
 */

namespace App\Logic\V1\Admin\Crontab;


use App\Http\Controllers\V1\Admin\Base\BaseController;
use App\Model\Exception;
use App\Model\V1\Crontab\CrontabModel;

class CrontabLogic extends BaseController
{
    protected $name = '';

    protected $beginTime = 0;

    protected $endTime = 0;

    protected $interval = 0;

    protected $type = 0;

    protected $action = '';

    /**
     * 定时任务列表
     * @return array|\DdvPhp\DdvPage
     */
    public function index(){
        $res = (new CrontabModel())
            ->orderByDesc('created_at')
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * 添加定时任务
     * @return bool
     * @throws Exception
     */
    public function store(){
        $crontabModel = (new CrontabModel());
        $nodeData = $this->getAttributes(['name', 'beginTime', 'endTime', 'interval', 'type', 'action'], ['', null]);
        $crontabModel->setDataByHumpArray($nodeData);
        if (!$crontabModel->save()){
            throw new Exception('添加定时任务失败','CRONTAB_STORE_FAIL');
        }
        return true;
    }

    /**
     *
     */
    public function show(){

    }
}
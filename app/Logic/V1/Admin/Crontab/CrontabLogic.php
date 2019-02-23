<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 17:59
 */

namespace App\Logic\V1\Admin\Crontab;


use App\Jobs\BaseJob;
use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Crontab\CrontabModel;

class CrontabLogic extends LoadDataLogic
{
    protected $name = '';

    protected $beginTime = 0;

    protected $endTime = 0;

    protected $interval = 0;

    protected $type = 0;

    protected $action = '';

    protected $crontabId = 0;

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
        $crontabData = $this->getAttributes(['name', 'beginTime', 'endTime', 'interval', 'type', 'action'], ['', null]);
        $crontabModel->setDataByHumpArray($crontabData);
        /**
         * 添加队列任务
         */
        BaseJob::dispatch(['name' => 'Max Sky', 'gender' => 1])
            ->onQueue('MyQueue');

        if (!$crontabModel->save()){
            throw new Exception('添加定时任务失败','CRONTAB_STORE_FAIL');
        }
        return true;
    }

    /**
     * 定时任务详情
     * @return \DdvPhp\DdvUtil\Laravel\Model
     * @throws Exception
     */
    public function show(){
        $crontabModel = (new CrontabModel())->where('crontab_id',$this->crontabId)->firstHump();
        if (empty($crontabModel)){
            throw new Exception('任务不存在','NOT_FIND_CRONTTAB');
        }
        $crontabModel->beginTime = array($crontabModel->beginTime,$crontabModel->endTime);
        unset($crontabModel->endTime);
        return $crontabModel;
    }

    /**
     * 编辑定时任务
     * @return bool
     * @throws Exception
     */
    public function update(){
        $crontabModel = (new CrontabModel())->where('crontab_id',$this->crontabId)->first();
        if (empty($crontabModel)){
            throw new Exception('任务不存在','NOT_FIND_CRONTTAB');
        }
        $crontabData = $this->getAttributes(['name', 'beginTime', 'endTime', 'interval', 'type', 'action'], ['', null]);
        $crontabModel->setDataByHumpArray($crontabData);
        if (!$crontabModel->save()){
            throw new Exception('编辑定时任务失败','CRONTAB_UPDATE_FAIL');
        }
        return true;
    }

    /**
     * 删除定时任务
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $crontabModel = (new CrontabModel())->where('crontab_id',$this->crontabId)->first();
        if (empty($crontabModel)){
            throw new Exception('任务不存在','NOT_FIND_CRONTTAB');
        }
        if (!$crontabModel->delete()){
            throw new Exception('删除定时任务失败','DELETE_CRONTAB_FAIL');
        }
        return true;
    }
}
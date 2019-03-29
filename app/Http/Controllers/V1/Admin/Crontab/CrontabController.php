<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/3
 * Time: 17:56
 */

namespace App\Http\Controllers\V1\Admin\Crontab;


use App\Http\Controllers\V1\Admin\Base\BaseController;
use App\Logic\V1\Admin\Crontab\CrontabLogic;

/**
 * 定时任务
 * Class CrontabController
 * @package App\Http\Controllers\V1\Admin\Crontab
 */
class CrontabController extends BaseController
{
    /**
     * 定时任务列表
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'status' => 'integer'
        ]);
        $crontabLogic = new CrontabLogic();
        $crontabLogic->load($this->verifyData);
        return $crontabLogic->index();
    }

    /**
     * 添加定时任务
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'beginTime' => 'required|string',
            'endTime' => 'required|string',
            'interval' => 'required|integer',
            'intervalType' => 'required|integer',
            'type' => 'required|integer',
            'action' => 'required|string',
        ]);
        $crontabLogic = new CrontabLogic();
        $crontabLogic->load($this->verifyData);
        if ($crontabLogic->store()){
            return [];
        }
    }

    /**
     * 定时任务详情
     * @param $crontabId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($crontabId){
        $this->validate(['crontabId' => $crontabId], [
            'crontabId' => 'required|integer'
        ]);
        $crontabLogic = new CrontabLogic();
        $crontabLogic->load($this->verifyData);
        return [
            'data' => $crontabLogic->show()
        ];
    }

    /**
     * 编辑定时任务
     * @param $crontabId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($crontabId){
        $this->validate(['crontabId' => $crontabId], [
            'crontabId' => 'required|integer',
            'name' => 'required|string',
            'beginTime' => 'required|string',
            'endTime' => 'required|string',
            'interval' => 'required|integer',
            'intervalType' => 'required|integer',
            'type' => 'required|integer',
            'action' => 'required|string',
        ]);
        $crontabLogic = new CrontabLogic();
        $crontabLogic->load($this->verifyData);
        if ($crontabLogic->update()){
            return [];
        }
    }

    /**
     * 删除定时任务
     * @param $crontabId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($crontabId){
        $this->validate(['crontabId' => $crontabId], [
            'crontabId' => 'required|integer'
        ]);
        $crontabLogic = new CrontabLogic();
        $crontabLogic->load($this->verifyData);
        if ($crontabLogic->destroy()){
            return [];
        }
    }
}
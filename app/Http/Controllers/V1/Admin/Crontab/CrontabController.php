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
        return [
            'lists' => $crontabLogic->index()
        ];
    }

    /**
     * 添加定时任务
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'beginTime' => 'required|integer',
            'endTime' => 'required|integer',
            'interval' => 'required|integer',
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
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
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
}
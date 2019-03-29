<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/29
 * Time: 19:12
 */

namespace App\Http\Controllers\V1\Admin\Base;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Base\OperationLogLogic;

class OperationLogController extends Controller
{
    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'uid' => 'integer'
        ]);
        $baseLogic = new OperationLogLogic();
        $baseLogic->load($this->verifyData);
        return [
            'lists' => $baseLogic->lists()
        ];
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'uid' => 'required|integer',
            'type' => 'required|integer',
            'detail' => 'required|string'
        ]);
        $baseLogic = new OperationLogLogic();
        $baseLogic->load($this->verifyData);
        if ($baseLogic->store()){
            return [];
        }
    }

    /**
     * @param $operationLogId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($operationLogId){
        $this->validate(['operationLogId' => $operationLogId], [
            'operationLogId' => 'required|integer'
        ]);
        $baseLogic = new OperationLogLogic();
        $baseLogic->load($this->verifyData);
        return [
            'data' => $baseLogic->show()
        ];
    }

    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($operationLogId){
        $this->validate(['operationLogId' => $operationLogId], [
            'operationLogId' => 'required|integer'
        ]);
        $baseLogic = new OperationLogLogic();
        $baseLogic->load($this->verifyData);
        if ($baseLogic->destroy()){
            return [];
        }
    }
}
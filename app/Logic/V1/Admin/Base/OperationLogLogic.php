<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/29
 * Time: 19:13
 */

namespace App\Logic\V1\Admin\Base;


use App\Logic\LoadDataLogic;
use App\Logic\V1\Login\AccountLogic;
use App\Model\Exception;
use App\Model\V1\Base\OperationLogModel;
use App\Model\V1\User\UserBaseModel;

class OperationLogLogic extends LoadDataLogic
{

    protected $uid = 0;

    protected $operationLogId = 0;

    protected $type = 0;

    protected $detail = '';
    /**
     * @return mixed
     */
    public function lists(){
        if (empty($this->uid)){
            $this->uid = AccountLogic::getLoginUid();
        }
        $res = (new OperationLogModel())
            ->where('uid',$this->uid)
            ->get()->each(function (OperationLogModel $model){

            });
        return $res->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $operationLogModel = new OperationLogModel();
        $operationLogData = $this->getAttributes(['uid', 'detail', 'type'], ['', null]);
        $operationLogModel->setDataByHumpArray($operationLogData);
        if (!$operationLogModel->save()) {
            throw new Exception('添加操作历史失败', 'ERROR_STORE_FAIL');
        }
        return true;
    }

    /**
     * @return OperationLogModel|\DdvPhp\DdvUtil\Laravel\Model|null|object
     * @throws Exception
     */
    public function show(){
        $operationLogModel = (new OperationLogModel())->where('operation_log_id',$this->operationLogId)->firstHump();
        if (empty($operationLogModel)){
            throw new Exception('查找操作历史失败', 'NOT_FIND_OPERATION_LOG');
        }
        $userBaseModel = (new UserBaseModel())->where('uid',$operationLogModel->uid)->firstHump();
        $operationLogModel->userBase = $userBaseModel ?? [];
        return $operationLogModel;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $operationLogModel = (new OperationLogModel())->where('operation_log_id',$this->operationLogId)->firstHump();
        if (empty($operationLogModel)){
            throw new Exception('查找操作历史失败', 'NOT_FIND_OPERATION_LOG');
        }
        if (!$operationLogModel->delete()){
            throw new Exception('删除操作历史失败', 'DESTROY_OPERATION_LOG_FIND');
        }
        return true;
    }
}
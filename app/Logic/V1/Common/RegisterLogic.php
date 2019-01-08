<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/17
 * Time: 11:24
 */

namespace App\Logic\V1\Common;


use App\Http\Middleware\ClientIp;
use App\Logic\LoadDataLogic;
use App\Model\V1\User\UserAccountModel;
use App\Model\V1\User\UserBaseModel;

class RegisterLogic extends LoadDataLogic
{
    protected $phone = '';

    protected $email = '';

    protected $password = '';

    protected $registerIp = '';

    protected $state = '';

    protected $type = '';

    protected $account = '';

    /**
     * 用户注册
     * @param $accountType
     * @throws \ReflectionException
     */
    public function userRegister($accountType){
        $model = new UserBaseModel();
        $this->registerIp = ClientIp::getClientIp();
        if (empty($this->password)) {
            $this->password = '123456';
        }
        $this->password = md5($this->password);
        $data = $this->getAttributes(['registerIp', 'password', 'type']);
        $model->setDataByHumpArray($data);
        $model->save();
        // 获取uid
        $this->uid = $model->getQueueableId();
        // 添加phone手机账号
        $this->account = !empty($this->phone) ? $this->phone : $this->email;;
        $this->type = $accountType;
        $accountData = $this->getAttributes(['uid', 'account', 'registerIp', 'type']);
        $accountModel = new UserAccountModel();
        $accountModel->setDataByHumpArray($accountData);
        $accountModel->save();
    }
}
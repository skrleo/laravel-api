<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/20
 * Time: 0:42
 */

namespace App\Logic\V1\Login;


use App\Http\Middleware\ClientIp;
use App\Logic\LoadDataLogic;
use App\Model\V1\User\UserAccountModel;
use App\Model\V1\User\UserBaseModel;

class RegisterLogic extends LoadDataLogic
{
    protected $password = '';

    protected $email = '';

    protected $uid = 0;

    protected $phone = '';

    protected $account = '';

    protected $headimg = '';

    /**
     * @return bool
     */
    public function register(){
        $userBaseModel = new UserBaseModel();
        $userBaseModel->register_ip = ClientIp::getClientIp();
        $userBaseModel->password = md5($this->password);
        $userBaseModel->headimg = $this->headimg ?? '';
        $userBaseModel->save();
        //  添加用户账号
        $accountModel = new UserAccountModel();
        $accountModel->uid = $userBaseModel->getQueueableId();
        // 系统生成
        $accountModel->account = $this->account;
        $accountModel->save();
        return true;
    }
}
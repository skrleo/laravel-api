<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/20
 * Time: 0:42
 */

namespace App\Logic\V1\Login;


use App\Http\Middleware\ClientIp;
use App\Logic\Exception;
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

    protected $name = '';

    /**
     * 用户注册
     *
     * @return bool
     * @throws Exception
     */
    public function register(){
        $userBaseModel = (new UserBaseModel())->where("phone",$this->phone)->first();
        if (!empty($userBaseModel)){
            throw new Exception("该用户已经存在","USE_IS_EXIST");
        }
        $userBaseModel = new UserBaseModel();
        $userBaseModel->register_ip = ClientIp::getClientIp();
        $userBaseModel->phone = $this->phone;
        $userBaseModel->password = md5($this->password);
        $userBaseModel->name = $this->name ?? '';
        $userBaseModel->headimg = $this->headimg ?? '';
        $userBaseModel->save();
        if (!$userBaseModel->save()){
            throw new Exception("注册失败","USE_REGISTER_FAIL");
        }
        return true;
    }
}
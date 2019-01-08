<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/8
 * Time: 21:14
 */

namespace App\Logic\V1\Login;


use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use App\Model\V1\User\UserAccountModel;

class AccountLogic extends LoadDataLogic
{
    public $account = '';

    /**
     * 登录
     * @throws Exception
     */
    public function login(){
        $userInfoModel = (new UserAccountModel())->where('account',$this->account)->first();
        if (empty($userInfoModel)){
            throw new Exception('用户账号不存在', 'USER_NOT_FIND');
        }
        return [];
    }
}
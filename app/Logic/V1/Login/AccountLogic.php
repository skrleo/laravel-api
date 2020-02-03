<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/8
 * Time: 21:14
 */

namespace App\Logic\V1\Login;


use App\Http\Middleware\ClientIp;
use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use App\Logic\V1\Common\Util\VerifyCommonLogic;
use App\Model\V1\Rbac\Purview\ManageModel;
use App\Model\V1\User\UserAccountModel;
use App\Model\V1\User\UserBaseModel;

class AccountLogic extends LoadDataLogic
{
    protected $account = '';

    protected $password = '';

    protected $type = 0;

    /**
     * uid不为空则是登录状态
     * @return bool
     */
    public static function isLogin(){
        return !empty(self::getLoginUid());
    }

    /**
     * 获取用户的ID
     * @return string|int
     */
    public static function getLoginUid(){
        dd(session('uid', null));
        return session('uid', null);
    }
    /**
     * 登录
     * @throws Exception
     */
    public function login(){
        $userAccountModel = (new UserAccountModel())->where('account',$this->account)->first();
        if (empty($userAccountModel)){
            throw new Exception('用户账号不存在', 'USER_NOT_FIND');
        }
        $userBaseModel = (new UserBaseModel())->where('uid',$userAccountModel->uid)->first();
        if ($userBaseModel->state <> UserBaseModel::ACCOUNT_START_ENABLE){
            throw new Exception('账号异常,请联系管理员', 'ACCOUNT_ABNORMAL_ERROR');
        }
        // 判断传进来的密码跟基本信息表中的密码是否相等
        if (md5($this->password)!== $userBaseModel->password){
            //记录输入错误的密码次数
            VerifyCommonLogic::setCacheShowCode($this->account);
            throw new Exception('密码错误,请重试！', 'USER_PASSWORD_ERROR');
        }
        //更新登录信息
        $userBaseModel->setDataByHumpArray([
            'loginNum' => intval($userBaseModel->login_num) + 1,
            'loginTime' => time(),
            'lastLoginTime' => $userBaseModel->login_time,
            'loginIp' => ClientIp::getClientIp(),
            'lastLoginIp' => $userBaseModel->login_ip
        ]);
        $userBaseModel->save();
        // 清除错误信息
        VerifyCommonLogic::clearCache($this->account);
        //把uid存到session中
        \Session::put('uid', $userBaseModel->uid);
        /**
         * 判断是前台和后台登录
         */
        if ($this->type <> 0 ){
            $manageModel = (new ManageModel())->where('uid',$userBaseModel->uid)->first();
            if (empty($manageModel)){
                throw new Exception('该用户并非管理员，禁止登录！', 'USER_NOT_MANAGE');
            }
        }
        return $userBaseModel->toHump();
    }

    /**
     * 退出登录
     * @return bool
     */
    public static function loginOut(){
        \Session::remove('uid');
        return true;
    }
}
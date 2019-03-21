<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 23:05
 */

namespace App\Http\Controllers\V1\Login;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use App\Logic\V1\Login\AccountLogic;

class AccountController extends Controller
{
    /**
     * 登录
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function login(){
        $this->validate(null, [
            'type' => 'required|integer',
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $accountLogic = new AccountLogic();
        $accountLogic->load($this->verifyData);
        return [
            'data' => $accountLogic->login()
        ];
    }

    /*
     * 退出登录
     */
    public function logOut()
    {
        AccountLogic::loginOut();
        return ['data' => []];
    }



}
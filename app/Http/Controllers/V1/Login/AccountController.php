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
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $articleLogic = new AccountLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->login()){
            return [
                'statusCode' => 'ok',
                'data' => ''
            ];
        }
    }


}
<?php
/**
 * 微信登录
 * User: chen
 * Date: 2020/1/28
 * Time: 10:25
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\LoginLogic;

class LoginController extends Controller
{
    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public function getQrCode()
    {
        $loginLogic = new LoginLogic();
        return $loginLogic->getQrCode();
    }
}
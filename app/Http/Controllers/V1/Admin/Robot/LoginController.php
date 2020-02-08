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
     * @return array
     * @throws \DdvPhp\DdvUtil\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function getQrCode()
    {
        $loginLogic = new LoginLogic();
        return [
            'data' => $loginLogic->getQrCode()
        ];
    }

    /**
     * 检查是否登录
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function checkLogin()
    {
        $this->validate(null, [
            'uuid' => 'required|string'
        ]);
        $loginLogic = new LoginLogic();
        $loginLogic->load($this->verifyData);
        return $loginLogic->checkLogin();
    }

    /**
     * 退出登录
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function loginOut()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new LoginLogic();
        $loginLogic->load($this->verifyData);
        return $loginLogic->loginOut();
    }

    /**
     * 心跳
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function heartBeat()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new LoginLogic();
        $loginLogic->load($this->verifyData);
        return $loginLogic->heartBeat();
    }
}
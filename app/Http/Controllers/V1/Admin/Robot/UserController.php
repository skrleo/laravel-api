<?php
/**
 * 用户详情
 * User: chen
 * Date: 2020/1/30
 * Time: 12:23
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\UserLogic;

class UserController extends Controller
{
    /**
     *  修改用户头像
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function updateHeadImage()
    {
        $this->validate(null, [
            'wxId' => 'required|string',
            'headImageUrl' => 'required|string',
        ]);
        $loginLogic = new UserLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->updateHeadImage();
    }

    /**
     *  修改资料
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function updateProfile()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new UserLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->updateProfile();
    }

    /**
     * 设置微信号
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function setAlisa()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new UserLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->setAlisa();
    }

    /**
     *  绑定邮箱
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function bindEmail()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new UserLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->bindEmail();
    }

    /**
     * 实名认证
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function verifyIdCard()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new UserLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->verifyIdCard();
    }

    /**
     * 修改密码
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function changePassword()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new UserLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->changePassword();
    }

}
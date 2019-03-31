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
use App\Logic\V1\Common\Util\VerifyCommonLogic;
use App\Logic\V1\Login\AccountLogic;
use DdvPhp\DdvRestfulApi\Exception\RJsonError;

class AccountController extends Controller
{
    protected $sessionKey = 'loginV3';

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
            'imgVerify' => 'string',
            'verifyGuid' => 'string',
        ]);
        $codeData = (new VerifyCommonLogic())->checkShowCode($this->verifyData);
        if (!empty($codeData) && $codeData['isShow'] == 1) {
            if (empty($this->verifyData['verifyGuid'])) {
                throw new RJsonError("验证码错误",'VERIFY_GUID_ERROR');
            }
            if (empty($this->verifyData['imgVerify'])) {
                throw new RJsonError("验证码错误",'VERIFY_IMG_ERROR');
            }
            //检查图形验证码
            VerifyCommonLogic::checkImgVerify($this->sessionKey, $this->verifyData['verifyGuid'], $this->verifyData['imgVerify']);
        }
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

    /**
     * 获取图形验证码
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     */
    public function getImgVerify(){
        $this->validate(null, [
            'verifyGuid' => 'required|string',
        ]);
        $code = VerifyCommonLogic::generateVerifyCode(4);
        $imageDataBase64 = VerifyCommonLogic::getImgVerifyBase64($this->sessionKey, $this->verifyData['verifyGuid'], $code);
        return [
            'data' => [
                'base64' => $imageDataBase64,
            ]
        ];
    }

    /**
     * 获取账号错误次数
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function getCodeCount(){
        $this->validate(null, [
            'account' => 'required|string',
        ]);
        $veirfyCommon = new VerifyCommonLogic();
        $codeData = $veirfyCommon->checkShowCode($this->verifyData);
        return [
            'data' => $codeData
        ];
    }

}
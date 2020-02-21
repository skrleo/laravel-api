<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/9
 * Time: 21:33
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\V1\Admin\Base\BaseLogic;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class UserLogic extends BaseLogic
{
    protected $wxId;

    protected $userHeadImg;

    protected $nickName;

    protected $sex;

    protected $country;

    protected $province;

    protected $city;

    protected $signature;

    protected $alisa;

    protected $email;

    protected $password;

    protected $newPassword;

    protected $realName;

    protected $idCardType;

    protected $idCardNumber;

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateHeadImage()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/user/UploadHeadImage',[
                'form_params' => [
                    "base64" => $this->userHeadImg,
                    "wxId" => $this->wxId
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 修改资料
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateProfile()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/user/UpdateProfile',[
                'form_params' => [
                    "nickName" => $this->nickName,
                    "sex" => $this->sex,
                    "country" => $this->country,
                    "province" => $this->province,
                    "city" => $this->city,
                    "signature" => $this->signature,
                    "wxId" => $this->wxId,
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 设置微信号
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setAlisa()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/user/setAlisa',[
                'form_params' => [
                    "alisa" => $this->alisa,
                    "wxId" => $this->wxId
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 绑定邮箱
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bindEmail()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/user/BindEmail',[
                'form_params' => [
                    "email" => $this->email,
                    "wxId" => $this->wxId
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 实名认证
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyIdCard()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/user/VerifyIdCard',[
                'form_params' => [
                    "realName" => $this->realName,
                    "idCardType" => $this->idCardType,
                    "idCardNumber" => $this->idCardNumber,
                    "wxId" => $this->wxId,
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"]){
                return ["data" => $res["Data"]];
            }
            return ["code" => $res["Code"],"message" => $res["Message"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }

    /**
     * 修改密码
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changePassword()
    {
        $client = new Client();
        try {
            $res = $client->request('POST', 'http://114.55.164.90:1697/api/user/OneChangePassword',[
                'form_params' => [
                    "password" => $this->password,
                    "newPassword" => $this->newPassword,
                    "wxId" => $this->wxId,
                ]
            ]);
            $res = json_decode($res->getBody()->getContents(), true);
            if ($res["Success"] == false){
                return ["code" => $res["Code"],"message" => $res["Message"]];
            }
            return ["data" => $res["Data"]];
        } catch (\Throwable $e) {
            Log::info('Fail to call api');
        }
    }
}
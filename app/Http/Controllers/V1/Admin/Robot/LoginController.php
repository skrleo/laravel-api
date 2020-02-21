<?php
/**
 * 微信登录
 * User: chen
 * Date: 2020/1/28
 * Time: 10:25
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Libraries\classes\CreateUnion;
use App\Libraries\classes\Haodanku\HaodankuApi;
use App\Libraries\classes\Haodanku\HeadleHaodanku;
use App\Libraries\classes\TbUnion\TaobaoOptional;
use App\Logic\V1\Admin\Robot\LoginLogic;
use App\Logic\V1\Admin\Robot\MessageLogic;
use App\Model\V1\Robot\WxRobotGroupModel;
use App\Model\V1\User\UserBaseModel;
use App\Model\V1\User\UserToRobotModel;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Support\Facades\Redis;
use TbkTpwdCreateRequest;
use TopClient;

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
     * 62数据登录
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function data62Login()
    {
        $this->validate(null, [
            'userName' => 'required|string',
            'password' => 'required|string'
        ]);
        $loginLogic = new LoginLogic();
        $loginLogic->load($this->verifyData);
        if ($loginLogic->data62Login()){
            return [];
        }
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
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function startHeartBeat()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new LoginLogic();
        $loginLogic->load($this->verifyData);
        return [
            "data" => $loginLogic->startHeartBeat()
        ];
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function closeHeartBeat()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new LoginLogic();
        $loginLogic->load($this->verifyData);
        return $loginLogic->closeHeartBeat();
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function stateHeartBeat()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new LoginLogic();
        $loginLogic->load($this->verifyData);
        return $loginLogic->stateHeartBeat();
    }
}
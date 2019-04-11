<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/10
 * Time: 23:22
 */

namespace App\Http\Controllers\V1\Common\WeChat;


use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use App\Model\V1\Open\OpenAppWechatModel;

class OpenAppWechatCommonLogic extends LoadDataLogic
{
    // 应用唯一标识[微信公众号或者小程序或者app的]
    protected $wechatAppId = '';
    // 商户号
    protected $wechatMchId = '';
    // 微信的auth_code
    protected $queryAuthCode = '';
    // 预授权码
    protected $preAuthCode = '';
    // 令牌-授权方接口调用凭据
    protected $authorizerAccessToken = '';
    // 刷新令牌-接口调用凭据刷新令牌
    protected $authorizerRefreshToken = '';
    // 授权信息
    protected $funcInfo = '';
    // 授权到期时间
    protected $authCodeExpiredAt = '';
    // 授权状态 0 没有,1 有
    protected $authState = '';
    // 授权时间
    protected $authCodeAt = '';
    // 回调地址
    protected $url = '';

    /**
     * @return $model
     * @throws Exception
     */
    public function getOne(){
        $this->getAppId();
        $openAppWechatModel = (new OpenAppWechatModel())->where(['wechat_app_id' => $this->wechatAppId])->firstHump();
        if(empty($openAppWechatModel)){
            throw new Exception('没有找到该公众号信息', 'APP_INFO_NOT_FIND');
        }
        return $openAppWechatModel;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function update($data = []){
        // 如果传入了数据就直接加载到逻辑层
        if (!empty($data)){
            $this->load($data);
        }
        try {
            // 试图获取这条数据
            $model = $this->getOne();
        }catch (Exception $e){
            // 不存在就新增
            $model = new OpenAppWechatModel();
        }
        // 读取数据
        $data = $this->getAttributes(null, ['', null]);
        $model->setDataByArray($data);
        $model->toUnderline();
        if(!$model->save()){
            throw new Exception('操作失败', 'SAVE_FAIL');
        }
        return true;
    }
    /**
     * @param null $wechatMchId
     * @return mixed|null|string
     * @throws Exception
     */
    public function getMchId($wechatMchId=null){
        // 设置进去
        $this->wechatMchId = empty($wechatMchId)?$this->wechatMchId:$wechatMchId;
        if(empty($this->wechatMchId)){
            $this->wechatMchId = $this->getOne()->wechatMchId;
        }
        return $this->wechatMchId;
    }
    /**
     * 获取微信appId
     * @param null $wechatAppId
     * @return null|string
     * @throws Exception
     */
    public function getAppId($wechatAppId = null){
        // 设置进去
        $this->wechatAppId = empty($wechatAppId) ? $this->wechatAppId : $wechatAppId;
        if(empty($this->wechatAppId)){
            throw new Exception('appId不能为空','APPID_NOT_NULL');
        }
        return $this->wechatAppId;
    }

    /**
     * 获取微信小程序配置
     * @return \EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Application
     * @throws Exception
     * @throws \ReflectionException
     */
    protected function getMiniProgram(){
        $this->getAuthorizerRefreshToken();
        return $this->getOpenPlatform()->miniProgram($this->wechatAppId, $this->authorizerRefreshToken);
    }

    /**
     * 获取微信公众号配置
     * @return \EasyWeChat\OpenPlatform\Authorizer\OfficialAccount\Application
     * @throws Exception
     * @throws \ReflectionException
     */
    protected function getOfficialAccount(){
        $this->getAuthorizerRefreshToken();
        return $this->getOpenPlatform()->officialAccount($this->wechatAppId, $this->authorizerRefreshToken);
    }

    /**
     * @throws Exception
     * @throws \ReflectionException
     */
    protected function getAuthorizerRefreshToken(){
        $model = $this->getOne();
        $this->load($model->toHumpArray());
        if (empty($this->authorizerRefreshToken)){
            throw new Exception('该公众号秘钥已经不存在', 'RefreshToken_NOT_FIND');
        }
    }

    /**
     * @return \EasyWeChat\OpenPlatform\Application|null
     * @throws Exception
     * @throws \ReflectionException
     */
    public function getOpenPlatform(){
        $openPlatform = (new OpenPlatformCommonLogic())->openPlatform();
        return $openPlatform;
    }
}
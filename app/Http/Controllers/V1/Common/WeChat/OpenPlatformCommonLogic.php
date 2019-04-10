<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/10
 * Time: 23:32
 */

namespace App\Http\Controllers\V1\Common\WeChat;


use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use EasyWeChat\Factory;

class OpenPlatformCommonLogic extends LoadDataLogic
{
    // 配置文件
    protected $config = [];
    /**
     * @var \EasyWeChat\OpenPlatform\Application|null $openPlatform
     */
    protected $openPlatform = null;

    /**
     * @param null $config
     * @param bool $isReload
     * @return $this
     * @throws Exception
     */
    public function configInit($config = null, $isReload = false){
        if ($isReload===false&&(!empty($this->config))){
            // 直接配置文件
            return $this;
        }
        if (empty($config))
        {
            // 试图读取配置信息的config
            $config = config('wechat.open');
        }
        if (empty($config)){
            // 如果没有找到配置文件
            throw new Exception('没有找到开放平台的配置', 'CONFIG_NOT_FIND');
        }
        //缓存起来
        $this->config = $config;
        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getConfig(){
        if (empty($this->config)){
            // 如果没有找到配置文件
            throw new Exception('没有找到开放平台的配置', 'CONFIG_NOT_FIND');
        }
        return $this->config;
    }

    /**
     * @return \EasyWeChat\OpenPlatform\Application|null
     * @throws Exception
     */
    public function openPlatform(){
        if (empty($this->openPlatform)){
            $this->configInit();
            $this->openPlatform = Factory::openPlatform($this->config);
        }
        return $this->openPlatform;
    }

    /**
     * @return mixed
     */
    public static function getOpenPlatform(){
        return self::getOpenPlatformLogic()->openPlatform();
    }

}
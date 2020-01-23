<?php
/**
 * 拼多多配置文件
 * User: chen
 * Date: 2020/1/22
 * Time: 19:30
 */

namespace App\Libraries\classes\DuoduoUnion;


class Config
{
    const API_URL = "http://gw-api.pinduoduo.com/api/router";

    /**
     * @return mixed
     */
    public static function baseConfig()
    {
        $baseConfig['client_secret'] = '52f2bb15a410f21233d853582f175e30f8c613c8';

        $baseConfig['access_token'] = 'asd78172s8ds9a921j9qqwda12312w1w21211';

        $baseConfig['client_id'] = '5798ae0ec02a4832b4adfa49d99a2523';
        // 响应格式，支持json 和 xml
        $baseConfig['data_type'] = 'JSON';

        return $baseConfig;
    }
}
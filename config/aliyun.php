<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/30
 * Time: 16:46
 */

return  array(
    'oss' => array(
        //bucket 名称
        'bucket'      =>'17wangku',
        //地区是深圳oss
        'region'      =>'cn-shenzhen',
        //bucket 地区的访问接口
        'endpoint'      =>'',
        //默认cdn域名
        'urlRoot'     =>'',
        //阿里云的api 授权id
        'accessKeyId'   =>'',
        //阿里云的api 授权key
        'accessKeySecret' =>'',
        //阿里云的api 授权角色
        'roleArn'      =>'',
        //生成授权信息的授权时间
        'tokenExpireTime' =>'900',
        //是否使用endpoint
        'isCName'     =>false,
        //本服务器是主控服务器，
        //这个参数是子权限使用的
        'securityToken'    =>NULL

    )
);

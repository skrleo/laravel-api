<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */

    'supportsCredentials' => true,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    // 授权请求头
    'allowedHeaders' => ['*'],
    // 授权请求
    'allowedMethods' => ['*'],
    // 授权响应头读取
    'exposedHeaders' => ['*'],
    // 缓存时间
    'maxAge' => 7200,

];

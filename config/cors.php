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

    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    // 授权请求头
    'allowedHeaders' => [
        'accept-language',
        'x-ddv-*',
        'authorization'
    ],
    // 授权请求
    'allowedMethods' => ['*'],
    // 授权响应头读取
    'exposedHeaders' => [
        'set-cookie',
        'x-ddv-request-id',
        'x-ddv-session-sign'
    ],
    // 缓存时间
    'maxAge' => 7200,

];

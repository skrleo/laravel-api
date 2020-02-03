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

    'allowedOrigins' => ['http://manage.17wangku.com'],

    'allowedOriginsPatterns' => [],
    // 授权请求头
    'allowedHeaders' => ['Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN'],
    // 授权请求
    'allowedMethods' => ['GET, POST, PATCH, PUT, OPTIONS'],
    // 授权响应头读取
    'exposedHeaders' => ['Authorization, authenticated'],
    // 缓存时间
    'maxAge' => 7200,
];

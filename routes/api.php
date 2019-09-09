<?php

use DdvPhp\DdvRestfulApi\Middleware\Laravel\RestfulApi;

Route::group([
    // 命名空间前缀
    'namespace'=>'V1',
], function ($router) {
    /**
     * 文件上传
     */
    Route::group([
        'prefix'=>'upload',
        // 命名空间前缀
        'namespace'=>'Common\Aliyun'
    ],function(){
        // 图片上传
        Route::post('img','UploadController@uploadImg');
    });

    Route::group([
        'middleware' => [
            RestfulApi::class,
        ],
    ], function ($router) {
        Route::group([
            // 命名空间前缀
            'namespace'=>'Login'
        ],function(){
            //用户登录
            Route::post('/login', 'AccountController@login');
            //退出登录
            Route::delete('/login', 'AccountController@logOut');
            // 获取图形验证码
            Route::get('/verify/img', 'AccountController@getImgVerify');
            //获取账号错误次数
            Route::get('/code/count', 'AccountController@getCodeCount');
            // 用户注册
            Route::post('/register', 'RegisterController@register');

        });
        Route::group([
            'prefix'=>'chat',
            'namespace'=>'Common\Chat'
        ],function(){
            //获取微信二维码
            Route::get('/getQrCode', 'ChatController@getQrCode');
            // 查询是否登录
            Route::get('/waitForLogin', 'ChatController@waitForLogin');
        });
    });

});
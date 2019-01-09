<?php

/**
 * 后台接口
 */
Route::group([
    // 命名空间前缀
    'namespace'=>'V1'
//    'middleware' => ['api', 'cors'],
], function ($router) {
    Route::get('hello', function () {
        return 'Hello, Welcome to Laravel';
    });
    Route::group([
        // 命名空间前缀
        'namespace'=>'Login'
    ],function(){
        /**
         * 用户登录
         */
        Route::post('/login', 'AccountController@login');
        /**
         * 用户注册
         */
        Route::post('/register', 'RegisterController@register');

    });

    /**
     * 后台接口
     */
    Route::group([
        // 命名空间前缀
        'namespace'=>'Admin'
    ],function(){
        Route::group([
            // path地址前缀
            'prefix'=>'rbac',
            // 命名空间前缀
            'namespace'=>'Rbac'
        ],function(){
            Route::group([
                // path地址前缀
                'prefix'=>'node',
            ],function(){
                /**
                 * 节点列表
                 */
                Route::get('/lists', 'NodeController@index');
            });
        });
    });

});
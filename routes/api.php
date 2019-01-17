<?php

use DdvPhp\DdvRestfulApi\Middleware\Laravel\RestfulApi;

/**
 * 后台接口
 */
Route::group([
    // 命名空间前缀
    'namespace'=>'V1',
    'middleware' => [
        RestfulApi::class,
    ],
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
                // 节点列表
                Route::get('/lists', 'NodeController@index');
                //添加节点
                Route::post('/', 'NodeController@store');
                //编辑节点
                Route::put('/{nodeId}', 'NodeController@update');
                //节点详情
                Route::get('/{nodeId}', 'NodeController@show');
                // 删除节点
                Route::delete('/', 'NodeController@destroy');
            });
            Route::group([
                // path地址前缀
                'prefix'=>'role',
            ],function(){
                // 角色列表
                Route::get('/lists', 'RoleController@index');
                // 添加角色
                Route::post('/', 'RoleController@store');
                // 角色详情
                Route::get('/{roleId}', 'RoleController@show');
                // 角色编辑
                Route::put('/{roleId}', 'RoleController@update');
                // 角色删除
                Route::delete('/', 'RoleController@destroy');
            });
        });
    });

});
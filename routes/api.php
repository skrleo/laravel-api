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
            'prefix'=>'user',
            // 命名空间前缀
            'namespace'=>'user'
        ],function(){
            // 用户列表
            Route::get('/lists', 'UserController@index');
            //添加用户
            Route::post('/', 'UserController@store');
            //用户详情
            Route::get('/{uid}', 'UserController@show');
            //用户编辑
            Route::put('/{uid}', 'UserController@update');
            // 删除用户
            Route::delete('/', 'UserController@destroy');
        });

        Route::group([
            // path地址前缀
            'prefix'=>'site',
            // 命名空间前缀
            'namespace'=>'site'
        ],function(){
            // 站点详情
            Route::get('/{siteId}', 'SiteController@show');
            // 站点编辑
            Route::put('/{siteId}', 'SiteController@update');
        });
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
            Route::group([
                // path地址前缀
                'prefix'=>'manage',
            ],function(){
                //管理员列表
                Route::get('/lists', 'ManageController@index');
                //添加管理员
                Route::post('/', 'ManageController@store');
                // 管理员详情
                Route::get('/{manageId}', 'ManageController@show');
                // 编辑管理员
                Route::put('/{manageId}', 'ManageController@update');
                // 删除管理员
                Route::delete('/', 'ManageController@destroy');
            });
            Route::group([
                // path地址前缀
                'prefix'=>'purview',
            ],function(){
                // 添加用户角色关系
                Route::put('/role', 'PurviewController@userToRole');
                // 添加角色节点关系
                Route::put('/node', 'PurviewController@roleToNode');
            });
        });
    });

});
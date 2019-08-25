<?php
/**
 * 前台路由
 * User: ChenGuanghui
 * Date: 2019/8/24
 * Time: 23:00
 */

use DdvPhp\DdvRestfulApi\Middleware\Laravel\RestfulApi;

Route::group([
    // 命名空间前缀
    'namespace'=>'V1',
], function ($router) {

    Route::group([
        'middleware' => [
            RestfulApi::class,
        ],
    ], function ($router) {
        Route::group([
            'prefix'=>'web',
            // 命名空间前缀
            'namespace'=>'Web',
        ],function(){
            Route::group([
                'prefix'=>'home',
                'namespace'=>'Home'
            ],function(){
                //首页banner
                Route::get('banner/lists', 'HomeController@lists');
            });
            Route::group([
                'prefix'=>'user',
                'namespace'=>'User'
            ],function(){
                //用户详情
                Route::get('/{uid}', 'UserController@show');
            });

            Route::group([
                'prefix'=>'article',
                'namespace'=>'Article'
            ],function(){
                // 文章列表
                Route::get('/lists', 'ArticleController@index');
                // 添加文章
                Route::post('/', 'ArticleController@store');

                Route::get('/spider', 'ArticleController@spider');
                // 编辑文章
                Route::put('/{articleId}', 'ArticleController@store');
                //文章详情
                Route::get('/{articleId}', 'ArticleController@show');
                //删除文章
                Route::delete('/{articleId}', 'ArticleController@destroy');

            });
            Route::group([
                'prefix'=>'tag',
                'namespace'=>'Article'
            ],function(){
                //标签列表
                Route::get('/lists', 'TagController@index');
                //添加标签
                Route::post('/', 'TagController@store');
                //标签详情
                Route::get('/{articleId}', 'TagController@show');
                //删除标签
                Route::delete('/{articleId}', 'TagController@destroy');
            });
        });

    });
});

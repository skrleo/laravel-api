<?php

use App\Http\Middleware\AdminManage;
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
        Route::group([
            'prefix'=>'web',
            // 命名空间前缀
            'namespace'=>'Web',
        ],function(){
            Route::group([
                'prefix'=>'article',
                'namespace'=>'Article'
            ],function(){
                /**
                 *  文章列表
                 */
                Route::get('/lists', 'ArticleController@index');
                /**
                 * 添加文章
                 */
                Route::post('/', 'ArticleController@store');

                Route::get('/spider', 'ArticleController@spider');
                /**
                 * 编辑文章
                 */
                Route::put('/{articleId}', 'ArticleController@store');
                /**
                 * 文章详情
                 */
                Route::get('/{articleId}', 'ArticleController@show');
                /**
                 * 删除文章
                 */
                Route::delete('/{articleId}', 'ArticleController@destroy');
            });
            Route::group([
                'prefix'=>'tag',
                'namespace'=>'Article'
            ],function(){
                /**
                 *  标签列表
                 */
                Route::get('/lists', 'TagController@index');
                /**
                 * 添加标签
                 */
                Route::post('/', 'TagController@store');
                /**
                 * 标签详情
                 */
                Route::get('/{articleId}', 'TagController@show');
                /**
                 * 删除标签
                 */
                Route::delete('/{articleId}', 'TagController@destroy');
            });
        });
        /**
         * 后台接口
         */
        Route::group([
            'middleware'=>[
                // 判断用户是否有权限
                AdminManage::class,
            ],
            'prefix'=>'admin',
            // 命名空间前缀
            'namespace'=>'Admin',
        ],function(){
            Route::group([
                'prefix'=>'base',
                'namespace'=>'Base'
            ],function(){
                //权限节点列表
                Route::get('/lists', 'BaseController@index');
                // 获取网站信息(服务器配置以及网站状态)
                Route::get('/config', 'BaseController@getConfig');
                // 快捷方式列表
                Route::get('/shortcut/lists', 'ShortcutController@index');
                // 添加快捷方式
                Route::post('/shortcut', 'ShortcutController@store');
                // 删除快捷方式
                Route::delete('/shortcut/{shortcutId}', 'ShortcutController@destroy');
            });

            Route::group([
                'prefix'=>'article',
                'namespace'=>'Article'
            ],function(){
                Route::group([
                    'prefix'=>'tag'
                ],function(){
                    /**
                     *  标签列表
                     */
                    Route::get('/lists', 'TagController@index');
                    /**
                     * 添加标签
                     */
                    Route::post('/', 'TagController@store');
                    /**
                     * 编辑标签
                     */
                    Route::put('/{tagId}', 'TagController@update');
                    /**
                     * 标签详情
                     */
                    Route::get('/{tagId}', 'TagController@show');
                    /**
                     * 删除标签
                     */
                    Route::delete('/{tagId}', 'TagController@destroy');
                });
                /**
                 *  文章列表
                 */
                Route::get('/lists', 'ArticleController@index');
                /**
                 * 添加文章
                 */
                Route::post('/', 'ArticleController@store');
                /**
                 * 编辑文章
                 */
                Route::put('/{articleId}', 'ArticleController@update');
                /**
                 * 文章详情
                 */
                Route::get('/{articleId}', 'ArticleController@show');
                /**
                 * 删除文章
                 */
                Route::delete('/{articleId}', 'ArticleController@destroy');
            });
            /**
             * vbot 微信机器人
             */
            Route::group([
                'prefix'=>'wechat',
                'namespace'=>'Wechat'
            ],function(){
                Route::get('/', 'Vbot\VbotController@config');
            });

            Route::group([
                'prefix'=>'task',
                'namespace'=>'Crontab'
            ],function(){
                // 启动守护进程
                Route::get('/daemon/start', 'DaemonController@start');
                // 停止守护进程
                Route::get('/daemon/stop', 'DaemonController@stop');
                //执行守护进程
                Route::get('/daemon/task', 'DaemonController@task');
                //定时任务列表
                Route::get('/lists', 'CrontabController@index');
                //添加定时任务
                Route::post('/', 'CrontabController@store');
                //定时任务详情
                Route::get('/{crontabId}', 'CrontabController@show');
                //编辑定时任务
                Route::put('/{crontabId}', 'CrontabController@update');
                //删除定时任务
                Route::delete('/{crontabId}', 'CrontabController@destroy');
                // 队列任务
                Route::get('/queue/lists', 'QueueController@index');
            });

            Route::group([
                // path地址前缀
                'prefix'=>'user',
                // 命名空间前缀
                'namespace'=>'User'
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
                Route::delete('/{uid}', 'UserController@destroy');
            });

            Route::group([
                // path地址前缀
                'prefix'=>'site',
                // 命名空间前缀
                'namespace'=>'Site'
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
                    Route::delete('/{nodeId}', 'NodeController@destroy');
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
                    Route::delete('/{roleId}', 'RoleController@destroy');
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
                    Route::delete('/{manageId}', 'ManageController@destroy');
                });
                Route::group([
                    // path地址前缀
                    'prefix'=>'purview',
                ],function(){
                    // 添加用户角色关系
                    Route::put('user/role', 'PurviewController@userToRole');
                    // 添加角色节点关系
                    Route::put('role/node', 'PurviewController@roleToNode');
                });
            });
        });
    });

});
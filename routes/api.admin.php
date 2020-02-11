<?php
/**
 * 后台路由
 * User: ChenGuanghui
 * Date: 2019/8/24
 * Time: 23:00
 */

use App\Http\Middleware\AdminManage;
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
                Route::group([
                    'prefix'=>'operation',
                ],function(){
                    Route::group([
                        'prefix'=>'log',
                    ],function(){
                        //操作历史列表
                        Route::get('/lists', 'OperationLogController@index');
                        //添加操作历史
                        Route::post('/lists', 'OperationLogController@store');
                        //操作历史详情
                        Route::get('/{operationLogId}', 'OperationLogController@show');
                        //删除操作历史
                        Route::delete('/{operationLogId}', 'OperationLogController@destroy');
                    });
                });
                Route::group([
                    'prefix'=>'shortcut',
                ],function(){
                    // 快捷方式列表
                    Route::get('/lists', 'ShortcutController@index');
                    // 添加快捷方式
                    Route::post('/', 'ShortcutController@store');
                    // 删除快捷方式
                    Route::delete('/{shortcutId}', 'ShortcutController@destroy');
                });

                //权限节点列表
                Route::get('/lists', 'BaseController@index');
                // 获取网站信息(服务器配置以及网站状态)
                Route::get('/config', 'BaseController@getConfig');
            });

            Route::group([
                'prefix'=>'express',
                'namespace'=>'Express'
            ],function(){
                Route::get('/', 'ExpressController@getExpress');
            });

            Route::group([
                'prefix'=>'article',
                'namespace'=>'Article'
            ],function(){
                Route::group([
                    'prefix'=>'tag'
                ],function(){
                    //标签列表
                    Route::get('/lists', 'TagController@index');
                    // 添加标签
                    Route::post('/', 'TagController@store');
                    // 编辑标签
                    Route::put('/{tagId}', 'TagController@update');
                    // 标签详情
                    Route::get('/{tagId}', 'TagController@show');
                    // 删除标签
                    Route::delete('/{tagId}', 'TagController@destroy');
                });
                //文章列表
                Route::get('/lists', 'ArticleController@index');
                // 添加文章
                Route::post('/', 'ArticleController@store');
                // 实时消息测试
                Route::get('/ceshi', 'ArticleController@ceshi');
                // 测试队列
                Route::get('/test/job', 'ArticleController@ceshi');
                // 文件导出测试
                Route::get('/excel', 'ArticleController@export');

                Route::get('/qrcode', 'ArticleController@getQrCode');
                // 修改文章审核状态
                Route::put('/review', 'ArticleController@review');
                // 编辑文章
                Route::put('/{articleId}', 'ArticleController@update');
                // 文章详情
                Route::get('/{articleId}', 'ArticleController@show');
                // 删除文章
                Route::delete('/{articleId}', 'ArticleController@destroy');
            });
            //vbot 微信机器人
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
                'prefix'=>'message',
                // 命名空间前缀
                'namespace'=>'Message'
            ],function(){
                //消息列表
                Route::get('/lists', 'MessageController@lists');
                //发布消息
                Route::post('/', 'MessageController@store');
                // 消息详情
                Route::get('/{messageId}', 'MessageController@show');
                // 删除消息
                Route::delete('/{messageId}', 'MessageController@destroy');
            });
            Route::group([
                // path地址前缀
                'prefix'=>'user',
                // 命名空间前缀
                'namespace'=>'User'
            ],function(){
                Route::group([
                    // path地址前缀
                    'prefix'=>'group',
                    // 命名空间前缀
                    'namespace'=>'Group'
                ],function(){
                    //分组列表
                    Route::get('/lists', 'UserGroupController@index');
                    //添加分组
                    Route::post('/store ','UserGroupController@store');
                });

                Route::group([
                    // path地址前缀
                    'prefix'=>'label',
                    // 命名空间前缀
                    'namespace'=>'Label'
                ],function(){
                    //标签列表
                    Route::get('/lists', 'UserLabelController@index');
                    //添加标签
                    Route::post('/store ','UserLabelController@store');
                });
                // 用户列表
                Route::get('/lists', 'UserController@index');
                //添加用户
                Route::post('/', 'UserController@store');
                //用户详情
                Route::get('/{uid}', 'UserController@show');
                //用户编辑
                Route::put('/{uid}', 'UserController@update');
                // 修改用户密码
                Route::put('/fix/pw', 'UserController@fixPw');
                // 删除用户
                Route::delete('/{uid}', 'UserController@destroy');
            });
            // 轮播图
            Route::group([
                'prefix'=>'banner',
                'namespace'=>'Banner'
            ],function(){
                // 轮播图列表
                Route::get('/lists', 'BannerController@index');
                // 添加轮播图
                Route::post('/', 'BannerController@store');
                // 轮播图详情
                Route::get('/{id}', 'BannerController@show');
                // 编辑轮播图
                Route::put('/{id}', 'BannerController@update');
                // 删除轮播图
                Route::delete('/{id}', 'BannerController@destroy');
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

            Route::group([
                // path地址前缀
                'prefix'=>'robot',
                // 命名空间前缀
                'namespace'=>'Robot'
            ],function(){

                Route::get('lists', 'RobotController@lists');

                Route::get('/{id}', 'RobotController@show');

                Route::group([
                    'prefix'=>'goods',
                ],function(){
                    Route::post('/', 'RobotGoodsController@store');
                });

                Route::group([
                    // path地址前缀
                    'prefix'=>'login',
                ],function(){
                    // 获取登录二维码
                    Route::get('getQrCode', 'LoginController@getQrCode');
                    // 检查是否登录
                    Route::post('checkLogin', 'LoginController@checkLogin');
                    // 退出登录
                    Route::post('loginOut', 'LoginController@loginOut');
                });

                Route::group([
                    // path地址前缀
                    'prefix'=>'user',
                ],function(){
                    // 修改头像
                    Route::post('state', 'UserController@updateHeadImage');
                    // 修改资料
                    Route::post('updateProfile', 'UserController@updateProfile');
                    // 设置微信号
                    Route::post('setAlisa', 'UserController@setAlisa');
                    // 绑定邮箱
                    Route::post('bindEmail', 'UserController@bindEmail');
                    // 实名认证
                    Route::post('verifyIdCard', 'UserController@verifyIdCard');
                    // 修改密码
                    Route::post('changePassword', 'UserController@changePassword');
                });

                Route::group([
                    // path地址前缀
                    'prefix'=>'heartBeat',
                ],function(){
                    // 心跳状态
                    Route::get('state', 'LoginController@stateHeartBeat');
                    // 开启心跳
                    Route::post('start', 'LoginController@startHeartBeat');
                    // 关闭心跳
                    Route::post('close', 'LoginController@closeHeartBeat');
                });

                Route::group([
                    // path地址前缀
                    'prefix'=>'message',
                ],function(){
                    // 同步消息消息
                    Route::post('sync', 'MessageController@syncMessage');
                });

                Route::group([
                    // path地址前缀
                    'prefix'=>'friend',
                ],function(){
                    // 查找微信好友、群
                    Route::post('searchWxName', 'FriendController@searchWxName');
                    // 获取微信好友、群
                    Route::post('contractList', 'FriendController@contractList');
                });

                Route::group([
                    // path地址前缀
                    'prefix'=>'pay',
                ],function(){
                    // 是否抢红包状态
                    Route::post('stateRedEnvelopes', 'PayController@stateRedEnvelopes');
                    //  开启抢红包
                    Route::post('startRedEnvelopes', 'PayController@startRedEnvelopes');
                    //  关闭抢红包
                    Route::post('closeRedEnvelopes', 'PayController@closeRedEnvelopes');
                });
            });
        });
    });
});

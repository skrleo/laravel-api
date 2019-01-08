<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/1
 * Time: 23:50
 */

use Illuminate\Support\Facades\Route;

Route::group([
    // 中间件

], function () {
    Route::post('login', 'AccountController@login');
});
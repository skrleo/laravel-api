<?php

use Illuminate\Http\Request;

Route::get('hello', function () {
    return 'Hello, Welcome to LaravelAcademy.org';
});
/**
 * 用户登录
 */
Route::post('/login', 'V1\Login\AccountController@login');
/**
 * 用户注册
 */
Route::post('/register', 'V1\Login\RegisterController@register');
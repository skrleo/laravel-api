<?php
/**
 * Created by PhpStorm.
 * User: hua
 * Date: 2017/9/16
 * Time: 上午11:35
 */

namespace App\Http\Middleware;

use \Illuminate\Http\Request;
use \Closure;


class ClientIp
{
    /**
     * @var \Illuminate\Http\Request
     */
    public static $request = null;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        self::setRequest($request);
        //拿IP地址
        $request->setTrustedProxies(array('127.0.0.1/8082'));

        return $next($request);
    }
    /**
     * @param \Illuminate\Http\Request $request
     */
    public static function setRequest(Request $request){
        self::$request = $request;
    }

    /**
     * @return \Illuminate\Http\Request
     */
    public static function getRequest(){
        $request = self::$request;
        if (!($request instanceof Request)){
            $request = Request();
        }
        if (!($request instanceof Request)){
            $request = app('request');
        }
        return $request;
    }
    public static function getClientIp(){
        $request = self::getRequest();
        return $request->getClientIp();
    }
    public static function get(){
        return self::getClientIp();
    }

}
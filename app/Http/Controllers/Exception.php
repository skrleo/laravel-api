<?php
/**
 * Created by PhpStorm.
 * User: hua
 * Date: 2018/1/15
 * Time: 上午10:40
 */

namespace App\Http\Controllers;


use App\Exceptions\ExceptionAll;

class Exception extends ExceptionAll
{
    // 魔术方法
    public function __construct( $message = 'Unknown Error', $errorId = 'UNKNOWN_ERROR' , $code = '400', $errorData  = array() )
    {
        parent::__construct( $message , $errorId , $code, $errorData );
    }

}
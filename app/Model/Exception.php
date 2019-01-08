<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 22:49
 */

namespace App\Model;


use App\Exceptions\ExceptionAll;
class Exception extends ExceptionAll
{
    // 魔术方法
    public function __construct( $message = 'Unknown Error', $errorId = 'UNKNOWN_ERROR' , $code = '400', $errorData  = array() )
    {
        parent::__construct( $message , $errorId , $code, $errorData );
    }
}
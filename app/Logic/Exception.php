<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 22:54
 */

namespace App\Logic;

use App\Exceptions\ExceptionAll;

class Exception extends ExceptionAll
{
    // 魔术方法
    public function __construct( $message = 'Unknown Error', $errorId = 'UNKNOWN_ERROR' , $code = '400', $errorData  = array() )
    {
        parent::__construct( $message , $errorId , $code, $errorData );
    }
    public static function getArrayByError($e, $et = []){
        $et = is_array($et)?$et:[];
        $et['type'] = get_class($e);
        if (method_exists($e,'getLine')) {
            $et['line'] =$e->getLine();
        }
        if (method_exists($e,'getCode')) {
            $et['statusCode'] = $e->getCode();
        }else{
            $et['statusCode'] = 500;
        }
        if (method_exists($e,'getFile')) {
            $et['file'] = $e->getFile();
        }
        if (method_exists($e,'getErrorId')) {
            $et['errorId'] =$e->getErrorId();
        }else{
            $et['errorId'] ='UNKNOWN_ERROR';
        }
        if (method_exists($e,'getMessage')) {
            $et['message'] = $e->getMessage();
        }else{
            $et['message'] ='UNKNOWN_ERROR';
            $et['errorId'] =empty($et['errorId'])?'Unknown Error':$et['errorId'];
        }
        return $et;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 22:50
 */

namespace App\Exceptions;
use Illuminate\Http\Response;

class ExceptionAll extends \DdvPhp\DdvException\Error
{
    public $response;
    // 魔术方法
    public function __construct( $message = 'Unknown Error', $errorId = 'UNKNOWN_ERROR' , $code = '400', $errorData  = array() )
    {
        parent::__construct( $message , $errorId , $code, $errorData );
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/9
 * Time: 15:57
 */

namespace App\Http\Controllers\V1\Common\Baidu;

use App\Http\Controllers\Controller;

/**
 * Baidu统计
 * Class tongjiController
 * @package App\Http\Controllers\V1\Common\Baidu
 */
class tongjiController extends Controller
{
    /**
     *
     */
    public function getData(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->postData);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/6
 * Time: 23:07
 */

namespace App\Http\Controllers\V1\Common\Chat;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class ChatController extends Controller
{

    /**
     * 用户登录 获取
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function init(){
        $this->getUuid();
        $this->showQrCode();
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUuid(){
        $client = new Client();
        $res = $client->request('GET', 'https://login.weixin.qq.com/jslogin', [
            'appid' => 'wx782c26e4c19acffb',
            'fun'   => 'new',
            'redirect_rui'   => 'https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxnewloginpage',
            'lang'  => 'zh_CN',
            '_'     => time(),
        ]);
        echo $res->getBody();
        return [
            'data' => $res->getBody(),
        ];
    }

    private function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    }

    public function showQrCode(){

    }
}
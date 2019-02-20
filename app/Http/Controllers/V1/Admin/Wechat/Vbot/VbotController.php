<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/17
 * Time: 14:01
 */

namespace App\Http\Controllers\V1\Admin\Wechat\Vbot;


use App\Http\Controllers\Controller;
use Hanson\Vbot\Foundation\Vbot;
use Hanson\Vbot\Message\Text;
use Illuminate\Support\Collection;

class VbotController extends Controller
{
    /**
     * @throws \Hanson\Vbot\Exceptions\ArgumentException
     */
    public function config(){
        $vbot = new Vbot(config('vbot'));
        // 获取监听器实例
        $observer = $vbot->observer;
        $observer->setQrCodeObserver(function($qrCodeUrl){
            $link    = str_replace('/l/', '/qrcode/', $qrCodeUrl);
            return ['data' => $link];
        });
    }
}
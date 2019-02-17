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
        $vbot->messageHandler->setHandler(function(Collection $message){
            Text::send($message['from']['UserName'], 'hi');
        });
        $vbot->server->serve();
    }
}
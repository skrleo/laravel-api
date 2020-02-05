<?php
/**
 * 消息管理
 * User: chen
 * Date: 2020/1/30
 * Time: 12:22
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\MessageLogic;

class MessageController extends Controller
{
    /**
     * 同步微信消息
     *
     * @return mixed
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function syncMessage()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new MessageLogic();
        $loginLogic->load($this->verifyData);
        return [
            'lists' => $loginLogic->syncMessage()
        ];
    }
}
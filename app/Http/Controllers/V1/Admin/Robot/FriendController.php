<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/1/30
 * Time: 12:36
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\FriendLogic;

class FriendController extends Controller
{
    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function searchWxName()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $friendLogic = new FriendLogic();
        $friendLogic->load($this->verifyData);
        return [
            'data' => $friendLogic->searchWxName()
        ];
    }

    /**
     * 获取微信好友/群
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function contractList()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $friendLogic = new FriendLogic();
        $friendLogic->load($this->verifyData);
        return [
            'data' => $friendLogic->contractList()
        ];
    }

    /**
     * 获取微信好友/群详情
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function getContractDetail()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $friendLogic = new FriendLogic();
        $friendLogic->load($this->verifyData);
        return [
            'data' => $friendLogic->contractList()
        ];
    }

    /**
     * 批量添加好友
     *
     * @return bool
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function batchAddFriend()
    {
        $this->validate(null, [
            'wxId' => 'required|string',
            'friends' => 'required|array',
        ]);
        $friendLogic = new FriendLogic();
        $friendLogic->load($this->verifyData);
        if ($friendLogic->batchAddFriend()) {
            return true;
        }
    }
}
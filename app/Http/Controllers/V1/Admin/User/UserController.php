<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/19
 * Time: 0:41
 */

namespace App\Http\Controllers\V1\Admin\User;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\User\UserLogic;

class UserController extends  Controller
{
    /**
     * @return mixed
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'name' => 'string',
        ]);
        $userLogic = new UserLogic();
        $userLogic->load($this->verifyData);
        return $userLogic->index();
    }

    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'sex' => 'integer',
            'status' => 'required|integer',
            'email' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string',
            'nickname' => 'required|string',
            'headimg' => 'string'
        ]);
        $userLogic = new UserLogic();
        $userLogic->load($this->verifyData);
        return $userLogic->store();
    }

    /**
     * @param $uid
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($uid){
        $this->validate(['uid' => $uid], [
            'uid' =>  'required|integer'
        ]);
        $userLogic = new UserLogic();
        $userLogic->load($this->verifyData);
        return [
            'data'=> $userLogic->show()
        ];
    }

    /**
     * @return mixed
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($uid){
        $this->validate(['uid' => $uid], [
            'uid' =>  'required|integer',
            'name' => 'required|string',
            'sex' => 'integer',
            'status' => 'required|integer',
            'email' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string',
            'nickname' => 'required|string',
            'headimg' => 'string'
        ]);
        $userLogic = new UserLogic();
        $userLogic->load($this->verifyData);
        return $userLogic->update();
    }

    /**
     * @return mixed
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy(){
        $this->validate(null, [
            'uids' => 'required|array',
        ]);
        $userLogic = new UserLogic();
        $userLogic->load($this->verifyData);
        return $userLogic->destroy();
    }
}
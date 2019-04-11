<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/11
 * Time: 23:07
 */

namespace App\Http\Controllers\V1\Admin\User\Group;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\User\Group\UserGroupLogic;

class UserGroupController extends Controller
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
        $userGroupLogic = new UserGroupLogic();
        $userGroupLogic->load($this->verifyData);
        return [
            'lists' => $userGroupLogic->index()
        ];
    }

    /**
     * 添加用户组
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'parentId' => 'integer',
        ]);
        $userGroupLogic = new UserGroupLogic();
        $userGroupLogic->load($this->verifyData);
        if ($userGroupLogic->store()){
            return [];
        }
    }

    public function show(){

    }
}
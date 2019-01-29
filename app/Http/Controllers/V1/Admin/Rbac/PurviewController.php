<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:04
 */

namespace App\Http\Controllers\V1\Admin\Rbac;

use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Rbac\PurviewLogic;

class PurviewController extends Controller
{
    /**
     * 用户权限列表
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'parentId' => 'integer',
        ]);
        $purviewLogic = new PurviewLogic();
        $purviewLogic->load($this->verifyData);
        return [
            'lists' => $purviewLogic->index()
        ];
    }

    /**
     * 添加用户角色关系(添加管理员)
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function userToRole(){
        $this->validate(null, [
            'uid' => 'required|integer',
            'roleIds' => 'required|array'
        ]);
        $purviewLogic = new PurviewLogic();
        $purviewLogic->load($this->verifyData);
        if ($purviewLogic->userToRole()){
            return [];
        }
    }

    /**
     * 添加角色节点关系
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function roleToNode(){
        $this->validate(null, [
            'roleId' => 'required|integer',
            'NodeIds' => 'required|array'
        ]);
        $purviewLogic = new PurviewLogic();
        $purviewLogic->load($this->verifyData);
        if ($purviewLogic->roleToNode()){
            return [];
        }
    }
}
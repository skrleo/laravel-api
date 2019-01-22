<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:09
 */

namespace App\Logic\V1\Admin\Rbac;

use App\Logic\LoadDataLogic;
use App\Model\V1\Rbac\Purview\RoleToNodeModel;
use App\Model\V1\Rbac\Purview\UserToRoleModel;

class PurviewLogic extends LoadDataLogic
{
    protected $uid = 0;

    protected $roleIds = [];

    protected $roleId = 0;

    protected $nodeIds = [];

    /**
     * 用户权限列表
     */
    public function index(){

    }

    /**
     * 添加用户角色关系
     * @return array
     */
    public function userToRole(){
        foreach ($this->roleIds as $roleId){
            (new UserToRoleModel)->firstOrCreate([
                'uid' => $this->uid,
                'roleId' => $roleId
            ]);
        }
        return [];
    }

    /**
     * 添加角色节点关系
     * @return array
     */
    public function roleToNode(){
        foreach ($this->nodeIds as $nodeId){
            (new RoleToNodeModel())->firstOrCreate([
                'roleId' => $this->roleId,
                'nodeId' => $nodeId
            ]);
        }
        return [];
    }
}
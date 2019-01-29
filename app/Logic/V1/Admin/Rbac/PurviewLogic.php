<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:09
 */

namespace App\Logic\V1\Admin\Rbac;

use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Rbac\Purview\RoleToNodeModel;
use App\Model\V1\Rbac\Purview\UserToRoleModel;
use App\Model\V1\Rbac\Role\RoleModel;
use App\Model\V1\User\UserBaseModel;

class PurviewLogic extends LoadDataLogic
{
    protected $uid = 0;

    protected $uids = [];

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
     * @throws Exception
     */
    public function userToRole(){
        $userBaseModel = (new UserBaseModel())->where('uid',$this->uid)->first();
        if (empty($userBaseModel)){
            throw new Exception('用户不存在','NOT_FIND_USER');
        }
        foreach ($this->roleIds as $roleId){
            (new UserToRoleModel)->firstOrCreate([
                'uid' => $this->uid,
                'role_id' => $roleId
            ]);
        }
        return [];
    }

    /**
     * 添加角色节点关系
     * @return array
     * @throws Exception
     */
    public function roleToNode(){
        $roleModel = (new RoleModel())->where('role_id',$this->roleId)->first();
        if (empty($roleModel)){
            throw new Exception('角色不存在','NOT_FIND_ROLE');
        }
        foreach ($this->nodeIds as $nodeId){
            (new RoleToNodeModel())->firstOrCreate([
                'role_id' => $this->roleId,
                'node_id' => $nodeId
            ]);
        }
        return [];
    }
}
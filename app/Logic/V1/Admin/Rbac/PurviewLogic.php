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
use App\Model\V1\Rbac\Node\NodeModel;
use App\Model\V1\Rbac\Purview\ManageModel;
use App\Model\V1\Rbac\Purview\RoleToNodeModel;
use App\Model\V1\Rbac\Purview\UserToRoleModel;
use App\Model\V1\Rbac\Role\RoleModel;
use App\Model\V1\User\UserBaseModel;
use Illuminate\Database\QueryException;

class PurviewLogic extends LoadDataLogic
{
    protected $uid = 0;

    protected $uids = [];

    protected $roleIds = [];

    protected $roleId = 0;

    protected $nodeIds = [];

    protected $name = '';

    protected $state = 0;

    protected $type = 0;

    protected $description = '';

    /**
     * 用户权限列表
     */
    public function index(){

    }

    /**
     * 添加用户角色关系
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function userToRole(){
        $manageModel = (new ManageModel())->where('uid',$this->uid)->first();
        if (!empty($manageModel)){
            throw new Exception('管理员已存在','HAVE_FIND_USER');
        }
        \DB::beginTransaction();
        try {
            // 删除用户角色关系
            (new UserToRoleModel)->where('uid',$this->uid)->delete();
            //添加用户角色关系
            foreach ($this->roleIds as $roleId){
                (new UserToRoleModel)->firstOrCreate([
                    'uid' => $this->uid,
                    'role_id' => $roleId
                ]);
            }
            $manageModel = (new ManageModel())->firstOrNew([
                'uid' => $this->uid
            ]);
            $manageModel->state = $this->state;
            $manageModel->type = $this->type;
            $manageModel->description = $this->description ?? '';
            $manageModel->save();
            \DB::commit();
        } catch (QueryException $exception) {
            \DB::rollBack();
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return true;
    }

    /**
     * 添加角色节点关系
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function roleToNode(){
        $roleModel = (new RoleModel())->where('role_id',$this->roleId)->firstHump();
        if (empty($roleModel)){
            throw new Exception('角色不存在','ROLE_NOT_FIND');
        }
        \DB::beginTransaction();
        try {
            // 删除角色节点关系
            (new RoleToNodeModel())->where('role_id',$this->roleId)->delete();
            // 添加角色节点关系
            foreach ($this->nodeIds as $nodeId){
                $nodeModel = (new NodeModel())->where('node_id',$nodeId)->firstHump();
                if(!empty($nodeModel->parentId)){
                    //添加父节点
                    (new RoleToNodeModel())->firstOrCreate([
                        'role_id' => $roleModel->roleId,
                        'node_id' => $nodeModel->parentId,
                        'is_checked' => RoleToNodeModel::IS_CHECKED_TRUE
                    ]);
                }
                //更新子节点
                (new RoleToNodeModel())->firstOrCreate([
                    'role_id' => $roleModel->roleId,
                    'node_id' => $nodeId
                ]);
            }
            \DB::commit();
        } catch (QueryException $exception) {
            \DB::rollBack();
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return true;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:49
 */

namespace App\Logic\V1\Admin\Rbac;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Rbac\Purview\RoleToNodeModel;
use App\Model\V1\Rbac\Role\RoleModel;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class RoleLogic extends LoadDataLogic
{
    protected $name = '';

    protected $roleId = 0;

    protected $state = 0;

    protected $description = '';

    /**
     * @return mixed
     */
    public function index(){
        $res = (new RoleModel())
            ->when(!empty($this->name),function ($query){
                $query->where('name','like','%' .$this->name . '%');
            })
            ->getDdvPage()->toHump();
        return $res;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function store(){
        $roleModel = new RoleModel();
        $roleModel->name = $this->name;
        $roleModel->state = $this->state;
        $roleModel->description = $this->description;
        if (!$roleModel->save()){
            throw new Exception('添加角色','ROLE_STORE_FAIL');
        }
        return [];
    }

    /**
     * @return RoleModel|\Illuminate\Database\Eloquent\Model|null|object
     * @throws Exception
     */
    public function show(){
        $roleModel = (new RoleModel())
            ->where('role_id',$this->roleId)
            ->with([
                'hasManyRoleToNodeModel' => function(HasOneOrMany $query){
                    $query->with([
                        'hasOneNodeModel' => function(HasOneOrMany $query){
                            $query->select('label','node_id');
                        }
                    ]);
                }
            ])
            ->first();
        if (empty($roleModel)){
            throw new Exception('角色不存在','NOT_FIND_ROLE');
        }
        foreach ($roleModel->hasManyRoleToNodeModel as $item){
            $nodeIds[] = $item->hasOneNodeModel->node_id;
            $item->setDataByModel($item->hasOneNodeModel);
            $item->removeAttribute('hasOneNodeModel');
        }
        $roleModel->nodeIds = $nodeIds ?? [];
        return $roleModel->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function update(){
        $roleModel = (new RoleModel())->where('role_id',$this->roleId)->first();
        if (empty($roleModel)){
            throw new Exception('角色不存在','NOT_FIND_ROLE');
        }
        $roleModel->name = $this->name;
        $roleModel->state = $this->state;
        $roleModel->description = $this->description;
        if (!$roleModel->save()){
            throw new Exception('编辑角色','ROLE_UPDATE_FAIL');
        }
        return true;
    }

    /**
     * 删除角色
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $roleModel = (new RoleModel())->where('role_id',$this->roleId)->first();
        if (empty($roleModel)){
            throw new Exception('角色不存在','NOT_FIND_ROLE');
        }
        (new RoleToNodeModel())->where('role_id',$this->roleId)
            ->get()->each(function (RoleToNodeModel $item){
                $item->delete();
            });
        if (!$roleModel->delete()){
            throw new Exception('删除角色','ROLE_DELETE_FAIL');
        }
        return true;
    }
}
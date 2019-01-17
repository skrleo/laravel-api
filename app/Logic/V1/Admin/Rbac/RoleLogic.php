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
use App\Model\V1\Rbac\Role\RoleModel;

class RoleLogic extends LoadDataLogic
{
    protected $name = '';

    protected $roleId = 0;

    protected $introduction = '';

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
     * @return bool
     * @throws Exception
     */
    public function store(){
        $roleModel = new RoleModel();
        $roleModel->name = $this->name;
        $roleModel->introduction = $this->introduction;
        if (!$roleModel->save()){
            throw new Exception('添加角色','ROLE_STORE_FAIL');
        }
        return true;
    }

    /**
     * @return RoleModel|\Illuminate\Database\Eloquent\Model|null|object
     * @throws Exception
     */
    public function show(){
        $roleModel = (new RoleModel())->where('role_id',$this->roleId)->first();
        if (empty($roleModel)){
            throw new Exception('角色不存在','NOT_FIND_ROLE');
        }
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
        $roleModel->introduction = $this->introduction;
        if (!$roleModel->save()){
            throw new Exception('编辑角色','ROLE_UPDATE_FAIL');
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $roleModel = (new RoleModel())->where('role_id',$this->roleId)->first();
        if (empty($roleModel)){
            throw new Exception('角色不存在','NOT_FIND_ROLE');
        }
        if (!$roleModel->delete()){
            throw new Exception('删除角色','ROLE_DELETE_FAIL');
        }
        return true;
    }
}
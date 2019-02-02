<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:42
 */

namespace App\Logic\V1\Admin\Rbac;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Rbac\Purview\ManageModel;
use App\Model\V1\Rbac\Purview\UserToRoleModel;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class ManageLogic extends LoadDataLogic
{
    protected $manageId = 0;

    protected $uid = 0;

    protected $type = 0;

    protected $remark = '';

    protected $state = 0;

    protected $roleIds = [];

    /**
     * 管理员列表
     * @return \DdvPhp\DdvPage
     */
    public function index(){
        $res = (new ManageModel())
            ->with([
                'hasManyUserToRoleModel' => function(HasOneOrMany $query){
                    $query->select('uid','role_id')->with([
                        'hasOneRoleModel' => function(HasOneOrMany $query){
                            $query->select('role_id','name','state');
                        }
                    ]);
                },
                'hasOneUserBaseModel' => function(HasOneOrMany $query){
                    $query->select('uid','name');
                }
            ])
            ->orderByDesc('created_at')
            ->getDdvPage();

        return $res->toHump();
    }

    /**
     * 管理员详情
     * @return \DdvPhp\DdvUtil\Laravel\Model
     * @throws Exception
     */
    public function show(){
        $manageModel = (new ManageModel())
            ->with([
                'hasOneUserBaseModel' => function(HasOneOrMany $query){
                    $query->select('uid','name');
                },
                'hasManyUserToRoleModel'
            ])
            ->where('manage_id',$this->manageId)->first();
        if (empty($manageModel)){
            throw new Exception('管理员不存在','NOT_FIND_MANAGE');
        }
        foreach ($manageModel->hasManyUserToRoleModel as $item){
            $roleIds[] = $item->role_id;
        }
        $manageModel->roleIds = array_unique($roleIds) ?? [];
        return $manageModel->toHump();
    }

    /**
     * 编辑管理员
     * @throws Exception
     */
    public function update(){
        $manageModel = (new ManageModel())->where('manage_id',$this->manageId)->first();
        if (empty($manageModel)){
            throw new Exception('该管理员不存在','MANAGE_NOT_FIND');
        }
        // 删除用户角色关系
        (new UserToRoleModel)->where('uid',$this->uid)->delete();
        //添加用户角色关系
        foreach ($this->roleIds as $roleId){
            (new UserToRoleModel)->firstOrCreate([
                'uid' => $this->uid,
                'role_id' => $roleId
            ]);
        }
        $manageModel->state = $this->state;
        $manageModel->type = $this->type;
        $manageModel->description = $this->description ?? '';
        if (!$manageModel->save()){
            throw new Exception('添加管理员失败','MANAGE_HAVE_EXISTED');
        }
        return true;
    }

    /**
     * 删除管理员
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $manageModel = (new ManageModel())->where('manage_id',$this->manageId)->first();
        if (empty($manageModel)){
            throw new Exception('管理员不存在','NOT_FIND_MANAGE');
        }
        (new UserToRoleModel())->where('uid',$manageModel->uid)
            ->get()->each(function (UserToRoleModel $item){
                $item->delete();
            });
        if (!$manageModel->delete()){
            throw new Exception('删除管理员失败','DELETE_MANAGE_FAIL');
        }
        return true;
    }
}
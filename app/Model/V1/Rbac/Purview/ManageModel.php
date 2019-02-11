<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:40
 */

namespace App\Model\V1\Rbac\Purview;


use App\Model\Model;
use App\Model\V1\User\UserBaseModel;

class ManageModel extends Model
{
    protected $table = 'rbac_manage';

    protected $primaryKey = 'manage_id';

    protected $fillable = ['uid'];
    // 用户状态启用
    const MANAGE_STATE_START = 1;

    public function hasManyUserToRoleModel(){
        return $this->hasMany(UserToRoleModel::class,'uid','uid');
    }

    public function hasOneUserBaseModel(){
        return $this->hasOne(UserBaseModel::class,'uid','uid');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:44
 */

namespace App\Model\V1\Rbac\Purview;


use App\Model\Model;
use App\Model\V1\Rbac\Role\RoleModel;

class UserToRoleModel extends Model
{
    protected $table = 'rbac_user_to_role';

    protected $primaryKey = ['uid','role_id'];

    public function hasOneRoleModel(){
        return $this->hasOne(RoleModel::class,'role_id','role_id');
    }
}
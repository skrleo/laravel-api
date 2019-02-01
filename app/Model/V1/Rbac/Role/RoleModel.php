<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:44
 */

namespace App\Model\V1\Rbac\Role;


use App\Model\Model;
use App\Model\V1\Rbac\Purview\RoleToNodeModel;

class RoleModel extends Model
{
    protected $table = 'rbac_role';

    protected $primaryKey = 'role_id';

    public function hasManyRoleToNodeModel(){
        return $this->hasMany(RoleToNodeModel::class,'role_id','role_id');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:44
 */

namespace App\Model\V1\Rbac\Role;


use App\Model\Model;

class RoleModel extends Model
{
    protected $table = 'rbac_role';

    protected $primaryKey = 'role_id';
}
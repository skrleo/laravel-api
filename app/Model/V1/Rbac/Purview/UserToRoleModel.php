<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:44
 */

namespace App\Model\V1\Rbac\Purview;


use App\Model\Model;

class UserToRoleModel extends Model
{
    protected $table = 'rbac_user_to_role';

    protected $primaryKey = ['uid','role_id'];
}
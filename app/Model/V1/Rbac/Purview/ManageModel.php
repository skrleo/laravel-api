<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:40
 */

namespace App\Model\V1\Rbac\Purview;


use App\Model\Model;

class ManageModel extends Model
{
    protected $table = 'rbac_manage';

    protected $primaryKey = 'manage_id';

    public function hasManyUserToRoleModel(){
        return $this->hasMany(UserToRoleModel::class,'uid','uid');
    }
}
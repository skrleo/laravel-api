<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:42
 */

namespace App\Model\V1\Rbac\Node;


use App\Model\Model;
use App\Model\V1\Rbac\Purview\RoleToNodeModel;

class NodeModel extends Model
{
    protected $table = 'rbac_node';

    protected $primaryKey = 'node_id';

    public function hasManyRoleToNodeModel(){
        return $this->hasMany(RoleToNodeModel::class,'node_id','node_id');
    }
}
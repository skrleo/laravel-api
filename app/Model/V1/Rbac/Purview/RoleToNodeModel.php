<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:20
 */

namespace App\Model\V1\Rbac\Purview;


use App\Model\Model;
use App\Model\V1\Rbac\Node\NodeModel;

class RoleToNodeModel extends Model
{
    protected $table = 'rbac_role_to_node';

    protected $primaryKey = 'role_id';

    public function hasOneNodeModel(){
        return $this->hasOne(NodeModel::class,'node_id','node_id');
    }
}
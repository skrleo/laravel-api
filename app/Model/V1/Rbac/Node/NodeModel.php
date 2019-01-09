<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:42
 */

namespace App\Model\V1\Rbac\Node;


use App\Model\Model;

class NodeModel extends Model
{
    protected $table = 'rbac_node';

    protected $primaryKey = 'node_id';
}
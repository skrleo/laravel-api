<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/2
 * Time: 18:37
 */

namespace App\Logic\V1\Admin\Base;


use App\Logic\LoadDataLogic;
use App\Model\V1\Rbac\Node\NodeModel;
use App\Model\V1\Rbac\Purview\RoleToNodeModel;
use App\Model\V1\Rbac\Purview\UserToRoleModel;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;

class BaseLogic extends LoadDataLogic
{
    public $uid = 0;

    public $roleId = 0;

    /**
     * 用户权限列表
     * @return NodeModel[]|array|\DdvPhp\DdvUtil\Laravel\EloquentCollection
     * @throws \DdvPhp\DdvUtil\Exception
     */
    public function nodeLists(){
        $nodes = (new NodeModel())
            ->whereDdvIf(!empty($this->getBaseNode()),function (EloquentBuilder $query){
                $query ->whereIn('node_id',$this->getBaseNode());
            })
            ->orderBy('sort', 'DESC')->getHump();
        if (!empty($nodes)) {
            $nodes = $this->_getNodeTree($nodes, 0);
        }
        return $nodes;
    }

    /**
     * 获取子集权限
     * @param $nodes
     * @param $nodeId
     * @return array
     */
    public function _getNodeTree($nodes, $nodeId)
    {
        $tree = [];
        foreach ($nodes as $node) {
            if ($node->parentId == $nodeId) {
                $node->children = $this->_getNodeTree($nodes, $node->nodeId);
                $tree[] = $node;
            }
        }
        return $tree;
    }

    /**
     * 获取用户的节点信息
     * @return array
     */
    public function getBaseNode(){
        $userToRoleModel = (new UserToRoleModel())->where('uid',$this->uid)->getHump();
        foreach ($userToRoleModel as $item){
            $roleToNodeModel = (new RoleToNodeModel())->where('role_id',$item->roleId)->getHump();
            foreach ($roleToNodeModel as $node){
                $nodeIds[] = $node->nodeId;
            }
        }
        return array_unique($nodeIds);
    }

}
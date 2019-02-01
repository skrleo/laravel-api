<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:48
 */

namespace App\Logic\V1\Admin\Rbac;

use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Rbac\Node\NodeModel;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;

class NodeLogic extends LoadDataLogic
{
    protected $nodeId = 0;

    protected $label = '';

    protected $icon = '';

    protected $sort = 0;

    protected $state = 0;

    protected $path = '';

    protected $parentId = 0;

    protected $description = '';

    protected $nodeIds = [];

    protected $isPage = 0;

    /**
     * @return mixed
     */
    public function index(){
        $nodes = (new NodeModel())->orderBy('sort', 'DESC')->get()->toHump();
        if (!empty($nodes)) {
            $nodes = $this->_getNodeTree($nodes, 0);
        }
        return $nodes;
    }

    /**
     * 递归权限树
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
     * 添加节点
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $nodeModel = (new NodeModel());
        $nodeData = $this->getAttributes(['label', 'icon', 'sort', 'state', 'path', 'parentId', 'description'], ['', null]);
        $nodeModel->setDataByHumpArray($nodeData);
        if (!$nodeModel->save()){
            throw new Exception('添加节点失败','ERROR_STORE_FAIL');
        }
        return true;
    }

    /**
     * 节点详情
     * @return NodeModel|\Illuminate\Database\Eloquent\Model|null|object
     * @throws Exception
     */
    public function show(){
        $nodeModel = (new NodeModel())->where('node_id',$this->nodeId)->first();
        if (empty($nodeModel)){
            throw new Exception('节点信息不存在','NOT_FIND_NODE');
        }
        return $nodeModel->toHump();
    }

    /**
     * 编辑节点
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function update(){
        $nodeModel = (new NodeModel())->where('node_id',$this->nodeId)->first();
        if (empty($nodeModel)){
            throw new Exception('节点信息不存在','NOT_FIND_NODE');
        }
        $nodeData = $this->getAttributes(['label', 'icon', 'sort', 'state', 'path', 'parentId', 'description'], ['', null]);
        $nodeModel->setDataByHumpArray($nodeData);
        if (!$nodeModel->save()){
            throw new Exception('编辑节点失败','ERROR_UPDATE_FAIL');
        }
        return true;
    }

    /**
     * 删除节点
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $nodeModel = (new NodeModel())->where('node_id',$this->nodeId)->first();
        if (!$nodeModel){
            throw new Exception('节点不存在','NODE_NOT_FIND');
        }
        if (!$nodeModel->delete()){
            throw new Exception('删除节点失败','DELETE_NODE_FAIL');
        }
        return true;
    }
}
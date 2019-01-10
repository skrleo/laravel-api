<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:48
 */

namespace App\Logic\V1\Admin\Rbac;


use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use App\Model\V1\Rbac\Node\NodeModel;

class NodeLogic extends LoadDataLogic
{
    protected $nodeId = 0;

    protected $name = '';

    protected $icon = '';

    protected $sort = 0;

    protected $state = 0;

    protected $isShow = 0;

    protected $path = '';

    protected $parentId = 0;

    protected $description = '';

    protected $nodeIds = [];


    /**
     * 节点列表
     * @return \DdvPhp\DdvPage
     */
    public function index(){
        $res = (new NodeModel())->getDdvPage();
        return $res;
    }

    /**
     * 添加节点
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $nodeModel = (new NodeModel());
        $nodeData = $this->getAttributes(['name', 'icon', 'sort', 'state', 'isShow', 'path', 'parentId', 'description'], ['', null]);
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
        $nodeData = $this->getAttributes(['name', 'icon', 'sort', 'state', 'isShow', 'path', 'parentId', 'description'], ['', null]);
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
        $nodeModel = (new NodeModel())->whereIn('node_id',$this->nodeIds)->delete();
        if (!$nodeModel){
            throw new Exception('删除节点信息失败','DESTROY_NODE_FAIL');
        }
        return true;
    }
}
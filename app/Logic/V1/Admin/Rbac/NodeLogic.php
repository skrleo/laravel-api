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
        $articleData = $this->getAttributes(['isHot', 'isRecommend', 'articleSpaceId', 'articleCategoryId'], ['', null]);
        $nodeModel->setDataByHumpArray($articleData);
        if (!$nodeModel->save()){
            throw new Exception('添加节点失败','ERROR_STORE_FAIL');
        }
        return true;
    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(){

    }
}
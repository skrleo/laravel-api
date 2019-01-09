<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/1
 * Time: 14:37
 */

namespace App\Http\Controllers\V1\Admin\Rbac;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Rbac\NodeLogic;

class NodeController extends Controller
{
    /**
     * 节点列表
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $nodeLogic = new NodeLogic();
        $nodeLogic->load($this->verifyData);
        return [
            'statusCode' => 'ok',
            'lists' => $nodeLogic->index()
        ];
    }

    /**
     * 添加节点
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $nodeLogic = new NodeLogic();
        $nodeLogic->load($this->verifyData);
        if ($nodeLogic->store()){
            return [
                'statusCode' => 'ok'
            ];
        }
    }

    /**
     * 节点编辑
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update(){
        $this->validate(null, [
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $nodeLogic = new NodeLogic();
        $nodeLogic->load($this->verifyData);
        if ($nodeLogic->update()){
            return [
                'statusCode' => 'ok'
            ];
        }
    }

    /**
     * 节点详情
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show(){
        $this->validate(null, [
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $nodeLogic = new NodeLogic();
        $nodeLogic->load($this->verifyData);
        return [
            'statusCode' => 'ok',
            'data' => $nodeLogic->show()
        ];
    }

    /**
     * 节点删除
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy(){
        $this->validate(null, [
            'account' => 'required|string',
            'password' => 'required|string',
        ]);
        $nodeLogic = new NodeLogic();
        $nodeLogic->load($this->verifyData);
        if ($nodeLogic->destroy()){
            return [
                'statusCode' => 'ok'
            ];
        }
    }
}
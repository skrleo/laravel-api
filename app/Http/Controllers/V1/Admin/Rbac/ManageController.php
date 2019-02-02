<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/22
 * Time: 23:42
 */

namespace App\Http\Controllers\V1\Admin\Rbac;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Rbac\ManageLogic;

class ManageController extends Controller
{
    /**
     * @return \DdvPhp\DdvPage
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'type' => 'integer'
        ]);
        $manageLogic = new ManageLogic();
        $manageLogic->load($this->verifyData);
        return $manageLogic->index();
    }

    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'uid' => 'required|integer',
            'type' => 'integer',
            'remark' => 'string'
        ]);
        $manageLogic = new ManageLogic();
        $manageLogic->load($this->verifyData);
        if ($manageLogic->store()){
            return [];
        }
    }

    /**
     * @param $manageId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($manageId){
        $this->validate([ 'manageId' => $manageId], [
            'manageId' => 'required|integer'
        ]);
        $manageLogic = new ManageLogic();
        $manageLogic->load($this->verifyData);
        return [
          'data' => $manageLogic->show()
        ];
    }

    /**
     * @param $manageId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($manageId){
        $this->validate([ 'manageId' => $manageId], [
            'manageId' => 'required|integer',
            'uid' => 'required|integer',
            'type' => 'integer',
            'remark' => 'string'
        ]);
        $manageLogic = new ManageLogic();
        $manageLogic->load($this->verifyData);
        if ($manageLogic->update()){
            return [];
        }
    }

    /**
     * 删除管理员
     * @param $manageId
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($manageId){
        $this->validate([ 'manageId' => $manageId], [
            'manageId' => 'required|integer'
        ]);
        $manageLogic = new ManageLogic();
        $manageLogic->load($this->verifyData);
        if ($manageLogic->destroy()){
            return [];
        }
    }
}
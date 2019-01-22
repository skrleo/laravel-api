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
    public function index(){

    }

    /**
     * @return array
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
     * @return mixed
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($manageId){
        $this->validate([ 'manageId' => $manageId], [
            'uid' => 'required|integer',
            'type' => 'integer',
            'remark' => 'string'
        ]);
        $manageLogic = new ManageLogic();
        $manageLogic->load($this->verifyData);
        return $manageLogic->show();
    }

    /**
     * @param $manageId
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($manageId){
        $this->validate([ 'manageId' => $manageId], [
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

    public function destroy(){

    }
}
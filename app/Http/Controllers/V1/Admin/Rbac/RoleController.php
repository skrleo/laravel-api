<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/1
 * Time: 14:37
 */

namespace App\Http\Controllers\V1\Admin\Rbac;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Rbac\RoleLogic;

class RoleController extends Controller
{
    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'name' => 'string'
        ]);
        $roleLogic = new RoleLogic();
        $roleLogic->load($this->verifyData);
        return $roleLogic->index();
    }

    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'state' => 'required|integer',
            'description' => 'required|string',
        ]);
        $roleLogic = new RoleLogic();
        $roleLogic->load($this->verifyData);
        return $roleLogic->store();
    }

    /**
     * @param $roleId
     * @return \App\Model\V1\Rbac\Role\RoleModel|\Illuminate\Database\Eloquent\Model|null|object
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($roleId){
        $this->validate(['roleId' => $roleId], [
            'roleId' => 'required|integer',
        ]);
        $roleLogic = new RoleLogic();
        $roleLogic->load($this->verifyData);
        return $roleLogic->show();
    }

    /**
     * @param $roleId
     * @return bool
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($roleId){
        $this->validate(['roleId' => $roleId], [
            'roleId' => 'required|integer',
            'name' => 'required|string',
            'state' => 'required|integer',
            'description' => 'required|string',
        ]);
        $roleLogic = new RoleLogic();
        $roleLogic->load($this->verifyData);
        return $roleLogic->update();
    }

    /**
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy(){
        $this->validate(null, [
            'roleId' => 'required|integer'
        ]);
        $roleLogic = new RoleLogic();
        $roleLogic->load($this->verifyData);
        return $roleLogic->destroy();
    }
}
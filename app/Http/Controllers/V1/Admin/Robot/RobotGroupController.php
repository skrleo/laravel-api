<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/17
 * Time: 12:19
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\RobotGroupLogic;

class RobotGroupController extends Controller
{

    /**
     * @return RobotGroupLogic
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function lists(){
        $this->validate(null,  [
            'robotId' => 'required|integer'
        ]);
        $robotGroupLogic = new RobotGroupLogic();
        $robotGroupLogic->load($this->verifyData);
        return $robotGroupLogic->lists();
    }

    /**
     * 扫码入群
     *
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'uid' => 'required|integer',
            'robotId' => 'required|integer',
            'groupUrl' => 'required|string'
        ]);
        $robotGroupLogic = new RobotGroupLogic();
        $robotGroupLogic->load($this->verifyData);
        return $robotGroupLogic->store();
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function setStatus()
    {
        $this->validate(null, [
            'robotGroupId' => 'required|integer',
            'status' => 'required|integer'
        ]);
        $robotGroupLogic = new RobotGroupLogic();
        $robotGroupLogic->load($this->verifyData);
        if ($robotGroupLogic->setStatus()){
            return [];
        }
    }

    /**
     * 删除微信群
     *
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy()
    {
        $this->validate(null, [
            'robotGroupId' => 'required|integer'
        ]);
        $robotGroupLogic = new RobotGroupLogic();
        $robotGroupLogic->load($this->verifyData);
        if ($robotGroupLogic->destroy()){
            return [];
        }
    }
}
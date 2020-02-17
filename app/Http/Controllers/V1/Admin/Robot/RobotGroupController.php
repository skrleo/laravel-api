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
//            'robotGoodsId' => 'required|integer'
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
            'wxid' => 'required|string',
            'groupUrl' => 'required|string'
        ]);
        $robotGroupLogic = new RobotGroupLogic();
        $robotGroupLogic->load($this->verifyData);
        return $robotGroupLogic->store();
    }
}
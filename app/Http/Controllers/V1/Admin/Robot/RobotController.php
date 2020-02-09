<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/9
 * Time: 22:15
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\RobotLogic;

class RobotController extends Controller
{
    /**
     * @return \DdvPhp\DdvPage
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function lists(){
        $this->validate(null, [
            'status' => 'integer'
        ]);
        $robotLogic = new RobotLogic();
        $robotLogic->load($this->verifyData);
        return $robotLogic->lists();
    }
}
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

    /**
     * @param $id
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \DdvPhp\DdvUtil\Exception
     * @throws \ReflectionException
     */
    public function show($id){
        $this->validate(['id' => $id], [
            'id' => 'required|integer'
        ]);
        $robotLogic = new RobotLogic();
        $robotLogic->load($this->verifyData);
        return [
            "data" => $robotLogic->show()
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/11
 * Time: 13:11
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\RobotGoodsLogic;

class RobotGoodsController extends Controller
{
    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'itemid' => 'required|string',
            'robotId' => 'required|integer',
            'type' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required',
            'picUrl' => 'required|string',
            'thumbUrl' => 'required',
            'currentPrice' => 'required|string',
            'couponPrice' => 'required|string',
        ]);
        $robotGoodsLogic = new RobotGoodsLogic();
        $robotGoodsLogic->load($this->verifyData);
        if ($robotGoodsLogic->store()){
            return [];
        }
    }

    /**
     * @param $messageId
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \DdvPhp\DdvUtil\Exception
     * @throws \ReflectionException
     */
    public function show($messageId){
        $this->validate(['messageId' => $messageId], [
            'messageId' => 'required|integer'
        ]);
        $robotGoodsLogic = new RobotGoodsLogic();
        $robotGoodsLogic->load($this->verifyData);
        return [
            'data'=> $robotGoodsLogic->show()
        ];
    }

    /**
     * @param $messageId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($robotGoodsId){
        $this->validate(['robotGoodsId' => $robotGoodsId], [
            'itemid' => 'required|string',
            'robotId' => 'required|integer',
            'type' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required',
            'picUrl' => 'required|string',
            'thumbUrl' => 'required',
            'currentPrice' => 'required|string',
            'couponPrice' => 'required|string',
        ]);
        $robotGoodsLogic = new RobotGoodsLogic();
        $robotGoodsLogic->load($this->verifyData);
        if ($robotGoodsLogic->destroy()){
            return [];
        }
    }

}
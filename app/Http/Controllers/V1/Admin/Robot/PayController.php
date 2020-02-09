<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/1/30
 * Time: 12:24
 */

namespace App\Http\Controllers\V1\Admin\Robot;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Robot\PayLogic;

class PayController extends Controller
{
    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function stateRedEnvelopes()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new PayLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->stateRedEnvelopes();
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function startRedEnvelopes()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new PayLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->stateRedEnvelopes();
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function closeRedEnvelopes()
    {
        $this->validate(null, [
            'wxId' => 'required|string'
        ]);
        $loginLogic = new PayLogic();
        $loginLogic->load($this->verifyData);
        return  $loginLogic->stateRedEnvelopes();
    }
}
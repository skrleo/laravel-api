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
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/11
 * Time: 23:07
 */

namespace App\Http\Controllers\V1\Admin\User\Label;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\User\Label\UserLabelLogic;

class UserLabelController extends Controller
{
    /**
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'name' => 'string',
        ]);
        $userLabelLogic = new UserLabelLogic();
        $userLabelLogic->load($this->verifyData);
        return $userLabelLogic->index();
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
        ]);
        $userLabelLogic = new UserLabelLogic();
        $userLabelLogic->load($this->verifyData);
        if ($userLabelLogic->store()){
            return [];
        }
    }
}
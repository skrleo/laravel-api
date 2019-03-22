<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/23
 * Time: 0:39
 */

namespace App\Http\Controllers\V1\Web\User;


use App\Http\Controllers\Controller;
use App\Logic\V1\Web\User\UserLogic;

class UserController extends Controller
{
    /**
     * @param $uid
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     */
    public function show($uid){
        $this->validate(['uid' => $uid], [
            'uid' =>  'required|integer'
        ]);
        $userLogic = new UserLogic();
        $userLogic->load($this->verifyData);
        return [
            'data'=> $userLogic->show()
        ];
    }
}
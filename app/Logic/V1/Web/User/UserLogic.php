<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/23
 * Time: 0:40
 */

namespace App\Logic\V1\Web\User;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\User\UserBaseModel;

class UserLogic extends LoadDataLogic
{
    protected $uid = 0;

    /**
     * @return \DdvPhp\DdvUtil\Laravel\Model
     * @throws Exception
     */
    public function show(){
        $userBaseModel = (new UserBaseModel())->where('uid',$this->uid)
            ->select('uid','name','headimg')->first();
        if (empty($userBaseModel)){
            throw new Exception('用户不存在','USER_NOT_FIND');
        }
        return $userBaseModel->toHump();
    }
}
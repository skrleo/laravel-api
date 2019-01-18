<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/19
 * Time: 0:42
 */

namespace App\Logic\V1\Admin\User;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\User\UserBaseModel;

class UserLogic extends LoadDataLogic
{
    protected $uid = 0;

    protected $name = '';

    protected $sex = 0;

    protected $status = 0;

    protected $email = '';

    protected $headimg = '';

    protected $phone = '';

    protected $password = '';
    
    protected $nickname = '';

    /**
     * @return \DdvPhp\DdvPage
     */
    public function index(){
        $res = (new UserBaseModel())->getDdvPage();
        return $res->toHump();
    }

    /**
     * @return array
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $userBaseModel = new UserBaseModel();
        $userData = $this->getAttributes(['name', 'sex', 'status', 'email','headimg', 'phone', 'password', 'nickname'], ['', null]);
        $userBaseModel->setDataByHumpArray($userData);
        if (!$userBaseModel->save()){
            throw new Exception('添加节点失败','ERROR_STORE_FAIL');
        }
        return [];
    }

    /**
     * @return \DdvPhp\DdvUtil\Laravel\Model
     * @throws Exception
     */
    public function show(){
        $userBaseModel = (new UserBaseModel())->where('uid',$this->uid)->first();
        if (empty($userBaseModel)){
            throw new Exception('用户不存在','USER_NOT_FIND');
        }
        return $userBaseModel->toHump();
    }

    /**
     * @return array
     * @throws Exception
     * @throws \ReflectionException
     */
    public function update(){
        $userBaseModel = (new UserBaseModel())->where('uid',$this->uid)->first();
        if (empty($userBaseModel)){
            throw new Exception('用户不存在','USER_NOT_FIND');
        }
        $userData = $this->getAttributes(['name', 'sex', 'status', 'email','headimg', 'phone', 'password', 'nickname'], ['', null]);
        $userBaseModel->setDataByHumpArray($userData);
        if (!$userBaseModel->save()){
            throw new Exception('添加节点失败','ERROR_STORE_FAIL');
        }
        return [];
    }

    /**
     *
     */
    public function destroy(){

    }

}
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
use App\Model\V1\User\UserAccountModel;
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
        $userData = $this->getAttributes(['name', 'sex', 'status', 'email','headimg', 'phone', 'nickname'], ['', null]);
        $userBaseModel->setDataByHumpArray($userData);
        $userBaseModel->password = md5($this->password);
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
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function update(){
        $userBaseModel = (new UserBaseModel())->where('uid',$this->uid)->first();
        if (empty($userBaseModel)){
            throw new Exception('用户不存在','USER_NOT_FIND');
        }
        $userData = $this->getAttributes(['name', 'sex', 'status', 'email','headimg', 'phone', 'nickname'], ['', null]);
        $userBaseModel->password = md5($this->password);
        $userBaseModel->setDataByHumpArray($userData);
        if (!$userBaseModel->save()){
            throw new Exception('修改用户失败','UPDATE_USER_FAIL');
        }
        return true;
    }

    /**
     * 删除用户
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $userBaseModel = (new UserBaseModel())->where('uid',$this->uid)->first();
        if (empty($userBaseModel)){
            throw new Exception('用户不存在','USER_NOT_FIND');
        }
        (new UserAccountModel())->where('uid',$userBaseModel->uid)
            ->get()->each(function (UserAccountModel $item){
                $item->delete();
            });
        if (!$userBaseModel->delete()){
            throw new Exception('删除用户失败','DELETE_USER_FAIL');
        }
        return true;
    }

}
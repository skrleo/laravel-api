<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/8
 * Time: 21:07
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserAccountModel extends Model
{
    protected $table = 'user_account';

    protected $primaryKey = 'uaid';

    public $timestamps = false;
    /**
     * 手机号
     */
    const ACCOUNT_TYPE_PHONE = 2;
    /**
     * 邮箱号
     */
    const ACCOUNT_TYPE_EMAIL = 3;

}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/8
 * Time: 21:06
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserBaseModel extends Model
{
    protected $table = 'user_base';

    protected $primaryKey = 'uid';

    /**
     * 账号启用
     */
    const ACCOUNT_START_ENABLE = 0;
}
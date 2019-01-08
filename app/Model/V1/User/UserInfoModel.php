<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/12/8
 * Time: 21:06
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserInfoModel extends Model
{
    protected $table = 'user_info';

    protected $primaryKey = 'uid';
}
<?php
/**
 * 用户对应的微信号
 *
 * User: chen
 * Date: 2020/2/18
 * Time: 13:00
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserToRobotModel extends Model
{
    protected $table = 'user_to_robot';

    protected $primaryKey = 'id';
}
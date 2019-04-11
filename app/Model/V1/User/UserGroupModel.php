<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/11
 * Time: 23:04
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserGroupModel extends Model
{
    protected $table = 'user_group';

    protected $primaryKey = 'group_id';

    protected $fillable = ['name','parent_id'];

}
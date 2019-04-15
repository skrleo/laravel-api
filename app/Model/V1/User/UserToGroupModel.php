<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/13
 * Time: 18:39
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserToGroupModel extends Model
{
    protected $table = 'user_to_group';

    protected $primaryKey = 'id';

    protected $fillable = ['uid','group_id'];

    public $timestamps = false;
}
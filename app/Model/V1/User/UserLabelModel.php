<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/12
 * Time: 0:05
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserLabelModel extends Model
{
    protected $table = 'user_label';

    protected $primaryKey = 'label_id';
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/12
 * Time: 0:06
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserToLabelModel extends Model
{
    protected $table = 'user_to_label';

    protected $primaryKey = 'id';

    public $timestamps = false;
    
    protected $fillable = ['uid','label_id'];
}
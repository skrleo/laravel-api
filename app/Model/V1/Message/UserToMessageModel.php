<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/31
 * Time: 16:02
 */

namespace App\Model\V1\Message;


use App\Model\Model;

class UserToMessageModel extends Model
{
    protected $table = 'user_to_message';

    protected $primaryKey = 'id';

    protected $fillable = ['uid','message_id'];
}
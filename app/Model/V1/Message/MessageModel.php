<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/30
 * Time: 11:53
 */

namespace App\Model\V1\Message;


use App\Model\Model;

class MessageModel extends Model
{
    protected $table = 'message';

    protected $primaryKey = 'message_id';
}
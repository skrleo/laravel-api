<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/10
 * Time: 23:27
 */

namespace App\Model\V1\Open;


use App\Model\Model;

class OpenAppWechatModel extends Model
{
    protected $table = 'open_app_wechat';

    protected $primaryKey = 'wechat_app_id';
}
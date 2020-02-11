<?php
/**
 * 机器人发单商品
 * User: chen
 * Date: 2020/2/11
 * Time: 13:07
 */

namespace App\Model\V1\Robot;


use App\Model\Model;

class WxRobotGoodsModel extends Model
{
    protected $table = 'wx_robot_goods';

    protected $primaryKey = 'robot_goods_id';

    protected $fillable = ["uid","itemid"];
}
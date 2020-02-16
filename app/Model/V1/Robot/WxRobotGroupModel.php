<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/16
 * Time: 23:59
 */

namespace App\Model\V1\Robot;

use App\Model\Model;

class WxRobotGroupModel extends Model
{
    protected $table = 'wx_robot_group';

    protected $primaryKey = 'robot_group_id';

    public function hasManyRobotToGroupModel(){
        return $this->hasMany(WxRobotToGroupModel::class,'group_id','robot_group_id');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/16
 * Time: 23:58
 */

namespace App\Model\V1\Robot;


use App\Model\Model;

class RobotToGroupModel extends Model
{

    protected $table = 'robot_to_group';

    protected $primaryKey = 'id';

    public function hasOneWxRobotModel(){
        return $this->hasOne(WxRobotModel::class,'id','robot_id');
    }

}
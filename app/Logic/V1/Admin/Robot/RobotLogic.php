<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/9
 * Time: 22:16
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\V1\Admin\Base\BaseLogic;
use App\Model\V1\Robot\WxRobotModel;
use DdvPhp\DdvUtil\Exception;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;

class RobotLogic extends BaseLogic
{
    protected $status;

    protected $id;

    /**
     * @return \DdvPhp\DdvPage
     */
    public function lists(){
        $res = (new WxRobotModel())
            ->when(!empty($this->uid),function (EloquentBuilder $query){
                $query->where('uid',$this->uid);
            })
            ->when(isset($this->status),function (EloquentBuilder $query){
                $query->where('status',$this->status);
            })
            ->latest('created_at')
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * 机器人详情
     *
     * @return WxRobotModel|\DdvPhp\DdvUtil\Laravel\Model|null|object
     * @throws Exception
     */
    public function show()
    {
        $wxRobotModel = (new WxRobotModel())->where('id',$this->id)->firstHump();
        if (empty($wxRobotModel)){
            throw new Exception('该机器人不存在','ROBOT_NOT_FIND');
        }
        return $wxRobotModel;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/9
 * Time: 22:16
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\Exception;
use App\Logic\V1\Admin\Base\BaseLogic;
use App\Model\V1\Robot\WxRobotModel;
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
            throw new Exception('该微信号不存在','ROBOT_NOT_FIND');
        }
        return $wxRobotModel;
    }

    /***
     * 修改微信机器人状态
     *
     * @return bool
     * @throws Exception
     */
    public function setStatus()
    {
        $wxRobotModel = (new WxRobotModel())->where('id',$this->id)->firstHump();
        if (empty($wxRobotModel)){
            throw new Exception('该微信号不存在','ROBOT_NOT_FIND');
        }
        $wxRobotModel->status = $this->status;
        if (!$wxRobotModel->save()){
            throw new Exception("修改微信状态失败","UPDATE_STATUS_FAIL");
        }
        return true;
    }

    /**
     * 删除微信机器人
     *
     * @return bool
     * @throws Exception
     */
    public function destroy()
    {
        $wxRobotModel = (new WxRobotModel())->where('id',$this->id)->firstHump();
        if (empty($wxRobotModel)){
            throw new Exception('该微信号不存在','ROBOT_NOT_FIND');
        }
        if (!$wxRobotModel->delete()){
            throw new Exception("删除微信失败","DELETE_ROBOT_FAIL");
        }
        return true;
    }
}
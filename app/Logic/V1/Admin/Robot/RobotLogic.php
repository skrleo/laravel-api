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
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;

class RobotLogic extends BaseLogic
{
    protected $status;

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

}
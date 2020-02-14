<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/12
 * Time: 19:09
 */

namespace App\Model\V1\Order;


use App\Model\Model;

class WxRobotOrderModel extends Model
{
    public $primaryKey = 'robot_order_id';

    /**
     * Set the table associated with the model.
     *
     * @param string $id
     * @return $this|Model
     */
    public function setTable($id)
    {
        $this->table = 'wx_robot_order_' . $id % 3;
        return $this;
    }

    /**
     * @param $orderIds
     * @return array
     */
    public function byOrderIdGetList($orderIds)
    {
        $model = $this->setTable(0)->select('order_sn', 'uid', 'itemid')->whereIn('order_sn', $orderIds);
        for ($i = 1; $i < 3; $i++) {
            $first = $this->setTable($i)->select('order_sn', 'uid', 'itemid')->whereIn('order_sn', $orderIds);
            $model = $model->unionAll($first);
        }
        return $model->get()->groupBy('order_sn')->toArray();
    }
}
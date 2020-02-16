<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/12
 * Time: 19:09
 */

namespace App\Model\V1\Order;


use App\Model\Model;
use DB;

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
        $this->table = 'wx_robot_order_' . intval($id)% 3;
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
        return $model->get()->keyBy('order_sn')->toArray();
    }

    /**
     * @param $uid
     * @param $list
     * @return bool
     * @throws \Exception
     */
    public function batchInsertData($uid, $list)
    {
        if (empty($list)) {
            return true;
        }
        $this->setTable($uid);
        $result = DB::connection($this->connection)->table($this->getTable())->insert($list);

        if (!$result) {
            throw new \Exception('插入数据失败');
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/11
 * Time: 13:12
 */

namespace App\Logic\V1\Admin\Robot;


use App\Logic\V1\Admin\Base\BaseLogic;
use App\Model\V1\Robot\WxRobotGoodsModel;
use DdvPhp\DdvUtil\Exception;

class RobotGoodsLogic extends BaseLogic
{
    protected $robotGoodsId;

    protected $itemid;

    protected $robotId;

    protected $type;

    protected $name;

    protected $description;

    protected $picUrl;

    protected $thumbUrl;

    protected $currentPrice;

    protected $couponPrice;

    /**
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store()
    {
        $wxRobotGoodsModel = new WxRobotGoodsModel();
        $messageData = $this->getAttributes(['itemid', 'robotId','type', 'name', 'description', 'picUrl', 'thumbUrl', 'currentPrice', 'couponPrice'], ['', null]);
        $wxRobotGoodsModel->setDataByHumpArray($messageData);
        if (!$wxRobotGoodsModel->save()){
            throw new Exception('添加商品失败','GOODS_STORE_FAIL');
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function show()
    {
        $wxRobotGoodsModel = (new WxRobotGoodsModel())->where("robot_goods_id",$this->robotGoodsId)->firstHump();
        if (empty($wxRobotGoodsModel)){
            throw new Exception('查找商品失败','GOODS_NOT_FIND');
        }
        return true;
    }

    public function destroy()
    {

    }
}
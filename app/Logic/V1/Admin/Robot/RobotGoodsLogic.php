<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/11
 * Time: 13:12
 */

namespace App\Logic\V1\Admin\Robot;


use App\Libraries\classes\DuoduoUnion\DuoduoInterface;
//use App\Libraries\classes\DuoduoUnion\FormatData;
use App\Libraries\classes\JdUnion\FormatData;
use App\Libraries\classes\JdUnion\JdInterface;
use App\Logic\V1\Admin\Base\BaseLogic;
use App\Model\V1\Robot\WxRobotGoodsModel;
use DdvPhp\DdvUtil\Exception;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;

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

    protected $sort;

    /**
     * @return \DdvPhp\DdvPage
     */
    public function lists()
    {
        $res = (new WxRobotGoodsModel())
//            ->where("robot_id",$this->robotId)
//            ->when(!empty($this->uid),function (EloquentBuilder $query){
//                $query->where('uid',$this->uid);
//            })
            ->latest('sort')
            ->latest('created_at')
            ->latest('robot_goods_id')
            ->oldest('status')
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function syncGoods(){
//        $data = DuoduoInterface::getInstance($params = [])->request('pdd.ddk.top.goods.list.query');
//        $lists = FormatData::getInit()->headleOptional($data["top_goods_list_get_response"]["list"]);
        $param = ["methodType" => 'promotion'];
        $data = [
            'materialId' => "https://item.jd.com/23484023378.html",
            'siteId' => 138815
        ];
        $param["param_json"]["promotionCodeReq"] = $data;

        $data = JdInterface::getInstance($param)->setRequestParam()->execute();
        $lists = FormatData::getInit()->headleOptional($data["data"]);
        $data = [];
        foreach ($lists as $key => $list){
            $data[$key]["itemid"] = $list["sku_id"];
            $data[$key]["robot_id"] = 2;
            $data[$key]["type"] = 2;
            $data[$key]["name"] = $list["goods_name"];
            $data[$key]["description"] = $list["goods_desc"];
            $data[$key]["pic_url"] = $list["goods_thumbnail_url"];
            $data[$key]["thumb_url"] = $list["goods_image_url"];
            $data[$key]["coupon_discount"] = $list["coupon_discount"];
            $data[$key]["current_price"] = $list["min_group_price"];
        }
        (new WxRobotGoodsModel())->insert($data);
        return true;
    }

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
     * @return WxRobotGoodsModel|\DdvPhp\DdvUtil\Laravel\Model|null|object
     * @throws Exception
     */
    public function show()
    {
        $wxRobotGoodsModel = (new WxRobotGoodsModel())->where("robot_goods_id",$this->robotGoodsId)->firstHump();
        if (empty($wxRobotGoodsModel)){
            throw new Exception('查找商品失败','GOODS_NOT_FIND');
        }
        return $wxRobotGoodsModel;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function destroy()
    {
        $wxRobotGoodsModel = (new WxRobotGoodsModel())->where("robot_goods_id",$this->robotGoodsId)->firstHump();
        if (empty($wxRobotGoodsModel)){
            throw new Exception('商品不存在','GOODS_NOT_FIND');
        }
        if (!$wxRobotGoodsModel->delete()){
            throw new Exception('删除商品成功','GOODS_IS_DESTROY');
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function changeSort()
    {
        $wxRobotGoodsModel = (new WxRobotGoodsModel())->where("robot_goods_id",$this->robotGoodsId)->update([
            "sort" => $this->sort
        ]);
        if (!$wxRobotGoodsModel){
            throw new Exception('修改排序失败','UPDATE_SORT_FAIL');
        }
        return true;
    }
}
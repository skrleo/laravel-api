<?php

namespace App\Console\Commands;

use App\Libraries\classes\DuoduoUnion\DuoduoInterface;
use App\Libraries\classes\DuoduoUnion\FormatData;
use App\Model\V1\Robot\WxRobotGoodsModel;
use Illuminate\Console\Command;

class GetRobotGoods extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getRobotGoods';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = DuoduoInterface::getInstance($params = [])->request('pdd.ddk.top.goods.list.query');
        $lists = FormatData::getInit()->headleOptional($data["top_goods_list_get_response"]["list"]);
        $data = [];
        foreach ($lists as $key => $list){
            $data[$key]["itemid"] = $list["goods_id"];
            $data[$key]["robot_id"] = 1;
            $data[$key]["type"] = 1;
            $data[$key]["name"] = $list["goods_name"];
            $data[$key]["description"] = $list["goods_desc"];
            $data[$key]["goods_url"] = $list["goods_url"];
            $data[$key]["pic_url"] = $list["goods_thumbnail_url"];
            $data[$key]["thumb_url"] = $list["goods_image_url"];
            $data[$key]["coupon_price"] = $list["coupon_discount"];
            $data[$key]["current_price"] = $list["min_group_price"];
        }
        (new WxRobotGoodsModel())->insert($data);
    }
}

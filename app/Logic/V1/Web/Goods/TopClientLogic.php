<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/8/27
 * Time: 22:46
 */

namespace App\Logic\V1\Web\Goods;


use App\Logic\LoadDataLogic;
use Orzcc\TopClient\Facades\TopClient;
use TopClient\request\TbkActivitylinkGetRequest;
use TopClient\request\TbkDgNewuserOrderGetRequest;
use TopClient\request\TbkDgOptimusMaterialRequest;
use TopClient\request\TbkDgVegasTljCreateRequest;
use TopClient\request\TbkItemInfoGetRequest;
use TopClient\request\TbkItemRecommendGetRequest;
use TopClient\request\TbkJuTqgGetRequest;
use TopClient\request\TbkShopGetRequest;
use TopClient\request\TbkTpwdCreateRequest;
use TopClient\request\TbkUatmFavoritesItemGetRequest;

class TopClientLogic extends LoadDataLogic
{
    public $topClient;
    
    public function __construct()
    {
        $this->topClient = TopClient::connection();
    }

    /**
     * 店铺搜索(物料搜索)
     * @return mixed
     */
    public function tbkShopGetRequest(){
        $req = new TbkShopGetRequest;
        $req->setFields("user_id,shop_title,shop_type,seller_nick,pict_url,shop_url");
        $req->setQ("女装");
        $req->setSort("commission_rate_des");
        $req->setIsTmall("false");
        $req->setStartCredit("1");
        $req->setEndCredit("20");
        $req->setStartCommissionRate("2000");
        $req->setEndCommissionRate("123");
        $req->setStartTotalAction("1");
        $req->setEndTotalAction("100");
        $req->setStartAuctionCount("123");
        $req->setEndAuctionCount("200");
        $req->setPlatform("1");
        $req->setPageNo("1");
        $req->setPageSize("20");
        return $this->topClient->execute($req);
    }

    /**
     * 淘礼金创建
     * @return mixed
     */
    public function tbkDgVegasTljCreateRequest(){
        $req = new TbkDgVegasTljCreateRequest;
        $req->setCampaignType("定向：DX；鹊桥：LINK_EVENT；营销：MKT");
        $req->setAdzoneId("1234567");
        $req->setItemId("1234567");
        $req->setTotalNum("10");
        $req->setName("淘礼金来啦");
        $req->setUserTotalWinNumLimit("1");
        $req->setSecuritySwitch("启动安全：true；不启用安全：false");
        $req->setPerFace("10");
        $req->setSendStartTime("2018-09-01 00:00:00");
        $req->setSendEndTime("2018-09-01 00:00:00");
        $req->setUseEndTime("5");
        $req->setUseEndTimeMode("1");
        $req->setUseStartTime("2019-01-29");
        return $this->topClient->execute($req);
    }

    /**
     * 聚划算&淘抢购商品获取
     * @return mixed
     */
    public function TbkJuTqgGetRequest(){
        $req = new TbkJuTqgGetRequest;
        $req->setAdzoneId("123");
        $req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
        $req->setStartTime("2016-08-09 09:00:00");
        $req->setEndTime("2016-08-09 16:00:00");
        $req->setPageNo("1");
        $req->setPageSize("40");
        return $this->topClient->execute($req);
    }

    /**
     * 官方活动转链
     * @return mixed
     */
    public function TbkActivitylinkGetRequest(){
        $req = new TbkActivitylinkGetRequest;
        $req->setPlatform("1");
        $req->setUnionId("demo");
        $req->setAdzoneId("123");
        $req->setPromotionSceneId("12345678");
        $req->setSubPid("mm_123_123_123");
        $req->setRelationId("23");
        return $this->topClient->execute($req);
    }

    /**
     * 物料精选
     * @return mixed
     */
    public function TbkDgOptimusMaterialRequest(){
        $req = new TbkDgOptimusMaterialRequest;
        $req->setPageSize("20");
        $req->setAdzoneId("123");
        $req->setPageNo("1");
        $req->setMaterialId("123");
        $req->setDeviceValue("xxx");
        $req->setDeviceEncrypt("MD5");
        $req->setDeviceType("IMEI");
        $req->setContentId("323");
        $req->setContentSource("xxx");
        $req->setItemId("33243");
        return $this->topClient->execute($req);
    }

    /**
     * 图文内容输出
     * @return mixed
     */
    public function TbkContentGetRequest(){
        $req = new TbkContentGetRequest;
        $req->setAdzoneId("123");
        $req->setType("1");
        $req->setBeforeTimestamp("1491454244598");
        $req->setCount("10");
        $req->setCid("2");
        $req->setImageWidth("300");
        $req->setImageHeight("300");
        $req->setContentSet("1");
        return $this->topClient->execute($req);
    }

    /**
     * 商品关联推荐
     * @return mixed
     */
    public function TbkItemRecommendGetRequest(){
        $req = new TbkItemRecommendGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
        $req->setNumIid("123");
        $req->setCount("20");
        $req->setPlatform("1");
        return $this->topClient->execute($req);
    }

    /**
     * 新用户订单明细查询
     * @return mixed
     */
    public function TbkDgNewuserOrderGetRequest(){
        $req = new TbkDgNewuserOrderGetRequest;
        $req->setPageSize("20");
        $req->setAdzoneId("123");
        $req->setPageNo("1");
        $req->setStartTime("2018-01-24 00:34:05");
        $req->setEndTime("2018-01-24 00:34:05");
        $req->setActivityId("119013_2");
        return $this->topClient->execute($req);
    }

    /**
     * 选品库宝贝信息
     * @return mixed
     */
    public function TbkUatmFavoritesItemGetRequest(){
        $req = new TbkUatmFavoritesItemGetRequest;
        $req->setPlatform("1");
        $req->setPageSize("20");
        $req->setAdzoneId("34567");
        $req->setUnid("3456");
        $req->setFavoritesId("10010");
        $req->setPageNo("2");
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick,shop_title,zk_final_price_wap,event_start_time,event_end_time,tk_rate,status,type");
        return $this->topClient->execute($req);
    }

    /**
     * 淘宝客商品详情查询
     * @return mixed
     */
    public function TbkItemInfoGetRequest(){
        $req = new TbkItemInfoGetRequest;
        $req->setNumIids("123,456");
        $req->setPlatform("1");
        $req->setIp("11.22.33.43");
        return $this->topClient->execute($req);
    }

    /**
     * 淘口令生成
     * @return mixed
     */
    public function TbkTpwdCreateRequest(){
        $req = new TbkTpwdCreateRequest;
        $req->setUserId("123");
        $req->setText("长度大于5个字符");
        $req->setUrl("https://uland.taobao.com/");
        $req->setLogo("https://uland.taobao.com/");
        $req->setExt("{}");
        return $this->topClient->execute($req);
    }
}
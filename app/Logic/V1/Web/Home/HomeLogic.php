<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/8/24
 * Time: 23:23
 */

namespace App\Logic\V1\Web\Home;


use App\Logic\LoadDataLogic;
use App\Model\V1\Base\BannerModel;
use Orzcc\TopClient\Facades\TopClient;
use TopClient\request\TbkJuTqgGetRequest;

class HomeLogic extends LoadDataLogic
{
    /**
     * 首页Banner图
     * @return \DdvPhp\DdvPage
     */
    public function lists(){
        $bannerModel = (new BannerModel())
            ->getDdvPage();
        return $bannerModel->toHump();
    }

    /**
     * 商品列表
     * @return array
     */
    public function goodsLists(){
        $topclient = TopClient::connection();
        $req = new TbkJuTqgGetRequest;
        $req->setAdzoneId("271206959");
        $req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
        $req->setStartTime("2019-08-09 09:00:00");
        $req->setEndTime("2019-09-09 16:00:00");
        $req->setPageNo("1");
        $req->setPageSize("40");
        $resp = $topclient->execute($req);
        return [
            'data' => $resp->results->results
        ];
    }

    public function xx(){
        $req = new TbkTpwdCreateRequest;
        $req->setUserId("123");
        $req->setText("长度大于5个字符");
        $req->setUrl("https://uland.taobao.com/");
        $req->setLogo("https://uland.taobao.com/");
        $req->setExt("{}");
        $resp = $topclient->execute($req);
        return [
            'data' => $resp->results->results
        ];
        $resp = $c->execute($req);
    }
}
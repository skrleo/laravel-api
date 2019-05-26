<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/5/7
 * Time: 21:02
 */
namespace App\Http\Controllers\V1\Admin\Express;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class ExpressController extends Controller
{
    //商户id
    protected $EBusinessID = 1308158;
    //AppKey
    protected $AppKey = 'cb220105-303c-4c06-936b-471666cb22a6';

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getExpress(){
        $client = new Client();
//        $res = $client->request('GET', 'https://login.weixin.qq.com/jslogin', [
//            'appid' => 'wx782c26e4c19acffb',
//            'fun'   => 'new',
//            'redirect_rui'   => 'https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxnewloginpage',
//            'lang'  => 'zh_CN',
//            '_'     => time(),
//        ]);
        $res = $client->request('POST', 'http://api.kdniao.com/api/EOrderService', [
            'form_params' => [
                'foo' => 'bar',
                'baz' => ['hi', 'there!']
            ]
        ]);
        echo $res->getBody();
        return [
            'data' => $res->getBody(),
        ];
    }

    /**
     * @param $arr
     * @return mixed
     */
    public function getOrderTraces($arr){
        $requestData = json_encode($arr, JSON_UNESCAPED_UNICODE);
        //$requestData= "{'OrderCode':'','ShipperCode':'SF','LogisticCode':'617709572650'}";
        $EBusinessID = $this->EBusinessID;
        $AppKey = $this->AppKey;
        $ReqURL = $this->ReqURL_orderTrace;
        $datas = array(
            'EBusinessID' => $EBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, $AppKey);
        $result=$this->sendPost($ReqURL, $datas);
        $result = json_decode($result, true);
        Debug::trace("快递鸟查询物流信息：", $result);
        return $result;
    }

    /**
     * @return array
     */
    public function sendData(){
        $data = [
            'ShipperCode' => 'SF',
            'ThrOrderCode' => '12334',
            'OrderCode' => '54654656',
            'PayType' => '1' ,// 邮费支付方式:1-现付，2-到付，3-月结，4-第三方支付(仅SF支持)
            'ExpType' => '1',//快递类型：1-标准快件 ,详细快递类型参考《快递公司快递业务类型.xlsx》
            'Receiver' => [
                'Company' => 'xxx公司',
                'Name' => '李四',
                'Tel' => '13800138000',
                'ProvinceName' => '广东省',
                'CityName' => '深圳市',
                'ExpAreaName' => '福田区',
                'Address' => 'xxx街道',
            ],
            'Sender' => [
                'Company' => '发件公司',
                'Name' => '张三',
                'Tel' => '10086',
                'ProvinceName' => '广东省',
                'CityName' => '深圳市',
                'ExpAreaName' => '福田区',
                'Address' => 'xxx街道',
            ],
            'Quantity' => '1',
            'Commodity' => [
                'GoodsName' => 'xxx东西'
            ]
        ];
        return $data;
    }

    /**
     * 电商Sign签名生成
     * @param $data，$appkey
     * @return string
     */
    function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
}
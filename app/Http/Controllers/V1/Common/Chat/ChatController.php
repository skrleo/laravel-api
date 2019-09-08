<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/6
 * Time: 23:07
 */

namespace App\Http\Controllers\V1\Common\Chat;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class ChatController extends Controller
{

    private $Uuid = '';

    /**
     * 获取微信登录uuid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUuid()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://login.weixin.qq.com/jslogin', [
            'query' => [
                'appid' => 'wx782c26e4c19acffb',
                'fun' => 'new',
                'redirect_rui' => 'https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxnewloginpage',
                'lang' => 'zh_CN',
                '_' => time(),
            ]
        ]);

        preg_match('/window.QRLogin.code = (\d+); window.QRLogin.uuid = \"(\S+?)\"/', $res->getBody(), $matches);
        $this->Uuid = $matches[2];
    }

    /**
     * 获取二维码
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getQrCode()
    {
        $client = new Client();
        $this->getUuid();
        $res = $client->request('GET', 'https://login.weixin.qq.com/qrcode/' . $this->Uuid);
        // 二维码格式转base64
        return [
            'data' => [
                'qrCode' => 'data:png;base64,' . base64_encode($res->getBody())
            ]
        ];
    }

    /**
     * 等待登录扫描（轮询）：
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkIsLogin()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://login.wx.qq.com/cgi-bin/mmwebwx-bin/login', [
            'query' => [
                'loginicon' => 'true',
                'uuid' => $this->Uuid,
                'tip' => 0,
                'r' => '862560455',
                '_' => time(),
            ]
        ]);

        echo $res->getBody();
        // 获取登录状态
        preg_match('/window.code=(\d+)/', $res->getBody(), $matches);
        preg_match('/window.code=201;window.userAvatar = \'(\S+?)\'/', $res->getBody(), $userAvatar);
        preg_match('/window.redirect_uri=\"(\S+?)\"/', $res->getBody(), $redirect_uri);

        return [
            'data' => [
                'code' => $matches[1],
                'userAvatar' => $userAvatar[1] ?? '',
                'redirectUri' => $redirect_uri[1] ?? ''
            ]
        ];
    }

    /**
     * 登录后获取cookie信息
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserCookie()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxnewloginpage', [
            'query' => [
                'ticket' => 'true',
                'uuid' => 'YeGrrvqmHQ==',
                'lang' => 'zh_CN ',
                'scan' => '1476606728',
                'fun' => 'new',
                'version' => 'v2',
                '_' => time(),
            ]
        ]);
        echo $matches[0];
        return [
            'data' => [
                'code' => $matches[1],
                'redirect_uri' => ''
            ]
        ];
    }

    /*-----------------微信网页版协议分析（2）-获取信息----------------------*/

    /**
     * 微信初始化请求
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function webWxInit()
    {
        $client = new Client();
        $res = $client->request('POST', 'https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxinit', [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8'
            ],
            'form_params' => [
                'r' => '862039733',
                'lang' => 'zh_CN',
                'pass_ticket' => 'kUY4PSgKNy4eOlWI%252FwIBMVULe3KHPVyvDqw1%252B4DVVu9McVvE2d5fL7LFOfa4iYnk ',
            ],
            'json' => [
                'BaseRequest' => [
                    'Uin' => '566148615',
                    'Sid' => 'jSsRlGGPyY7U8det',
                    'Skey' => '@crypt_14ae1b12_b73ba2673448154847d7007a2de3c53b',
                    'DeviceID' => 'e119795675188164',
                ]
            ]
        ]);

        return [
            'data' => $res->getBody()
        ];
    }

    /**
     * 通知消息已读
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isWxNotify()
    {
        $client = new Client();
        $res = $client->request('POST', 'https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxstatusnotify', [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8'
            ],
            'form_params' => [
                'pass_ticket' => 'kUY4PSgKNy4eOlWI%252FwIBMVULe3KHPVyvDqw1%252B4DVVu9McVvE2d5fL7LFOfa4iYnk ',
            ],
            'json' => [
                'BaseRequest' => [
                    'Uin' => '566148615',
                    'Sid' => 'jSsRlGGPyY7U8det',
                    'Skey' => '@crypt_14ae1b12_b73ba2673448154847d7007a2de3c53b',
                    'DeviceID' => 'e119795675188164',
                ],
                'Code' => 3,
                'FromUserName' => 'FromUserName',
                'ToUserName' => 'ToUserName',
                'ClientMsgId' => 'ClientMsgId',
            ]
        ]);

        return [
            'data' => $res->getBody()
        ];
    }

    /**
     * 获取联系人信息列表
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getContactLists()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://login.wx.qq.com/cgi-bin/mmwebwx-bin/login', [
            'query' => [
                'pass_ticket' => 'ZDJfLCa0EAKrLn2CdD7MDl%252B54GwlW0IEiwYOsm6II%252F8W57y0pF1F8fqS%252B5z4INU5',
                'seq' => 0,
                'skey' => '@crypt_14ae1b12_f59314a579c67b15f838d09feb79c17f',
                'r' => '1476608979549',
            ]
        ]);

        return [
            'data' => $res->getBody()
        ];
    }

    /**
     * 获取聊天会话列表信息
     */
    public function getChatLists()
    {
        $client = new Client();
        $res = $client->request('POST', 'https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxstatusnotify', [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8'
            ],
            'form_params' => [
                'type' => 'ex',
                'r' => '1476608979648',
                'pass_ticket' => 'kUY4PSgKNy4eOlWI%252FwIBMVULe3KHPVyvDqw1%252B4DVVu9McVvE2d5fL7LFOfa4iYnk ',
            ],
            'json' => [
                'BaseRequest' => [
                    'Uin' => '566148615',
                    'Sid' => 'jSsRlGGPyY7U8det',
                    'Skey' => '@crypt_14ae1b12_b73ba2673448154847d7007a2de3c53b',
                    'DeviceID' => 'e119795675188164',
                ],
                'List' => [
                    'UserName' => '@@e2da072e5beda58413f788fd2978b6f9fbde2ba337a71f02e1458958fcdb8371',
                    'ChatRoomId' => 'ChatRoomId'
                ]
            ]
        ]);

        return [
            'data' => $res->getBody()
        ];
    }

    /**
     * 同步刷新
     */
    public function syncCheck()
    {

    }

    /**
     * 获取消息
     */
    public function webWxSync()
    {

    }

    /*-----------------微信网页版协议分析（3）-消息接口----------------------*/


    /*-----------------微信网页版协议分析（4）-好友操作----------------------*/


}
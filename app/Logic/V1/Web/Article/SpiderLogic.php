<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/20
 * Time: 23:06
 */

namespace App\Logic\V1\Web\Article;


use App\Logic\LoadDataLogic;

class SpiderLogic extends LoadDataLogic
{

    /**
     * 爬取页面全部数据
     * @param $url
     * @return mixed|string
     */
    public function curlGetData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch,  CURLOPT_HEADER,  false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * @return mixed|string
     */
    public function getNewsInfo(){
        $url = "https://mp.weixin.qq.com/s/gKD9Rkv8CWqU26MrlJKPEQ";
        $result = $this->curlGetData($url);
        $pattern = '/<div id="img-content">[\s\S]*<ul id="js_hotspot_area" class="article_extend_area">/is';
        preg_match_all($pattern, $result, $result);
        $result = $result[0][0];
        var_dump($result);
        return $result;
    }
}
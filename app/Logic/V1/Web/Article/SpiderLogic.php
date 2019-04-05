<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/20
 * Time: 23:06
 */

namespace App\Logic\V1\Web\Article;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Article\ArticleModel;
use App\Model\V1\Article\ArticleToTagModel;

class SpiderLogic extends LoadDataLogic
{
    protected $categoryId = 0;

    protected $articleId = 0;

    protected $title = '';

    protected $uid = 0;

    protected $related = '';

    protected $recommend = '';

    protected $status = 0;

    protected $tagIds = [];

    protected $description = '';

    protected $address = '';

    protected $openTime = '';

    protected $reason = '';

    protected $price = '';

    protected $cover = '';

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
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function getNewsInfo(){
        $url = "https://mp.weixin.qq.com/s/gKD9Rkv8CWqU26MrlJKPEQ";
        preg_match_all('/(<span style="font-size: 15px;">)(.*?)((<\/span>))/', $this->curlGetData($url), $titles, PREG_SET_ORDER);
        foreach ($titles as $val) {
            $title[]['title'] = $val[2];
        }
        preg_match_all('/(<p style="text-indent: 2em;"><span style="font-size: 14px;text-indent: 2em;">)(.*?)((<\/span><\/p>))/', $this->curlGetData($url), $contents, PREG_SET_ORDER);
        foreach ($contents as $val) {
            $title[]['content'] = $val[2];

        foreach($title as $key=>$vo){
            $list[] = array_merge($vo,$title[$key]);

        }
        var_dump($list);
//        $pattern = '|[^<div id="js_article" class="rich_media"]+>(.*)</[^>]+>|U';
//        preg_match_all($pattern, $result, $content);
        // 标题
//        $title = '/<section class="135brush" data-brushtype="text" style="margin-left: -12px;text-align: center;font-size: 18px;padding: 12px 5px;box-sizing: border-box;">[\s\S]*</section>/is';
//        preg_match_all($title, $result, $result);
//        $result = $result[0][0];
//        var_dump($result);
//        $articleModel = new ArticleModel();
//        $this->reason = $result = $result[0][0];
//        $this->cover = $result = $result[0][0];
//        $articleData = $this->getAttributes(['uid', 'title', 'price', 'status','address','openTime','description','categoryId','reason','cover'], ['', null]);
//        $articleModel->setDataByHumpArray($articleData);
//        if (!$articleModel->save()){
//            throw new Exception('添加文章失败','ERROR_STORE_FAIL');
//        }
        return true;
    }
}
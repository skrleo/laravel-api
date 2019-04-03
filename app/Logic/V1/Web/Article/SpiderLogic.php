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
        $result = $this->curlGetData($url);
        $pattern = '/<div id="img-content">[\s\S]*<ul id="js_hotspot_area" class="article_extend_area">/is';
        preg_match_all($pattern, $result, $result);
        $result = $result[0][0];
        $articleModel = new ArticleModel();
        $this->reason = $result = $result[0][0];
        $this->cover = $result = $result[0][0];
        $articleData = $this->getAttributes(['uid', 'title', 'price', 'status','address','openTime','description','categoryId','reason','cover'], ['', null]);
        $articleModel->setDataByHumpArray($articleData);
        if (!$articleModel->save()){
            throw new Exception('添加文章失败','ERROR_STORE_FAIL');
        }
        return true;
    }
}
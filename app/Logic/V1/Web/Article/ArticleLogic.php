<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/13
 * Time: 19:22
 */

namespace App\Logic\V1\Web\Article;


use App\Logic\LoadDataLogic;
use App\Model\V1\Article\ArticleModel;

class ArticleLogic extends LoadDataLogic
{

    protected $articleId = 0;

    public function lists(){
        $res = (new ArticleModel())
            ->latest()
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * @return \DdvPhp\DdvUtil\Laravel\Model
     */
    public function show(){
        $articleModel = (new ArticleModel())->where('article_id',$this->articleId)->first();
        if (empty($articleModel)){
            throw new Exception('文章不存在','ARTICLE_NOT_FIND');
        }
        return $articleModel->toHump();
    }
}
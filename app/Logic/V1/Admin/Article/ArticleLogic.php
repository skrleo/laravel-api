<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 23:08
 */

namespace App\Logic\V1\Admin\Article;

use App\Logic\Exception;
use App\Logic\LoadDataLogic;
use App\Model\V1\Article\ArticleModel;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\QueryException;

class ArticleLogic extends LoadDataLogic
{
    protected $title = '';

    protected $uid = 0;

    protected $related = '';

    protected $recommend = '';

    protected $articleId = 0;

    protected $categoryId = 0;

    /**
     * @return string
     */
    public function lists()
    {
        $res = (new ArticleModel())
        ->latest()
        ->getDdvPage();
        return $res->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $articleModel = new ArticleModel();
        $articleData = $this->getAttributes(['uid', 'title', 'related', 'recommend','categoryId'], ['', null]);
        $articleModel->setDataByHumpArray($articleData);
        if (!$articleModel->save()){
            throw new Exception('添加文章失败','ERROR_STORE_FAIL');
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function update(){
        $articleModel = (new ArticleModel())->where('article_id',$this->articleId)->first();
        if (empty($articleModel)){
            throw new Exception('文章不存在','ARTICLE_NOT_FIND');
        }
        $articleData = $this->getAttributes(['uid', 'title', 'related', 'recommend','categoryId'], ['', null]);
        $articleModel->setDataByHumpArray($articleData);
        if (!$articleModel->save()){
            throw new Exception('修改文章失败','UPDATE_ARTICLE_ERROR');
        }
        return true;
    }

    /**
     * @return \DdvPhp\DdvUtil\Laravel\Model
     * @throws Exception
     */
    public function show(){
        $articleModel = (new ArticleModel())->where('article_id',$this->articleId)->first();
        if (empty($articleModel)){
            throw new Exception('文章不存在','ARTICLE_NOT_FIND');
        }
        return $articleModel->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $articleModel = (new ArticleModel())->where('article_id',$this->articleId)->first();
        if (empty($articleModel)){
            throw new Exception('文章不存在','ARTICLE_NOT_FIND');
        }
        if (!$articleModel->delete()){
            throw new Exception('删除文章失败','DESTROY_ARTICLE_FAIL');
        }
        return true;
    }

}
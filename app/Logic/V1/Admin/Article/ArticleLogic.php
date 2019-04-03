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
use App\Model\V1\Article\ArticleToTagModel;
use App\Model\V1\Article\TagModel;
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

    protected $status = 0;

    protected $categoryId = 0;

    protected $tagIds = [];

    protected $description = '';

    protected $address = '';

    protected $openTime = '';

    protected $reason = '';

    protected $price = '';

    protected $cover = '';

    protected $articleIds = [];

    /**
     * @return string
     */
    public function lists()
    {
        $res = (new ArticleModel())
        ->latest()
        ->getDdvPage()
        ->mapLists(function ($model){
            $articleToTagModel = (new ArticleToTagModel())->where('article_id',$this->articleId)
                ->get();
            foreach ($articleToTagModel as $item){
                $tagModel = (new TagModel())->where('tag_id',$item->tag_id)->first();
                if (!empty($tagModel)){
                    $tagName[] = $tagModel->name;
                }
            }
            $model->tagName = $tagName ?? [];
        });
        return $res->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $articleModel = new ArticleModel();
        $articleData = $this->getAttributes(['uid', 'title', 'price', 'status','address','openTime','description','categoryId','reason','cover'], ['', null]);
        $articleModel->setDataByHumpArray($articleData);
        if (!$articleModel->save()){
            throw new Exception('添加文章失败','ERROR_STORE_FAIL');
        }
        foreach ($this->tagIds as $tagId){
            (new ArticleToTagModel())->firstOrCreate([
                'tag_id' => $tagId['tagId'],
                'article_id' => $articleModel->getQueueableId()
            ]);
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
        $articleData = $this->getAttributes(['uid', 'title', 'related', 'status','recommend','categoryId','description'], ['', null]);
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
        $articleToTagModel = (new ArticleToTagModel())->where('article_id',$this->articleId)
            ->getHump();
        foreach ($articleToTagModel as $item){
            $tagModel = (new TagModel())->where('tag_id',$item->tagId)->firstHump(['tagId','name']);
            if (!empty($tagModel)){
                $tag[] = $tagModel;
            }
        }
        $articleModel->tags = $tag ?? [];
        return $articleModel->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function destroy(){
        $articleModel = (new ArticleModel())->where('article_id',$this->articleId)->firstHump();
        if (empty($articleModel)){
            throw new Exception('文章不存在','ARTICLE_NOT_FIND');
        }
        \DB::beginTransaction();
        try {
            $articleModel->delete();
            (new ArticleToTagModel())->whereIn('article_id',$this->articleId)->delete();
            \DB::commit();
        } catch (QueryException $exception) {
            \DB::rollBack();
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return true;
    }

    /**
     * @return bool
     */
    public function review(){
        (new ArticleModel())
            ->whereIn('article_id',$this->articleIds)
            ->get()->each(function (ArticleModel $model){
                $model->status = $this->status;
                $model->save();
            });
        return true;
    }
}
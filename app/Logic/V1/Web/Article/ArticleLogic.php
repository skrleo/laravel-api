<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/13
 * Time: 19:22
 */

namespace App\Logic\V1\Web\Article;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Article\ArticleModel;
use App\Model\V1\Article\ArticleToTagModel;
use App\Model\V1\Article\TagModel;
use App\Model\V1\User\UserBaseModel;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class ArticleLogic extends LoadDataLogic
{

    protected $articleId = 0;

    public function lists(){
        $res = (new ArticleModel())
            ->with([
                'hasOneUserBaseModel' => function(HasOneOrMany $query){
                    $query->select('uid','name','phone');
                }
            ])
            ->latest()
            ->getDdvPage()
            ->mapLists(function (ArticleModel $model){
                $model->setDataByModel($model->hasOneUserBaseModel, [
                    'uid' => 0,
                    'name' => '',
                    'phone' => ''
                ]);
                $model->removeAttribute($model->hasOneUserBaseModel);
            });
        return $res->toHump();
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
        $userBaseModel = (new UserBaseModel())->where('uid',$articleModel->uid)->firstHump();
        $articleModel->name = $userBaseModel->name ?? '';
        $articleToTagModel = (new ArticleToTagModel())->where('article_id',$this->articleId)
            ->get();
        foreach ($articleToTagModel as $item){
            $tagModel = (new TagModel())->where('tag_id',$item->tag_id)->firstHump(['tag_id','name']);
            if (!empty($tagModel)){
                $tag[] = $tagModel;
            }
        }
        $articleModel->tags = $tag ?? [];
        return $articleModel->toHump();
    }
}
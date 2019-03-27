<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/13
 * Time: 19:22
 */

namespace App\Logic\V1\Web\Article;


use App\Logic\LoadDataLogic;
use App\Logic\V1\Login\AccountLogic;
use App\Model\Exception;
use App\Model\V1\Article\ArticleModel;
use App\Model\V1\Article\ArticleToTagModel;
use App\Model\V1\Article\TagModel;
use App\Model\V1\User\UserBaseModel;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class ArticleLogic extends LoadDataLogic
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

    public function lists(){
        $res = (new ArticleModel())
            ->with([
                'hasOneUserBaseModel' => function(HasOneOrMany $query){
                    $query->select('uid','name','phone');
                }
            ])
            ->when(isset($this->categoryId),function (EloquentBuilder $query){
                $query->where('category_id',$this->categoryId);
            })
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
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        if (AccountLogic::isLogin()){
            throw new Exception('用户未登录','USER_NOT_LOGIN');
        }
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
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
    public $title = '';
    public $languageId = 0;

    /**
     * @return string
     */
    public function getDdvPage()
    {
        $res = '123';
        return $res;
    }
}
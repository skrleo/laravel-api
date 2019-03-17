<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/13
 * Time: 19:20
 */

namespace App\Http\Controllers\V1\Web\Article;


use App\Http\Controllers\Controller;
use App\Logic\V1\Web\Article\ArticleLogic;

class ArticleController extends Controller
{
    /**
     * @return ArticleLogic
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'uid' => 'integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        return  $articleLogic->lists();
    }
}
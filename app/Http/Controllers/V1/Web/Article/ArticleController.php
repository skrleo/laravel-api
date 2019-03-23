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
use App\Logic\V1\Web\Article\SpiderLogic;

class ArticleController extends Controller
{
    /**
     * @return ArticleLogic
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'categoryId' => 'integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        return  $articleLogic->lists();
    }

    /**
     * @param $articleId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($articleId){
        $this->validate(['articleId' => $articleId], [
            'articleId' => 'required|integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        return  [
            'data' => $articleLogic->show()
        ];
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function spider(){
        $this->validate(null, [
            'uid' => 'integer'
        ]);
        $articleLogic = new SpiderLogic();
        $articleLogic->load($this->verifyData);
        return[
            'data' => $articleLogic->getNewsInfo()
        ];
    }
}
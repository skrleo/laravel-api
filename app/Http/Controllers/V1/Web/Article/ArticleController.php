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
            'keyword' => 'string',
            'check' => 'integer',
            'uid' => 'integer',
            'categoryId' => 'integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        return  $articleLogic->lists();
    }

    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'uid' => 'integer',
            'title' => 'required|string',
            'price' => 'required|string',
            'cover' => 'required|string',
            'tagIds' => 'array',
            'address' => 'required|string',
            'openTime' => 'required|string',
            'categoryId' => 'required|string',
            'description' => 'required|string',
            'reason' => 'required|string',
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->store()){
            return[];
        }
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
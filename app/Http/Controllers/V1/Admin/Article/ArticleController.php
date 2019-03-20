<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 23:07
 */

namespace App\Http\Controllers\V1\Admin\Article;

use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Article\ArticleLogic;

class ArticleController extends Controller
{
    /**
     * @return string
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

    /**
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'uid' => 'required|integer',
            'title' => 'required|string',
            'tagIds' => 'required|array',
            'related' => 'required|string',
            'description' => 'required|string',
            'recommend' => 'required|string'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->store()){
            return[];
        }
    }

    /**
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($articleId){
        $this->validate(['articleId' => $articleId], [
            'articleId' => 'required|integer',
            'uid' => 'required|integer',
            'title' => 'required|string',
            'related' => 'required|string',
            'recommend' => 'required|string'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->update()){
            return[];
        }
    }
    /**
     * @param $articleId
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($articleId){
        $this->validate(['articleId' => $articleId], [
            'articleId' => 'required|integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        return[
            'data' => $articleLogic->show()
        ];
    }

    /**
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($articleId){
        $this->validate(['articleId' => $articleId], [
            'articleId' => 'required|integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->destroy()){
            return[];
        }
    }
}
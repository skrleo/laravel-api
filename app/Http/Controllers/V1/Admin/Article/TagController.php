<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/14
 * Time: 0:07
 */

namespace App\Http\Controllers\V1\Admin\Article;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Article\TagLogic;

class TagController extends Controller
{
    /**
     * @return \DdvPhp\DdvPage
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'uid' => 'integer'
        ]);
        $tagLogic = new TagLogic();
        $tagLogic->load($this->verifyData);
        return $tagLogic->lists();
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     * @throws \App\Model\Exception
     */
    public function store(){
        $this->validate(null, [
            'name' => 'required|string',
            'status' => 'required|integer',
            'description' => 'required|string',
        ]);
        $tagLogic = new TagLogic();
        $tagLogic->load($this->verifyData);
        if ($tagLogic->store()){
            return [];
        }
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     * @throws \App\Model\Exception
     */
    public function update($tagId){
        $this->validate(['tagId' => $tagId], [
            'tagId' => 'required|integer',
            'name' => 'required|string',
            'status' => 'required|integer',
            'description' => 'required|string',
        ]);
        $tagLogic = new TagLogic();
        $tagLogic->load($this->verifyData);
        if ($tagLogic->update()){
            return [];
        }
    }

    /**
     * @param $tagId
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     * @throws \App\Model\Exception
     */
    public function show($tagId){
        $this->validate(['tagId' => $tagId], [
            'tagId' => 'required|integer'
        ]);
        $tagLogic = new TagLogic();
        $tagLogic->load($this->verifyData);
        return [
            'data' => $tagLogic->show()
        ];
    }

    /**
     * @param $tagId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($tagId){
        $this->validate(['tagId' => $tagId], [
            'tagId' => 'required|integer'
        ]);
        $tagLogic = new TagLogic();
        $tagLogic->load($this->verifyData);
        if ($tagLogic->destroy()){
            return [];
        }
    }
}
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
     * @return array
     */
    public function index(){
        var_dump('222');
        return [
            'data' => '123'
        ];
    }
}
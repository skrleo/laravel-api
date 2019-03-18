<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/18
 * Time: 15:24
 */

namespace App\Model\V1\Article;


use App\Model\Model;

class ArticleToTagModel extends Model
{
    protected $table = 'article_to_tag';

    protected $primaryKey = 'id';
}
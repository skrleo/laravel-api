<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/18
 * Time: 2:17
 */

namespace App\Model\V1\Article;


use App\Model\Model;

class TagModel extends Model
{
    protected $table = 'tag';

    protected $primaryKey = 'tag_id';
}
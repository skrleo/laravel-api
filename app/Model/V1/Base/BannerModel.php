<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/8/24
 * Time: 23:30
 */

namespace App\Model\V1\Base;


use App\Model\Model;

class BannerModel extends Model
{
        public $primaryKey = 'banner_id';

        public $table = 'banner';
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/19
 * Time: 14:55
 */

namespace App\Model\V1\Site;


use App\Model\Model;

class SiteConfigModel extends Model
{
    protected $table = 'site_config';

    protected $primaryKey = 'site_id';
}
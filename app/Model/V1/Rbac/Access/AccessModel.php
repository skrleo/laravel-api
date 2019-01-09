<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/9
 * Time: 22:44
 */

namespace App\Model\V1\Rbac\Access;


use App\Model\Model;

class AccessModel extends Model
{
    protected $table = 'rbac_access';

    protected $primaryKey = 'role_id';
}
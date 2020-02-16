<?php
/**
 * 用户账户钱包
 *
 * User: chen
 * Date: 2020/2/16
 * Time: 17:42
 */

namespace App\Model\V1\User;


use App\Model\Model;

class UserWalletsModel extends Model
{
    protected $table = 'user_wallets';

    protected $primaryKey = 'id';

    protected $fillable = ["uid","balance","is_lock","can_withdraw"];
}
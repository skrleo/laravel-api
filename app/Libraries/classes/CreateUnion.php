<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2020/2/13
 * Time: 12:22
 */

namespace App\Libraries\classes;


class CreateUnion
{
    /**
     * 生成用户邀请码
     * length : 邀请码长度
     */
    public static function invitation_code($length)
    {
        $number = '123456789';
        $number_len = 8;
        $letter = 'abcdefghijklmnopqrstuvwxyz';
        $letter_len = 25;
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $rand = intval(mt_rand(0, 100));
            if (70 <= $rand && $rand < 100) {
                $key .= $number{
                mt_rand(0, $number_len)};
            } else {
                $key .= $letter{
                mt_rand(0, $letter_len)};
            }
        }
        return strtoupper($key);
    }

}
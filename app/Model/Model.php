<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 22:42
 */

namespace App\Model;


class Model extends \Illuminate\Database\Eloquent\Model
{
    use \DdvPhp\DdvUtil\Laravel\Model;

    /**
     * @var string 统一使用时间戳
     */
    protected $dateFormat = 'U';
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';
    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    public static $getCalledClassModel = [];
    /**
     * @return \App\Model\Model Model
     */
    public static function getCalledClassModel(){
        $class = get_called_class();
        if (!(isset(self::$getCalledClassModel[$class])&&self::$getCalledClassModel[$class] instanceof \App\Model\Model)){
            self::$getCalledClassModel[$class] = new $class;
        }
        return self::$getCalledClassModel[$class];
    }
    public static function tableName(){
        $model = self::getCalledClassModel();
        $table = $model->getTable();
        return $table;
    }
    public static function keyName(){
        $model = self::getCalledClassModel();
        $keyName = $model->getKeyName();
        return $keyName;

    }

}
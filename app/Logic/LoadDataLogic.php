<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 23:10
 */

namespace App\Logic;


class LoadDataLogic
{

    public $db = '';
    /**
     * LoadDataLogic constructor.
     * @param array $data
     * @throws \ReflectionException
     */
    public function __construct($data = [])
    {
        $this->load($data);
        // 连接回收站数据库
//        $this->db = \DB::connection('mysql_trash');
    }

    /**
     * @param $data
     * @return bool
     * @throws \ReflectionException
     */
    public function load($data)
    {
        if (!empty($data)) {
            $this->setAttributes($data);
            return true;
        }else{
            return false;
        }
    }
    /**
     * @param $values
     * @throws \ReflectionException
     */
    public function setAttributes($values)
    {
        // 必须是个数组
        if (is_array($values)) {
            $attributes = array_flip($this->attributes());
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    // 如果存在该属性，就直接赋值
                    $this->$name = $value;
                }
            }
        }
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function attributes()
    {
        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        foreach ($class->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        return $names;
    }

    /**
     *
     */
    public function getAttribute($key = null, $isNotReturnArrays = [], $isNotReturnArraysType = true, $isNotObject = true)
    {
        if ($isNotObject&&is_object($this->$key)){
            return null;
        }
        if (in_array($this->$key, $isNotReturnArrays, $isNotReturnArraysType)){
            return null;
        }
        return $this->$key;
    }
    /**
     * @param null $keys
     * @param array $isNotReturnArrays
     * @param bool $isNotReturnArraysType
     * @return array
     * @throws \ReflectionException
     */
    public function getAttributes($keys = null, $isNotReturnArrays = [], $isNotReturnArraysType = true, $isNotObject = true){
        if (is_string($keys)){
            $keys = explode(',', $keys);
        }
        $thisKeys = $this->attributes();
        $data = [];
        if (is_array($keys)){
            if ($keys[0]===true){
                $keysnew = [];
                foreach ($thisKeys as $index => $key){
                    if (!in_array($key,$keys,true)){
                        $keysnew[] =  $key;
                    }
                }
                $keys = $keysnew;
            }
        }else{
            $keys = $thisKeys;
        }
        if (!is_array($isNotReturnArrays)){
            $isNotReturnArrays = [$isNotReturnArrays];
        }
        if (is_array($keys)){
            foreach ($keys as $index => $key) {
                if (in_array($key, $thisKeys)) {
                    if ($isNotObject&&is_object($this->$key)){
                        continue;
                    }
                    if (in_array($this->$key, $isNotReturnArrays, $isNotReturnArraysType)){
                        continue;
                    }
                    $data[$key] = $this->$key;
                }
            }
        }
        return $data;
    }
}
<?php
/*
|--------------------------------------------------------------------------
| 全局公用自定义函数
|--------------------------------------------------------------------------
|
 */

/**
 * 创建设备ID
 *
 * @return string
 */
function guid(){
 	if (function_exists('com_create_guid')){
 		return com_create_guid();
 	}else{
 		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
 		$charid = strtoupper(md5(uniqid(rand(), true)));
 		$hyphen = chr(45);// "-"
 		$uuid = chr(123)//
 		.substr($charid, 0, 8).$hyphen
 		.substr($charid, 8, 4).$hyphen
 		.substr($charid,12, 4).$hyphen
 		.substr($charid,16, 4).$hyphen
 		.substr($charid,20,12)
 		.chr(125);//
 		return strtolower($uuid);
 	}
}

/**
 * 图片转base64编码
 *
 * @param string $img
 * @return bool|string
 */
function imgToBase64($imgUrl)
{
    if (!$imgUrl) {
        return false;
    }
    $imageInfo = getimagesize($imgUrl);
    $base64 = chunk_split(base64_encode(file_get_contents($imgUrl)));
    return 'data:' . $imageInfo['mime'] . ';base64,' . $base64;
}
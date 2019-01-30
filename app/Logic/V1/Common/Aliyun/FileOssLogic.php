<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/1/30
 * Time: 16:28
 */

namespace App\Logic\V1\Common\Aliyun;


use App\Logic\LoadDataLogic;
use OSS\Core\OssException;
use OSS\OssClient;

class FileOssLogic extends LoadDataLogic
{
    public function index(){
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->createBucket($bucket);
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }
}

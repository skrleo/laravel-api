<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2018/11/25
 * Time: 23:07
 */

namespace App\Http\Controllers\V1\Admin\Article;

use App\HelpTrait\BroadcastHttpPush;
use App\Http\Controllers\Controller;
use App\Jobs\BaseJob;
use App\Logic\V1\Admin\Article\ArticleLogic;
use Endroid\QrCode\QrCode;

class ArticleController extends Controller
{
    use BroadcastHttpPush;
    /**
     * @return string
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'uid' => 'integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        return  $articleLogic->lists();
    }

    /**
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'uid' => 'required|integer',
            'title' => 'required|string',
            'price' => 'required|string',
            'cover' => 'required|string',
            'tagIds' => 'array',
            'address' => 'required|string',
            'openTime' => 'required|string',
            'categoryId' => 'required|string',
            'description' => 'required|string',
            'reason' => 'required|string',
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->store()){
            return[];
        }
    }

    /**
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function update($articleId){
        $this->validate(['articleId' => $articleId], [
            'articleId' => 'required|integer',
            'uid' => 'required|integer',
            'title' => 'required|string',
            'price' => 'required|string',
            'address' => 'required|string',
            'openTime' => 'required|string',
            'reason' => 'required|string',
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->update()){
            return[];
        }
    }
    /**
     * @param $articleId
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($articleId){
        $this->validate(['articleId' => $articleId], [
            'articleId' => 'required|integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        return[
            'data' => $articleLogic->show()
        ];
    }

    /**
     * @return array
     * @throws \App\Logic\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($articleId){
        $this->validate(['articleId' => $articleId], [
            'articleId' => 'required|integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->destroy()){
            return[];
        }
    }

    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function review(){
        $this->validate(null, [
            'articleIds' => 'required|array',
            'status' => 'required|integer'
        ]);
        $articleLogic = new ArticleLogic();
        $articleLogic->load($this->verifyData);
        if ($articleLogic->review()){
            return[];
        }
    }

    public function test(){
        $broadcastChannel = array(
            "channel" => "private-Message",   // 通道名，`private-`表示私有
            "name" => "sayHello",    // 事件名
            "data" => array(
                "status" => 200,
                "message" => "hello world!"
            )
        );
        $this->push($broadcastChannel);
    }

    /**
     * 文件导出下载
     */
    public function export(){
        // 生成临时存储位置
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');

        var_dump(sys_get_temp_dir());

        //弹出下载对话框
        header('Content-Type: application/vnd.ms-excel');
        // 指定保存的名字
        header('Content-Disposition: attachment; filename=test.xls');

        // 读取那个临时文件，并且输出浏览器
        readfile($tempFile);
        // 删除那个临时文件
        unlink($tempFile);
    }

    /**
     *
     */
    public function getQrCode(){
        $qrCode = new QrCode();
        $qrCode->setText('123');
        $qrCode->setSize(300);
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(2);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrCode->writeFile(public_path() . '/qrcode.png');

        return [
          'data' =>   public_path() . '/qrcode.png'
        ];
    }

    /**
     * 封装 swool 妙计定时任务器
     *  see https://blog.csdn.net/m0_37082962/article/details/85991115
     */
//    public function ceshi(){
////        dispatch(new BaseJob());
//        $num = 0;
//        $microTimer = new Timer();
//        $microTimer->isMicro()->loop(function ()use ($microTimer){
//            global $num;
//            $num ++;
//            if ($microTimer->stop()){
//                $GLOBALS['num'] = 0;
//                print '执行成功';
//            }else{
//                print '执行失败';
//            }
//        },1);
//    }

    public function ceshi(){

    }
}
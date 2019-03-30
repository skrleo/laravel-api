<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/30
 * Time: 11:54
 */

namespace App\Http\Controllers\V1\Admin\Message;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Message\MessageLogic;

class MessageController extends Controller
{
    /**
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function lists(){
        $this->validate(null, [
            'status' => 'integer'
        ]);
        $mssageLogic = new MessageLogic();
        $mssageLogic->load($this->verifyData);
        return $mssageLogic->lists();
    }

    /**
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate(null, [
            'uid' => 'required|integer',
            'type' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string'
        ]);
        $mssageLogic = new MessageLogic();
        $mssageLogic->load($this->verifyData);
        if ($mssageLogic->store()){
            return [];
        }
    }

    /**
     * @param $messageId
     * @return \App\Model\V1\Message\MessageModel|\DdvPhp\DdvUtil\Laravel\Model|null|object
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function show($messageId){
        $this->validate(['messageId' => $messageId], [
            'messageId' => 'required|integer'
        ]);
        $mssageLogic = new MessageLogic();
        $mssageLogic->load($this->verifyData);
        return $mssageLogic->show();
    }

    /**
     * @param $messageId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($messageId){
        $this->validate(['messageId' => $messageId], [
            'messageId' => 'required|integer'
        ]);
        $mssageLogic = new MessageLogic();
        $mssageLogic->load($this->verifyData);
        if ($mssageLogic->destroy()){
            return [];
        }
    }

}
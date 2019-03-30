<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/30
 * Time: 11:56
 */

namespace App\Logic\V1\Admin\Message;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Message\MessageModel;

class MessageLogic extends LoadDataLogic
{
    protected $uid = 0;

    protected $type = 0;

    protected $title = '';

    protected $content = '';

    protected $messageId = 0;

    /**
     * @return \DdvPhp\DdvPage
     */
    public function lists(){
        $res = (new MessageModel())
            ->latest('created_at')
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     */
    public function store(){
        $messageModel = new MessageModel();
        $messageData = $this->getAttributes(['title', 'uid','type', 'content'], ['', null]);
        $messageModel->setDataByHumpArray($messageData);
        if (!$messageModel->save()){
            throw new Exception('添加消息失败','MESSAGE_STORE_FAIL');
        }
        return true;
    }

    /**
     * @return MessageModel|\DdvPhp\DdvUtil\Laravel\Model|null|object
     * @throws Exception
     */
    public function show(){
        $messageModel = (new MessageModel())->where('message_id',$this->messageId)->firstHump();
        if (empty($messageModel)){
            throw new Exception('该消息不存在','MESSAGE_NOT_FIND');
        }
        return $messageModel;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $messageModel = (new MessageModel())->where('message_id',$this->messageId)->firstHump();
        if (empty($messageModel)){
            throw new Exception('该消息不存在','MESSAGE_NOT_FIND');
        }
        if (!$messageModel->delete()){
            throw new Exception('该消息删除失败','MESSAGE_DESTROY_FAIL');
        }
        return true;
    }
}
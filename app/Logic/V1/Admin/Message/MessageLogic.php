<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/3/30
 * Time: 11:56
 */

namespace App\Logic\V1\Admin\Message;


use App\Logic\LoadDataLogic;
use App\Logic\V1\Login\AccountLogic;
use App\Model\Exception;
use App\Model\V1\Message\MessageModel;
use App\Model\V1\Message\UserToMessageModel;
use App\Model\V1\User\UserBaseModel;
use DdvPhp\DdvUtil\Laravel\EloquentBuilder;
use Illuminate\Database\QueryException;

class MessageLogic extends LoadDataLogic
{
    protected $uid = 0;

    protected $uids = [];

    protected $type = 0;

    protected $title = '';

    protected $status = '';

    protected $content = '';

    protected $messageId = 0;

    /**
     * @return \DdvPhp\DdvPage
     */
    public function lists(){
        $res = (new MessageModel())
            ->when(!empty($this->uid),function (EloquentBuilder $query){
                $query->where('uid',$this->uid);
            })
//            ->when(isset($this->status),function (EloquentBuilder $query){
//                $query->where('status',$this->status);
//            })
            ->latest('created_at')
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function store(){
        $messageModel = new MessageModel();
        $this->uid = AccountLogic::getLoginUid();
        $messageData = $this->getAttributes(['title', 'uid','type', 'content'], ['', null]);
        $messageModel->setDataByHumpArray($messageData);
        \DB::beginTransaction();
        try {
            if (!$messageModel->save()){
                throw new Exception('添加消息失败','MESSAGE_STORE_FAIL');
            }
            foreach ($this->uids as $uid){
                (new UserToMessageModel())->firstOrCreate([
                   'uid' => $uid['uid'],
                   'message_id' => $messageModel->getQueueableId()
                ]);
            }
            \DB::commit();
        } catch (QueryException $exception) {
            \DB::rollBack();
            throw new Exception($exception->getMessage(), $exception->getCode());
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
        $userToMessageModel = (new UserToMessageModel())->where('message_id',$this->messageId)->get();
        foreach ($userToMessageModel as $item){
            $userBaseModel = (new UserBaseModel())->where('uid',$item->uid)->firstHump(['uid','name']);
            $users[] = $userBaseModel;
        }
        $messageModel->users = $users ?? [];
        return $messageModel;
    }

    /**
     * @return bool
     * @throws Exception
     * @throws \Exception
     */
    public function destroy(){
        $messageModel = (new MessageModel())->where('message_id',$this->messageId)->firstHump();
        if (empty($messageModel)){
            throw new Exception('该消息不存在','MESSAGE_NOT_FIND');
        }
        \DB::beginTransaction();
        try {
            $messageModel->delete();
            (new UserToMessageModel())->where('message_id',$this->messageId)->delete();
            \DB::commit();
        } catch (QueryException $exception) {
            \DB::rollBack();
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return true;
    }
}
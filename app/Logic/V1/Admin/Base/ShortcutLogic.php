<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/27
 * Time: 22:13
 */

namespace App\Logic\V1\Admin\Base;


use App\Logic\LoadDataLogic;
use App\Model\Exception;
use App\Model\V1\Base\ShortcutModel;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class ShortcutLogic extends LoadDataLogic
{
    protected $uid = 0;

    protected $shortcutId = 0;

    protected $nodeId = 0;

    /**
     * 快捷方式列表
     * @return \DdvPhp\DdvPage
     */
    public function lists(){
        $res = (new ShortcutModel())
            ->where('uid',$this->uid)
            ->with([
                'hasOneNodeModel' => function(HasOneOrMany $query){
                    $query->select('node_id','label','icon','path');
                }
            ])
            ->orderByDesc('number')
            ->getDdvPage()
        ->mapLists(function (ShortcutModel $model){
            $model->setDataByModel($model->hasOneNodeModel, [
                'node_id' => 0,
                'label' => '',
                'icon' => '',
                'path' => ''
            ]);
            $model->path = substr($model->path,1);
            $model->removeAttribute('hasOneNodeModel');
        });
        return $res->toHump();
    }

    /**
     * 添加快捷方式
     * @return bool
     */
    public function store(){
        $shortcutModel = (new ShortcutModel())->firstOrCreate([
                'node_id' => $this->nodeId,
                'uid' => $this->uid
            ]);
        $shortcutModel->increment('number');
        return true;
    }

    /**
     * 删除快捷方式
     * @return bool
     * @throws Exception
     */
    public function destroy(){
        $shortcutModel = (new ShortcutModel())->where('shortcut_id',$this->shortcutId)->first();
        if (empty($shortcutModel)){
            throw new Exception('快捷方式不存在','SHORTCUT_NOT_FIND');
        }
        if (!$shortcutModel->delete()){
            throw new Exception('删除快捷方式失败','DELETE_SHORTCUT_FAIL');
        }
        return true;
    }
}
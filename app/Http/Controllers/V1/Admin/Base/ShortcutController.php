<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/27
 * Time: 22:13
 */

namespace App\Http\Controllers\V1\Admin\Base;


use App\Http\Controllers\Controller;
use App\Logic\V1\Admin\Base\ShortcutLogic;

class ShortcutController extends Controller
{
    /**
     * @return array
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'uid' => 'integer'
        ]);
        $shortcutLogic = new ShortcutLogic();
        $shortcutLogic->load($this->verifyData);
        return [
            'lists' => $shortcutLogic->lists()
        ];
    }

    /**
     * 添加快捷方式
     * @param $shortcutId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function store(){
        $this->validate([], [
            'nodeId' => 'required|integer'
        ]);
        $shortcutLogic = new ShortcutLogic();
        $shortcutLogic->load($this->verifyData);
        if ($shortcutLogic->store()){
            return [];
        }
    }

    /**
     * 删除快捷方式
     *
     * @param $shortcutId
     * @return array
     * @throws \App\Model\Exception
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function destroy($shortcutId){
        $this->validate(['shortcutId' => $shortcutId], [
            'shortcutId' => 'required|integer'
        ]);
        $shortcutLogic = new ShortcutLogic();
        $shortcutLogic->load($this->verifyData);
        if ($shortcutLogic->destroy()){
            return [];
        }
    }
}
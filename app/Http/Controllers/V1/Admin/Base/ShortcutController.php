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
     * @return \DdvPhp\DdvPage
     * @throws \DdvPhp\DdvRestfulApi\Exception\RJsonError
     * @throws \ReflectionException
     */
    public function index(){
        $this->validate(null, [
            'uid' => 'required|integer'
        ]);
        $shortcutLogic = new ShortcutLogic();
        $shortcutLogic->load($this->verifyData);
        return $shortcutLogic->lists();
    }

    /**
     * 删除快捷方式
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
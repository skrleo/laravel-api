<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/11
 * Time: 23:09
 */

namespace App\Logic\V1\Admin\User\Group;


use App\Logic\LoadDataLogic;
use App\Model\V1\User\UserGroupModel;

class UserGroupLogic extends LoadDataLogic
{
    protected $name = '';

    protected $parentId = 0;

    /**
     * 用户分组列表
     * @return UserGroupModel[]|array|\DdvPhp\DdvUtil\Laravel\EloquentCollection
     */
    public function index(){
        $groups = (new UserGroupModel())->orderByDesc('sort')
            ->getHump();
        if (!empty($groups)) {
            $groups = $this->_getGroupTree($groups, 0);
        }
        return $groups;
    }

    /**
     * 分组递归树
     * @param $groups
     * @param $groupId
     * @return array
     */
    public function _getGroupTree($groups,$groupId){
        $tree = [];
        foreach ($groups as $group) {
            var_dump($group->parentId . '&&'. $groupId);
            if ($group->parentId == $groupId) {
                var_dump('ner:' . $group->parentId . '&&'. $groupId);
                $group->children = $this->_getGroupTree($groups, $group->groupId);
                $tree[] = $group;
            }
        }
        return $tree;
    }

    /**
     * @return bool
     */
    public function store(){
        (new UserGroupModel())->firstOrCreate([
            'name' => $this->name,
            'parent_id' => $this->parentId
        ]);
        return true;
    }

    /**
     *
     */
    public function show(){

    }
}
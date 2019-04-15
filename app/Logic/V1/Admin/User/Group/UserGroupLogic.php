<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/11
 * Time: 23:09
 */

namespace App\Logic\V1\Admin\User\Group;


use App\Logic\LoadDataLogic;
use App\Model\V1\User\UserBaseModel;
use App\Model\V1\User\UserGroupModel;
use App\Model\V1\User\UserToGroupModel;

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
            if ($group->parentId == $groupId) {
                $children = $this->_getGroupTree($groups, $group->groupId);
                if (!empty($children)){
                    $group->children = $children;
                }
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
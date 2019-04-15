<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/4/11
 * Time: 23:23
 */

namespace App\Logic\V1\Admin\User\Label;


use App\Logic\LoadDataLogic;
use App\Model\V1\User\UserLabelModel;

class UserLabelLogic extends LoadDataLogic
{
    private $uid = 0;

    private $labelId = 0;

    private $name = '';

    /**
     * @return \DdvPhp\DdvPage
     */
    public function index(){
        $res = (new UserLabelModel())
            ->getDdvPage();
        return $res->toHump();
    }

    /**
     * @return array
     */
    public function store(){
        $userLabelModel = (new UserLabelModel())->firstOrCreate([
            'name' => $this->name
        ]);
        return [
            'labelId' => $userLabelModel->getQueueableId()
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2019/2/27
 * Time: 22:10
 */

namespace App\Model\V1\Base;


use App\Model\Model;
use App\Model\V1\Rbac\Node\NodeModel;

class ShortcutModel extends Model
{
    protected $table = 'shortcut';

    protected $primaryKey = 'shortcut_id';

    protected $fillable = ['uid','node_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOneNodeModel(){
        return $this->hasOne(NodeModel::class,'node_id','node_id');
    }
}
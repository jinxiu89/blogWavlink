<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/28
 * Time: 18:35
 */

namespace app\common\models;


/**
 * Class PermissionGroup
 * @package app\common\models
 */
class PermissionGroup extends Base
{
    /***
     * id 组ID
     * name 组名称
     * description 权限组描述
     * create_time 创建时间
     * @var string
     * 组和权限是一对多的关系
     */
    protected $table= "tb_permission_group";
    /**
     * 组和权限是一对多的关系
     * @return \think\model\relation\HasMany
     */
    public function permissions(){
        return $this->hasMany('Permission','gid');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/28
 * Time: 18:34
 */

namespace app\common\models;


/**
 * Class Permission
 * @package app\common\models
 */
class Permission extends Base
{
    /***
     * id  权限ID
     * gid  权限所属组
     * name  权限名称
     * handler  控制器地址
     * description 权限描述
     * create_time 创建日期
     * @var string
     */
    protected $table = "tb_permission";

    /**
     * @return \think\model\relation\BelongsTo
     */
    public function permissionGroup()
    {
        return $this->belongsTo('PermissionGroup');
    }

    /**
     * 权限和角色之间 的关系是多对多的关系
     * @return \think\model\relation\BelongsToMany
     * 1、关联模型（必须）：模型名或者模型类名  即 你从本模型关联的哪个模型，这里是Role
     * 2、中间表：默认规则是当前模型名+_+关联模型名 （可以指定模型名） 这里就可以不用解释了 这个都动，就是中间表名
     * 3、外键：中间表的当前模型外键，默认的外键名规则是关联模型名+_id 即 中间表里的 被关联的那个模型的的键 这里是pid
     * 4、关联键：中间表的当前模型关联键名，默认规则是当前模型名+_id  当前模型 指permission模型
     */
    public function roles()
    {
        return $this->belongsToMany('Role', 'permission_role', 'rid', 'pid');
    }
}
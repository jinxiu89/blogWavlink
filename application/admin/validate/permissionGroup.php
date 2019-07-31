<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/29
 * Time: 16:28
 */

namespace app\admin\validate;

use think\Validate;

/**
 * Class permissionGroup
 * @package app\admin\validate
 */
class permissionGroup extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'name' => 'require|max:16',
        'description' => 'require|max:64',
    ];
    protected $message = [
        'id.require' => '编辑时必须要有id',
        'id.number' => 'ID必须为数字',
        'name.require' => '组名必须填',
        'name.max' => '权限组名最长不超过16个字符',
        'description.require' => '描述是管理时需要用到的信息，必须要填好',
        'description.max' => '描述长度不能太长了64个字符为限制',
    ];
    protected $scene = [
        'edit' => ['id', 'name', 'description'],
        'add' => ['name', 'description'],
    ];
}
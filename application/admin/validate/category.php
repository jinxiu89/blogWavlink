<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/8
 * Time: 14:00
 */

namespace app\admin\validate;

use think\Validate;

/**
 * Class category
 * @package app\admin\validate
 */
class category extends Validate
{
    protected $rule = [
        "name" => "require|max:25"
    ];
    protected $message = [
        "name.require" => "分类名必须填",
        "name.max" => "分类名最长不超过25个字符"
    ];
    protected $scene = [
        'edit' => ['name'],
        'add' => [],
    ];

}
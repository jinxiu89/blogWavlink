<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/4
 * Time: 11:26
 */

namespace app\admin\validate;


use think\Validate;

/***
 * Class manager
 * @package app\admin\validate
 */
class manager extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'name' => 'require|max:16',
    ];
    protected $message = [
        'id.require' => 'id必须填',
        'id.number' => 'id必须是数字',
        'name.require' => '那么必须填',
        'name.max' => 'name必须在16个字符以下',
    ];
    protected $scene = [
        'add' => ['name'],
        'edit' => ['id', 'name'],
    ];
}
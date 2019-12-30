<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/12
 * Time: 13:33
 */

namespace app\admin\validate;


use think\Validate;

/***
 * Class language
 * @package app\admin\validate
 */
class language extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'name' => 'require',
        'code' => 'require|max:16',
        'status'=>'require|number'
    ];
    protected $message = [
        'id.require' => 'id必须填',
        'id.number' => 'id必须是数字',
        'name.require' => '语言名称必须填',
        'name.max' => 'name字段必须在16个字符以下',
        'code.require' => '那么必须填',
        'code.max' => 'code字段必须在16个字符以下',
        'status.require'=>'触发此异常通常是黑客攻击，请联系程序开发者',
        'status.number'=>'触发此异常通常是黑客攻击，修改了状态的值'
    ];
    protected $scene = [
        'add' => ['name', 'code','status'],
        'edit' => ['id', 'name', 'code','status'],
    ];
}
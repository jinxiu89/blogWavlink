<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/14
 * Time: 14:19
 */

namespace app\admin\validate;


use think\Validate;

/**
 * Class files
 * @package app\admin\validate
 */
class files extends Validate
{
    protected $rule = [
        'title' => 'require|max:25',
        'c_id' => 'require'
    ];
    protected $message = [
        'title.require' => '分类名必须填',
        'title.max' => '分类名最长不超过25个字符',
        'c_id.require'=>'必须选择分类',
    ];
    protected $scene = [
        'edit' => ['name'],
        'add' => [],
    ];
}
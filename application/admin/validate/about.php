<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/18
 * Time: 11:34
 */

namespace app\admin\validate;


use think\Validate;

class about extends Validate
{
    protected $rule = [
        "language_id" => 'require|number',
        "title" => 'require|max:64',
        "keywords" => 'require|max:128',
        "description" => 'require|max:120',
    ];
    protected $message = [
        "language_id.require" => '语言ID必须具备',
        "language_id.number" => '语言ID必须要正整数',
        "title.require" => '标题必须填',
        "title.max" => '标题必须在64个字符以下',
        "keywords.require" => '关键词必须填',
        "keywords.max" => "关键词最长不能超过120个字符",
        "description.require" => "描述必须填",
        "description.max" => "描述必须在128个字符以下"
    ];
    protected $scene = [
    ];
}
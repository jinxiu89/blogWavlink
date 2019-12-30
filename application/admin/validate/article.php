<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/13
 * Time: 13:43
 */

namespace app\admin\validate;


use think\Validate;

/***
 * Class article
 * @package app\admin\validate
 */
class article extends Validate
{
    protected $rule = [
        "title" => 'require|max:128',
        "ftitle" => 'max:32',
        "keywords" => 'require|max:64',
        "description" => 'require|max:255',
        "markdown" => 'require',
    ];
    protected $message = [
        "title.require" => '标题必须填',
        "title.max" => '标题必须在128个字符以下',
        "ftitle.max" => '副标题必须在32个字符以下',
        "description.require"=>'描述必须填',
        "description.max"=>'描述字数不能超过255个字符',
    ];
    protected $scene = [
        'edit' => ['id', 'name', 'title','description'],
        'add' => ['title', 'ftitle', 'keywords', 'description', 'markdown'],
    ];
}
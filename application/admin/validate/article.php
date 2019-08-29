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
        "title" => 'require|max:64',
        "ftitle" => 'require|max:16',
        "keywords" => 'require|max:64',
        "description" => 'require|max:120',
        "markdown" => 'require',
    ];
    protected $message = [
        "title.require" => '标题必须填',
        "title.max" => '标题必须在64个字符以下',
        "ftitle.require" => '副标题必须填，为了整站美观度和优化',
        "ftitle.max" => '副标题必须在16个字符以下',
    ];
    protected $scene = [
        'edit' => ['id', 'name', 'title','description'],
        'add' => ['title', 'ftitle', 'keywords', 'description', 'markdown'],
    ];
}
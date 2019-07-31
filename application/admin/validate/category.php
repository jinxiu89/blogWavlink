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
        "name" => "require|max:25",
        "title" => 'require|unique:tb_category',
        "url_title" => 'require|alpha'
    ];
    protected $message = [
        "name.require" => "分类名必须填",
        "name.max" => "分类名最长不超过25个字符",
        "title.unique" => '标题不能重复',
        "title.require" => '分类标题必须填',
        "url_title.require" => 'url标识必须填写',
        "url_title.alpha" => 'url标识必须为字母，可以是标准单词组成！'
    ];
    protected $scene = [
        'edit' => ['id', 'name', 'title', 'url_title'],
        'add' => ['name', 'title', 'url_title'],
    ];

}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/16
 * Time: 16:30
 */

namespace app\admin\validate;


use think\Validate;

/**
 * Class download
 * @package app\admin\validate
 */
class download extends Validate
{
    protected $rule = [
        'title' => 'require|max:25',
        'file_id' => 'require',
        'keywords'=>'require|max:64',
        'description'=>'require|max:255',
        'aws_key'=>'require'
    ];
    protected $message = [
        'title.require' => '文件名必须填',
        'title.max' => '分类名最长不超过25个字符',
        'file_id' =>'必须要通过产品添加或者编辑入口才能进入添加文件功能，否则添加不进去',
        'keywords.require'=>'关键词必须填',
        'keywords.max'=>'关键词不能太长，64个字符为限制',
        'description.require'=>'描述是用户识别该下载链接的重要信息，必须要填好',
        'description.max'=>'描述长度不能太长了255个字符为限制',
        'aws_key.require'=>'请上传文件',
    ];
    protected $scene = [
        'edit' => ['title'],
        'add' => [],
    ];
}
<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/31
 * Time: 9:02
 */

namespace app\admin\validate;


use think\Validate;

/***
 * Class permission
 * @package app\admin\validate
 */
class permission extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'gid' => 'require|number',
        'name' => 'require|max:16',
        'handler' => 'require',
        'description' => 'require|max:64',
    ];
    protected $message = [
        'id.require' => '编辑时必须要有id',
        'id.number' => 'ID必须为数字',
        'gid.require' => '权限组必须要有，触发这个问题，肯定是黑客在搞鬼',
        'gid.number' => '不要乱改参数,烦人，你开发的东西不被人搞么？',
        'name.require' => '组名必须填',
        'name.max' => '权限组名最长不超过16个字符',
        'description.require' => '描述是管理时需要用到的信息，必须要填好',
        'description.max' => '描述长度不能太长了64个字符为限制',
    ];
    protected $scene = [
        'edit' => ['id', 'gid', 'name', 'handler', 'description'],
        'add' => ['gid', 'name', 'handler', 'description'],
    ];
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/31
 * Time: 9:02
 */

namespace app\admin\validate;


use think\Validate;

/***
 * Class permission
 * @package app\admin\validate
 */
class permission extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'gid' => 'require|number',
        'name' => 'require|max:16',
        'handler' => 'require',
        'description' => 'require|max:64',
    ];
    protected $message = [
        'id.require' => '编辑时必须要有id',
        'id.number' => 'ID必须为数字',
        'gid.require' => '权限组必须要有，触发这个问题，肯定是黑客在搞鬼',
        'gid.number' => '不要乱改参数,烦人，你开发的东西不被人搞么？',
        'name.require' => '组名必须填',
        'name.max' => '权限组名最长不超过16个字符',
        'description.require' => '描述是管理时需要用到的信息，必须要填好',
        'description.max' => '描述长度不能太长了64个字符为限制',
    ];
    protected $scene = [
        'edit' => ['id', 'gid', 'name', 'handler', 'description'],
        'add' => ['gid', 'name', 'handler', 'description'],
    ];
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
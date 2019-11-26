<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/30
 * Time: 8:49
 */

namespace app\common\validate;
use think\Validate;

/**
 * Class number
 * @package app\common\validate
 */
class number extends Validate
{
    protected $rule=[
        'id' => 'require|number',
    ];
    protected $message=[
        'id.require'=>'ID必须传递',
        'id.number'=>'ID必须为非负数字',
    ];
}
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/30
 * Time: 8:49
 */

namespace app\common\validate;
use think\Validate;

/**
 * Class number
 * @package app\common\validate
 */
class number extends Validate
{
    protected $rule=[
        'id' => 'require|number',
    ];
    protected $message=[
        'id.require'=>'ID必须传递',
        'id.number'=>'ID必须为非负数字',
    ];
}
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd

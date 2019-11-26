<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/9/2
 * Time: 13:48
 */

namespace app\common\agency;


use think\Model;
use think\facade\Config;

class Base extends Model
{
    protected $debug = false;

    public function initialize()
    {
        parent::initialize();
        $this->debug = Config::get('app.app_debug');
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/9/2
 * Time: 13:48
 */

namespace app\common\agency;


use think\Model;
use think\facade\Config;

class Base extends Model
{
    protected $debug = false;

    public function initialize()
    {
        parent::initialize();
        $this->debug = Config::get('app.app_debug');
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
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
}
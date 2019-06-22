<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/6
 * Time: 18:00
 */

namespace app\common\models;


use think\Model;
use think\facade\Config;

/**
 * Class Base
 * @package app\common\models
 */
class Base extends Model
{
    protected $debug = false;

    public function initialize()
    {
        parent::initialize();
        $this->debug = Config::get('app.app_debug');
    }
}
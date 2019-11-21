<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/5
 * Time: 15:02
 */

namespace app\admin\controller;

use think\Request;

/**
 * Class Index
 * @package app\admin\controller
 *
 *
 *
 *
 *
 */
class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}
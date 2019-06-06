<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/6
 * Time: 17:52
 */

namespace app\admin\controller;

/***
 * Class Language
 * @package app\admin\controller
 */
class Language extends Base
{
    /***
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }
}
<?php

namespace app\home\controller;



/**
 * Class Index
 * @package app\index\controller
 */
class Index extends Base
{


    /***
     * @return mixed
     */
    public function index()
    {
        return $this->fetch($this->theme . '/index/index.html');
    }
}

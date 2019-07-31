<?php

namespace app\home\controller;


/**
 * Class Index
 * @package app\index\controller
 */
class Product extends Base
{


    /***
     * @return mixed
     */
    public function index()
    {
        print_r($this->language);
        return "hello";
    }
}

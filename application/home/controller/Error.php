<?php


namespace app\home\controller;


use think\View;

class Error extends Base
{
    public function notFound()
    {
        return \view('', '', $code = 404);
    }
}
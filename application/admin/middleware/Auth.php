<?php

/**
 * 中间件
 *
 *
 *
 *
 *
 */

namespace app\admin\middleware;

use app\common\agency\auth as authAgency;
use Closure;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;

class Auth
{


    public function handle($request, Closure $closure)
    {
        $session = Session::get('adminUser', 'admin');
        $request->see = $session;


        return $closure($request);
    }


}
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

use Closure;

class Auth
{
    public function handle($request,Closure $closure)
    {
        echo '556';
        return $closure($request);
    }

}
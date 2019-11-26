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
use think\Controller;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;

class Auth extends Controller
{
    public function handle($request, Closure $closure)
    {
        if (Session::has('adminUser', 'admin')) {
            $session = Session::get('adminUser', 'admin');
            $this->user = $session;
            $this->assign('session', $session);
        } else {
            $this->redirect('/' . $this->backendPrefix . '/login.html');
        }
        /***
         * 权限核对
         * 这里把变量名命名为handler是有深意的，所有的访问控制器/方法 理论上都是为操作者打开一扇门，这扇门允不允许你进去，就看你有没有这个门的权限
         * 允许直接访问的页面
         * 1、获取到被访问的handler(即访问的控制器/方法，数据库访问节点存储的就是这个数据)
         * 2、把当前用户所拥有的权限的handlers拿到，然后 用in_array()来判断他是否有访问的权限
         * 3、如果是超级用户，他不需要授权，直接通行？
         * checkPermission（）方法负责检查权限
         */
        $handler = request()->controller() . '/' . Request::action();
        $notCheck = Config::get('app.not_check');
        //todo:: 免校验的Handler还没处理
        $uid = $session['id'];
        $check = (new authAgency())->checkPermission($handler, $notCheck, $uid);
        if ($check['status'] == false) {//假，没权限
            $che = $this->assign('access', $check['data']);
            return show(0, $check['message']);
        } else {//有权限
            $this->assign('access', $check['data']);
        }
        $request->che = $this->assign('access', $check['data']);
        return $closure($request);
    }


}
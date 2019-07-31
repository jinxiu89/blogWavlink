<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/5
 * Time: 15:57
 */

namespace app\admin\controller;

use think\Controller;
use app\common\models\Manager;
use think\Request;
use think\facade\Session;
use app\admin\agency\language;

class Auth extends Controller
{
    protected $next;

    public function login()
    {
        if (Session::has('adminUser', 'admin')) {
            $this->redirect('/wavlink/index.html');
        }

        if (input('next')) {
            $this->next = input('next');
        } else {
            $this->next = '/wavlink/index.html';
        }
        if (Request()->isGet()) {
            $result = (new language())->getAll();//获取语言的数据列表
            if ($result['status'] == true) {
                $this->assign('language', $result['data']);
            }
            return $this->fetch();
        }

        if (Request()->isAjax()) {
            $data = input('post.');
            if (!captcha_check($data['captcha'])) {
                return show(false, '验证码错误', $this->next);
            }
            $result = ((new Manager())->login($data, $this->next));
            return $result;
        }
    }

    public function logout()
    {
        if (Request()->isGet()) {
            Session::delete('adminUser', 'admin');
            Session::delete('language', 'admin');
            $this->redirect('/wavlink/login.html');
        }
    }
}
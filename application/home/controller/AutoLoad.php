<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/19
 * Time: 10:37
 */

namespace app\home\controller;


use think\Controller;
use think\facade\Cookie;
use think\facade\Request;

/***
 * Class AutoLoad
 * @package app\home\controller
 */
class AutoLoad extends Controller
{
    /***
     *
     * @return \think\response\Redirect
     * 自动跳转 只获取到code 取值有两个地方  1、cookie 里的lang_var 2、 通过header 获取到 到浏览器的首要语言
     * 不对this->language 赋值
     */
    public function autoload()
    {
        $code = Cookie::get('lang_var') ? Cookie::get('lang_var') : autoGetLang(Request::header());
        return redirect('/' . $code . '/main.html', [], 200);
    }

    /***
     * @param $code
     * @return \think\response\Redirect
     * 这里跳转只设置lang_var值 然后跳转到 main函数
     */
    public function setLanguage($code)
    {
        Cookie::set('lang_var', $code);
        return redirect('/' . $code . '/main.html', [], 200);
    }
}
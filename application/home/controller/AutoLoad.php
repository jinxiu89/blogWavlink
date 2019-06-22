<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/19
 * Time: 10:37
 */

namespace app\home\controller;


use app\common\models\Language;
use think\Controller;
use think\facade\Cookie;
use think\facade\Request;

/***
 * Class AutoLoad
 * @package app\home\controller
 */
class AutoLoad extends Controller
{
    protected $language;

    /***
     *
     */
    public function initialize()
    {
        parent::initialize();
    }

    /***
     *
     * @return \think\response\Redirect
     */
    public function autoload()
    {
        $this->language = Cookie::get('lang_var') ?
            (new Language())->getLanguageByCode(Cookie::get('lang_var')) :
            (new Language())->getLanguageByCode(autoGetLang(Request::header()));
        return redirect('/' . $this->language['code'] . '/index.html', [], 200);
    }

    /***
     * @param $code
     * @return \think\response\Redirect
     */
    public function setLanguage($code)
    {
        $this->language = (new Language())->getLanguageByCode($code);
        Cookie::set('lang_var', $this->language['code']);
        return redirect('/' . $this->language['code'] . '/index.html', [], 200);
    }
}
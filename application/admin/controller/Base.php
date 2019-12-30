<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/6
 * Time: 15:44
 */

namespace app\admin\controller;

use app\admin\agency\category as CategoryAgency;
use app\common\agency\auth as authAgency;
use app\common\helper\Category as CategoryHelper;
use app\common\models\Language;
use think\App;
use think\Controller;
use think\Exception;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;

/**
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    protected $toLevel;
    protected $backendPrefix;
    protected $user;
    protected $websiteName; //所有的页面的后缀；
    protected $auth;//认证类
    protected $language;
    protected $url;
    protected $fileHost;
    protected $agency;
    /***
     * @var array
     * beforActionList 是用于在运行该控制器时 第一个先运行的几个方法名，很有必要，不然initialize方法会臃肿不堪，home模块也一样这里不赘述
     *
     */


    protected $beforeActionList = [
        'languageList', 'CategoryTree', 'init', 'Auth'
    ];

    public function __construct(App $app = null)
    {
        parent::__construct($app);

    }

    public function initialize()
    {
        parent::initialize();
        $this->language = Session::get('language', 'admin');//在用户登录时选择的语言会被存储在language中，后台所有的操作都将携带该属性
        $this->backendPrefix = Config::get('app.backend_prefix');
        $this->assign('language', $this->language);
    }

    protected function CategoryTree()
    {
        $category = (new CategoryAgency())->getCategory($this->language['id']);
        $this->toLevel = CategoryHelper::toLevel($category, '-', 0, 0);
    }

    /***
     * 登录和权限验证在Auth方法里处理
     */
    protected function Auth()
    {
        if (Session::has('adminUser', 'admin')) {
            $session = Session::get('adminUser', 'admin');
            $this->user = $session;
            $this->assign('session', $session);
        } else {
            $this->redirect('/' . $this->backendPrefix . '/login.html');
        }
        /**
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
            $this->assign('access', $check['data']);
            return show(0, $check['message']);
        } else {//有权限
            $this->assign('access', $check['data']);
        }
    }

    /**
     * 初始化配置信息
     */
    protected function init()
    {
        $this->backendPrefix = Config::get('app.backend_prefix');
        $this->websiteName = Config::get('app.website_name');
        $this->fileHost = Config::get('app.fileHost');
        $this->assign('backendPrefix', $this->backendPrefix);
        $this->assign('app_name', $this->websiteName);
        $this->assign('fileHost', $this->fileHost);
    }

    protected function languageList()
    {
        $languageList = (new Language())->getAll();
        $this->assign('languageList', $languageList);
    }

    /***
     * @param $code
     * @return \think\response\Redirect
     * 后台前台可以设置自己管理的内容个的语言
     *
     */
    public function ChangeLanguage($code)
    {
        $language = (new Language())->getLanguageByCode($code);
        $next = Request::header('referer');
        session('language', $language, 'admin');
        return redirect($next);
    }

    /**
     * @return string
     * 清理缓存
     *
     */
    public function CacheClear()
    {
        $cachedir = __DIR__.'/../../../runtime/cache';
        if (is_empty_dir($cachedir)){
            return show(true,'很干净，不用清理！');;
        }
        try {
            if (deltree($cachedir)===true){
                return show(true,'清理成功！');
            };
        } catch (Exception $exception) {
            return show(false,$exception->getMessage());
        }
        return show(false,'清理失败，原因未知！');
    }
}
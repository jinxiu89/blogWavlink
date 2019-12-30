<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/18
 * Time: 15:10
 */

namespace app\home\controller;


use think\App;
use think\Controller;
use think\facade\Config;
use think\facade\Cookie;
use think\facade\Lang;
use think\facade\Request;
use app\common\models\Language;
use app\common\models\Setting;
use app\common\models\Category as CategoryModel;
use app\common\helper\Category as CategoryHelper;
use app\common\models\About as AboutModel;
use app\common\models\Article as ArticleModel;


/**
 * Class Base
 * @package app\home\controller
 *
 */
class Base extends Controller
{
    protected $module;
    protected $theme;
    protected $language;
    protected $languageList;
    protected $setting;
    protected $CatalogTree;
    protected $about;
    protected $lastUpdate;
    protected $fileHost;
    protected $agency;
    protected $code;
    protected $beforeActionList = [
        'setLanguage', 'setting', 'category', 'about', 'lastUpdate', 'PanelData', 'languageList', 'getAllArticle'
    ];

    public function initialize()
    {
        /***
         * 20190619 'setLanguage',
         * 定义成员变量 theme  language  module  三个 容器
         * module 只当前的模块,即home模块
         * 他用来定义主题的初始目录 以及 语言加载的目录
         */
        parent::initialize();

        /***
         * 获取当前模型名
         */
        $this->module = $this->request->module();
        /***
         * 指定主题模板目录，设置在app.php中设置
         */
        $this->theme = APP_PATH . $this->module . '/view' . Config::get('app.theme');
    }

    public function __construct(App $app = null)
    {
        //判断URL地址与cookie是否一致，地址栏地址为准
        $this->code = Cookie::get('lang_var');
        $path=Request::path();
        $newcode = explode('/',$path)[0];
        if ($newcode!=$this->code){
            Cookie::set('lang_var',$newcode);
        }
        parent::__construct($app);
    }
    /***
     * 20190620
     * 前置操作：
     * 设置语言
     * 修复问题，当用户输入完整的url地址到网站时，语言无法变动，例如 用户访问http://blog.wavlink.com/zh-CN/main.html的话，如果他的
     * 浏览器是英文的话，他不会变为中文的界面，而是英文界面，即地址和网站语言不一致
     * $url = Request::url();
     * $userSelect = explode('/', $url);
     * if ($userSelect) {
     *     $lang_var = $userSelect[1];
     * } else {
     *     $lang_var = Cookie::get('lang_var') ? Cookie::get('lang_var') : autoGetLang(Request::header());
     * }
     * 20190830
     */
    protected function setLanguage()
    {
        $lang_var = Cookie::get('lang_var') ? Cookie::get('lang_var') : autoGetLang(Request::header());
        if (empty($this->language))
        {
            $this->language = (new Language())->getLanguageByCode($lang_var);
        }
        Lang::load(APP_PATH . $this->module . '/lang/' . $this->language['code'] . ".php");
        $this->assign('lang_var', $lang_var);

    }

    /***
     * 20190620
     * 前置操作：优化init方法
     * 设置不需要缓存，切换语言需要自动更换
     */
    protected function setting()
    {
        /***
         * 拿到系统的设置项目，所有的项目都附带language_id参数
         *
         */
        $this->fileHost = Config::get('app.fileHost');
        $this->setting = (new Setting())->getDataById($this->language['id']);
        $this->assign('setting', $this->setting);
        $this->assign('fileHost', $this->fileHost);
    }

    /***
     * 20190620
     * 获取文章分类
     * 后期加缓存
     *
     */
    protected function category()
    {
        $category = (new CategoryModel())->getCategoryByLanguage($this->language['id']);
        $this->CatalogTree = CategoryHelper::toLayer($category, 'child', 0);
        $this->assign('CatalogTree', $this->CatalogTree);
    }

    /***
     * 20190620
     * 获取关于我们的数据
     * 不需要缓存
     */
    protected function about()
    {
        /***
         * 关于我们
         */
        $this->about = (new AboutModel())->getDataByLanguageId($this->language['id']);
        $this->assign('about', $this->about);

    }

    /***
     * 20190620
     * 获取最近更新数据
     */
    protected function lastUpdate()
    {
        /***
         * 最新文章
         * 有缓存
         */
        $this->lastUpdate = (new ArticleModel())->getLastUpdateList($this->language['id']);
        $this->assign('lastUpdate', $this->lastUpdate);
    }

    /***
     * 获取 语言列表
     * 有缓存，这里有缓存 ，影响因素是加语言后不出来到列表里，后期在后台开发清缓存功能
     */
    protected function languageList()
    {
        $this->languageList = (new Language())->getAll();
        $this->assign('languageList', $this->languageList);
    }

    /***
     * 获取 聚合数据
     * 需要缓存，影响文章统计数据
     *
     */
    protected function PanelData()
    {
        /***
         * 文章总数
         */
        $ArticleCounts = (new ArticleModel())->getCountByLanguageId($this->language['id']);

        /***
         *  公共组建赋值
         * 有缓存
         */
        $this->assign('ArticleCounts', $ArticleCounts);
    }

    protected function getAllArticle()
    {
        $Article = (new ArticleModel())->getDataByLanguage($this->language['id']);
        $this->assign('ArticleData', $Article);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/18
 * Time: 15:10
 */

namespace app\home\controller;


use think\Controller;
use think\facade\Cache;
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
    protected $beforeActionList = [
        'setLanguage', 'setting', 'category', 'about', 'lastUpdate', 'PanelData', 'languageList', 'getAllArticle'
    ];

    public function initialize()
    {
        /***
         * 20190619
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

    /***
     * 20190620
     * 前置操作：
     * 设置语言
     */
    protected function setLanguage()
    {
        /***
         * 拿到系统支持的语言，如果不支持，将会默认en-us
         * 缓存已设置为假时设置，为ture时  不缓存
         */
        $this->language = Cookie::get('lang_var') ? (new Language())->getLanguageByCode(Cookie::get('lang_var')) : (new Language())->getLanguageByCode(autoGetLang(Request::header()));
        /***
         * 记住用户选择的语言
         */
        Lang::load(APP_PATH . $this->module . '/lang/' . $this->language['code'] . ".php");
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
        $this->setting = (new Setting())->getDataById($this->language['id']);
        $this->assign('setting', $this->setting);
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
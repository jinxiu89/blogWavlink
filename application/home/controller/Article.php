<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/26
 * Time: 11:51
 */

namespace app\home\controller;

use app\common\agency\category as agency;
use app\common\agency\article as ArticleAgency;
use think\App;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\View;

/***
 * Class Article
 * @package app\home\controller
 */
class Article extends Base
{
    protected $categoryAgency;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->ArticleAgency = new ArticleAgency();
        $this->categoryAgency = new agency();
    }

    /***
     * @param $category
     * @return mixed
     * 1、根据category 名 来查出他自己的SEO信息 以及 他的之分类ID 并组合成ids数组
     */
    public function lists($category)
    {
        if (request()->isGet()) {
            if (!isset($category)) {
                return "hello";
            }
            $categorys = $this->categoryAgency->getChild($category, $this->language['id']); // 获取SEO信息 以及 他的子分类ID
            $ids = $categorys['ids'];
            $result = $this->categoryAgency->getDataByIds($category, $ids, $this->language['id']);//根据分类ID（ID为Int的一个数组）
            $this->assign('seo', $categorys['category']);
            if ($result['status'] == true) {
                $this->assign('data', $result['data']);
            }
            return $this->fetch($this->theme . '/article/lists.html');
        }
    }

    /**
     * @param $url_title
     * @return mixed
     * 2019-11-28 修改点击次数BUG
     * 第一个if 判断路由访问方式  方式正确  通过 $url_title 条件获取文章
     *
     * 第二个if 判断该文章状态是否正常 否则抛出500错误页面
     *
     * 第三个if 判断是否在120秒之内重复点击  点击过后会设置cookie 获取cookie 是否存在？
     *         不存在则进行更新且设置新得cookie $ip获取 用户ip加密 与$url_title 拼接  生成本次唯一cookie
     *
     */
    public function details($url_title)
    {
        if (request()->isGet()) {
            $result = (new ArticleAgency())->getDataByUrl_title($url_title);
            //dump($result['status']);exit();
            if ($result['status']==1) {
                $ip = Request::ip();
                if (empty(Cookie::has(md5($ip).$url_title, 'home_'))) {
                    $result['data']['clicks']++;
                    Cookie::set(md5($ip).$url_title,1, ['prefix' => 'home_', 'expire' => 120]);
                    (new ArticleAgency())->updateClicks($result['data']);
                }
                $this->assign('data', $result['data']);
                return $this->fetch($this->theme . '/article/details.html');
            }else{

                return View::fetch('/500');
            }

        }
    }
}
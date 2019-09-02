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

    public function details($url_title)
    {
        if (request()->isGet()) {
            $result = (new ArticleAgency())->getDataByUrl_title($url_title);
            if ($result['status']) {
                $result['data']['clicks']++;
                $ip = Request::ip();
                if (empty(Cookie::has(md5($ip), 'home_'))) {
                    Cookie::set(md5($ip), $url_title, ['prefix' => 'home_', 'expire' => 120]);
                    (new ArticleAgency())->updateClicks($result['data']);
                }
                $this->assign('data', $result['data']);
            }
            return $this->fetch($this->theme . '/article/details.html');
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/12
 * Time: 15:32
 */

namespace app\admin\controller;

use app\admin\agency\article as articleAgency;
use think\Request;

/***
 * Class Article
 * @package app\admin\controller
 */
class Article extends Base
{
    protected $url;

    /***
     * @return false|string|void
     */
    public function initialize()
    {

        parent::initialize();
        $this->url = '/' . $this->backendPrefix . '/article/list.html';
        $category = (new articleAgency())->getCategory($this->language['id']);
        $this->assign('category', json_encode($category));
    }

    /**
     * @return      mixed
     * @function    index   所有文章列表
     * @array       result  逻辑层返回的结果
     */
    public function index()
    {
        $result = (new articleAgency())->getAll($this->language['id']);
        if ($result['status']==true){
            $this->assign('data', $result['data']['paginate']);
            $this->assign('count', $result['data']['count']);
            //dump($result);exit();
            return $this->fetch();
        }else{
            abort(404,$result['message']);
        }
    }

    /**
     * @param       $category_id            分类ID
     * @return      mixed
     * @function    articleListByCategory  按分类获取文章列表
     * @array       result                 逻辑层返回的结果
     */
    public function articleListByCategory($category_id)
    {
        $result = (new articleAgency())->getDataByCategoryId($category_id);
        if ($result['status']==true){
            $this->assign('data', $result['data']['paginate']);
            $this->assign('count', $result['data']['count']);
            return $this->fetch();
        }else{
            abort(404,$result['message']);
        }
    }

    /**
     * @return false|mixed|string
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if (request()->isGet()) {
            $this->assign('to_level', $this->toLevel);
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $markdown_html = strip_html_tags(['style', 'script'], $data['markdown-html-code'], true);
            $refer_html = strip_html_tags(['style', 'script'], $data['refer-html-code'], true);
            $data['markdown_html_code'] = $markdown_html;
            $data['thumbnail'] = getThumb($data['markdown_html_code']);
            $data['refer_html_code'] = $refer_html;
            unset($data['markdown-html-code']);
            unset($data['refer-html-code']);
            $data['user_id'] = $this->user['id'];
            $data['language_id'] = $this->language['id'];//语言
            $data['url_title'] = md5(uniqid());//随机生成url_title
            $result = (new articleAgency())->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            } else {
                return show($result['status'], $result['message']);
            }
        }
    }

    /***
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        if ($this->request->isGet()) {
            $result = (new articleAgency())->getDataById($id);
            $this->assign('to_level', $this->toLevel);
            $this->assign('data', $result);
            return $this->fetch();
        }
        if ($this->request->isPost()) {
            $data = input('post.');
            $markdown_html = strip_html_tags(['style', 'script'], $data['markdown-html-code'], true);
            $refer_html = strip_html_tags(['style', 'script'], $data['refer-html-code'], true);
            $data['markdown_html_code'] = $markdown_html;
            $data['thumbnail'] = getThumb($data['markdown_html_code']);
            $data['refer_html_code'] = $refer_html;
            unset($data['markdown-html-code']);
            unset($data['refer-html-code']);
            $result = (new articleAgency())->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            } else {
                return show($result['status'], $result['message']);
            }
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/12
 * Time: 15:32
 */

namespace app\admin\controller;

use app\admin\agency\article as articleAgency;

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

    /***
     *
     */
    public function index()
    {
        $result = (new articleAgency())->getAll($this->language['id']);
        $this->assign('data', $result['data']);
        $this->assign('count', $result['count']);
        return $this->fetch();
    }

    public function list($category_id)
    {
        $result = (new articleAgency())->getDataByCategoryId($category_id);
        $this->assign('data', $result['data']);
        $this->assign('count', $result['count']);
        return $this->fetch();

    }

    public function add()
    {
        if (request()->isGet()) {
            $this->assign('to_level', $this->toLevel);
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $markdown_html = strip_html_tags(['style', 'script', 'iframe'], $data['markdown-html-code'], true);
            $refer_html = strip_html_tags(['style', 'script', 'iframe'], $data['refer-html-code'], true);
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
        if (request()->isGet()) {
            $result = (new articleAgency())->getDataById($id);
            $this->assign('to_level', $this->toLevel);
            $this->assign('data', $result);
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $markdown_html = strip_html_tags(['style', 'script', 'iframe'], $data['markdown-html-code'], true);
            $refer_html = strip_html_tags(['style', 'script', 'iframe'], $data['refer-html-code'], true);
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
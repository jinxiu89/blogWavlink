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
    protected $agency;
    protected $url;

    /***
     * @return false|string|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->agency = new articleAgency();
        $this->url = '/' . $this->backendPrefix . '/article/list.html';
    }

    /***
     *
     */
    public function index()
    {
        $result = $this->agency->getAll($this->language['id']);
        $this->assign('data', $result);
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
            $data['user_id'] = $this->user['id'];
            $data['create_at'] = date('Y-m-d', time());//创建时间
            $data['language_id'] = $this->language['id'];//语言
            $data['url_title'] = md5(uniqid());//随机生成url_title
            $result = (new articleAgency())->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            }else{
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
            $result = $this->agency->getDataById($id);
            $this->assign('to_level', $this->toLevel);
            $this->assign('data', $result);
            return $this->fetch();
        }
        if(request()->isPost()){
            $data=input('post.');
            $result = $this->agency->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            }else{
                return show($result['status'], $result['message']);
            }
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/18
 * Time: 10:48
 */

namespace app\admin\controller;

use app\admin\agency\about as agency;
use think\App;

/***
 * 创建日期：20190618
 *
 * Class About
 * @package app\admin\controller
 */
class About extends Base
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->agency=new agency();
    }

    /**
     *
     * @return false|string|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->url = '/' . $this->backendPrefix . '/system/about/list.html';
    }

    public function index()
    {
        $result = $this->agency->getAllData($this->language['id']);
        if ($result['status'] == true) {
            $this->assign('data', $result['data']);
        }
        return $this->fetch();
    }

    public function add()
    {
        if (request()->isGet()) {
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $data['language_id'] = $this->language['id'];
            $result = $this->agency->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            } else {
                return show($result['status'], $result['message']);
            }
        }
    }

    public function edit($id)
    {
        if (request()->isGet()) {
            $result = $this->agency->getDataById($id);
            if($result['status']){
                if(!empty($result['data'])){
                    $this->assign('data',$result['data']);
                }else{
                    return show($result['status'], "数据不存在");//这里要传到前端一个标准的报错信息
                }
            }
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $data['language_id'] = $this->language['id'];
            $result = $this->agency->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            } else {
                return show($result['status'], $result['message']);
            }
        }
    }
}
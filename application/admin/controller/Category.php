<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/5
 * Time: 15:02
 */

namespace app\admin\controller;


use app\admin\agency\category as agency;
use think\App;


/**
 * Class Index
 * @package app\admin\controller
 */
class Category extends Base
{

    /**
     * Category constructor.
     * @param App|null $app
     *
     */
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->agency = new agency();
    }

    public function initialize()
    {
        parent::initialize();
        $this->url = '/' . $this->backendPrefix . '/article/category/list.html';

    }

    public function index()
    {
//        $data = (new agency())->getCategory($this->language['id']);
        $data = $this->agency->getCategory($this->language['id']);
        $count = $data->count();
        return $this->fetch('', [
            'data' => $data,
            'count' => $count
        ]);
    }

    /***
     * @return false|mixed|string
     */
    public function add()
    {
        if (Request()->isGet()) {
            return $this->fetch('', [
                'to_level' => $this->toLevel,
            ]);
        }
        if (Request()->isPost()) {
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
        if (Request()->isGet()) {
            $data = $this->agency->getDataById($id);
            if ($data) {
                return $this->fetch('', [
                    'data' => $data,
                    'to_level' => $this->toLevel
                ]);
            } else {
                return "数据库错误";
            }
        }
        if (Request()->isPost()) {
            $data = input('post.');
            $result = $this->agency->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            } else {
                return show($result['status'], $result['message']);
            }
        }
    }
}
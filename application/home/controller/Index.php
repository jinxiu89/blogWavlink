<?php

namespace app\home\controller;

use app\common\agency\article;


/**
 * Class Index
 * @package app\index\controller
 */
class Index extends Base
{


    /***
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 20190902：为方便以后扩展，统一数据返回接口格式
     *
     */
    public function index()
    {
        $result = (new article())->getDataByLanguage($this->language['id']);
        if ($result['status'] == true) {
            $this->assign('data', $result['data']);
        }
        return $this->fetch($this->theme . '/index/index.html');
    }
}

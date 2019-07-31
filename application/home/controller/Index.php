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
     */
    public function index()
    {
        $data = (new article())->getDataByLanguage($this->language['id']);
        return $this->fetch($this->theme . '/index/index.html', [
            'data' => $data,
        ]);
    }
}

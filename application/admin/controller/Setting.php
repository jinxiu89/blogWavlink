<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/17
 * Time: 10:04
 */

namespace app\admin\controller;

use app\admin\agency\setting as agency;

/***
 * Class setting
 * @package app\admin\controller
 */
class Setting extends Base
{
    /***
     * @return false|string|void
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->url = '/' . $this->backendPrefix . '/system/setting.html';
        $this->agency=new agency();
    }

    /***
     * 系统设置，
     * @return mixed
     */
    public function setting()
    {
        $language_id = $this->language['id'];
        if (request()->isGet()) {
            $data = $this->agency->getDataById($language_id);
            if ($data) {
                $this->assign('data', $data);
            }
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $data['language_id']=$this->language['id'];
            $result = $this->agency->saveData($data);
            if ($result['status']) {
                return show($result['status'], $result['message'], $this->url);
            } else {
                return show($result['status'], $result['message']);
            }
        }
    }
}
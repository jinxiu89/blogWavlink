<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/13
 * Time: 10:44
 */

namespace app\admin\agency;


use think\Model;
use app\common\models\Article as articleModel;
use app\admin\validate\article as articleValidate;

/***
 * Class post
 * @package app\admin\agency
 */
class article extends base
{
    public function initialize()
    {
        parent::initialize();
        $this->model = new articleModel();
        $this->validate = new articleValidate();
        $this->success = "保存成功！";
        $this->failed = "保存失败！";
    }

    /***
     * @param $data
     * @return array|false|string
     */
    public function saveData($data)
    {
        if (isset($data['id'])) {
            if ($this->validate->scene('edit')->check($data)) {
                try {
                    return $this->model->allowField(true)->save($data, ['id' => $data['id']]) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $exception) {
                    return show(false, $exception->getMessage(), '');
                }
            } else {
                return show(false, $this->validate->getError(), '');
            }
        }
        if ($this->validate->scene('add')->check($data)) {
            try {
                return $this->model->allowField(true)->save($data) ?
                    ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
            } catch (Exception $exception) {
                return ['status' => false, 'message' => $exception->getMessage()];
            }

        } else {
            return ['status' => false, 'message' => $this->validate->getError()];
        }
    }

    public function getAll($language_id)
    {
        try {
            return $this->model->where(['language_id' => $language_id])->order("id")->all();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getDataById($id)
    {
        return $this->model->getDataById($id);
    }
}
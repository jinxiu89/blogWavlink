<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/18
 * Time: 11:25
 */

namespace app\admin\agency;

use app\common\models\About as AboutModel;
use app\admin\validate\about as AboutValidate;
use app\common\validate\number;

/***
 * Class about
 * @package app\admin\agency
 * hello 添加 新开发者
 */
class about extends base
{
    protected $number;
    public function initialize()
    {
        parent::initialize();
        $this->model = new AboutModel();
        $this->validate = new AboutValidate();
        $this->number=new number();
        $this->success = "保存成功";
        $this->failed = "保存失败";
    }

    public function getAllData($language_id)
    {
        if(!is_numeric($language_id)){
            return ['status' => false, 'message' => 'error', 'data' => "语言Id必须为数字"];
        }
        return ['status' => true, 'message' => 'ok', 'data' => $this->model->getAllData($language_id)];
    }

    public function getDataById($id)
    {
        if(!is_numeric($id)){
            return ['status' => false, 'message' => 'error', 'data' => "Id必须为数字"];
        }
        return ['status' => true, 'message' => 'ok', 'data' => $this->model->getDataById($id)];
    }

    /***
     * hello\
     * @param $data
     * @return array
     */
    public function saveData($data)
    {
        if (isset($data['id'])) {
            //更新
            if ($this->validate->check($data)) {
                return $this->model->allowField(true)->save($data, ['id' => $data['id']]) ?
                    ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        } else {
            //保存
            if ($this->validate->check($data)) {
                return $this->model->allowField(true)->save($data) ?
                    ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        }
    }
}
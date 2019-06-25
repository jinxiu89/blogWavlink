<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/12
 * Time: 15:50
 */

namespace app\admin\agency;


use think\Config;
use think\Model;
use app\common\models\Category as CategoryModel;
use app\admin\validate\category as CategoryValidate;
use think\Exception;

class category extends base
{
    public function initialize()
    {
        parent::initialize();
        $this->model = new CategoryModel();
        $this->validate = new CategoryValidate();
        $this->success = "保存成功";
        $this->failed = "保存失败";
    }

    public function getCategory($language_id)
    {
        return $this->model->getCategory($language_id);
    }

    /***
     * @param $id
     * @return mixed
     *
     */
    public function getDataById($id){
        return $this->model->getDataById($id);
    }

    /***
     * @param $data
     * @return false|string
     */
    public function saveData($data)
    {
        if (isset($data['id'])) {
            if ($data['id'] == $data['parent_id']) {
                return ['status' => false, 'message' => '修改分类的时候所属分类不能属于他本身'];
            }
            if ($this->validate->scene('edit')->check($data)) {
                try {
                    return $this->model->allowField(true)->save($data, ['id' => $data['id']]) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message'=>$this->failed];
                } catch (Exception $exception) {
                    return ['status' => false, 'message' => $exception->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        }
        if ($this->validate->scene('add')->check($data)) {
            try {
                return $this->model->allowField(true)->save($data) ?
                    ['status' => true, 'message' => $this->success] : ['status' => false, 'message'=>$this->failed];
            } catch (Exception $exception) {
                return ['status' => false, 'message' => $exception->getMessage()];
            }

        } else {
            return ['status' => false, 'message' => $this->validate->getError()];
        }
    }
}
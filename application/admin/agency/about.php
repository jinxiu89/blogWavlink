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
 *
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
            return result(false,'语言Id必须为数字');
        }
        return $this->model->getAllData($language_id);
    }
    public function getDataById($id)
    {
        if(!is_numeric($id)){
            return result(false,'Id必须为数字');
        }
        return $this->model->getDataById($id);
    }

    /***
     * hello\
     * @param $data
     * @return array
     */
    public function saveData($data)
    {
        if(!$this->validate->check($data)){
            return result(false,$this->validate->getError());
        }else{
            return isset($data['id']) ? $this->model->updateDataBase($data,$data['id']) : $this->model->saveDataBase($data);
        }
    }
}
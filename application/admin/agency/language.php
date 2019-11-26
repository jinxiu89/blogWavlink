<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/12
 * Time: 13:28
 */

namespace app\admin\agency;


use think\Model;
use app\admin\validate\language as languageValidate;
use app\common\models\Language as languageModel;
use app\common\validate\number;
use think\Exception;

/***
 * Class language
 * @package app\admin\agency
 */
class language extends base
{
    public function initialize()
    {
        parent::initialize();
        $this->validate = new languageValidate();
        $this->model = new languageModel();
        $this->success = '保存成功！';
        $this->failed = '保存失败！';
    }

    public function getAll(){
        try {
            return ['status' => true, 'message' => 'ok', 'data' => $this->model->paginate()];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
    /***
     * @param $data
     */
    public function saveData($data)
    {
        if (isset($data['id'])) {
            //更新
            if ($this->validate->scene('edit')->check($data)) {
                try {
                    return $this->model->allowField(true)->save($data, ['id' => $data['id']]) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $exception) {
                    return ['status' => false, 'message' => $exception->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        } else {
            //保存
            if ($this->validate->scene('add')->check($data)) {
                try {
                    return $this->model->allowField(true)->save($data) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $e) {
                    return ['status' => false, 'message' => $exception->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        }
    }
    public function getDataById($data){
        $validate = new number();
        if ($validate->check($data)) {
            try {
                return ['status' => true, 'message' => "ok", 'data' => $this->model->get($data['id'])->toArray()];
            } catch (Exception $exception) {
                return ['status' => false, 'message' => $exception->getMessage()];
            }
        } else {
            return ['status' => false, 'message' => $validate->getError()];
        }
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/12
 * Time: 13:28
 */

namespace app\admin\agency;


use think\Model;
use app\admin\validate\language as languageValidate;
use app\common\models\Language as languageModel;
use app\common\validate\number;
use think\Exception;

/***
 * Class language
 * @package app\admin\agency
 */
class language extends base
{
    public function initialize()
    {
        parent::initialize();
        $this->validate = new languageValidate();
        $this->model = new languageModel();
        $this->success = '保存成功！';
        $this->failed = '保存失败！';
    }

    public function getAll(){
        try {
            return ['status' => true, 'message' => 'ok', 'data' => $this->model->paginate()];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
    /***
     * @param $data
     */
    public function saveData($data)
    {
        if (isset($data['id'])) {
            //更新
            if ($this->validate->scene('edit')->check($data)) {
                try {
                    return $this->model->allowField(true)->save($data, ['id' => $data['id']]) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $exception) {
                    return ['status' => false, 'message' => $exception->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        } else {
            //保存
            if ($this->validate->scene('add')->check($data)) {
                try {
                    return $this->model->allowField(true)->save($data) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $e) {
                    return ['status' => false, 'message' => $exception->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        }
    }
    public function getDataById($data){
        $validate = new number();
        if ($validate->check($data)) {
            try {
                return ['status' => true, 'message' => "ok", 'data' => $this->model->get($data['id'])->toArray()];
            } catch (Exception $exception) {
                return ['status' => false, 'message' => $exception->getMessage()];
            }
        } else {
            return ['status' => false, 'message' => $validate->getError()];
        }
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
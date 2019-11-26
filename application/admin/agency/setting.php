<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/17
 * Time: 11:08
 */

namespace app\admin\agency;

use app\common\models\Setting as SettingModel;
use app\admin\validate\setting as SettingValidate;
use think\Exception;
/***
 * Class setting
 * @package app\admin\agency
 */
class setting extends base
{
    public function initialize()
    {
        parent::initialize();
        $this->model=new SettingModel();
        $this->validate=new SettingValidate();
        $this->success="保存成功";
        $this->failed="保存失败";

    }

    public function setting()
    {

    }

    /***
     * @param $data
     *
     * @return array
     */
    public function saveData($data){
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

    /***
     * @param $language_id
     * @return bool|mixed
     */
    public function getDataById($language_id)
    {
        return (new SettingModel())->getDataById($language_id);
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/17
 * Time: 11:08
 */

namespace app\admin\agency;

use app\common\models\Setting as SettingModel;
use app\admin\validate\setting as SettingValidate;
use think\Exception;
/***
 * Class setting
 * @package app\admin\agency
 */
class setting extends base
{
    public function initialize()
    {
        parent::initialize();
        $this->model=new SettingModel();
        $this->validate=new SettingValidate();
        $this->success="保存成功";
        $this->failed="保存失败";

    }

    public function setting()
    {

    }

    /***
     * @param $data
     *
     * @return array
     */
    public function saveData($data){
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

    /***
     * @param $language_id
     * @return bool|mixed
     */
    public function getDataById($language_id)
    {
        return (new SettingModel())->getDataById($language_id);
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
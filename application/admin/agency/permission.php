<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/31
 * Time: 8:59
 */

namespace app\admin\agency;


use think\Model;
use app\common\models\Permission as permissionModel;
use think\Exception;
use app\admin\validate\permission as permissionValidate;
use app\common\validate\number;
use think\Validate;
use app\common\models\Role as roleModel;

/**
 * Class permission
 * @package app\admin\agency
 */
class permission extends Model
{
    protected $success = "保存成功！";
    protected $failed = "保存失败！";
    private $validate;
    private $model;

    public function initialize()
    {
        $this->validate = new permissionValidate();
        $this->model = new permissionModel();
    }

    public function getDataById($data)
    {
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

    /**
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

    public function getAll()
    {
        try {
            return ['status' => true, 'message' => 'ok', 'data' => $this->model->order(['gid' => 'asc'])->paginate()];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }



    public function savePermission($data, $id)
    {
        $permissions = [];
        foreach ($data as $k => $v) {
            $permissions[] = $k;
        }
        //操作中间表
        try {
            return $this->model->roles()->saveAll($permissions) ?
                ['status' => true, 'message' => $this->success,] : ['status' => false, 'message' => $this->failed];
        } catch (Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
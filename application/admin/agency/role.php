<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/31
 * Time: 17:07
 */

namespace app\admin\agency;

use app\common\models\Role as roleModel;
use app\admin\validate\role as roleValidate;
use think\Model;
use app\common\validate\number;
use think\Exception;

/***
 * Class role
 * @package app\admin\agency
 */
class role extends Model
{
    protected $success = "保存成功！";
    protected $failed = "保存失败！";
    private $validate;
    private $model;

    public function initialize()
    {
        $this->validate = new roleValidate();
        $this->model = new roleModel();
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

    public function getAll()
    {
        try {
            return ['status' => true, 'message' => 'ok', 'data' => $this->model->paginate()];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
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

    /***
     * 通过角色 来返回他所拥有的所有权限
     * @param $id
     * @return array
     */
    public function getDataWithPermission($id)
    {
        try {
            $role = $this->model->get($id);
            $permissions=$role->permissions;
            $plist=[];
            foreach ($permissions as $item){
                $plist[]=$item->pivot->toArray()['pid'];
            }
            return ['status' => true, 'message' => 'ok', 'data' => $plist];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    public function getPlist($data)
    {
        $plist = [];
        foreach ($data as $k) {

        }
    }

    public function checkID($data)
    {
        $validate = new number();
        if ($validate->check($data)) {
            return ['status' => true, 'message' => "ok"];
        } else {
            return ['status' => false, 'message' => $validate->getError()];
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
            $role = $this->model->get($id);
            if (!$role) {
                return ['status' => false, 'message' => '不存在'];
            }
            return $role->permissions()->saveAll($permissions) ?
                ['status' => true, 'message' => $this->success,] : ['status' => false, 'message' => $this->failed];
        } catch (Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
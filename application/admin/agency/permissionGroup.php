<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/29
 * Time: 16:10
 * agency 的解释
 * 我们每一次对逻辑的操作都非常复杂，如果在model层去操作逻辑的话会导致一个问题，就是代码冗长无比，不便于阅读
 * 现在我的思想是 控制器调用agency 里的操作逻辑，由agency里的方法去和model层沟通 操作数据库
 * 上述语义
 * 1、控制器调用agency的方法
 * 2、agency逻辑去调用model层的增删改查
 * 3、返回成功还是失败
 * 4、由控制器来抛出异常：这里理解为错误异常还是正确的异常
 */

namespace app\admin\agency;

use app\admin\validate\permissionGroup as permissionGroupValidate;
use app\common\models\PermissionGroup as groupModel;
use app\common\validate\number;
use think\Exception;

/**
 * Class permissionGroup
 * @package app\common\agency
 */
class permissionGroup extends base
{
    public function initialize()
    {
        $this->validate = new permissionGroupValidate();
        $this->model = new groupModel();
        $this->success="保存成功！";
        $this->failed="保存失败!";
    }

    /**
     * @param $data
     * @return false|string
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

    public function getAll()
    {
        try {
            return ['status' => true, 'message' => 'ok', 'data' => $this->model->paginate()];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    public function getDatawithPermission()
    {
        try {
            return [
                'status' => true,
                'message' => 'ok',
                'data' => $this->model->with('permissions')->select()->toArray()
            ];
        } catch (Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
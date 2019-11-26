<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/31
 * Time: 17:07
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

use app\admin\validate\role as roleValidate;
use app\common\models\Role as roleModel;
use app\common\validate\number;
use think\Exception;

/***
 * Class role
 * @package app\admin\agency
 */
class role extends base
{
    /***
     * 初始运行 给成员变量赋值
     */
    public function initialize()
    {
        $this->validate = new roleValidate();
        $this->model = new roleModel();
        $this->success="保存成功！";
        $this->failed="保存失败!";
    }

    /***
     * @param $data
     * 新增日期：20190531
     * 保存数据的逻辑，这个方法和大部分的存储逻辑是一样的，但也有细小的差别，所以没有合并到一起
     * 存在ID的情况下是更新方法
     * 不存在时 是保存方法，他们之间的区别在于save()方法时 一个传了ID 一个没有传ID,还有就是他们的验证场景是不一样的，因为如果传过来的ID 不是数字的话，就会出现严重错误
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

    /***
     * @return array
     * 新增日期：20190530
     * 修改：添加分页功能 20190531
     * 获得所有的数据，有翻页
     * 解释一下this->model 在agency中先定一个成员变量，然后通过 init去给他传值，这样就能通过this->model来访问model层了，
     * 包含一些复杂的方法，model成只完成数据查询操作
     */
    public function getAll()
    {
        try {
            return ['status' => true, 'message' => 'ok', 'data' => $this->model->paginate()];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    /***
     * @param $data
     * @return array
     */
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
            $permissions = $role->permissions;
            $plist = [];
            foreach ($permissions as $item) {
                $plist[] = $item->pivot->toArray()['pid'];
            }
            return ['status' => true, 'message' => 'ok', 'data' => $plist];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    /***
     * @param $data
     * @param array $plist
     * @param $id
     * @return array
     */
    public function savePermission($data, $plist = [], $id)
    {
        $permissions = [];
        foreach ($data as $k => $v) {
            $permissions[] = $k;
        }
        //操作中间表
        try {
            $role = $this->model->get($id);
            if (!$role) {
                return ['status' => false, 'message' => '该数据不存在'];
            }
            if (!empty($plist)) {
                //是更新操作，先删除原有的数据
                $role->permissions()->detach($plist);
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
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/31
 * Time: 17:07
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

use app\admin\validate\role as roleValidate;
use app\common\models\Role as roleModel;
use app\common\validate\number;
use think\Exception;

/***
 * Class role
 * @package app\admin\agency
 */
class role extends base
{
    /***
     * 初始运行 给成员变量赋值
     */
    public function initialize()
    {
        $this->validate = new roleValidate();
        $this->model = new roleModel();
        $this->success="保存成功！";
        $this->failed="保存失败!";
    }

    /***
     * @param $data
     * 新增日期：20190531
     * 保存数据的逻辑，这个方法和大部分的存储逻辑是一样的，但也有细小的差别，所以没有合并到一起
     * 存在ID的情况下是更新方法
     * 不存在时 是保存方法，他们之间的区别在于save()方法时 一个传了ID 一个没有传ID,还有就是他们的验证场景是不一样的，因为如果传过来的ID 不是数字的话，就会出现严重错误
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

    /***
     * @return array
     * 新增日期：20190530
     * 修改：添加分页功能 20190531
     * 获得所有的数据，有翻页
     * 解释一下this->model 在agency中先定一个成员变量，然后通过 init去给他传值，这样就能通过this->model来访问model层了，
     * 包含一些复杂的方法，model成只完成数据查询操作
     */
    public function getAll()
    {
        try {
            return ['status' => true, 'message' => 'ok', 'data' => $this->model->paginate()];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    /***
     * @param $data
     * @return array
     */
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
            $permissions = $role->permissions;
            $plist = [];
            foreach ($permissions as $item) {
                $plist[] = $item->pivot->toArray()['pid'];
            }
            return ['status' => true, 'message' => 'ok', 'data' => $plist];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    /***
     * @param $data
     * @param array $plist
     * @param $id
     * @return array
     */
    public function savePermission($data, $plist = [], $id)
    {
        $permissions = [];
        foreach ($data as $k => $v) {
            $permissions[] = $k;
        }
        //操作中间表
        try {
            $role = $this->model->get($id);
            if (!$role) {
                return ['status' => false, 'message' => '该数据不存在'];
            }
            if (!empty($plist)) {
                //是更新操作，先删除原有的数据
                $role->permissions()->detach($plist);
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
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/4
 * Time: 11:02
 */

namespace app\admin\agency;

use app\common\models\Manager as managerModel;
use app\common\models\Role as roleModel;
use app\admin\validate\manager as managerValidate;
use app\common\validate\number as numberValidate;
use think\Exception;
use think\facade\Config;


/***
 * Class manger
 * @package app\admin\agency
 */
class manager extends base
{
    protected $roleModel;
    protected $number;


    /***
     * he
     */
    public function initialize()
    {
        parent::initialize();
        $this->validate = new managerValidate();
        $this->model = new managerModel();
        $this->roleModel = new roleModel();
        $this->number = new numberValidate();
        $this->success="保存成功！";
        $this->failed="保存失败!";
    }

    public function getAll()
    {
        try {
            return [
                'status' => true,
                'message' => 'ok',
                'data' => $this->model->with('roles')->paginate()
            ];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    public function getRoleList()
    {
        try {
            return [
                'status' => true,
                'message' => 'ok',
                'data' => $this->roleModel->select()->toArray()
            ];
        } catch (Except $exception) {
            return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
        }
    }

    /***
     * @param $data
     * @return array
     * 更新日期：20190605
     * 该方法存在两个功能分支1、保存 2、更新
     * 判断依据就是POST数据是否存在id，如果有，说明他是编辑POST过来的数据，没有说明是新增，各走各的方法
     * 保存时，首先验证的是post数据的合法性，然后就是保存，保存完数据就需要通过多对多关联模型新增他的角色权限
     * 保存角色失败还需要滚回操作，这个在catch异常里做滚回操作
     * 对于更新操作，是比较复杂的，他先是要删除已存在的角色，然后再存入新提交过来的角色
     * 并且还要验证其合法性
     * // rlist是一维数组 例如 [1,2,4]
     */
    public function saveData($data)
    {
        $manager = $data['manager'];//管理员
        $roles = $data['roles']; //提交过来的角色
        $rlist = [];
        foreach ($roles as $key => $value) {
            $rlist[] = $key;
        }
        if (isset($manager['id'])) {
            //更新
            if (!$this->number->check(['id' => $manager['id']])) {//验证ID是否合法
                return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
            }
            if ($this->validate->scene('edit')->check($manager)) {
                $tempManager = self::getDataById(['id' => $manager['id']]);
                if ($tempManager['data']['password'] != $manager['password']) { //manager['password']如果没有更改的话就应该是相等的 不相等 就需要加密后修改
                    $manager['password'] = md5($manager['password']) . Config::get('app.user_secret');
                }
                $orlist = self::getRoleslist($tempManager['data']['roles']);
                try {
                    $temp = $this->model->get($manager['id']);
                    $temp->allowField(true)->save($manager);
                    if (!empty($orlist['data'])) {//删除他原有的角色
                        $temp->roles()->detach($orlist['data']);
                    }
                    if ($temp->roles()->saveAll($rlist)) {
                        return ['status' => true, 'message' => $this->success];
                    }
                } catch (Exception $exception) {//
                    return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
            }
        } else {
            //保存
            $manager['password'] = md5($manager['password']) . Config::get('app.user_secret');
            if ($this->validate->scene('add')->check($manager)) {
                try {
                    //1、保存管理员 2、保存角色
                    $result = $this->model->allowField(true)->save($manager);
                    if ($result) {
                        $object = $this->model->getByName($manager['name']);
                        try {
                            $object->roles()->saveAll($rlist);
                            return ['status' => true, 'message' => $this->success];
                        } catch (Exception $exception) {
                            $object->delete();
                            return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
                        }
                    } else {
                        return ['status' => false, 'message' => $this->failed];
                    }
                    return $this->model->allowField(true)->save($manager) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $exception) {
                    return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
            }
        }
    }

    /***
     * @param $data
     * @return array
     * 添加日期：20190605
     * 通过ID 来获得管理员数据，并带上他的角色数据
     * 查找结果为空的话 返回数据不存在
     * 如果ID非法的话 返回数据非法
     * 如果本身查询就出错 就返回异常信息，一般数据库错了就会出现该异常
     */
    public function getDataById($data)
    {
        if ($this->number->check($data)) {
            try {
                $data = $this->model->with('roles')->get($data['id'])->toArray();
                if (empty($data)) {
                    return ['status' => false, 'message' => '数据不存在', 'data' => []];
                }
                return ['status' => true, 'message' => 'ok', 'data' => $data];
            } catch (Exception $exception) {
                return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
            }
        } else {
            return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
        }
    }

    /***
     * @param $roles
     * 将用户的所拥有的角色编程一个数组,无论他有没有被授予某角色 都返回true 只不过是空值而已
     */
    public function getRoleslist($roles)
    {
        if (empty($roles)) {
            return ['status' => true, 'message' => 'ok', 'data' => []];
        } else {
            $data = [];
            foreach ($roles as $role) {
                $data[] = $role['id'];
            }
            return ['status' => true, 'message' => 'ok', 'data' => $data];
        }
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/4
 * Time: 11:02
 */

namespace app\admin\agency;

use app\common\models\Manager as managerModel;
use app\common\models\Role as roleModel;
use app\admin\validate\manager as managerValidate;
use app\common\validate\number as numberValidate;
use think\Exception;
use think\facade\Config;


/***
 * Class manger
 * @package app\admin\agency
 */
class manager extends base
{
    protected $roleModel;
    protected $number;


    /***
     * he
     */
    public function initialize()
    {
        parent::initialize();
        $this->validate = new managerValidate();
        $this->model = new managerModel();
        $this->roleModel = new roleModel();
        $this->number = new numberValidate();
        $this->success="保存成功！";
        $this->failed="保存失败!";
    }

    public function getAll()
    {
        try {
            return [
                'status' => true,
                'message' => 'ok',
                'data' => $this->model->with('roles')->paginate()
            ];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    public function getRoleList()
    {
        try {
            return [
                'status' => true,
                'message' => 'ok',
                'data' => $this->roleModel->select()->toArray()
            ];
        } catch (Except $exception) {
            return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
        }
    }

    /***
     * @param $data
     * @return array
     * 更新日期：20190605
     * 该方法存在两个功能分支1、保存 2、更新
     * 判断依据就是POST数据是否存在id，如果有，说明他是编辑POST过来的数据，没有说明是新增，各走各的方法
     * 保存时，首先验证的是post数据的合法性，然后就是保存，保存完数据就需要通过多对多关联模型新增他的角色权限
     * 保存角色失败还需要滚回操作，这个在catch异常里做滚回操作
     * 对于更新操作，是比较复杂的，他先是要删除已存在的角色，然后再存入新提交过来的角色
     * 并且还要验证其合法性
     * // rlist是一维数组 例如 [1,2,4]
     */
    public function saveData($data)
    {
        $manager = $data['manager'];//管理员
        $roles = $data['roles']; //提交过来的角色
        $rlist = [];
        foreach ($roles as $key => $value) {
            $rlist[] = $key;
        }
        if (isset($manager['id'])) {
            //更新
            if (!$this->number->check(['id' => $manager['id']])) {//验证ID是否合法
                return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
            }
            if ($this->validate->scene('edit')->check($manager)) {
                $tempManager = self::getDataById(['id' => $manager['id']]);
                if ($tempManager['data']['password'] != $manager['password']) { //manager['password']如果没有更改的话就应该是相等的 不相等 就需要加密后修改
                    $manager['password'] = md5($manager['password']) . Config::get('app.user_secret');
                }
                $orlist = self::getRoleslist($tempManager['data']['roles']);
                try {
                    $temp = $this->model->get($manager['id']);
                    $temp->allowField(true)->save($manager);
                    if (!empty($orlist['data'])) {//删除他原有的角色
                        $temp->roles()->detach($orlist['data']);
                    }
                    if ($temp->roles()->saveAll($rlist)) {
                        return ['status' => true, 'message' => $this->success];
                    }
                } catch (Exception $exception) {//
                    return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
            }
        } else {
            //保存
            $manager['password'] = md5($manager['password']) . Config::get('app.user_secret');
            if ($this->validate->scene('add')->check($manager)) {
                try {
                    //1、保存管理员 2、保存角色
                    $result = $this->model->allowField(true)->save($manager);
                    if ($result) {
                        $object = $this->model->getByName($manager['name']);
                        try {
                            $object->roles()->saveAll($rlist);
                            return ['status' => true, 'message' => $this->success];
                        } catch (Exception $exception) {
                            $object->delete();
                            return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
                        }
                    } else {
                        return ['status' => false, 'message' => $this->failed];
                    }
                    return $this->model->allowField(true)->save($manager) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $exception) {
                    return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
            }
        }
    }

    /***
     * @param $data
     * @return array
     * 添加日期：20190605
     * 通过ID 来获得管理员数据，并带上他的角色数据
     * 查找结果为空的话 返回数据不存在
     * 如果ID非法的话 返回数据非法
     * 如果本身查询就出错 就返回异常信息，一般数据库错了就会出现该异常
     */
    public function getDataById($data)
    {
        if ($this->number->check($data)) {
            try {
                $data = $this->model->with('roles')->get($data['id'])->toArray();
                if (empty($data)) {
                    return ['status' => false, 'message' => '数据不存在', 'data' => []];
                }
                return ['status' => true, 'message' => 'ok', 'data' => $data];
            } catch (Exception $exception) {
                return ['status' => false, 'message' => $exception->getMessage(), 'data' => []];
            }
        } else {
            return ['status' => false, 'message' => $this->validate->getMessage(), 'data' => []];
        }
    }

    /***
     * @param $roles
     * 将用户的所拥有的角色编程一个数组,无论他有没有被授予某角色 都返回true 只不过是空值而已
     */
    public function getRoleslist($roles)
    {
        if (empty($roles)) {
            return ['status' => true, 'message' => 'ok', 'data' => []];
        } else {
            $data = [];
            foreach ($roles as $role) {
                $data[] = $role['id'];
            }
            return ['status' => true, 'message' => 'ok', 'data' => $data];
        }
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
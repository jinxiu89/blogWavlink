<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/5
 * Time: 17:20
 */

namespace app\common\agency;

use app\common\models\Manager as managerModel;
use app\common\models\Role as roleModel;
use app\common\models\Permission as permissionsModel;
use think\Model;

/***
 * Class auth
 * @package app\common\agency
 */
class auth extends Model
{
    protected $managerModel;
    protected $roleModel;
    protected $permissionsModel;

    /***
     * 该类访问之前初始化的内容
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->managerModel = new managerModel();
        $this->roleModel = new roleModel();
        $this->permissionsModel = new permissionsModel();
    }

    /***
     * @param $handler
     * @param $notCheck
     * @param $uid
     * @return array|bool
     * handler是当前访问的对象
     * notCheck是负责校验权限的方法
     * 创建日期：20190606
     *
     */
    public function checkPermission($handler, $notCheck, $uid)
    {
        if ($uid != 1) {
            $_access =  self::getHandlersById($uid);
            return !in_array($handler, $_access) ?
                    ['status' => false, 'message' => "没有权限", 'data' => $_access] :
                    ['status' => true, 'message' => 'ok', 'data' => $_access];
        } else {
            return ['status' => true, 'message' => 'ok', 'data' => self::getHandlerAll()];
        }
    }

    /***
     * @param $uid
     * @return array
     * 新增日期：20190606
     * 功能：传递一个USER_id （这个id其实是不可以手动修改的，他只从session里获得）
     * todo:: 后面研究一下递归替代三维数组的操作
     */
    public function getHandlersById($uid)
    {
        $manager = $this->managerModel->with('roles')->get($uid);
        $roles = $manager->roles;
        $permissions = [];
        foreach ($roles as $role) {
            $permissions[] = $this->roleModel->with('permissions')->get($role->id)->toArray();
        }
        $temps = [];
        $handlers = [];
        foreach ($permissions as $permission) {
            foreach ($permission['permissions'] as $item) {
                $handlers[] = $item['handler'];
            }
        }
        return $handlers;
    }

    /***
     * @return array
     * 当是超级用户时，用此方法
     * 新增日期：20190606
     * 功能：当是超级用户时，返回系统后台所有的权限handler
     */
    public function getHandlerAll()
    {
        $permissions = $this->permissionsModel->all();
        $handlers = [];
        foreach ($permissions as $permission) {
            $handlers[] = $permission['handler'];
        }
        return $handlers;
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/5
 * Time: 17:20
 */

namespace app\common\agency;

use app\common\models\Manager as managerModel;
use app\common\models\Role as roleModel;
use app\common\models\Permission as permissionsModel;
use think\Model;

/***
 * Class auth
 * @package app\common\agency
 */
class auth extends Model
{
    protected $managerModel;
    protected $roleModel;
    protected $permissionsModel;

    /***
     * 该类访问之前初始化的内容
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->managerModel = new managerModel();
        $this->roleModel = new roleModel();
        $this->permissionsModel = new permissionsModel();
    }

    /***
     * @param $handler
     * @param $notCheck
     * @param $uid
     * @return array|bool
     * handler是当前访问的对象
     * notCheck是负责校验权限的方法
     * 创建日期：20190606
     *
     */
    public function checkPermission($handler, $notCheck, $uid)
    {
        if ($uid != 1) {
            $_access =  self::getHandlersById($uid);
            return !in_array($handler, $_access) ?
                    ['status' => false, 'message' => "没有权限", 'data' => $_access] :
                    ['status' => true, 'message' => 'ok', 'data' => $_access];
        } else {
            return ['status' => true, 'message' => 'ok', 'data' => self::getHandlerAll()];
        }
    }

    /***
     * @param $uid
     * @return array
     * 新增日期：20190606
     * 功能：传递一个USER_id （这个id其实是不可以手动修改的，他只从session里获得）
     * todo:: 后面研究一下递归替代三维数组的操作
     */
    public function getHandlersById($uid)
    {
        $manager = $this->managerModel->with('roles')->get($uid);
        $roles = $manager->roles;
        $permissions = [];
        foreach ($roles as $role) {
            $permissions[] = $this->roleModel->with('permissions')->get($role->id)->toArray();
        }
        $temps = [];
        $handlers = [];
        foreach ($permissions as $permission) {
            foreach ($permission['permissions'] as $item) {
                $handlers[] = $item['handler'];
            }
        }
        return $handlers;
    }

    /***
     * @return array
     * 当是超级用户时，用此方法
     * 新增日期：20190606
     * 功能：当是超级用户时，返回系统后台所有的权限handler
     */
    public function getHandlerAll()
    {
        $permissions = $this->permissionsModel->all();
        $handlers = [];
        foreach ($permissions as $permission) {
            $handlers[] = $permission['handler'];
        }
        return $handlers;
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
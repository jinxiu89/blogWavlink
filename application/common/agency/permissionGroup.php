<<<<<<< HEAD
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

namespace app\common\agency;

use app\admin\validate\permissionGroup as permissionGroupValidate;
use app\common\models\PermissionGroup as groupModel;
use app\common\validate\number;
use think\Exception;
use think\Model;

/**
 * Class permissionGroup
 * @package app\common\agency
 */
class permissionGroup extends Model
{
    protected $success = "保存成功！";
    protected $failed = "保存失败！";
    private $validate;
    private $model;

    public function initialize()
    {
        $this->validate = new permissionGroupValidate();
        $this->model = new groupModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function getGroupNameByGid($data)
    {
        $validate = new number();
        if ($validate->check($data)) {
            try {
                $result = $this->model->get($data['id'])->toArray();
            } catch (Exception $exception) {
                $result['name']=$exception->getMessage();
            }
            $result = $this->model->get($data['id'])->toArray();
            return $result['name'];
        } else {
            return "GID非法";
        }
    }
=======
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

namespace app\common\agency;

use app\admin\validate\permissionGroup as permissionGroupValidate;
use app\common\models\PermissionGroup as groupModel;
use app\common\validate\number;
use think\Exception;
use think\Model;

/**
 * Class permissionGroup
 * @package app\common\agency
 */
class permissionGroup extends Model
{
    protected $success = "保存成功！";
    protected $failed = "保存失败！";
    private $validate;
    private $model;

    public function initialize()
    {
        $this->validate = new permissionGroupValidate();
        $this->model = new groupModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function getGroupNameByGid($data)
    {
        $validate = new number();
        if ($validate->check($data)) {
            try {
                $result = $this->model->get($data['id'])->toArray();
            } catch (Exception $exception) {
                $result['name']=$exception->getMessage();
            }
            $result = $this->model->get($data['id'])->toArray();
            return $result['name'];
        } else {
            return "GID非法";
        }
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
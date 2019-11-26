<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/28
 * Time: 18:35
 */

namespace app\common\models;


/***
 * Class Role
 * @package app\common\models
 */
class Role extends Base
{
    protected $table = 'tb_role';

    /***
     * 角色和权限之间是多对多的关系
     * @return \think\model\relation\BelongsToMany
     * 1、关联模型（必须）：模型名或者模型类名  即 你从本模型关联的哪个模型，这里是Permission
     * 2、中间表：默认规则是当前模型名+_+关联模型名 （可以指定模型名） 这里就可以不用解释了 这个都动，就是中间表名
     * 3、外键：中间表的当前模型外键，默认的外键名规则是关联模型名+_id 即 中间表里的 被关联的那个模型的的键 这里是pid
     * 4、关联键：中间表的当前模型关联键名，默认规则是当前模型名+_id  当前模型 只role模型
     */
    public function permissions()
    {
        return $this->belongsToMany('Permission', 'permission_role', 'pid', 'rid');
    }

    /***
     * @return \think\model\relation\BelongsToMany
     * 管理员和角色的关系是多对多的关系
     * 新增日期：20190604
     * 关系表定义 和上面的一模一样
     */
    public function managers()
    {
        return $this->belongsToMany('Manager', 'manager_role','mid', 'rid');
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/28
 * Time: 18:35
 */

namespace app\common\models;


/***
 * Class Role
 * @package app\common\models
 */
class Role extends Base
{
    protected $table = 'tb_role';

    /***
     * 角色和权限之间是多对多的关系
     * @return \think\model\relation\BelongsToMany
     * 1、关联模型（必须）：模型名或者模型类名  即 你从本模型关联的哪个模型，这里是Permission
     * 2、中间表：默认规则是当前模型名+_+关联模型名 （可以指定模型名） 这里就可以不用解释了 这个都动，就是中间表名
     * 3、外键：中间表的当前模型外键，默认的外键名规则是关联模型名+_id 即 中间表里的 被关联的那个模型的的键 这里是pid
     * 4、关联键：中间表的当前模型关联键名，默认规则是当前模型名+_id  当前模型 只role模型
     */
    public function permissions()
    {
        return $this->belongsToMany('Permission', 'permission_role', 'pid', 'rid');
    }

    /***
     * @return \think\model\relation\BelongsToMany
     * 管理员和角色的关系是多对多的关系
     * 新增日期：20190604
     * 关系表定义 和上面的一模一样
     */
    public function managers()
    {
        return $this->belongsToMany('Manager', 'manager_role','mid', 'rid');
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
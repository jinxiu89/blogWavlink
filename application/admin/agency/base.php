<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/4
 * Time: 9:42
 *  agency 的解释
 * 我们每一次对逻辑的操作都非常复杂，如果在model层去操作逻辑的话会导致一个问题，就是代码冗长无比，不便于阅读
 * 现在我的思想是 控制器调用agency 里的操作逻辑，由agency里的方法去和model层沟通 操作数据库
 * 上述语义
 * 1、控制器调用agency的方法
 * 2、agency逻辑去调用model层的增删改查
 * 3、返回成功还是失败
 * 4、由控制器来抛出异常：这里理解为错误异常还是正确的异常
 */

namespace app\admin\agency;


use think\Model;
use app\common\validate\number;
/**
 * Class base
 * @package app\admin\agency
 * 所有重复复制的方法都写在这个地方
 *
 */
class base extends Model
{
    protected $model;
    protected $validate;
    protected $success;
    protected $failed;
    /***
     * @param $data
     * @return array
     * 验证ID ,这个方法应该可以抽象到上一级
     *
     */
    public function checkID($data)
    {
        $validate = new number();
        if ($validate->check($data)) {
            return ['status' => true, 'message' => "ok"];
        } else {
            return ['status' => false, 'message' => $validate->getError()];
        }
    }
}
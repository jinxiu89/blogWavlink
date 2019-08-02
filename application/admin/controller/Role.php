<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/31
 * Time: 16:39
 */

namespace app\admin\controller;

use app\admin\agency\permissionGroup as permissionGroupAgency;
use app\admin\agency\role as agency;

/**
 * Class Role
 * @package app\admin\controller
 */
class Role extends Base
{
    protected $url;

    /***
     * @return Base|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->url = '/' . $this->backendPrefix . '/user/permission/role/list.html';
    }

    /**
     * @return mixed
     * 新增日期：20190531
     * 列表
     */
    public function index()
    {
        $data = (new agency())->getAll();
        if ($data['status'] == true) {
            $this->assign('data', $data['data']);
            $this->assign('count', count($data['data']));
        }
        return $this->fetch();
    }

    /***
     * @return mixed
     * 新增日期：20190531
     * 简单逻辑
     * 主要是注意这个agency方法
     * agency方法是针对于Role方法建立的一个专门操作逻辑的办事中心
     */
    public function add()
    {

        if (request()->isGet()) {
            return $this->fetch();
        }

        if (request()->isPost()) {
            $data = input('post.');
            $result = (new agency())->saveData($data);
            if ($result['status'] == false) {
                return show($result['status'], $result['message']);
            }
            return show($result['status'], $result['message'], $this->url);
        }
    }

    /***
     * @param $id
     * @return false|mixed|string
     * 新增日期：20190531
     * 简单的逻辑自己看，很简单的
     */

    public function edit($id)
    {
        if (request()->isGet()) {
            $data = (new agency())->getDataById(['id' => $id]);
            if ($data['status'] == true) {
                $this->assign('data', $data['data']);
            }
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $result = (new agency())->saveData($data);
            if ($result['status'] == false) {
                return show($result['status'], $result['message']);
            }
            return show($result['status'], $result['message'], $this->url);
        }
    }

    /***
     * @param $id
     * @return array|false|mixed|string
     * 新增日期：20190601
     * 人员 邱锦
     * 设置权限，具体思路：
     * 传值为角色的ID，当用户点击添加权限时，触发get方法，get方法中注意的地方是 用户已有的权限plist['data']是一个中间表的数组 如[1,2,3,4]
     * 1、将ID传给getDataWithPermission()去获得中间表数据
     * 2、这里遵循agency范式，所有的逻辑操作都交给agency去操作，这和办事员的逻辑是一样的
     * 3、agency里可以是验证数据，也可以是处理一段数据
     * 4、show 方法用于处理json到前端的数据
     *
     */
    public function setpermission($id)
    {
        if (request()->isGet()) {
            $plist = (new agency())->getDataWithPermission($id);//获得角色 并且取出角色所拥有的权限
            $check = (new agency())->checkID(['id' => $id]);
            if ($check['status'] = true) {
                $data = (new permissionGroupAgency())->getDatawithPermission(); // 这个里是获得权限列表数据
                if ($data['status'] == true) {
                    $this->assign('data', $data['data']);
                    $this->assign('id', $id);
                    $this->assign('plist', $plist['data']);
                }
                return $this->fetch();
            } else {
                return show($check['status'], $check['message']);
            }
        }
        if (request()->isPost()) {
            $data = input('post.');
            $id = $data['id'];
            unset($data['id']);
            $check = (new agency())->checkID(['id' => $id]);
            if ($check['status'] == true) {
                $plist = (new agency())->getDataWithPermission($id);
                $result = (new agency())->savePermission($data, $plist['data'], $id);
                if ($result['status'] == false) {
                    return show($result['status'], $result['message']);
                }
                return show($result['status'], $result['message'], $this->url);
            } else {
                return [$check['status'], $check['message']];
            }
        }
    }
}
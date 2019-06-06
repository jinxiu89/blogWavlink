<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/4
 * Time: 10:10
 */

namespace app\admin\controller;

use app\admin\agency\manager as agency;
use think\Config;

/***
 * Class Manager
 * @package app\admin\controller
 */
class Manager extends Base
{
    protected $agency;
    protected $url;
    protected $roleList;

    /***
     * @return Base|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->agency = new agency();
        $this->url = '/' . $this->backendPrefix . '/user/manager/list.html';
        $this->roleList = $this->agency->getRoleList();
    }


    /***
     * @return mixed
     */
    public function index()
    {
        if (request()->isGet()) {
            $data = $this->agency->getAll();
            $count = count($data['data']);
            if ($data['status'] == true) {
                $this->assign('data', $data['data']);
                $this->assign('count', $count);
            }
            return $this->fetch();
        }
    }

    /***
     * @return mixed
     */
    public function add()
    {
        if (request()->isGet()) {
            if ($this->roleList['status'] == true) {
                $this->assign('data', $this->roleList['data']);
            }
            return $this->fetch();
        }
        if (request()->isPOST()) {
            $data = input('post.');
            $result = $this->agency->saveData($data);
            if ($result['status'] == false) {
                return show($result['status'], $result['message']);
            }
            return show($result['status'], $result['message'], $this->url);
        }
    }

    /***
     * @param $id
     * 创建时间：20190605
     * 编辑是整个逻辑里比较复杂的
     * 他首先是解决一个多对多的查询
     * 然后就是该管理员原来拥有哪些权限，你要默认给他勾选上，这个勾选上的逻辑比较复杂
     */
    public function edit($id)
    {
        if (request()->isGet()) {
            $result = $manager = $this->agency->getDataById(['id' => $id]);
            if ($this->roleList['status'] == true) {
                $this->assign('roles', $this->roleList['data']);//所有的角色数据
            }
            if ($result['status'] == true) {
                $roles = $result['data']['roles'];//这个地方是调用的是result里的data数据中的roles；这个是个硬功夫啦，看不懂去看手册
                unset($result['roles']);
                $manager_roles = $this->agency->getRoleslist($roles);//用户已经拥有的权限，把他弄成一个角色ID的数组
                $this->assign('data', $result['data']);
                $this->assign('manager_roles', $manager_roles['data']);
            } else {
                return show($result['status'], $result['message']);
            }
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = input('post.');
            $result = $this->agency->saveData($data);
            if ($result['status'] == false) {
                return show($result['status'], $result['message']);
            }
            print_r($result['message']);
            return show($result['status'], $result['message'], $this->url);
        }
    }

}
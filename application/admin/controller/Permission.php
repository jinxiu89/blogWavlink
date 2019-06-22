<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/28
 * Time: 19:02
 */

namespace app\admin\controller;

use app\admin\agency\permission as agency;
use think\facade\Config;

/***
 * Class Permission
 * @package app\admin\controller
 */
class Permission extends Base
{
    protected $url;
    protected $agency;

    public function initialize()
    {
        parent::initialize();
        $this->url = '/' . $this->backendPrefix . "/user/permission/list.html";
        $this->agency = new agency();
    }

    /***
     * @return mixed
     */
    public function index()
    {
        $data=$this->agency->getAll();
        if ($data['status'] == true) {
            $this->assign('data', $data['data']);
            $this->assign('count',count($data['data']));
        }
        if ($data['status'] == false) {
            //todo:: 异常处理
        }
        return $this->fetch();
    }

    public function add($gid)
    {//权限组ID
        if (Request()->isGet()) {
            $this->assign('gid', $gid);
            return $this->fetch();
        }
        if (Request()->isPost()) {
            //保存操作
            $data = input('post.');
            $result = $this->agency->saveData($data);
            if ($result['status'] == true) {
                return show($result['status'], $result['message'], $this->url);
            } else {
                return show(false, $result['message']);
            }
        }
    }
    public function edit($id){
        if(request()->isGet()){
            $data=$this->agency->getDataById(['id'=>$id]);
            if($data['status'] == true){
                $this->assign('data',$data['data']);
            }
            return $this->fetch();
        }
        if(request()->isPost()){
            $data=input('post.');
            $result= $this->agency->saveData($data);
        }
        if ($result['status'] == true) {
            return show($result['status'], $result['message'], $this->url);
        } else {
            return show(false, $result['message']);
        }
    }
}
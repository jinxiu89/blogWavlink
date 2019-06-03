<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Config;
use think\facade\Env;
use think\facade\Route;

/***
 * 用户功能模块路由
 * 管理用户只能在后台由超级用户来添加
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('/user/permission/list', 'permission/index');
    Route::get('/user/permission/add/:gid', 'permission/add')->parent(['gid' => '\d+']);
    Route::post('/user/permission/add/:gid', 'permission/add')->parent(['gid' => '\d+']);
    Route::get('/user/permission/edit/:id', 'permission/edit')->parent(['id' => '\d+']);
    Route::post('/user/permission/edit/:id', 'permission/edit')->parent(['id' => '\d+']);
    Route::get('/user/permission/group/list', 'PermissionGroup/index');
    Route::get('/user/permission/group/add', 'PermissionGroup/add');
    Route::post('/user/permission/group/add', 'PermissionGroup/add');
    Route::get('/user/permission/group/edit/:id', 'PermissionGroup/edit')->parent(['id' => '\d+']);
    Route::post('/user/permission/group/edit/:id', 'PermissionGroup/add')->parent(['id' => '\d+']);
    Route::get('/user/permission/role/list', 'Role/index');
    Route::get('/user/permission/role/add', 'Role/add');
    Route::post('/user/permission/role/add', 'Role/add');
    Route::get('/user/permission/role/edit/:id', 'Role/edit')->parent(['id' => '\d+']);
    Route::post('/user/permission/role/edit/:id', 'Role/edit')->parent(['id' => '\d+']);
    Route::get('/usr/permission/set/:id', 'Role/setpermission')->parent(['id' => '\d+']);
    Route::post('/usr/permission/set/:id', 'Role/setpermission')->parent(['id' => '\d+']);
    Route::get('/user/create', '');
    Route::post('/user/create', '');
    Route::get('/user/edit/:id', '')->parent(['id' => '\d+']);
    Route::post('/user/edit/:id', '')->parent(['id' => '\d+']);
    Route::get('/login', 'auth/login');
    Route::post('/login', 'auth/login');
    Route::get('/logout', 'auth/logout');
})->prefix('admin/')->ext('html');
/***
 * 20190506
 * 后台GET组
 * 用于处理后台get请求
 *
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('/index', 'index/index');
    Route::get('/category/list', 'category/index');
    Route::get('/category/add', 'category/add');
    Route::get('/aws/uploader', 'aws/uploader');
    Route::get("/category/edit/:id", 'category/edit')->parent(['id' => '\d+']);
})->prefix('admin/')->ext('html');

/***
 * 一个组一个功能
 * get 在上面
 * post 在下面
 *
 */
/***
 * 所有的post 都放在post组里
 * post组
 */
Route::group(Config::get('app.backend_prefix'), function () {

    Route::post('/category/add', 'category/add');
    Route::post('/aws/uploader', 'aws/uploader');
    Route::post('/category/edit/:id', 'category/edit')->parent(['id' => '\d+']);
})->prefix('admin/')->ext('html');

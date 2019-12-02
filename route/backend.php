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
use app\admin\middleware\Auth;
/***
 * 20190525-20190605
 * 用户功能模块路由
 * 管理用户只能在后台由超级用户来添加
 * 记住哈  prefix('admin/')是指模块名，如application 下的 admin  index 这些模块
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('/user/permission/list', 'Permission/index');
    Route::get('/user/permission/group/:gid', 'Permission/group')->pattern(['gid' => '\d+']);
    Route::get('/user/permission/add/:gid', 'Permission/add')->pattern(['gid' => '\d+']);
    Route::post('/user/permission/add/:gid', 'Permission/add')->pattern(['gid' => '\d+']);
    Route::get('/user/permission/edit/:id', 'Permission/edit')->pattern(['id' => '\d+']);
    Route::post('/user/permission/edit/:id', 'Permission/edit')->pattern(['id' => '\d+']);
    Route::get('/user/permission/group/list', 'PermissionGroup/index');
    Route::get('/user/permission/group/add', 'PermissionGroup/add');
    Route::post('/user/permission/group/add', 'PermissionGroup/add');
    Route::get('/user/permission/group/edit/:id', 'PermissionGroup/edit')->pattern(['id' => '\d+']);
    Route::post('/user/permission/group/edit/:id', 'PermissionGroup/add')->pattern(['id' => '\d+']);
    Route::get('/user/permission/role/list', 'Role/index');
    Route::get('/user/permission/role/add', 'Role/add');
    Route::post('/user/permission/role/add', 'Role/add');
    Route::get('/user/permission/role/edit/:id', 'Role/edit')->pattern(['id' => '\d+']);
    Route::post('/user/permission/role/edit/:id', 'Role/edit')->pattern(['id' => '\d+']);
    Route::get('/usr/permission/set/:id', 'Role/setpermission')->pattern(['id' => '\d+']);
    Route::post('/usr/permission/set/:id', 'Role/setpermission')->pattern(['id' => '\d+']);
    Route::get('/user/manager/list', 'Manager/index');
    Route::get('/user/manager/create', 'Manager/add');
    Route::post('/user/manager/create', 'Manager/add');
    Route::get('/user/manager/edit/:id', 'Manager/edit')->pattern(['id' => '\d+']);
    Route::post('/user/manager/edit/:id', 'Manager/edit')->pattern(['id' => '\d+']);
    //TODO::
    Route::get('/user/edit/:id', '')->pattern(['id' => '\d+']);
    Route::post('/user/edit/:id', '')->pattern(['id' => '\d+']);

})->prefix('admin/')->ext('html');


Route::group(Config::get('app.backend_prefix'),function (){

    Route::get('/login', 'Auth/login');
    Route::post('/login', 'Auth/login');
    Route::get('/logout', 'Auth/logout');

})->prefix('admin/')->ext('html');;
/***
 * 20190612
 * 语言管理相关的路由
 *
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('system/language/list', 'Language/index');
    Route::get('system/language/add', 'Language/add');
    Route::post('system/language/add', 'Language/add');
    Route::get('system/language/edit/:id', 'Language/edit')->pattern(['id' => '\d+']);
    Route::post('system/language/edit/:id', 'Language/edit')->pattern(['id' => '\d+']);
})->prefix('admin/')->ext('html');

/***
 * 20190613
 *
 */
/***
 * post管理相关的路由
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('/article/category/list', 'Category/index');
    Route::get('/article/category/add', 'Category/add');
    Route::post('/article/category/add', 'Category/add');
    Route::get('/article/category/edit/:id', 'Category/edit')->pattern(['id' => '\d+']);
    Route::post('/article/category/edit/:id', 'Category/edit')->pattern(['id' => '\d+']);
    Route::get('/article/list', 'Article/index');
    Route::get('/article/category/:category_id', 'Article/list')->pattern(['category_id' => '\d+']);
    Route::get('/article/add', 'Article/add');
    Route::post('/article/add', 'Article/add');
    Route::get('/article/edit/:id', 'Article/edit')->pattern(['id' => '\d+']);
    Route::post('/article/edit/:id', 'Article/edit')->pattern(['id' => '\d+']);
})->prefix('admin/')->ext('html');
/***
 * 20190617
 * 系统设置部分
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('/system/setting', 'Setting/setting');
    Route::post('/system/setting', 'Setting/setting');
    Route::get('/system/about/list', 'About/index');
    Route::get('/system/about/add', 'About/add');
    Route::post('/system/about/add', 'About/add');
    Route::get('/system/about/edit/:id', 'About/edit');
    Route::post('/system/about/edit/:id', 'About/edit');
})->prefix('admin/')->ext('html');
/***
 * 20190506
 * 后台GET组
 * 用于处理后台get请求
 *
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('/category/list', 'category/index');
    Route::get('/category/add', 'category/add');
    Route::get('/aws/uploader', 'aws/uploader');
    Route::get("/category/edit/:id", 'category/edit')->pattern(['id' => '\d+']);
    Route::get('/index', 'Index/index');

    Route::get('/cache_clear','Base/CacheClear');

})->prefix('admin/')->ext('html');

/***
 * 静态资源管理路由
 *
 */
Route::group(Config::get('app.backend_prefix'), function () {
    Route::get('/static/images/list', 'Images/index');
    Route::get('/static/images/upload', 'Images/upload');
    Route::post('/static/images/upload', 'Images/upload');
    Route::post('/aws/uploader', 'Aws/uploader');
    Route::get('static/image/list', 'Images/listimg');
    Route::post('/aws/image/markdownUpload', 'Aws/markdownUpload');
})->prefix('admin/')->ext('html');

/***
 * 公共部分的路由设置
 */

Route::get('/wavlink/', 'admin/Index/index')->middleware(Auth::class);
Route::get('/wavlink/language/:code', 'admin/Base/ChangeLanguage')->pattern(['code' => '[\w-]+']);
//Route::get('/wavlink', 'admin/Index/index');


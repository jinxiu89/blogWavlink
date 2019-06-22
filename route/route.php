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

/***
 *
 */

use think\facade\Config;
use think\facade\Env;
use think\facade\Route;

/***
 * 前端路由控制
 * 对于根来说，他需要的是得到语言信息 然后跳转
 *
 */
Route::get('/', 'home/AutoLoad/autoload');
Route::get('/language/:code', 'home/AutoLoad/setLanguage')->pattern(['code' => '[\w-]+']);
/***
 * 每一个语言都需要指定合适的路由
 */
Route::group('en-us', function () {
    Route::get('/index', 'Index/index');
})->prefix('home/')->ext('html');

/***
 *
 */

Route::group('zh-cn', function () {
    Route::get('/index', 'Index/index');
})->prefix('home/')->ext('html');

Route::group('ja', function () {
    Route::get('/index', 'Index/index');
})->prefix('home/')->ext('html');
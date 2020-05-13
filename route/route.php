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

Route::group('en-US', function () {
    Route::get('/article/:category/index', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/article/:category/:url_title', 'Article/details')->pattern(['category' => '[\w-]+','url_title'=>'[\w-]+']);
    Route::get('/article/:category', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/product/index', 'Product/index');
    Route::get('/main', 'Index/index');

})->prefix('home/')->ext('html');

Route::group('en-us', function () {
    Route::get('/article/:category/index', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/article/:category/:url_title', 'Article/details')->pattern(['category' => '[\w-]+','url_title'=>'[\w-]+']);
    Route::get('/article/:category', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/product/index', 'Product/index');
    Route::get('/main', 'Index/index');

})->prefix('home/')->ext('html');
/***
 *
 */
Route::group('zh-CN', function () {
    Route::get('/article/:category/index', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/article/:category/:url_title', 'Article/details')->pattern(['category' => '[\w-]+','url_title'=>'[\w-]+']);
    Route::get('/article/:category', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/product/index', 'Product/index');
    Route::get('/main', 'Index/index');

})->prefix('home/')->ext('html');

Route::group('zh-cn', function () {
    Route::get('/article/:category/index', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/article/:category/:url_title', 'Article/details')->pattern(['category' => '[\w-]+','url_title'=>'[\w-]+']);
    Route::get('/article/:category', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/product/index', 'Product/index');
    Route::get('/main', 'Index/index');

})->prefix('home/')->ext('html');

Route::group('ja', function () {
    Route::get('/article/:category/index', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/article/:category/:url_title', 'Article/details')->pattern(['category' => '[\w-]+','url_title'=>'[\w-]+']);
    Route::get('/article/:category', 'Article/lists')->pattern(['category' => '[\w-]+']);
    Route::get('/product/index', 'Product/index');
    Route::get('/main', 'Index/index');

})->prefix('home/')->ext('html');

/***
 * 前端路由控制
 * 对于根来说，他需要的是得到语言信息 然后跳转
 *
 */
Route::get('/', 'home/AutoLoad/autoload');
Route::get('/language/:code', 'home/AutoLoad/setLanguage')->pattern(['code' => '[\w-]+']);
//Route::miss('home/Error/notfound');
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
 * 修改日期：20190521
 * 给url加上 token
 */

use think\facade\Route;

/***
 * 获取文件的全部在files里解决，
 * 获取分类
 */
Route::group('api', function () {
    //某分类下的第几页，例如：mesh_wifi 这个分类下共有50条数据，每5条数据为一页的话，他就会被分成10页来处理，那么他就有了page页数这个参数
    //c_id为0的情况会查所有的数据（有分页）
    Route::get('/files/category/:c_id/:page/:token', 'category/files')->parent(['c_id' => '\d+', 'page' => '\d+']);
    Route::get('/files/:page/:token', 'files/lists')->parent(['page' => '\d+']);
    Route::get('/category/:token', 'category/categoryList');
})->prefix('api/')->ext('html')->parent(['token' => '\w+']);

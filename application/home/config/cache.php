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

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    'type' => 'complex',
    'default' => [
        'type' => 'Redis',
        'prefix' => 'home_',
        'expire'=>3600,
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => 'Wavlink@163',
    ],
    'file'=>[
        'type'=>'file',
        'path'=>'../runtime/cache/',
        'prefix'=>'home_',
        'expire'=>3600,
    ],
];

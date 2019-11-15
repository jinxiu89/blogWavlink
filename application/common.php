<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use app\common\models\category as categoryModel;
use app\common\agency\PermissionGroup as PermissionGroupAgency;
use app\common\models\Files as FilesModel;
use think\facade\Config;
use app\common\models\Media;
use think\facade\Cookie;

/***
 * 返回错误信息
 * @param $status
 * @param $message
 * @param $title
 * @param $btn
 * @param string $url 返回跳转url
 * @param array $data 数据
 */
function show($status, $message = '', $url = '')
{
    $res = array(
        'status' => $status,
        'message' => $message,
        'url' => $url,
    );
    return json_encode($res);
}

/***
 * @param $gid
 */
function getGroupName($gid)
{
    $result = new app\common\agency\permissionGroup();
    return $result->getGroupNameByGid(['id' => $gid]);
}

function getCategoryNameByID($id)
{
    $category = (new categoryModel())->getCategoryName($id);
    return $category['name'];
}

function getCategoryUrlById($id)
{
    $category = (new categoryModel())->getCategoryName($id);
    return $category['url_title'];
}

function getCategoryName($id)
{
    $category = (new categoryModel())->getCategoryName($id);
    if ($category) {
        if ($category['parent_id'] == 0) {
            return "一级分类";
        } else {
            $parent = (new categoryModel())->getDataById($category['parent_id']);
            return $parent['name'];
        }

        return $category['parent_id'] == 0 ? "一级分类" : $category['name'];
    } else {
        return "程序错误";
    }
}


function toJSON($data)
{
    return json_encode($data);
}

function autoGetLang($header)
{
    //拿到浏览器的语言，初始化语言项
    if (empty($header['accept-language'])) {
        return 'en-us';
    } else {
        $lang_code = $header['accept-language'];
        $code = explode(',', $lang_code);
        //在extra 里配置各国语言代码对应相应的模块
        return $code[0];
    }
}

/***
 * @param $type
 * @return mixed
 * 20190622
 * 使用在后台的 图片列表中，通过数据库中的字段来返回他的图片类型
 * 使用范围是  静态资源管理功能
 */
function getTypeName($type)
{
    return Config::get('type.' . $type);
}

function getActive($id)
{
    $cat = (new categoryModel())->getActive($id);
    return $cat[0]['url_title'];
}


/**
 * @param $tags
 * @param $str
 * @param bool $content
 * @return string|string[]|null
 * 20190803 过滤调不安全的标签
 */
function strip_html_tags($tags, $str, $content = true)
{
    $html = [];
    foreach ($tags as $tag) {
        if ($content) {
            $html[] = '/(<' . $tag . '.*?>(.|\n)*?<\/' . $tag . '>)/is';
        } else {
            $html[] = "/(<(?:\/" . $tag . "|" . $tag . ")[^>]*>)/is";
        }
    }
    return preg_replace($html, '', $str);
}

function getThumb($content)
{
    $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern, $content, $matches);
    if ($matches[1]) {
        return $matches[1][0];
    } else {
        return "";//默认的图片
    }
}

/***
 * 防止刷新扰乱数据库的计数器
 */
function counter($prefix, $ip, $expire)
{
    $ip = md5($ip);
    if (Cookie::has('ip', $prefix)) {//没有 就设置一个
        Cookie::set('ip', $ip, ['prefix' => $prefix, 'expire' => $expire]);
        return Cookie::get('ip',$prefix);
    }
    return false;
}

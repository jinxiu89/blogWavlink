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

function getProductName($id)
{
    $product = (new FilesModel())->getDataById($id);
    if ($product) {
        return $product['title'];
    }
}

function toJSON($data)
{
    return json_encode($data);
}

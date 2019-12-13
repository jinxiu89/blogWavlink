<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/17
 * Time: 10:12
 */

namespace app\api\controller;

use app\common\models\Files as FilesModel;
//use app\api\validate\apiValidate as Validate;

/**
 * Class Files
 * @package app\api\controller
 */
class Files extends Base
{

    /**
     * page 是 前端传过来的页码,用于手工分页
     * $token 是用于系统验证的
     * @param $page
     * @param $token
     * @return false|string
     * @throws \think\Exception\DbException
     */
    public function lists($page, $token)
    {
        $listRow = 1;
        $data = (new FilesModel())->getAllData($page, $listRow);
        $count = (new FilesModel())->getCount();
        $pageCount = NULL;
        if ($count / $listRow < 1) {
            $pageCount = 1;
        } elseif (is_int($count / $listRow)) {
            $pageCount = $count / $listRow;
        } else {
            $pageCount = ceil($count / $listRow);
        }
        $result = [
            'code' => "10000",
            'currentPage' => $page, //页数
            'totalPage' => intval($pageCount),
            'message' => '成功',
            'downloadList' => $data,
        ];
        return toJSON($result);
    }

}
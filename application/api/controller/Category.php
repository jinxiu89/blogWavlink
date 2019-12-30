<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/22
 * Time: 10:33
 */

namespace app\api\controller;

use app\common\models\Category as CategoryModel;
use app\common\helper\Category as CategoryHelper;


/**
 * Class Category
 * @package app\api\controller
 */
class Category extends Base
{
    /**
     * @param $token
     * @return mixed
     */
    public function categoryList($token)
    {
        $data = (new CategoryModel())->getCategory();
        $category = CategoryHelper::toLayer($data, 'child', 0, 0);
        $result = [
            'code' => "10000",
            'message' => '成功！',
            'data' => $category,
        ];
        return toJSON($result);
    }

    /**
     * 添加分页数据，
     * 把
     * @param $c_id
     * @param $page
     * @param $token
     * @return false|string
     */
    public function files($c_id, $page, $token)
    {
        $listRow = 1;
        // 我在getDataByCid中组装好json数组，分页，总页数，每页显示多少条
        if($c_id == 0){
            $data = (new CategoryModel())->getDateByDefault($page,$listRow);
        }else{
            $data = (new CategoryModel())->getDataByCid($c_id, $page, $listRow);
        }
        return $data;
    }
}
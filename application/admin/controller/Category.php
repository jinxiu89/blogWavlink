<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/5
 * Time: 15:02
 */

namespace app\admin\controller;


use think\Request;
use app\common\models\Category as CategoryModel;
use app\common\helper\Category as CategoryHelper;


/**
 * Class Index
 * @package app\admin\controller
 */
class Category extends Base
{
    protected $toLevel;

    public function index()
    {
        $data = (new CategoryModel())->getCategory();
        $count = $data->count();
        return $this->fetch('', [
            'data' => $data,
            'count' => $count
        ]);
    }

    public function add()
    {
        if (Request()->isGet()) {

            return $this->fetch('', [
                'to_level' => $this->toLevel,
            ]);
        }
        if (Request()->isPost()) {
            $data = input('post.');
            return (new CategoryModel())->saveData($data);
        }
    }

    public function edit($id)
    {
        if (Request()->isGet()) {
            $data = (new CategoryModel())->getDataById($id);
            if ($data) {
                return $this->fetch('', [
                    'data' => $data,
                    'to_level' => $this->toLevel
                ]);
            } else {
                return "数据库错误";
            }
        }
        if (Request()->isPost()) {
            $data = input('post.');
            return (new CategoryModel())->saveData($data);
        }
    }
}
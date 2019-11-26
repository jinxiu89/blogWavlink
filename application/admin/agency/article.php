<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/13
 * Time: 10:44
 */

namespace app\admin\agency;


use Exception;
use app\common\models\Article as articleModel;
use app\common\models\Category;
use app\admin\validate\article as articleValidate;
use think\Db;

/***
 * Class post
 * @package app\admin\agency
 */
class article extends base
{
    public function initialize()
    {
        parent::initialize();
    }

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->model = new articleModel();
        $this->validate = new articleValidate();
        $this->success = "保存成功！";
        $this->failed = "保存失败！";
    }

    /***
     * @param $data
     * @return array|false|string
     * @throws \think\exception\PDOException
     */
    public function saveData($data)
    {
        if (isset($data['id'])) {
            if ($this->validate->scene('edit')->check($data)) {
                try {
                    return $this->model->allowField(true)->save($data, ['id' => $data['id']]) ?
                        ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
                } catch (Exception $exception) {
                    $this->rollback();
                    return ['status' => false, 'message' => $exception->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => $this->validate->getError()];
            }
        }
        if ($this->validate->scene('add')->check($data)) {
            try {
                return $this->model->allowField(true)->save($data) ?
                    ['status' => true, 'message' => $this->success] : ['status' => false, 'message' => $this->failed];
            } catch (Exception $exception) {
                $this->rollback();
                return ['status' => false, 'message' => $exception->getMessage()];
            }

        } else {
            return ['status' => false, 'message' => $this->validate->getError()];
        }
    }

    public function getAll($language_id)
    {
        try {
            $query = $this->model->where(['language_id' => $language_id])->field('id,category_id,title,keywords,mark,clicks')->order("id");
            $data = $query->paginate();
            $count = $query->count();
            return ['data' => $data, 'count' => $count];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getDataById($id)
    {
        return $this->model->getDataById($id);
    }

    public function getCategory($language_id)
    {
        $data = (new Category())->getCategory($language_id)->toArray();
        $category = [];
        foreach ($data as $item) {
            $item['url'] = "/wavlink/article/category/" . $item['id'] . '.html';
            $item['target'] = "_self";
            $category[] = $item;
        }
        return $category;
    }

    public function getDataByCategoryId($category_id)
    {
        try {
            $query = $this->model->where(['category_id' => $category_id])
                ->order(['id' => 'asc'])
                ->field('id,category_id,title,keywords,mark,clicks');
            $data = $query->paginate();
            $count = $query->count();
            return ['data' => $data, 'count' => $count];
        } catch (Exception $exception) {
            return [];
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/8
 * Time: 14:18
 */

namespace app\common\models;

use app\admin\validate\category as categoryValidate;
use app\common\models\Files as FilesModel;
use think\Exception;
use think\facade\Cache;

/***
 * Class category
 * @package app\common\models
 */
class Category extends Base
{
    protected $table = "tb_category";

    public function getDateByDefault($page, $listRow)
    {
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
            'totalPage' => strval($pageCount),
            'message' => '成功',
            'downloadList' => $data,
        ];
        return toJSON($result);
    }

    public function getDataByCid($c_id, $page, $listRow)
    {
        //如果这个分类有下一级的话要把他下一级的数据弄出来
        //这个分类ID自己
        $cat = self::where(['parent_id' => $c_id])->whereOr(['id' => $c_id])->select()->toArray();
        $id = [];
        foreach ($cat as $item) {
            $id[] = $item['id'];
        }
        //计算总页数的方法
        $offset = ($page - 1) == 0 ? 0 : ($page - 1) * $listRow;
        $query = new FilesModel();
        $data = $query->with('Downloads')->where('c_id', 'in', $id)->limit($offset, $listRow)->select()->toArray();//
        $count = count($data);
        //总共多少页？
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
            'currentPage' => $page, //访问的当前页数
            'totalPage' => strval($pageCount),
            'message' => '成功',
            'downloadList' => $data,
        ];
        return toJSON($result);
    }


    /***
     * @param $data
     * @return false|string
     */
    public function saveData($data)
    {
        $validate = new categoryValidate();
        if (isset($data['id'])) {
            if ($data['id'] == $data['parent_id']) {
                return show(false, '修改分类的时候所属分类不能属于他本身', '');
            }
            if ($validate = new categoryValidate()) {
                try {
                    return self::allowField(true)->save($data, ['id' => $data['id']]) ?
                        show(true, $this->success, $this->url) : show(false, $this->failed, $this->url);
                } catch (Exception $exception) {
                    return show(false, $exception->getMessage(), '');
                }
            } else {
                return show(false, $validate->getError(), '');
            }
        }
        if ($validate->check($data)) {
            try {
                return self::allowField(true)->save($data) ?
                    show(true, $this->success, $this->url) : show(false, $this->failed, $this->url);
            } catch (Exception $e) {
                return show(false, $e->getMessage(), '');
            }

        } else {
            return show(false, $validate->getError(), '');
        }
    }

    public function getCategoryName($id)
    {
        try {
            return self::where(['id' => $id])->find();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getDataById($id)
    {
        try {
            return self::get($id);
        } catch (Exception $exception) {
            return false;
        }
    }
    /***
     * @param $language_id
     * @return array|false|\think\db\Query[]
     */
    public function getCategory($language_id)
    {
        try {
            return self::where(['language_id' => $language_id])->order("parent_id")->all();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getCategoryByLanguage($language_id)
    {
        try {
            return self::where(['language_id' => $language_id])->order("parent_id")->all()->toArray();
            //todo:后期开缓存
//            if (!$this->debug) {
//                if (Cache::get('Category')) {
//                    return Cache::get('Category');
//                } else {
//                    Cache::set('Category', self::where(['language_id' => $language_id])->order("parent_id")->all()->toArray());
//                }
//            }
//            return Cache::get('Category') ? Cache::get('Category') : self::where(['language_id' => $language_id])->order("parent_id")->all()->toArray();
        } catch (Exception $exception) {
            return '';
        }
    }
}
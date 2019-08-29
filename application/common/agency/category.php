<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/26
 * Time: 15:09
 */

namespace app\common\agency;


use think\Model;
use app\common\models\Category as CategoryModel;
use app\common\helper\Category as Helper;
use think\facade\Cache;
use think\facade\Config;

/***
 * Class category
 * @package app\common\agency
 */
class category extends Model
{
    /***
     * @param $category
     * @param $language_id
     * @return array
     */
    public function getDataByCategory($category, $language_id)
    {
        $cat = CategoryModel::all();
        $data = (new CategoryModel())->getCategoryWithNameLanguageId($category, $language_id);
        return $categoryIds = Helper::getChildsByPid($cat, $data['id']);
    }

    /***
     * @param $category
     * @param $ids
     * @param $language_id
     * @return \think\Paginator
     * 20190627 更新 缓存代码 减少数据库查询操作
     *
     */
    public function getDataByIds($category, $ids, $language_id)
    {
        if (!Config::get('app.app_debug')) {
            if (!Cache::store('default')->get($category . '_' . $language_id)) {
                Cache::store('default')->set($category . '_' . $language_id, (new CategoryModel())->getDataByIds($ids));
            } else {
                return Cache::store('default')->get($category . '_' . $language_id);
            }
        }
        return Cache::store('default')
            ->get($category . '_' . $language_id) ? Cache::store('default')
            ->get($category . '_' . $language_id) : (new CategoryModel())->getDataByIds($ids);
    }

    /***
     * @param $category
     * @param $language_id
     * @return array|string
     * 20190627 主要内容是缓存方面的逻辑优化
     *
     */
    public function getChild($category, $language_id)
    {
        if (!Config::get('app.app_debug')) {//如果关闭了DEBUG 就会走这里 ,本段if 语句 用于减少数据库查询次数
            if (!Cache::store('default')->get('Category')) { //如果获取不到缓存 就设置缓存  KEY字为 Category 表示所有的分类数据全部缓存起来
                Cache::store('default')->set('Category', CategoryModel::all());
            } else { //获取到缓存就拿到缓存
                $cat = Cache::store('default')->get('Category');
            }
            if (!Cache::store('default')->get($category . '_' . $language_id)) { //key值为 当前分类_当前语言
                Cache::store('default')->set($category . '_' . $language_id, (new CategoryModel())->getCategoryWithNameLanguageId($category, $language_id));
            } else {
                $data = Cache::store('default')->get($category . '_' . $language_id);
            }
        }
        $cat = Cache::store('default')
            ->get('Category') ? Cache::store('default')
            ->get('Category') : CategoryModel::all(); // debug 开启了的话 就直接去数据库拿数据
        $data = Cache::store('default')
            ->get($category . '_' . $language_id) ? Cache::store('default')
            ->get($category . '_' . $language_id) : (new CategoryModel())->getCategoryWithNameLanguageId($category, $language_id);
        $ids[] = $data['id'];
        $childs = Helper::getChilds($cat, $data['id']);
        foreach ($childs as $child) {
            $ids[] = $child['id'];
        }
        $categoryData['category'] = $data;
        $categoryData['ids'] = $ids;
        return $categoryData;
    }
}
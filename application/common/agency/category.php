<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/26
 * Time: 15:09
 */

namespace app\common\agency;

use app\common\models\Category as CategoryModel;
use app\common\helper\Category as Helper;
use think\facade\Cache;

/***
 * Class category
 * @package app\common\agency
 */
class category extends Base
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
     *
     * 20190627 更新 缓存代码 减少数据库查询操作
     *
     * @return array
     */
    public function getDataByIds($category, $ids, $language_id)
    {
        if ($this->debug) {//真
            $result = (new CategoryModel())->getDataByIds($ids);
            if ($result['status'] == true) {
                return ['status' => $result['status'], 'message' => $result['message'], 'data' => $result['data']];
            } else {
                return ['status' => $result['status'], 'message' => $result['message']];
            }
        } else {
            //假
            if (!Cache::store('file')->get('data_' . $category . $language_id)) {
                $result = (new CategoryModel())->getDataByIds($ids);
                if ($result['status'] == true) {
                    Cache::store('file')->set('data_' . $category . $language_id, $result['data']);
                    return ['status' => $result['status'], 'message' => $result['message'], 'data' => $result['data']];
                } else {
                    return ['status' => $result['status'], 'message' => $result['message']];//数据库错误或者其他原因没有数据
                }
            } else {
                return ['status' => true, 'message' => 'ok', 'data' => Cache::store('file')->get('data_' . $category . $language_id)];
            }
        }
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
        if ($this->debug) {
            //真，不加缓存
            $cat = CategoryModel::all();
            $data = (new CategoryModel())->getCategoryWithNameLanguageId($category, $language_id);
        } else {//假，加缓存提高访问性能
            if (!Cache::store('file')->get('Category')) {
                Cache::store('file')->set('Category', CategoryModel::all());
            }
            $cat = Cache::store('file')->get('Category');
            if (!Cache::store('file')->get($category . '_' . $language_id)) { //key值为 当前分类_当前语言
                Cache::store('file')->set($category . '_' . $language_id, (new CategoryModel())->getCategoryWithNameLanguageId($category, $language_id));
            }
            $data = Cache::store('file')->get($category . '_' . $language_id);
        }
        $ids[] = $data['id'];
        $childs = Helper::getChilds($cat, $data['id']);
        foreach ($childs as $child) {
            $ids[] = $child['id'];
        }
        $categoryData['category'] = $data;
        $categoryData['ids'] = $ids;
        return $categoryData;
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/26
 * Time: 15:09
 */

namespace app\common\agency;

use app\common\models\Category as CategoryModel;
use app\common\helper\Category as Helper;
use think\facade\Cache;

/***
 * Class category
 * @package app\common\agency
 */
class category extends Base
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
     *
     * 20190627 更新 缓存代码 减少数据库查询操作
     *
     * @return array
     */
    public function getDataByIds($category, $ids, $language_id)
    {
        if ($this->debug) {//真
            $result = (new CategoryModel())->getDataByIds($ids);
            if ($result['status'] == true) {
                return ['status' => $result['status'], 'message' => $result['message'], 'data' => $result['data']];
            } else {
                return ['status' => $result['status'], 'message' => $result['message']];
            }
        } else {
            //假
            if (!Cache::store('file')->get('data_' . $category . $language_id)) {
                $result = (new CategoryModel())->getDataByIds($ids);
                if ($result['status'] == true) {
                    Cache::store('file')->set('data_' . $category . $language_id, $result['data']);
                    return ['status' => $result['status'], 'message' => $result['message'], 'data' => $result['data']];
                } else {
                    return ['status' => $result['status'], 'message' => $result['message']];//数据库错误或者其他原因没有数据
                }
            } else {
                return ['status' => true, 'message' => 'ok', 'data' => Cache::store('file')->get('data_' . $category . $language_id)];
            }
        }
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
        if ($this->debug) {
            //真，不加缓存
            $cat = CategoryModel::all();
            $data = (new CategoryModel())->getCategoryWithNameLanguageId($category, $language_id);
        } else {//假，加缓存提高访问性能
            if (!Cache::store('file')->get('Category')) {
                Cache::store('file')->set('Category', CategoryModel::all());
            }
            $cat = Cache::store('file')->get('Category');
            if (!Cache::store('file')->get($category . '_' . $language_id)) { //key值为 当前分类_当前语言
                Cache::store('file')->set($category . '_' . $language_id, (new CategoryModel())->getCategoryWithNameLanguageId($category, $language_id));
            }
            $data = Cache::store('file')->get($category . '_' . $language_id);
        }
        $ids[] = $data['id'];
        $childs = Helper::getChilds($cat, $data['id']);
        foreach ($childs as $child) {
            $ids[] = $child['id'];
        }
        $categoryData['category'] = $data;
        $categoryData['ids'] = $ids;
        return $categoryData;
    }
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
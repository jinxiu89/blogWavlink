<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/13
 * Time: 10:43
 */

namespace app\common\models;

use think\Exception;
use think\facade\Cache;
use think\facade\Config;

/***
 * Class Article
 * @package app\common\models
 */
class Article extends Base
{
    protected $table = 'tb_article';
    protected $resultSetType = 'collection';

    /***
     * @param $id
     * @return bool|mixed
     */
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
     * @return array|bool|mixed
     * 缓存：当debug为false是为生产环境，设置缓存 后面所有的操作都这样操作
     */
    public function getLastUpdateList($language_id)
    {
        try {
            if (!$this->debug) {
                if (Cache::get('lastUpdate')) {
                    return Cache::get('lastUpdate');
                } else {
                    Cache::set('lastUpdate', self::where(['language_id' => $language_id])->field('title,url_title')->limit(5)->order('id', 'asc')->all()->toArray());
                }
            }
            return Cache::get('lastUpdate') ? Cache::get('lastUpdate') : self::where(['language_id' => $language_id])->field('title,url_title')->limit(5)->order('id', 'asc')->all()->toArray();
        } catch (Exception $exception) {
            return false;
        }
    }

    /***
     * @param $language_id
     * @return bool|float|mixed|string
     * 当base 里的init方法里的debug 设置为false时 设置缓存
     */
    public function getCountByLanguageId($language_id)
    {
        try {
            if (!$this->debug) {
                if (Cache::get('ArticleCounts')) {
                    return Cache::get('ArticleCounts');
                } else {
                    Cache::set('ArticleCounts', self::where(['language_id' => $language_id])->count());
                }
            }
            return Cache::get('ArticleCounts') ? Cache::get('ArticleCounts') : self::where(['language_id' => $language_id])->count();
        } catch (Exception $exception) {
            return false;
        }
    }

    /***
     * @param $language_id
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDataByLanguage($language_id)
    {
        try {
            if ($this->debug) {//根据语言id来缓存数据
                if (Cache::store('default')->get('ArticleData_' . $language_id)) {//如果拿到缓存的话就直接返回缓存
                    return Cache::store('default')->get('ArticleData_' . $language_id);
                } else {//没有就设置缓存
                    Cache::store('default')->set('ArticleData_' . $language_id, self::where(['language_id' => $language_id])->field('id,language_id,title,ftitle,url_title,description')->paginate());
                }
            }
            // 如果能拿到缓存的话就返回缓存 没有就 查库 返回
            return Cache::store('default')->get('ArticleData_' . $language_id) ? Cache::store('file')->get('ArticleData_' . $language_id) : self::where(['language_id' => $language_id])->field('id,language_id,title,ftitle,url_title,description')->paginate();
        } catch (Exception $exception) {
            return '';
        }
    }
}
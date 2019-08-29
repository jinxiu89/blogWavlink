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
    protected $createTime = 'create_time';

    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id');
    }

    public function media()
    {
        return $this->belongsToMany('Media', 'article_media', 'media_id', 'article_id');
    }

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
     * 通过分类 来获取 文章列表
     * 当debug为false时 设置缓存
     * @param $category_id
     * @param $language_id
     * @return mixed|string|\think\Paginator
     */
    public function getDataByCategory($category_id, $language_id)
    {
        try {
            if (!$this->debug) {
                if (Cache::store('default')->get('Article_category_' . $language_id)) {
                    return Cache::store('default')->get('Article_category_' . $language_id);
                } else {
                    Cache::store('default')
                        ->set('Article_category_' . $language_id, self::where(['category_id' => $category_id])
                            ->field('id,category_id,title,thumbnail,url_title,description')->paginate());
                }
            }
            return Cache::store('default')->get('Article_category_' . $language_id) ? Cache::store('default')->get('Article_category_' . $language_id) :
                self::where(['category_id' => $category_id])->field('id,category_id,title,thumbnail,url_title,description')->paginate();
        } catch (Exception $exception) {
            return '';
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
                    Cache::set('lastUpdate', self::where(['language_id' => $language_id])->field('title,category_id,url_title')->limit(5)->order('id', 'asc')->all()->toArray());
                }
            }
            return Cache::get('lastUpdate') ? Cache::get('lastUpdate') : self::where(['language_id' => $language_id])->field('title,category_id,url_title')->limit(5)->order('id', 'asc')->all()->toArray();
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
    //todo:: Cache 没有处理
    public function getDataByIds($ids)
    {
        return self::where('category_id', 'in', $ids)->order('id asc')->field('id,category_id,language_id,create_time,thumbnail,title,ftitle,url_title,description')->paginate();
    }

    /***
     * @param $language_id
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getDataByLanguage($language_id)
    {
        try {
            if (!$this->debug) {//根据语言id来缓存数据
                if (Cache::store('default')->get('ArticleData_' . $language_id)) {//如果拿到缓存的话就直接返回缓存
                    return Cache::store('default')->get('ArticleData_' . $language_id);
                } else {//没有就设置缓存
                    Cache::store('default')->set('ArticleData_' . $language_id, self::where(['language_id' => $language_id])->field('id,category_id,language_id,create_time,thumbnail,title,ftitle,url_title,description')->order('create_time desc,id asc')->paginate());
                }
            }
            // 如果能拿到缓存的话就返回缓存 没有就 查库 返回
            return Cache::store('default')->get('ArticleData_' . $language_id) ? Cache::store('file')->get('ArticleData_' . $language_id) : self::where(['language_id' => $language_id])->field('id,category_id,language_id,title,create_time,thumbnail,ftitle,url_title,description')->order('create_time desc,id asc')->paginate();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /***
     * @param $url_title
     * @return array|null|\PDOStatement|string|\think\Model
     * todo:: 这里 如果url_title不存在的话 报404的这个还没处理
     */
    public function getDataByUrl_title($url_title)
    {
        try {
            return self::where(['url_title' => $url_title])->find();
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
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
                if (Cache::store('file')->get('lastUpdate_' . $language_id)) {
                    return Cache::store('file')->get('lastUpdate_' . $language_id);
                } else {
                    Cache::store('file')->set('lastUpdate_' . $language_id, self::where(['language_id' => $language_id])
                        ->field('title,category_id,url_title')
                        ->limit(5)->order('id', 'desc')->all()->toArray());
                }
            }
            return Cache::store('file')->get('lastUpdate_' . $language_id) ?
                Cache::store('default')->get('lastUpdate_' . $language_id) : self::where(['language_id' => $language_id])
                    ->field('title,category_id,url_title')->limit(5)->order('id', 'desc')
                    ->all()->toArray();
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
                if (Cache::get('ArticleCounts_'.$language_id)) {
                    return Cache::get('ArticleCounts_'.$language_id);
                } else {
                    Cache::set('ArticleCounts_'.$language_id, self::where(['language_id' => $language_id])->count());
                }
            }
            return Cache::get('ArticleCounts_'.$language_id) ? Cache::get('ArticleCounts_'.$language_id) : self::where(['language_id' => $language_id])->count();
        } catch (Exception $exception) {
            return false;
        }
    }

    //todo:: Cache 没有处理
    public function getDataByIds($ids)
    {
        try {
            $data = self::where('category_id', 'in', $ids)->where(['status' => 1])
                ->order('create_time desc,id asc')
                ->field('id,clicks,category_id,language_id,create_time,thumbnail,title,ftitle,url_title,description')
                ->paginate();
            return ['status' => true, 'message' => 'ok', 'data' => $data];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
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
            $data = self::where(['language_id' => $language_id,'status'=>1])
                ->field('id,clicks,category_id,language_id,title,create_time,thumbnail,ftitle,url_title,description')
                ->order('create_time desc,id asc')->paginate();
            return ['status' => true, 'message' => 'ok', 'data' => $data];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
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
            if ($data = self::where(['url_title' => $url_title])->find()){
                return ['status'=>true,'message'=>'查到了','data'=>$data->toArray()];
            }
            return ['status'=>false,'message'=>'未找到','data'=>$this->getLastSql()];
        } catch (Exception $exception) {
            return ['status'=>false,'message'=>$exception->getMessage(),'data'=>$this->getLastSql()];
        }
    }
}
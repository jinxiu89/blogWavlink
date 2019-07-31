<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/20
 * Time: 17:48
 */

namespace app\common\agency;


use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\facade\Cache;
use think\Model;
use app\common\models\Article as ArticleModel;
use think\facade\Config;

/***
 * Class article
 * @package app\common\agency
 */
class article extends Model
{
    /***
     * @param $language_id
     * @return array|\PDOStatement|string|\think\Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getDataByLanguage($language_id)
    {
        return (new ArticleModel())->getDataByLanguage($language_id);
    }

    /***
     * @param $url_title
     * @return array|mixed|null|\PDOStatement|string|Model
     */
    public function getDataByUrl_title($url_title)
    {
        if (!Config::get('app.app_debug')) {
            if (!Cache::store('default')->get($url_title)) {
                Cache::store('default')->set($url_title, (new ArticleModel())->getDataByUrl_title($url_title)->toArray());
            } else {
                return ['status' => true, 'message' => 'ok', 'data' => Cache::store('default')->get($url_title)];
            }
        }
        return ['status' => true, 'message' => 'ok', 'data' => Cache::store('default')
            ->get($url_title) ? Cache::store('default')
            ->get($url_title) : (new ArticleModel())->getDataByUrl_title($url_title)->toArray()];
    }
}
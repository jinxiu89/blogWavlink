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
use think\Model;
use app\common\models\Article as ArticleModel;
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
}
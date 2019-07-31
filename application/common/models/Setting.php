<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/17
 * Time: 11:09
 */

namespace app\common\models;

use think\facade\Cache;
use think\Exception;

/***
 * Class Setting
 * @package app\common\models
 * 20190617
 */
class Setting extends Base
{
    protected $table = 'tb_setting';

    /***
     * @param $language_id
     * @return bool|mixed
     * 如果debug为假时 需要设置缓存
     */
    public function getDataById($language_id)
    {
        try {
            return self::where(['language_id' => $language_id])->find();
        } catch (Exception $exception) {
            return false;
        }
    }

}
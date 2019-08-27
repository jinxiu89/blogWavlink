<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/12
 * Time: 9:18
 */

namespace app\common\models;

use think\Exception;
use think\facade\Cache;
use think\facade\Config;

/***
 * Class Language
 * @package app\common\models
 */
class Language extends Base
{
    protected $table = "tb_language";


    /***
     * @param $code
     * @return array|string
     */
    public function getLanguageByCode($code)
    {
        try {
            return self::where('code', $code)->find()->toArray();
        } catch (Exception $exception) {
            return '';
        }
    }

    /***
     * @return mixed|string
     * 注意debug 为假时才设置缓存
     */
    public function getAll()
    {
        try {
            if (!$this->debug) {
                if(Cache::get('languageList')){
                    return Cache::get('languageList');
                }else {
                    $data = self::order('id asc')->where(['status' => 1])->all()->toArray();
                    Cache::set('languageList', $data);
                }
            }
            return Cache::get('languageList') ? Cache::get('languageList') : self::order('id asc')->where(['status' => 1])->all()->toArray();
        } catch (Exception $exception) {
            return '';
        }
    }
}
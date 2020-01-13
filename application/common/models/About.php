<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/18
 * Time: 11:31
 */

namespace app\common\models;


use think\Exception;

/***
 * Class About
 * @package app\common\models
 */
class About extends Base
{
    protected $table = 'tb_about';
    /***
     * @param $language_id
     * @return \think\Paginator
     */

    public function getAllData($language_id)
    {
        try {
            return result(true,'查询成功',self::where(['language_id' => $language_id])->paginate());
        } catch (Exception $exception) {
            return result(false,$this->error($exception->getMessage()));
        }
    }
    public function getDataByLanguageId($language_id){
        try{
            return result(true,'查找成功',self::where(['language_id'=>$language_id])
                                                            ->field('id,title,url_title')
                                                            ->select()
                                                            ->toArray());
        }catch (Exception $exception){
            return result(false,$this->error($exception->getMessage()));
        }
    }

    public function getDataById($id)
    {
        try {
            return result(true,'查询成功',self::get($id));
        } catch (Exception $exception) {
            return result(false,$this->error($exception->getMessage()));
        }
    }

}
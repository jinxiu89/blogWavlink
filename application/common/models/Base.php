<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/6
 * Time: 18:00
 */

namespace app\common\models;


use think\Db;
use think\Exception;

use think\exception\PDOException;
use think\Model;
use think\facade\Config;

/**
 * Class Base
 * @package app\common\models
 */
class Base extends Model
{
    protected $debug = false;
    protected $autoWriteTimestamp = true; //把时间设置成当前时间

    public function initialize()
    {
        parent::initialize();
        $this->debug = Config::get('app.app_debug');
    }

    /**
     * @param $data
     * @return array
     * @throws PDOException
     * @function saveDataBase  存储数据
     *
     */
    public function saveDataBase($data){
        //开启数据库事务操作
        self::startTrans();
        try {
            //commit() 提交事务
            return result(true,'添加成功',[self::save($data),self::commit()]);
        }catch (Exception $exception){
            //rollback 事务回滚
            return result(false,$exception->getMessage(),self::rollback());
        }
    }

    /**
     * @param $data
     * @param $condition
     * @return array
     * @throws PDOException
     * @function updateDataBase  存储更新
     */
    public function updateDataBase($data,$condition){
        //开启数据库事务操作
        self::startTrans();
        try {
            //commit() 提交事务
            return result(true,'更新成功',[self::update($data,$condition),self::commit()]);
        }catch (Exception $exception){
            //rollback 事务回滚
            return result(false,$exception->getMessage(),self::rollback());
        }
    }
}
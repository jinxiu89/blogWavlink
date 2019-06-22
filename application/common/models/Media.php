<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/22
 * Time: 11:29
 */

namespace app\common\models;

use think\Exception;

/***
 * Class Media
 * @package app\common\models
 */
class Media extends Base
{
    protected $table = "tb_media";
    protected $ok = "成功！";
    protected $failed = "失败！";

    /***
     * @return array
     */
    public function getAll()
    {
        try {
            return ['status' => true, 'message' => $this->ok, 'data' => self::paginate(25)];
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    /***
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function saveData($data)
    {
        try {
            if (self::allowField(true)->saveAll($data)) {
                return ['status' => true, 'message' => $this->ok];
            } else {
                return ['status' => false, 'message' => $this->failed];
            }
        } catch (Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
}
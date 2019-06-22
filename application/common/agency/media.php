<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/22
 * Time: 11:31
 */

namespace app\common\agency;

use think\Exception;
use think\Model;
use app\common\models\Media as MediaModel;

/***
 * Class media
 * @package app\common\agency
 */
class media extends Model
{
    protected $MediaModel;
    public function initialize()
    {
        parent::initialize();
        $this->MediaModel=new MediaModel();
    }

    /***
     * @param $data
     * @return array
     */
    public function Flipper($data)
    {
        $items = [];
        $item = [];
        if (!is_array($data)) {
            $this->error("上传图片格式有问题！");
        }
        foreach ($data as $key => $value) {
            $item[$value] = explode('_', $key)[0] . '.' . explode('_', $key)[1];
            $item['type'] = explode('_', $key)[1];
            $items[] = $item;
        }
        return $items;
    }

    public function saveData($data)
    {
        try {
            if ((new MediaModel())->saveData($data)) {
                return ['status' => true, 'message' => "保存成功！"];
            } else {
                return ['status' => false, 'message' => '保存失败！'];
            }
        } catch (Exception $exception) {
            return ['status' => false, 'message' => '保存失败！'];
        }
    }
    public function getALL(){
        return $this->MediaModel->getAll();
    }
}
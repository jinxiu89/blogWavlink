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
class article extends Base
{
    protected $model;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->model = new ArticleModel();
    }

    /***
     * @param $language_id
     *
     * @return array
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function getDataByLanguage($language_id)
    {
        //debug 为 是否开启缓存的配置，值是真或者假
        if ($this->debug) {//真
            $result = $this->model->getDataByLanguage($language_id);  //['status'=>true/false,'message'=>'ok/错误信息','data'=>"为真就有数据，为假就没有"]
            if ($result['status'] == true) {
                return ['status' => true, 'message' => 'ok', 'data' => $result['data']];
            } else {
                return ['status' => false, 'message' => $result['message']];
            }
        } else {//假

            if (!Cache::store('file')->get('data_' . $language_id)) {
                $result = $this->model->getDataByLanguage($language_id); //['status'=>true/false,'message'=>'ok/错误信息','data'=>"为真就有数据，为假就没有"]
                if ($result['status'] == true) {
                    Cache::store('file')->set('data_' . $language_id, $result['data']);
                    return ['status' => true, 'message' => $result['message'], 'data' => $result['data']];
                } else {
                    return ['status' => false, 'message' => $result['message']];
                }
            }

            return ['status' => true, 'message' => 'ok', 'data' => Cache::store('file')->get('data_' . $language_id)];
        }
    }

    /***
     * @param $url_title
     * @return array|mixed|null|string|Model
     *
     */
    public function getDataByUrl_title($url_title)
    {
        if ($this->debug==false) {//直接返回数据
            $data = $this->model->getDataByUrl_title($url_title);
            if ($data['status'] == true) {
                return ['status' => $data['status'], 'message' => $data['message'], 'data' => $data['data']];
            }
            return ['status' => $data['status']];
        }
        if (!Cache::store('default')->get($url_title)) {
            $data = $this->model->getDataByUrl_title($url_title);
            if ($data['status'] == true) {
                Cache::store('default')->set($url_title, $data['data']);
                return ['status' => true, 'message' => 'ok!', 'data' => Cache::store('default')->get($url_title)];
            }
            return ['status' => $data['status']];
        }
        return ['status'=>true,'message'=>'ok','data'=>Cache::store('default')->get($url_title)];
    }

    /***
     * @param $data
     */
    public function updateClicks($data)
    {
        $this->model->save($data, ['id' => $data['id']]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/14
 * Time: 14:14
 */

namespace app\common\models;

use app\admin\validate\files as filesValidate;
use function PHPSTORM_META\type;
use think\Collection;
use think\Exception;

/**
 * Class files
 * @package app\common\models
 */
class Files extends Base
{
    protected $table = 'tb_files';
    protected $success = "保存成功！";
    protected $failed = "保存失败！";
    protected $url = '/wavlink/files/list.html';

    /***
     * 创建文件和下载地址的一对多关系
     * @return \think\model\relation\HasMany
     */
    public function downloads()
    {
        return $this->hasMany('Download', 'file_id');
    }

    /***
     * 获取所有的数据并带上downloads
     * @return false|\think\db\Query[]
     * @throws Exception\DbException
     */
    public function getAllData($page, $listRow)
    {
        $offset = ($page - 1) == 0 ? 0 : ($page - 1) * $listRow;
        return self::with('Downloads')->order(['listorder' => 'desc', 'id' => 'asc'])->limit($offset, $listRow)->select()->toArray();
    }

    public function getCount()
    {
        return count(self::all());
    }

    /***
     * 此方法用于获取所有的文件列表
     *
     * @return bool|false|\think\db\Query[]
     */
    public function getFiles()
    {
        try {
            return self::order(['listorder' => 'desc', 'id' => 'asc'])->paginate();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getDataById($id)
    {
        try {
            return self::get($id);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param $data
     * @return false|string
     */
    public function saveData($data)
    {
        $validate = new filesValidate();
        if (isset($data['id'])) {
            if ($validate->check($data)) {
                try {
                    return self::allowField(true)->save($data, ['id' => $data['id']]) ?
                        show(true, $this->success, $this->url) : show(false, $this->failed, $this->url);
                } catch (Exception $exception) {
                    return show(false, $exception->getMessage(), '');
                }
            } else {
                return show(false, $validate->getError(), '');
            }
        } else {
            if ($validate->check($data)) {
                try {
                    return self::allowField(true)->save($data) ?
                        show(true, $this->success, $this->url) : show(false, $this->failed, $this->url);
                } catch (Exception $e) {
                    return show(false, $e->getMessage(), '');
                }
            } else {
                return show(false, $validate->getError(), '');
            }
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/13
 * Time: 14:05
 */

namespace app\admin\controller;

use app\common\helper\Aws as AwsHelper;
use think\Controller;
use app\common\models\Media;

header('Access-Control-Allow-Origin:*');
header('multipart/form-data');

/**
 * Class Aws
 * @package app\admin\controller
 */
class Aws extends Controller
{
    public function uploader()
    {
        if (Request()->isGet()) {
            return "ok";
        }
        if (Request()->isPost()) {
            $soure = $this->request->file('file');
            $key = 'WavlinkBlog/' . date("Y/m/d") . '/' . $soure->getInfo('name');
            $result = AwsHelper::uploader($soure, $key);
            if ($result) {
                return $result;
            }
        }
    }

    /***
     * 用于markdown的上传图片
     * 成功，返回url地址，不成功返回失败
     * todo:: 编辑器上传的时候会出现 Provisional headers are shown 后续再过来查问题
     */
    public function markdownUpload()
    {
        $soure = request()->file('editormd-image-file');
        $key = 'WavlinkBlog/' . date("Y/m/d") . '/' . $soure->getInfo('name');
        $result = AwsHelper::uploader($soure, $key);
        if ($result) {
            $file['aws_key'] = $result;
            $file['type'] = explode('.', $result)[1];
            $data[] = $file;
            $res = (new Media())->saveData($data);
            if ($res['status'] == true) {
                $data = array(
                    "success" => 1,
                    'message' => 'success',
                    "url" => "//files.iqs.link/" . $result
                );
                echo json_encode($data);
            } else {
                echo json_encode(array(
                    'success' => 0,
                    'message' => 'failed',
                ));
            }
        } else {
            echo json_encode(array(
                'success' => 0,
                'message' => 'failed',
            ));
        }
    }
}
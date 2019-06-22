<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/13
 * Time: 14:05
 */

namespace app\admin\controller;

use app\common\helper\Aws as AwsHelper;

/**
 * Class Aws
 * @package app\admin\controller
 */
class Aws extends Base
{
    public function uploader()
    {
        if (Request()->isGet()) {
            return "ok";
        }
        if (Request()->isPost()) {
            $soure = $this->request->file('file');
            $key = 'WavlinkBlog/'.$soure->getInfo('name');
            $result = AwsHelper::uploader($soure, $key);
            if ($result) {
                return $result;
            }
        }
    }
}
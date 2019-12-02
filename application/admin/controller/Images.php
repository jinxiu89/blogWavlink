<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/21
 * Time: 15:26
 */

namespace app\admin\controller;

use app\common\agency\media;

header('Access-Control-Allow-Origin:*');
/***
 * Class Images
 * @package app\admin\controller
 */
class Images extends Base
{
    /***
     *
     */
    public function initialize()
    {
        parent::initialize();
    }

    /***
     * @return string
     */
    public function index()
    {
        $result = (new media())->getALL();
        if ($result['status'] == true) {
            $this->assign('data', $result['data']);
        }
        return $this->fetch();
    }

    public function listimg()
    {
        $result = (new media())->getAll();
        return $this->fetch('', [
            'data' => $result['data']
        ]);
    }

    /***
     * @return mixed
     */
    public function upload()
    {
        if (request()->isGet()) {
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = (new media())->Flipper(input('post.'));
            $result = (new media())->saveData($data);
            return show($result['status'], $result['message'], '/wavlink/static/images/list.html');
        }
    }
=======
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/6/21
 * Time: 15:26
 */

namespace app\admin\controller;

use app\common\agency\media;

header('Access-Control-Allow-Origin:*');
/***
 * Class Images
 * @package app\admin\controller
 */
class Images extends Base
{
    /***
     *
     */
    public function initialize()
    {
        parent::initialize();
    }

    /***
     * @return string
     */
    public function index()
    {
        $result = (new media())->getALL();
        if ($result['status'] == true) {
            $this->assign('data', $result['data']);
        }
        return $this->fetch();
    }

    public function listimg()
    {
        $result = (new media())->getAll();
        return $this->fetch('', [
            'data' => $result['data']
        ]);
    }

    /***
     * @return mixed
     */
    public function upload()
    {
        if (request()->isGet()) {
            return $this->fetch();
        }
        if (request()->isPost()) {
            $data = (new media())->Flipper(input('post.'));
            $result = (new media())->saveData($data);
            return show($result['status'], $result['message'], '/wavlink/static/images/list.html');
        }
    }
>>>>>>> newbranch
}
<<<<<<< HEAD
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
     * @return \think\model\relation\BelongsToMany
     * 媒体资源和文章是一个多对多的关系，即同一张图片可以被用在多篇文章上 belongsToMany
     * 第一个参数：被关联的那个模型的类名（即Article）
     * 第二个参数：关系表的表明（数据库中的那个关系表），这里指的是article_media这个表
     * 第三个参数：外键，相对于本模型，被关联的那个模型在关系表体现的那个ID，这里是指 Article 模型的ID 在关系表中的那个体现，这里命名为 article_id
     * 第四个参数：关联键，是相对于本模型，在关系表中体现的那个ID，这里为media_id
     * 多对多关联时 也可以用field过滤输出的字段，默认不需要这么多不是
     */
    public function article()
    {
        return $this->belongsToMany('Article', 'article_media', 'article_id', 'media_id')->field('id,title');
    }

    /***
     * @param $id
     * @return null
     *
     */
    public function getDataById($id)
    {
        try {
            return $this->with('article')->get($id)->toArray();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

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
=======
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
     * @return \think\model\relation\BelongsToMany
     * 媒体资源和文章是一个多对多的关系，即同一张图片可以被用在多篇文章上 belongsToMany
     * 第一个参数：被关联的那个模型的类名（即Article）
     * 第二个参数：关系表的表明（数据库中的那个关系表），这里指的是article_media这个表
     * 第三个参数：外键，相对于本模型，被关联的那个模型在关系表体现的那个ID，这里是指 Article 模型的ID 在关系表中的那个体现，这里命名为 article_id
     * 第四个参数：关联键，是相对于本模型，在关系表中体现的那个ID，这里为media_id
     * 多对多关联时 也可以用field过滤输出的字段，默认不需要这么多不是
     */
    public function article()
    {
        return $this->belongsToMany('Article', 'article_media', 'article_id', 'media_id')->field('id,title');
    }

    /***
     * @param $id
     * @return null
     *
     */
    public function getDataById($id)
    {
        try {
            return $this->with('article')->get($id)->toArray();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

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
>>>>>>> 301e3c4052971c4e29904b2afed128ab72ab63dd
}
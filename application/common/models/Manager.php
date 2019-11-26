<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/6
 * Time: 17:59
 */

namespace app\common\models;


use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\facade\Config;
use app\common\models\Language;

/**
 * Class manager
 * @package app\common\models
 */
class Manager extends Base
{
    protected $table = "tb_manager";

    /***
     * @return \think\model\relation\BelongsToMany
     * 管理员和角色之间的关系是多对多的关系 belongsToMany
     * 第一个参数：被关联的那个模型的类名（即Role）
     * 第二个参数：关系表的表明（数据库中的那个关系表）
     * 第三个参数：外键，相对于本模型，被关联的那个模型在关系表体现的那个ID，这里是指 Role模型的ID 在关系表中的那个体现，这里命名为 rid
     * 第四个参数：关联键，是相对于本模型，在关系表中体现的那个ID，这里为mid
     */
    public function roles()
    {
        return $this->belongsToMany('Role', 'manager_role', 'rid', 'mid');
    }

    public function login($data, $url)
    {
        $map = array(
            "name" => $data['name'],
            "status" => 1,
        );
        $language_id = $data['language_id'];
        try {
            $user = self::where($map)->find()->toArray();
            if ($user['password'] != md5($data['password']) . Config::get('app.user_secret')) {
                return show(false, '密码不正确', '');
            } else {
                $language = (new Language())::get($language_id)->toArray();
                session("adminUser", $user, 'admin');
                session('language',$language,'admin');
                return show(true, '登录成功！', $url);
            }
        } catch (DataNotFoundException $e) {
            return show(false, $e->getMessage(), '');
        } catch (ModelNotFoundException $e) {
            return show(false, $e->getMessage(), '');
        } catch (DbException $e) {
            return show(false, $e->getMessage(), '');
        }
    }
}
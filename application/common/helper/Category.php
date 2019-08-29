<?php

namespace app\common\helper;
class Category
{

    /**
     * 建立一个空数组
     * 用foreach 遍历 数组里的数据
     * 如果数组里的parent_id 全等于 $parent_id值，则
     * 让level加一
     *
     * @param $cate 第一个参数接受一个数组
     * @param string $delimiter 第二个参数指定分界符
     * @param int $parent_id 第三个参数指定默认父ID
     * @param int $level 第四个参数默认等级
     * @return array
     */
    static public function toLevel($cate, $delimiter = "━", $parent_id = 0, $level = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['level'] = $level + 1;
                $v['delimiter'] = str_repeat($delimiter, $level);
                $arr[] = $v;
                $arr = array_merge($arr, self::toLevel($cate, $delimiter, $v['id'], $v['level']));
            }
        }
        return $arr;
    }

    /**
     * 组成多维数组
     * @param $cate
     * @param string $name
     * @param int $parent_id
     * @return array
     */
    static public function toLayer($cate, $name = 'title', $parent_id = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['parent_id'] == $parent_id) {
                $v[$name] = self::toLayer($cate, $name, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }


    //一维数组(同模型)(model = tablename相同)，删除其他模型的分类
    static public function getLevelOfModel($cate, $tablename = 'article')
    {

        $arr = array();
        foreach ($cate as $v) {
            if ($v['tablename'] == $tablename) {
                $arr[] = $v;
            }
        }

        return $arr;

    }

    //一维数组(同模型)(modelid)，删除其他模型的分类

    /**
     * @param $cate
     * @param int $modelid
     * @return array
     */
    static public function getLevelOfModelId($cate, $modelid = 0)
    {

        $arr = array();
        foreach ($cate as $v) {
            if ($v['modelid'] == $modelid) {
                $arr[] = $v;
            }
        }

        return $arr;

    }

    //传递一个子分类ID返回他的所有父级分类

    /**
     * @param $cate
     * @param $id
     * @return array
     */
    static public function getParents($cate, $id)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['id'] == $id) {
                $arr[] = $v;
                $arr = array_merge(self::getParents($cate, $v['parent_id']), $arr);
            }
        }
        return $arr;
    }

    /***
     * 传递一个子分类，把他的一级分类返回去
     *
     * @param $cate
     * @param $id
     */
    static public function getParent($cate, $id)
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v['id'] == $id) {
                if ($v['parent_id'] == 0) {
                    $arr[] = $v;
                }
                $arr = array_merge(self::getParent($cate, $v['parent_id']), $arr);
            }

        }
        return $arr;
    }

    //传递一个子分类ID返回他的同级分类
    static public function getSameCate($cate, $id)
    {
        $arr = array();
        $self = self::getSelf($cate, $id);
        if (empty($self)) {
            return $arr;
        }

        foreach ($cate as $v) {
            if ($v['id'] == $self['pid']) {
                $arr[] = $v;
            }
        }
        return $arr;
    }


    //判断分类是否有子分类,返回false,true
    static public function hasChild($cate, $id)
    {
        $arr = false;
        foreach ($cate as $v) {
            if ($v['parent_id'] == $id) {
                $arr = true;
                return $arr;
            }
        }
        return $arr;
    }
    //传递一个父级分类ID返回所有子分类ID

    /**
     * @param $cate 全部分类数组
     * @param $pid 父级ID
     * @param 是否包括父级自己的ID|int $flag 是否包括父级自己的ID，默认不包括
     * @return array
     */
    static public function getChildsId($cate, $pid, $flag = 0)
    {
        $arr = array();
        if ($flag) {
            $arr[] = $pid;
        }
        foreach ($cate as $v) {
            if ($v['parent_id'] == $pid) {
                $arr[] = $v['id'];
                $arr = array_merge($arr, self::getChildsId($cate, $v['id']));
            }
        }
        return $arr;
    }

    static public function getChildsByPid($cate, $pid)
    {
        $arr = [];
        foreach ($cate as $item) {
            if ($item['parent_id'] == $pid) {
                $arr[] = $item;
            }
        }
        return $arr;
    }

    //传递一个父级分类ID返回所有子级分类
    static public function getChilds($cate, $pid)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['parent_id'] == $pid) {
                $arr[] = $v;
                $arr = array_merge($arr, self::getChilds($cate, $v['id']));
            }
        }
        return $arr;
    }

    //传递一个分类ID返回该分类相当信息
    static public function getSelf($cate, $id)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['id'] == $id) {
                $arr = $v;
                return $arr;
            }
        }
        return $arr;
    }

    //传递一个分类ID返回该分类相当信息
    static public function getSelfByEName($cate, $ename)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['ename'] == $ename) {
                $arr = $v;
                return $arr;
            }
        }
        return $arr;
    }
}

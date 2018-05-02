<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/28
 * Time: 23:53
 */

namespace app\back\model;
use think\Db;
use think\Collection;

class Privileges extends Base
{
    protected  $table="bk_auth_rule";
    protected static function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        self::afterDelete(function ($Privileges)
        {

        });
    }

    public function add()
    {
        $data = input('post.');
        $res = $this->validate('Privileges.add')->allowField(true)->save($data);
        if($res)
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function edit()
    {
        $data = input('post.');
        $res = $this->validate('Privileges.edit')->allowField(true)->save($data,['id'=>$data['id']]);
        if($res)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function getAllPrivileges()
    {

        return list_to_tree($this->select(),'id','pid');


    }
    //无限级分类树
    public function getTree()
    {
        $data =self::all();
        //dump($data);
        return  $this->_getTree($data);
    }
    /*
     * 无限级递归调用
     */
    public function _getTree($data,$pid=0,$level=0)
    {
        static $res = [];
        foreach ($data as $k => $v )
        {
            if($v['pid'] == $pid)
            {
                //$v['level'] = $level;
               $v['title'] = str_repeat('--',$level*2).$v['title'];
                $res[] =  $v;
                $this->_getTree($data,$v['id'],$level+1);
            }
          //  return false;
        }
        return Collection::make($res)->toArray();
    }
    //
    public function getChildren($id)
    {
        $data = $data =self::all();
        return $this->_children($data, $id);
    }
    private function _children($data, $pid=0, $isClear=TRUE)
    {
        static $ret = [];
        if($isClear)
            $ret = [];
        foreach ($data as $k => $v)
        {
            if($v['pid'] == $pid)
            {
                $ret[] = $v['id'];
                $this->_children($data, $v['id'], FALSE);
            }
        }
        return $ret;
    }
}
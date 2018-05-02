<?php

namespace app\back\model;



class Category extends Base
{

    //无限级分类树
    public function getTree()
    {
        $data = $this::all();
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
                $v['level'] = $level;
                $res[] =  $v;
                $this->_getTree($data,$v['id'],$level+1);
            }

        }
        return $res;
    }
    public function getList()
    {
        if(request()->isGet())
        {
            $where=[];
            $data = input('param.');
           return $this::where($where)->order('id')->paginate(5);

        }
    }
}

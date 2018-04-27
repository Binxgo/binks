<?php

namespace app\back\controller;

use think\Db;
use think\Request;

class Category extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function cateList()
    {
        $m = model('category');
        $cate = $m->getTree();
        $this->assign('cate',$cate);
        $this->assign('count',$m->count());
       return $this->fetch('cate_list');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function cateAdd()
    {
        $m = model('category');
        $cate = $m->getTree();
        if(request()->isPost())
        {
            $data = input('post.');
            //dump($data);
           if( $m->validate(true)->save($data))
           {
               $this->success('成功','Category/cateList');
           }else
           {
               $this->error('失败');
           }

        }
        $this->assign('cate',$cate);
        return $this->fetch('cate_add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function cateEdit()
    {
       $m =  model('category');
        $cate_id = input('id');
        if(request()->isPost())
        {
            $data = input('post.');
            if($m->validate(true)->isUpdate(true)->save($data,['id'=>$cate_id]))
            {
                $this->success('成功','cateList');
            }else{

                $this->error('失败');
            }
        }

        $cate = $m->getTree();
        $cate_list =  Db::name('category')->find($cate_id);
        $this->assign('cate_list',$cate_list);
        $this->assign('cate',$cate);
        $this->assign('cate_id',$cate_id);

        return $this->fetch('cate_edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function cateDel($id)
    {
        //
        if(!is_array($id))
        {
            \app\back\model\Category::destroy(function ($query) use ($id)
            {
                $query->where('pid',$id)->field('id');
            }
            );
            return  \app\back\model\Category::destroy($id) ? ['message'=>'成功','status'=>1] : ['message'=>'失败','status'=>0];
        }else
        {
            return  \app\back\model\Category::destroy($id) ? ['message'=>'成功','status'=>1] : ['message'=>'失败','status'=>0];

        }


    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/19
 * Time: 11:35
 */

namespace app\back\controller;
use app\back\model\Goods as goodsM;

use think\Db;
use think\response\Redirect;

class Goods extends  Base
{
    public function goodsAdd()
    {
        $m = new goodsM();

        if(request()->isPost())
        {
            $data = input('param.');

            if($m->data($data)->save())
            {
                $this->success('增加成功','goodsList');
            }
            else
            {
                $this->error('增加失败','goodAdd');
            }


        }

        return $this->fetch('goods_add');
    }

    public function goodsList()
    {
        $m = model('goods');

        $list = $m->getList();
        //dump($list);
        $total = $m->count();
        $this->assign('total',$total);
        $this->assign('list',$list);
        //dump($list);
        return $this->fetch('goods_list');
    }


    public function goodsDel($id)
    {
        return goodsM::destroy($id)? ['message'=>'删除成功','status'=>1] : ['message'=>'删除失败','status'=>0];

    }

    public function goodsEdit()
    {
        $m = model('goods');
        $id = input('param.id');
        $goods = Db::name('goods')->where(['id'=>$id])->find();
        if(request()->isPost())
        {
            $data = input('param.');
           // dump($data);
            if($m->allowField(true)->isUpdate(true)->save($data))
            {
                $this->success('修改成功','goodsList');
            }
            else
            {
                $this->error('修改失败','goodsEdit');
                //echo '失败';
            }


        }
        $this->assign('goods',$goods);
        return $this->fetch('goods_edit');
    }



}
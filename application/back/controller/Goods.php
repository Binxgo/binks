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
        $total = $m->count();
        $this->assign('total',$total);
        $this->assign('list',$list);
        //dump($list);
        return $this->fetch('goods_list');
    }


    public function goodsDel()
    {
        return $this->fetch('goods_del');
    }

    public function goodsEdit()
    {
        $m = model('goods');
        $id = input('param.id');
        $goods = Db::name('goods')->where('id',$id)->find();
        if(request()->isPost())
        {
            $data = input('param.');
            if($m->data($data)->isUpdate(true)->save())
            {
                $this->success('修改成功','goodsList');
            }
            else
            {
                $this->error('修改失败','goodEdit');
            }


        }
        $this->assign('goods',$goods);
        return $this->fetch('goods_edit');
    }

}
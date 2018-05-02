<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/27
 * Time: 18:17
 */

namespace app\back\controller;


use think\Db;

class Admin extends Base
{
    public function index()
    {
        $lst = model('admin')->getAdminList();
        $count = Db::name('admin')->count();
        $this->assign('count',$count);
        $this->assign('lst',$lst);
        return $this->fetch('admin-list');
    }

    public function edit($id)
    {
        $db =  Db::name('admin');
        if($this->request->isPost())
        {
            $data = input('post.');
            if($db->where('id',$id)->update($data))
            {
                return ['msg'=>'成功','code'=>1];
            }else
            {
                return ['msg'=>'失败','code'=>0];
            }

        }

        $lst = $db->where('id',$id)->find();
        $this->assign('lst',$lst);

        return $this->fetch('admin-edit');
    }

    public function adminAdd()
    {
      $role =   Db::name('auth_group g')->field('g.title,g.id')
                ->where('status',1)
                ->select();
       //dump($role);
        $this->assign('role',$role);
        return $this->fetch('admin-add');
    }

    public function adminEdit($id)
    {
        $admin = Db::name('admin')->find($id);
        $role =   Db::name('auth_group g')->field('g.title,g.id,ga.uid,ga.group_id')
                    ->join('auth_group_access ga','ga.group_id= g.id')
                    ->where('status',1)->select();
        //dump($role);
        $this->assign('admin',$admin);
        $this->assign('role',$role);
       // $this->assign('role_id',$role_id);

        return $this->fetch('admin-edit');
    }
    public function update()
    {
        $data = input('post.');
        $passwd = input('post.passwd');
       //echo $passwd;
        if($passwd)
        {
            if(model('admin')->validate('Admin.add')->allowField(true)->isUpdate(true)->save($data))
            {
                return ['msg'=>'更改成功','code'=>1];
            }else
            {
                return ['msg'=>'更改失败','code'=>0];
            }
        }else
        {
            if(model('admin')->validate('Admin.edit')->allowField('username','role_id')->isUpdate(true)->save($data))
            {
                return ['msg'=>'更改成功','code'=>1];
            }else
            {
                return ['msg'=>'更改失败','code'=>0];
            }
        }

    }

    public function add()
    {
        $ad =  model('admin');

        if($this->request->isPost())
        {
            $data = input('post.');
            //dump($data);
            if($ad->validate(true)->allowField(true)->save($data))
            {
                return ['msg'=>'添加成功','code'=>1];
            }else
            {
                return ['msg'=>'添加失败','code'=>0];
            }

        }

        return $this->fetch('admin-add');
    }

    public function delete($id)
    {
        return   \app\back\model\Admin::destroy($id)  ?   ['msg'=>'已删除','code'=>1]   :  ['msg'=>'删除失败','code'=>0] ;



    }

    public function isUse($id)
    {
        $m = model('admin');
        $use = $m::where('id',$id)->value('is_use');
        if($use == 1)
        {
            $m::update(['is_use'=>0],['id'=>$id]);
            return ['msg'=>'停用成功','code'=>0];
        }
        else
        {
            $m::update(['is_use'=>1],['id'=>$id]);
            return ['msg'=>'启用成功','code'=>1];
        }
    }
}
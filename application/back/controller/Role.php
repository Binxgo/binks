<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/28
 * Time: 16:42
 */

namespace app\back\controller;

use think\Db;
class Role extends Base
{

    public function index()
    {
        $role_list = model('role')->getRoleList();

        $this->assign('role_list',$role_list);
        $this->assign('count',$role_list->count());
        return $this->fetch('role_list');
    }

    public function add()
    {
        if(request()->isPost()) {
            $add = model('role')->add();
            if ($add) {
                $this->success('添加用户组成功！', url('index'));
            } else {
                $this->error('添加用户组失败！');
            }
        }

        return $this->fetch('role_add');
    }

    public function edit($id)
    {

        if(request()->isPost()) {
            $eidt = model('role')->edit();
            if ($eidt) {
                $this->success('修改用户组成功！', url('index'));
            } else {
                $this->error('修改用户组失败！');
            }
        }
        $role_list = model('role')->find($id);
        $this->assign('role_list',$role_list);
        $this->assign('id',$id);
        return $this->fetch('role_edit');
    }
    //删除
    public function delete($id)
    {
        return   \app\back\model\Role::destroy($id)  ?   ['msg'=>'已删除','code'=>1]   :  ['msg'=>'删除失败','code'=>0] ;

    }

    //返回无限级权限树形结构
    public function roleList($type,$id=0)
    {
        $rlu = model('role');
        if ($type == "add" && $id == 0)
        {
            $items= Db::name('auth_rule')->order('pid, sort')->select();//按pid从小到大排序，以保证父节点在前，子节点在后。sort是同一层次节点的显示顺序。
            $menu = $rlu->getRulesTrees($items);
            $rlue = ['code'=>0,'msg'=>'成功','data'=>['trees'=>$menu]];
        }
        elseif($type == 'edit' && $id != 0)
        {
            $items= Db::name('auth_rule')->order('pid, sort')->select();
            $ids = Db::name('auth_group')->where('id',$id)->value('rules');
           // $item = Db::name('auth_rule')->order('pid,sort')->where('id','in',$ids)->select();
            $ids = explode(',',$ids);
            $menu = $rlu->getRulesTrees($items,$ids);
            $rlue = ['code'=>0,'msg'=>'成功','data'=>['trees'=>$menu]];
        }

        //dump($rlue);exit;
        return json($rlue);
    }

    public function isUse($id)
    {
        $m =  model('role');
        if(0 == $m->where('id',$id)->value('status'))
        {
            $m::update(['status'=>1],['id'=>$id]);
            return ['msg'=>'启用成功','code'=>1];
        }
        else
            $m::update(['status'=>0],['id'=>$id]);
            return ['msg'=>'停用成功','code'=>0];
    }

}
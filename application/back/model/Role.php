<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/5/1
 * Time: 13:07
 */

namespace app\back\model;


class Role extends Base
{
    protected $table = "bk_auth_group";
    //添加
    public function add()
    {

            $title = input('post.title/s');
            $privi = input('post.authids/a');
            $status = input('post.status/d');
            //dump($privi) ;die();
            if ($privi) {
                $rules = implode(",", $privi);
            }
            $data['title'] = $title;
            $data['status'] = $status;
            $data['rules'] = $rules;
            //dump($data);die;
            $add = $this->allowField(true)->data($data)->save();
            return $add ? true : false;

    }
    //修改
    public function edit()
    {
        $id = input('post.id/d');
        $title = input('post.title/s');
        $privi = input('post.authids/a');
        $status = input('post.status/d');
        //dump($privi) ;die();
        if ($privi) {
            $rules = implode(",", $privi);
        }
        $data['title'] = $title;
        $data['status'] = $status;
        $data['rules'] = $rules;
        //dump($data);die;
        $edit = $this->allowField(true)->save($data,['id'=>$id]);
        return $edit ? true : false;

    }

    //获取角色列表分页
    public function getRoleList()
    {
        return self::paginate(5);
    }

    /*
     * 返回无限级权限树形结构
     * @param []
     * @param  [] 权限数组
     * @param 0
     * @return  []
     */
    public function getRulesTrees($items,$ids=[],$isajax=0)
    {
        //$items= Db::name('auth_rule')->order('pid, sort')->select();//按pid从小到大排序，以保证父节点在前，子节点在后。sort是同一层次节点的显示顺序。
        $menu = array();//
        foreach ($items as $k => $v) {
            $v['name'] = $v['title'];
            $v['value'] = $v['id'];
            if(!empty($ids))
            {
                //$diff = array_diff($ids,$v);
                //判断当前id是否在权限数组中
                   if(in_array($v['id'],$ids))
                   {
                       $v['checked'] = true;
                   }
                   else
                   {
                       $v['checked'] = false;
            }
        }
            $menu[$v['id']] = $v;//按ID存放循环的一维数组
            $menu[$v['id']]['list'] = [];//items存放当前节点的所有子节点。
            if($v['pid'] != 0) {
                $menu[$v['pid']]['list'][$v['id']] = &$menu[$v['id']];
            }
        }
        foreach ($menu as $k=>$v) {
            if($v['pid'] != 0) {
                unset($menu[$k]);
            }
        }

        return $menu;
    }
}
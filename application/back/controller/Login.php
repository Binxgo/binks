<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/27
 * Time: 18:28
 */

namespace app\back\controller;
use think\Controller;
use think\Db;

use think\captcha\Captcha;

class Login extends Controller
{

    public function index()
    {
       return $this->view->fetch('login');
    }
    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串，$id多个验证码标识
    function check_verify($code, $id = ''){
        $captcha = new Captcha();
        return $captcha->check($code, $id);
    }
    public function check()
    {
        $username = input('post.username');
        $passwd   = sha1(input('post.passwd'));
        $check    = input('post.check');
       // dump($data);
        if(!$check || !$this->check_verify($check)) $this->error('验证码错误');
        $admin = Db::name('admin')->where('username',$username)->find();
        if($admin)
        {
            if($admin['passwd'] == $passwd)
            {
                session('admin_id',$admin['id']);
                $this->success('登陆成功','index/index');
            }
            else
            {
                $this->error('密码不正确');
            }
        }
        else
        {
            $this->error('用户不存在');
        }

        //return ['message'=>'成功','status'=>1];
    }

}
<?php
namespace app\back\controller;

class Index extends Base
{
    public function index()
    {
        //if($this->isLogin()) $this->error('请先登录','login/index');
        return $this->fetch('index');
    }
    public function welcome()
    {
        return $this->fetch('welcome');
    }


}

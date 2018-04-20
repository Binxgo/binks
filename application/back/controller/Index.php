<?php
namespace app\back\controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch('index');
    }
    public function welcome()
    {
        return $this->fetch('welcome');
    }
}

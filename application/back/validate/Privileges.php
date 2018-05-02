<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/29
 * Time: 22:15
 */

namespace app\back\validate;


use think\Validate;

class Privileges extends  Validate
{
    protected $rule = [
        ['title','require|max:15','权限名称必须|最大15个字符'],
        ['name','require','必须'],



    ];
    protected $scene = [
        'add' => ['name','title'],
        'edit'=>['name','title']
    ];

}
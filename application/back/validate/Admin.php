<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/28
 * Time: 20:10
 */

namespace app\back\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        ['username' , 'require|max:25','名称必须'],
        ['passwd','require|max:64','密码必须'],
        ['group_id','require','角色必须']
    ];

    protected $scene = [
        'add'=>['username','passwd','group_id'],
        'edit'=>['username','group_id']
    ];
}
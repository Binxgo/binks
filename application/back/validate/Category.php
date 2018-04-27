<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/19
 * Time: 16:54
 */

namespace app\back\validate;
use think\Validate;

class Category extends Validate
{
    // 当前验证的规则
    protected $rule = [
       ['cate_name','require','名称必须'],
       [ 'pid','require','父类必须'],
    ];

    protected $scene = [
        //'add'=>['goodsName'],
        //'edit'=>['goodsNo']
    ];
}
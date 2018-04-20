<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018/4/19
 * Time: 16:54
 */

namespace app\back\validate;
use think\validate;

class Goods extends validate
{
    // 当前验证的规则
    protected $rule = [
       ['goodsName' => 'require','名称必须'],
       [ 'goodsSn' => 'require|max:1,10','货号必须|货号只能在1-10之间'],
    ];

    protected $scene = [
        'add'=>['goodsName'],
        'edit'=>['goodsNo']
    ];
}
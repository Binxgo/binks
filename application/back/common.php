<?php

/**
 * 生成数据返回值
 */
function BkReturn($msg,$status = -1,$data = []){
    $rs = ['status'=>$status,'msg'=>$msg];
    if(!empty($data))$rs['data'] = $data;
    return $rs;
}

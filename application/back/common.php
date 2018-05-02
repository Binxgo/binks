<?php

/**
 * 生成数据返回值
 */
function BkReturn($msg,$status = -1,$data = []){
    $rs = ['status'=>$status,'msg'=>$msg];
    if(!empty($data))$rs['data'] = $data;
    return $rs;
}


/**
 * 把返回的数据集转换成Tree
 * access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * return array
 */
function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
    /*
     * 字符串查找并删除
     * $data[$key] = "1,2,4,6,8,9" , $id = 6
     * @return $res = '1,2,4,8,9'
     */
    function sub_str($data,$id,$key,$len)
    {
        $res = [];
        foreach ($data as $k => $v)
            {
                $count = strpos(','.$v[$key],','.$id);
                if(FALSE !== $count)
                {
                    $str=substr_replace(','.$v[$key],"",$count,$len);
                    $link = substr($str,(strpos($str,',')+1));
                    $v[$key] = $link;
                    $res[] = $v;
                }
            }
            return $res;
    }
}
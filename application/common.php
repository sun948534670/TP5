<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

if (!function_exists('get_tree')) {

    /**
     * 获取当前访问的URL
     * @param array $data 所需转换的树形结构数组
     * @param string $pId 所需转换的树形结构的起始点
     * @return array
     */
    function get_tree($data, $pid)
    {
        $tree = '';
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                //父亲找到儿子
                $v['son'] = get_tree($data, $v['id']);
                $tree[] = $v;
                unset($data[$k]);
            }
        }
        return $tree;
    }

}

if (!function_exists('del_by_value')) {

    /**
     * 删除数组中指定的value
     * @param array $data 所需数组
     * @param string $value 所需value
     * @return array
     */

    function delByValue($data, $value){
        if(!is_array($data)){
            return $data;
        }
        foreach($data as $k=>$v){
            if($v == $value){
                unset($data[$k]);
            }
        }
        return $data;
    }
}
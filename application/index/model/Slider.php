<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 http://www.hisiphp.com
// +----------------------------------------------------------------------
// | HisiPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
// +----------------------------------------------------------------------
// | Author: 孙承志 <948534670@qq.com>，开发者QQ群：50304283
// +----------------------------------------------------------------------
namespace app\index\model;

use think\Model;
use think\Cache;

/**
 * 后台用户模型
 * @package app\admin\model
 */
class Slider extends Model
{

    /**
     * 查询所有
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public static function getEntitys(){

        if(Cache::get('slider')){
            return Cache::get('slider');
        }else{
            $result = collection(self::where('status','1')->order('sort')->select())->toArray();
            Cache::set('slider',$result);
        }
        return $result;
    }

}

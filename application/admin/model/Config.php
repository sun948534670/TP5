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
namespace app\admin\model;

use think\Model;


/**
 * 后台用户模型
 * @package app\admin\model
 */
class Config extends Model
{

    /**
     * 查询所有配置
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public static function getEntitys(){

        $orgin_result =  collection(self::all())->toArray();
        $result = array();
        foreach ($orgin_result as $value){
            $result[$value['name']] = $value;
        }
        return $result;
    }

    public static function updateEntity($data){
        foreach ($data as $key=>$value){
            self::where('name', $key)->update(['value' => $value]);
        }
    }
}

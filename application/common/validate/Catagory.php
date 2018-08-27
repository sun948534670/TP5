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
namespace app\common\validate;

use think\Validate;

/**
 * 用户验证器
 * @package app\admin\validate
 */
class Catagory extends Validate
{
    //定义验证规则
    protected $rule = [
        'id|ID' =>'number',
        'catagory_name|分类名称' => 'require|unique:video_catagory',
        'status|状态'    => '',
    ];

    //定义验证提示
    protected $message = [
        'id.number' => '非法操作',
        'catagory_name.require' => '请输入分类名称',
        'catagory_name.unique' => '已存在相同的分类名称',
        'status'  => '',
    ];

    //定义验证场景
    protected $scene = [
        //更新
        'insert'  =>  ['id','catagory_name'],
        'del'  =>  ['id' => 'array'],
    ];
}

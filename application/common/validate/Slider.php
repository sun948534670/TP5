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
class Slider extends Validate
{
    //定义验证规则
    protected $rule = [
        'id|ID' =>'number',
        'title|标题' => 'token',
        'content|内容'    => '',
        'href|超链接'     => '',
        'img|图片'  => 'require',
        'status|状态'   => '',
    ];

    //定义验证提示
    protected $message = [
        'id.number' => '非法操作',
        'title.token' => '未知错误',
        'img.require'  => '请上传图片',
    ];

    //定义验证场景
    protected $scene = [
        //更新
        'insert'  =>  ['id','img'],
        'del'  =>  ['id' => 'array'],
    ];
}

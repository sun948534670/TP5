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
class Video extends Validate
{
    //定义验证规则
    protected $rule = [
        '__token__' => 'require|token',
        'id|ID' =>'number',
        'catagory_id|分类' => 'require',
        'tag_id|标签'    => 'require',
        'name|视频名称'     => 'require|length:1,100',
        'content|视频描述'     => 'require',
        'code|识别码'     => 'require|length:4,8|unique:video|alphaNum',
        'thumb|缩略图'  => 'require',
        'path|视频'   => 'require',
        'status|状态' =>''
    ];

    //定义验证提示
    protected $message = [
        'id.number' => '非法操作',
        'catagory_id.require' => '请选择分类',
        '__token__.token' => '请勿重复提交',
        'tag_id.require'  => '请输入热门标签',
        'name.require'     => '请输入视频名称',
        'name.length'     => '最多可输入100个字符',
        'content.require'     => '请输入视频内容',
        'code.require'     => '请输入识别码',
        'code.length'     => '请输入4-8位随机字符',
        'path.require'   => '请上传视频',
    ];

    //定义验证场景
    protected $scene = [
        //更新
        'insert'  =>  ['catagory_id','tag_id','name','content','code','thumb','path','__token__'],
        'del'  =>  ['id' => 'array'],
    ];
}

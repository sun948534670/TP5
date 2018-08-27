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
namespace app\admin\validate;

use think\Validate;

/**
 * 用户验证器
 * @package app\admin\validate
 */
class AdminRole extends Validate
{
    //定义验证规则
    protected $rule = [
        'id|ID' =>'number|notIn:1',
        'name|角色名称' => 'require|token|unique:admin_role',
        'intro|简介'    => 'require',
        'auth|权限'     => 'require|array',
    ];

    //定义验证提示
    protected $message = [
        'id.number' => '非法操作',
        'id.In' => '不可操作超级管理员',
        'name.require' => '请输入角色名',
        'name.token' => '未知错误，请刷新后再试。',
        'intro.require'  => '请输入简介',
        'auth.require'    => '请选择至少一项权限',
        'auth.array'    => '请选择权限',
    ];

    //定义验证场景
    protected $scene = [
        //更新
        'insert'  =>  ['name', 'intro', 'auth'],

        //删除
        'del'  =>  ['id' => 'array'],

    ];
}

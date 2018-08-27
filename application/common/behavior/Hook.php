<?php
// +----------------------------------------------------------------------
// | HisiPHP框架[基于ThinkPHP5开发]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2018 http://www.HisiPHP.com
// +----------------------------------------------------------------------
// | HisiPHP承诺基础框架永久免费开源，您可用于学习和商用，但必须保留软件版权信息。
// +----------------------------------------------------------------------
// | Author: 孙承志 <948534670@qq.com>，开发者QQ群：50304283
// +----------------------------------------------------------------------
namespace app\common\behavior;
use app\admin\model\AdminHook as HookModel;
use app\admin\model\AdminHookPlugins as HookPluginsModel;
use app\admin\model\AdminPlugins as PluginsModel;
/**
 * 注册钩子
 * @package app\common\behavior
 */
class Hook
{
    public function run(&$params)
    {
        // 安装操作直接return
        if(defined('BIND_MODULE') && BIND_MODULE == 'install') return;

    }
}

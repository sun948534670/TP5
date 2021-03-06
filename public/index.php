<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

//检验PHP环境
if(version_compare(PHP_VERSION,'5.5.0','<'))  die('PHP版本过低，最少需要PHP5.5，请升级PHP版本！');

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 检查是否安装
if(!is_file(APP_PATH.'install/install.lock')) {
    if (!is_writable(dirname(__DIR__ ). '/runtime')) {
        echo '请开启[runtime]文件夹的读写权限';
        exit;
    }
    define('BIND_MODULE', 'install');
}{
    define('BIND_MODULE', 'index');
}


// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';

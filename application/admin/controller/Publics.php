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
namespace app\admin\controller;
use app\common\controller\Common;
use think\Cache;
/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class Publics extends Common
{
    /**
     * 登陆页面
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function index()
    {
        $model = model('AdminUser');
        if ($this->request->isPost()) {
            $username = input('post.username/s');
            $password = input('post.password/s');
            if (!$model->login($username, $password)) {
                return $this->error($model->getError(), url('index'));
            }
            return $this->success('登陆成功，页面跳转中...', url('index/index'));
        }

        if ($model->isLogin()) {
            $this->redirect(url('index/index', '', true, true));
        }

        return $this->fetch();
    }

    /**
     * 退出登陆
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function logout(){
        $root_dir = request()->baseFile();
        $root_dir  = preg_replace(['/index.php$/'], [''], $root_dir);
        model('AdminUser')->logout();
        $this->redirect($root_dir);
    }

    /**
     * 清除缓存
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function cleanCache(){

        Cache::clear();

        $this->redirect(url('index/index'));
    }

}

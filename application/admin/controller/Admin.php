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
use think\Db;
use app\admin\model\AdminMenu as MenuModel;
use app\admin\model\AdminUser as UserModel;
use app\admin\model\AdminRole as RoleModel;



/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class Admin extends Common
{
    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        parent::_initialize();

        self::checkLogin();//后台登录相关操作

    }

    /**
     * 后台菜单相关操作
     */
    protected function checkLogin(){
        $model = new UserModel();
        // 判断登陆
        $login = $model->isLogin();
        if (!$login['uid']) {
            return $this->redirect(url('publics/index'));
        }

        $menu_id = MenuModel::where('url',$this->getCurrentUrl())->column('id');

        // 检查权限
        if (count($menu_id) < 1 ||!RoleModel::checkAuth($menu_id[0])) {

            if(request()->isAjax()){
                echo json_encode(array('error'=>'500','msg'=>'权限不足'));
                exit(0);
            }else{
                return $this->redirect(url('error/auth'));
            }

        }else{
            define('ADMIN_ID', $login['uid']);
            define('ADMIN_ROLE', $login['role_id']);

            self::menu();//后台菜单相关操作
        }
    }

    /**
     * 后台菜单相关操作
     */
    protected function menu(){

        $menu_data['menu_list'] = MenuModel::getMainMenu();//获取后台用户列表

        $menu_data['current_url'] =$this->getCurrentUrl();//获取当前菜单的URL

        $this->assign('menu_data',$menu_data);
    }

    /**
     * 获取当前访问的URL
     */
    private function getCurrentUrl(){
        return strtolower($this->request->module().'/'.$this->request->controller().'/'.$this->request->action());
    }

}

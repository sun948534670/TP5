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

use app\admin\model\AdminRole as RoleModel;
use app\admin\model\AdminMenu as MenuModel;

/**
 * 后台用户
 * @package app\admin\controller
 */
class Role extends Admin
{
    /**
     * 首页
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function index()
    {
        //获取权限角色
        $roles = RoleModel::getEntitys();
        $this->assign('roles', $roles);
        return $this->fetch();
    }

    /*
     * 角色分页获取
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function data($page = 1, $limit = 10, $type = '')
    {

        //获取信息
        $result = RoleModel::getEntityPage($page, $limit, $type);

        //获取总数
        $total = RoleModel::getCount($type);

        return json(array('code' => '0', 'msg' => '', 'count' => $total, 'data' => $result));
    }

    /*
     * 编辑角色(不渲染页面)
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $result = RoleModel::getEntityById($id)->toArray();
            $result['auth'] = json_decode($result['auth']);

            $menu = get_tree(MenuModel::getEntitys(), 0);

            $this->assign('menus', $menu);
            $this->assign('result', $result);


            echo $this->fetch();
        }
    }

    /*
     * 新增角色(不渲染页面)
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function add()
    {

        $menu = get_tree(MenuModel::getEntitys(), 0);

        $this->assign('menus', $menu);

        echo $this->fetch();
    }

    /*
    * 保存角色
    *@author 孙承志 <364666827@qq.com>
    * @return json
    */
    public function save_data()
    {

        $result = $this->validate(input('post.'), 'AdminRole.insert');

        if ($result !== TRUE) {

            return $this->error($result);
        } else {
            $model = new RoleModel();
            $model->saveData(input('post.'));
            return $this->success('success');
        }
    }

    /*
     * 删除角色
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function del_data()
    {

        $result = $this->validate(input('post.id/a'), 'AdminRole.del');

        if ($result !== TRUE) {

            return $this->error($result);

        } else {
            $model = new RoleModel();

            if ($model->del(input('post.id/a'))) {
                return $this->success('success');

            } else {
                return $this->error('无法删除，请确保没有有管理员绑定此角色');
            }

        }
    }


}

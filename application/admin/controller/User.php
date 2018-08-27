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

use app\admin\model\AdminUser as UserModel;
use app\admin\model\AdminRole as RoleModel;

/**
 * 后台用户
 * @package app\admin\controller
 */

class User extends Admin
{
    /**
     * 首页
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function index()
    {
        //获取权限角色
        $roles =  RoleModel::getEntitys();

        $this->assign('roles',$roles);


        return $this->fetch('user/index');
    }

    /*
     * 用户分页获取
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function data($page =1,$limit = 10,$type=''){

        //获取信息
        $result = UserModel::getEntityPage($page,$limit,$type);

        //获取总数
        $total = UserModel::getCount($type);

        return json(array('code'=>'0','msg'=>'','count'=>$total,'data'=>$result));
    }

    /*
     * 新增用户(不渲染页面)
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function add(){
        $roles =  RoleModel::getEntitys();
        $this->assign('roles',$roles);
        echo $this->fetch();

    }

    /*
     * 编辑用户(不渲染页面)
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function edit($id){
        if(is_numeric($id)){
            $result = UserModel::getEntityById($id);
            $roles =  RoleModel::getEntitys();

            $this->assign('user',$result);
            $this->assign('roles',$roles);

            echo $this->fetch();
        }
    }

    /*
    * 保存用户
    *@author 孙承志 <364666827@qq.com>
    * @return json
    */
    public function save_data(){

        $result =  $this->validate(input('post.'),'AdminUser.insert');

        if($result !== TRUE){

            return $this->error($result);
        }else{
            $model = new UserModel();
            $model->saveData(input('post.'));

             return $this->success('success');
        }
    }

    /*
     * 删除用户
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function del_data(){

        $result =  $this->validate(input('post.id/a'),'AdminUser.del');

        if($result !== TRUE){

            return $this->error($result);

        }else{
            $model = new UserModel();
            $model->delData(input('post.'));

            return $this->success('success');
        }

    }

}

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

use app\admin\model\Article as ArticleModel;

/**
 * 后台默认首页控制器
 * @package app\admin\controller
 */

class Article extends Admin
{
    /**
     * 首页
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function index()
    {
        if(request()->isAjax()){
            return self::data();
        }else{
            return $this->fetch();
        }

    }


    /*
     * 文章分页获取
     *@author 孙承志 <948534670@qq.com>
     * @return json
     */
    private function data($page =1,$limit = 10){

            //获取信息
        $result = ArticleModel::getEntityPage($page,$limit);
        //获取总数
        $total = ArticleModel::getCount();

        return json(array('code'=>'0','msg'=>'','count'=>$total,'data'=>$result));

    }

    /*
     * 新增文章(不渲染页面)
     *@author 孙承志 <948534670@qq.com>
     * @return json
     */
    public function add(){

        //保存修改
        if(request()->isPost()){
            self::save_data();
        }

        echo $this->fetch();

    }

    /*
    * 新增文章(不渲染页面)
    *@author 孙承志 <948534670@qq.com>
    * @return json
    */
    public function edit($id = 0){

        //保存修改
        if(request()->isPost()){
            self::save_data();
        }

        if(is_numeric($id)){
            $result = ArticleModel::getEntityById($id);

            $this->assign('article',$result);

            echo $this->fetch();
        }
    }


    /*
     * 保存数据
     */
    public function save_data(){

        $result =  $this->validate(input('post.'),'Article.insert');

        if($result !== TRUE){

            $this->error($result);
        }else{
            $model = new ArticleModel();
            $model->saveData(input('post.'));

            $this->success('success');
        }
    }


    /*
    * 删除文章
    *@author 孙承志 <364666827@qq.com>
    * @return json
    */
    public function del_data(){

        $result =  $this->validate(input('post.id/a'),'Article.del');

        if($result !== TRUE){

            return $this->error($result);

        }else{
            $model = new ArticleModel();
            $model->delData(input('post.'));

            return $this->success('success');
        }

    }

}

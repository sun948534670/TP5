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

use app\admin\model\Slider as SliderModel;

/**
 * 后台默认首页控制器
 * @package app\admin\controller
 */

class Slider extends Admin
{
    /**
     * 首页
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /*
     * 轮播图分页获取
     *@author 孙承志 <948534670@qq.com>
     * @return json
     */
    public function data(){

        if(isset($_GET['id'])){
            return json(array(
                'src'  => $img = SliderModel::where('id',$_GET['id'])->column('img')[0]
            ));
        }else{
            //获取信息
            $result = SliderModel::getEntitys();
            //获取总数
            $total = SliderModel::getCount();

            return json(array('code'=>'0','msg'=>'','count'=>$total,'data'=>$result));
        }
    }

    /*
     * 编辑轮播图(不渲染页面)
     *@author 孙承志 <948534670@qq.com>
     * @return json
     */
    public function edit($id = 0){

        //上传图片
        if(request()->isAjax()){
            self::upload();
        }

        //保存修改
        if(request()->isPost()){
            self::save_data();
        }

        if(is_numeric($id)){
            $result = SliderModel::getEntityById($id);

            $this->assign('slider',$result);

            echo $this->fetch();
        }
    }


    /*
     * 新增用户(不渲染页面)
     *@author 孙承志 <948534670@qq.com>
     * @return json
     */
    public function add(){

        //上传图片
        if(request()->isAjax()){
            self::upload();
        }

        //保存修改
        if(request()->isPost()){
            self::save_data();
        }

        echo $this->fetch();

    }

    /*
     * 上传图片
     */
    private function upload(){
        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'upload'. DS . 'frontend'. DS .'slider');
            if($info){
                // 成功上传后 获取上传信息
                $this->success(str_replace('\\', '/', $info->getSaveName()));
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }
    }


    /*
     * 保存数据
     */
    public function save_data(){

        $result =  $this->validate(input('post.'),'Slider.insert');

        if($result !== TRUE){

             $this->error($result);
        }else{
            $model = new SliderModel();
            $model->saveData(input('post.'));

             $this->success('success');
        }
    }

    /*
     * 删除轮播图
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function del_data(){

        $result =  $this->validate(input('post.id/a'),'Slider.del');

        if($result !== TRUE){

            return $this->error($result);

        }else{
            $model = new SliderModel();
            $model->delData(input('post.'));

            return $this->success('success');
        }

    }


}

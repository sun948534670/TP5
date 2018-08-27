<?php
/**
 * Created by PhpStorm.
 * User: 孙承志
 * Date: 2018/8/14 0014
 * Time: 16:19
 */

namespace app\admin\controller;

use app\admin\model\VideoCatagory as CatagoryModel;


class Catagory extends Admin
{

    /**
     * 视频主题
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function index()
    {
        if(request()->isAjax()){

            $page = input('get.page');

            $limit = input('get.limit');

            return self::data( $page,$limit);
        }else{
            return $this->fetch();
        }
    }

    /*
     * 视频分页获取
     *@author 孙承志 <948534670@qq.com>
     * @return json
     */
    private function data($page =1,$limit = 10,$type=''){
        //获取信息
        $result = CatagoryModel::getEntityPage($page,$limit,$type);
        //获取总数
        $total = CatagoryModel::getCount();

        return json(array('code'=>'0','msg'=>'','count'=>$total,'data'=>$result));
    }

    /*
     * 新增视频(不渲染页面)
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

        $catagorys = CatagoryModel::getEntitys();

        $this->assign('catagorys',$catagorys);

        echo $this->fetch();

    }
    /*
     * 视频编辑
     */
    public function edit($id = 0){

        if(request()->isAjax()){
            self::upload();
        }

        if(request()->isPost()){
            self::save_data();
        }

        if(is_numeric($id)){

            $result = CatagoryModel::getEntityById($id);

            $this->assign('result',$result);

            echo $this->fetch();
        }
    }

    /*
     * 上传图片或视频
     */
    private function upload(){

        $file = request()->file('file');

        $video = request()->file('video');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'upload'. DS . 'frontend'. DS .'video'.DS.'thumb');
            if($info){
                // 成功上传后 获取上传信息
                $this->success(str_replace('\\', '/', $info->getSaveName()));
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }

        if($video){
            $info = $video->validate(['ext'=>'mp4'])->move(ROOT_PATH . 'public' . DS . 'upload'. DS . 'frontend'. DS .'video'.DS.'entity');
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

        $result =  $this->validate(input('post.'),'Catagory.insert');

        if($result !== TRUE){

            $this->error($result);
        }else{
            $model = new CatagoryModel();
            $model->saveData(input('post.'));

            $this->success('success');
        }
    }

    /*
     * 删除视频
     *@author 孙承志 <364666827@qq.com>
     * @return json
     */
    public function del_data(){

        $result =  $this->validate(input('post.id/a'),'Catagory.del');

        if($result !== TRUE){

            return $this->error($result);

        }else{
            $model = new CatagoryModel();
            if($model->delData(input('post.'))){
                $this->success('success');
            }else{
                $this->error('请确保此分类没有绑定任何视频！');
            }
        }

    }
}
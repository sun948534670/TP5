<?php
/**
 * 分层处理器. 轮播图
 * User: 孙承志
 * Date: 2018/8/22 0022
 * Time: 15:25
 */
 namespace app\index\widget;

 use think\Controller;

 Class Widgets extends Controller{

     public function banner_carousel($name,$data){

         $this->assign('carousel_name',$name);
         $this->assign('carousel_data',$data);

         return $this->fetch('widget/carousel');//当然得有视图了
     }

     public function video_carousel($name,$data){

         $this->assign('carousel_name',$name);
         $this->assign('carousel_data',$data);

         return $this->fetch('widget/video_carousel');//当然得有视图了
     }

 }
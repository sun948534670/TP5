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

use app\admin\model\Config as ConfigModel;
use think\Cache;

/**
 * 后台默认设置控制器
 * @package app\admin\controller
 */

class Config extends Admin
{
    /**
     * 首页
     * @author 孙承志 <948534670@qq.com>
     * @return mixed
     */
    public function index()
    {

        if(request()->isAjax()){
            self::upload();
        }

        if(request()->isPost()){
            //保存并更新缓存
            self::save();
            //更新缓存
        }

        $this->assign('config',ConfigModel::getEntitys());
        return $this->fetch();
    }

    /*
   * 上传图片或视频
   */
    private function upload(){

        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->validate(['ext'=>'png'])->move(ROOT_PATH . 'public' . DS . 'static'. DS . 'web'. DS .'img'.DS.'fixed','headLogo-index.png');
            if($info){
                // 成功上传后 获取上传信息
                $this->success(str_replace('\\', '/', $info->getSaveName()));
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }

    }

    private function save(){
        $result = input("post.");
        ConfigModel::updateEntity($result);
        self::createCache();
    }

    //生成缓存
    private static function createCache(){
        $cache_list = collection(ConfigModel::all())->toArray();
        Cache::set('website_base',$cache_list);
    }
}

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
namespace app\admin\model;

use think\Model;
use app\admin\model\Video as VideoModel;

/**
 * 后台用户模型
 * @package app\admin\model
 */
class VideoCatagory extends Model
{
    // 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = 'mtime';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;


    /**
     * 分页查询
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public static function getEntityPage($page,$limit){

        return  self::limit(($page-1)*$limit,$limit)->select();
    }

    /**
     * 查询所有
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public static function getEntitys(){
        return  self::where('status','1')->select();
    }

    /**
     * 获取角色总数
     * @author 孙承志 <948534670@qq.com>
     * @return count
     */
    public static function getCount(){
        return  self::count();
    }

    /**
     * 根据Id获取信息
     * @author 孙承志 <948534670@qq.com>
     * @return array
     */
    public static function getEntityById($id){

        return self::get($id);

    }

    /**
     * 保存信息(insert)
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public function saveData($data){

        $data['status']  = isset($data['switch'])?$data['switch']:"0";
        if(isset($data['id'])){
            $slider = self::get($data['id']);

        }else{
            $slider = new self();
        }
        return $slider->allowField(true)->save($data);
    }


    /**
     * 删除信息
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public function delData($data){
        if(is_array($data['id'])){
            $error = '';
            foreach ($data['id'] as $k => $v) {

                // 判断是否有用户绑定此角色
                if (VideoModel::where('catagory_id', $v)->find()) {
                    $error .= '删除失败，已有视频绑定此分类！<br>';
                    continue;
                }
                $map = [];
                $map['id'] = $v;
                self::where($map)->delete();
            }
            if ($error) {
                return false;
            }
            return true;
        }
    }


}

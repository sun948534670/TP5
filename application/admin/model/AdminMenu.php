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
use think\Loader;
use app\admin\model\AdminRole as RoleModel;
use think\Db;
/**
 * 后台菜单模型
 * @package app\admin\model
 */
class AdminMenu extends Model
{
    // 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = false;

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 获取后台主菜单(一级 > 二级)
     * 后台顶部和左侧使用
     * @param int $pid 父ID
     * @param int $level 层级数
     * @param int $uid 登陆用户ID
     * @author 孙承志 <948534670@qq.com>
     * @return array
     */
    public static function getMainMenu($update = false, $pid = 0, $level = 0, $data = [])
    {
        $cache_tag = '_admin_menu'.ADMIN_ID;
        $trees = [];
        if ($level == 0 && $update == false) {
            $trees = cache($cache_tag);
        }
        if (empty($trees) || $update === true) {
            if (empty($data)) {
                $map = [];
                $map['status'] = 1;
                $data = self::where($map)->order('sort asc')->column('id,pid,title,url,target,icon');
                $data = array_values($data);
            }

            foreach ($data as $k => $v) {
                if ($v['pid'] == $pid) {

                    if ($level == 2) {
                        return $trees;
                    }

                    // 过滤没访问权限的节点
                    if (!RoleModel::checkAuth($v['id'])) {
                        unset($data[$k]);
                        continue;
                    }

                    unset($data[$k]);
                    $v['childs'] = self::getMainMenu($update, $v['id'], $level+1, $data);
                    $trees[] = $v;
                }
            }
             cache($cache_tag, $trees);
        }
        return $trees;
    }

    public static function getEntitys(){
        return collection(self::all())->toArray();
    }
}
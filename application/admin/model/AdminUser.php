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
use app\admin\model\AdminRole as RoleModel;


/**
 * 后台用户模型
 * @package app\admin\model
 */
class AdminUser extends Model
{
    // 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = 'mtime';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    protected static function init()
    {
        //不允许删除超级管理员
        self::event('before_delete', function ($user) {
            if ($user->id == 1)return false;
        });
    }



    // 对密码进行自动加密
    public function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    /**
     * 用户登录
     * @param string $username 用户名
     * @param string $password 密码
     * @param bool $remember 记住登录 TODO
     * @author 孙承志 <948534670@qq.com>
     * @return bool|mixed
     */
    public function login($username = '', $password = '', $remember = false)
    {
        $username = trim($username);
        $password = trim($password);
        $map = [];
        $map['status'] = 1;
        $map['username'] = $username;
        if ($this->validateData(input('post.'), 'AdminUser.login') != true) {
            $this->error = $this->getError();
            return false;
        }

        $user = self::where($map)->find();
        if (!$user) {
            $this->error = '用户不存在或被禁用！';
            return false;
        }

        // 密码校验
        if (!password_verify($password, $user->password)) {
            $this->error = '登陆密码错误！';
            return false;
        }

        // 检查是否分配角色
        if ($user->role_id == 0) {
            $this->error = '禁止访问(原因：未分配角色)！';
            return false;
        }

        // 角色信息
        $role = RoleModel::where('id', $user->role_id)->find();

        if (!$role || $role['status'] == 0) {
            $this->error = '禁止访问(原因：角色分组可能被禁用)！';
            return false;
        }
        $role = $role->toArray();

        // 更新登录信息
        $user->last_login_time = time();
        $user->last_login_ip   = get_client_ip();

        if ($user->save()) {
            // 执行登陆
            $login = [];
            $login['uid'] = $user->id;
            $login['role_id'] = $user->role_id;
            $login['role_name'] = $role['name'];
            $login['nick'] = $user->nick;

            // 缓存角色权限
            session('role_auth_'.$user->role_id, json_decode($role['auth'], true));
            // 缓存登录信息
            session('admin_user', $login);
            return $user->id;
        }
        return false;
    }

    /**
     * 判断是否登录
     * @author 孙承志 <948534670@qq.com>
     * @return bool|array
     */
    public function isLogin()
    {
        $user = session('admin_user');
        if (isset($user['uid'])) {
            if (!self::where('id', $user['uid'])->find()) {
                return false;
            }
            return $user;
        }
        return false;
    }

    /**
     * 退出登陆
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public function logout()
    {
        session('admin_user', null);
    }

    /**
     * 分页查询
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public static function getEntityPage($page,$limit,$type){
        if(!empty($type)){
            return  self::where('role_id',$type)->limit(($page-1)*$limit,$limit)->select();
        }else{
            return  self::limit(($page-1)*$limit,$limit)->select();

        }
    }

    /**
     * 获取角色总数
     * @author 孙承志 <948534670@qq.com>
     * @return count
     */
    public static function getCount($type){

        if(!empty($type)){
            return  self::where('role_id',$type)->count();
        }else{
            return  self::count();
        }

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

        if ($data['password'] == '') {
            unset($data['password']);
        }

        if(isset($data['id'])){
            $user = self::get($data['id']);

        }else{
            $user = new self();
        }
        $user->role_id   = $data['role_id'];
        $user->username  = $data['username'];
        if(isset($data['password'])){
            $user->password  = $data['password'];
        }
        $user->nick      = AdminRole::where('id',$data['role_id'])->value('name');
        $user->email   = $data['email'];
        $user->mobile   = $data['phone'];
        $user->status   = isset($data['switch'])?$data['switch']:"0";
        return $user->save();
    }


    /**
     * 删除信息
     * @author 孙承志 <948534670@qq.com>
     * @return bool
     */
    public function delData($data){
        return self::destroy(implode(',',$data['id']));
    }


}

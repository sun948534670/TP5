<?php

namespace app\admin\controller;

use app\common\controller\Common;
use think\Db;
use app\admin\model\AdminUser as UserModel;

class Error extends common
{
    public function auth(){
        return $this->fetch();
    }
}
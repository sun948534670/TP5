<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Slider as SliderModel;

class Index extends Controller
{
    public function index()
    {

        $this->assign('sliders',SliderModel::getEntitys());
        return $this->fetch();
    }

}

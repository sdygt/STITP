<?php

namespace app\index\controller;

use think\Controller;
use think\View;
class Index extends \think\Controller
{
    public function index()
    {
        $view = new \think\View();
        return $view->fetch();
    }
}
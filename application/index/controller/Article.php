<?php
namespace app\index\controller;

use think\View;
use think\Loader;
use think\Controller;
use think\Db;
use think\Session;
class Article  extends controller
{
    public function index($id)
    {
       $article=Loader::model('articleNode','model')->getarticle($id);
       print_r($article);
        $this->view->assign('article',$article);
        return $this->view->fetch('index');
    }
}

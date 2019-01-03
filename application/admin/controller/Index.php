<?php
namespace app\admin\controller;
 

use app\admin\BaseController;
use think\Loader;
use think\Db;
use think\View;
use think\Session;

class Index  extends BaseController
{	


	
    public function index()
    {
    	$username=Session::get('user.name');

    	$this->view->assign('username',$username);
    	//获得菜单栏
    	$uid=Session::get('user.id');
		$menu=Loader::model('AdminNode','model')->getMenu($uid);

		 $this->view->assign('menu',$menu);

        return $this->view->fetch('');
    }


    public function welcome()
    {
        return $this->view->fetch('');
    }

}

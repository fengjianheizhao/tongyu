<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-05-30 15:22:23
 * @version $Id$
 */

namespace app\admin\controller;

use app\admin\BaseController;
use think\View;
use think\Loader;
use think\Controller;
use think\config;
use think\Db;
use think\Session;

class Login extends Controller {
    
    // function __construct(){
        
    // }

   public function index() {

    	return $this->view->fetch('login');
    }


     public function test() {

     	//获取登录ajax传过来的值
     
     	$username=json_decode($_POST['name']);
     	$pwd=json_decode($_POST['pwd']);
     	$data=$_POST['captcha'];
     	$online=$_POST['online'];



     	//密码加密
     	$mpwd=md5($pwd);
     	$time=time();
        //输入存入cookie
         if($online==1){
             setcookie('username',$username,time()+3600,'/','tp5.com');
             setcookie('password',$mpwd,time()+3600,'/','tp5.com');
         }
     	// 从数据库中获取密码
     	$tpwd=Db::name('user')->where('username',"$username")->find();

     	
     	if(!captcha_check($data)){
     		echo '2';
     	}
     	elseif(empty($tpwd['password']))
     	{
     		echo'3';
     	}else if($tpwd['password']==$mpwd){
     		//将登陆时间存入数据库
     		$data1=['logtime'=>"$time"];
     		db('user')->where('username',"$username")->setField('logtime',"$time");
     		//把用户名存入session
     		$uid=$tpwd['id'];
     		 Session::set('user.name',"$username");
     		 Session::set('user.id',"$uid");

     		echo'1';
     	}else{
     		echo'0';
     	}
     	

//     if(!captcha_check($data)){
//      echo'<script type="text/javascript">
//   alert("888888");
// </script>';
// }else{
// 	echo'77777';  	
//     }
	}

	public function out() {

    	session('user',null);
    	$this->redirect(__URL__.'/'.ADMIN_MODULE . "/login");
    	
    }
}
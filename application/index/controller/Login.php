<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-05-30 15:22:23
 * @version $Id$
 */

namespace app\index\controller;


use think\View;
use think\Loader;
use think\Controller;
use think\config;
use think\Db;
use think\Session;

class Login extends Controller {
    


   public function index() {

       if(Session::has('index_user'))
       {
           $this->redirect('index/index');
       }

    	return $this->view->fetch('login');
    }


    public function register() {

        if(Session::has('index_user'))
        {
            $this->redirect('index/index');
        }

        return $this->view->fetch('register');
    }


     public function do_login() {

     	//获取登录ajax传过来的值
     
     	$username=json_decode($_POST['username']);
     	$pwd=$_POST['pwd'];




     	//密码加密
//     	$mpwd=sha1($pwd);

     	$time=time();
        //输入存入cookie
//         if($online==1){
//             setcookie('username',$username,time()+3600,'/','tp5.com');
//             setcookie('password',$mpwd,time()+3600,'/','tp5.com');
//         }
     	// 从数据库中获取密码
     	$tpwd=Db::name('indexuser')->where('username',"$username")->find();





     	if(empty($tpwd['password']))
     	{
     		echo'3';
     	}else if($tpwd['password']==$pwd){
     		//将登陆时间存入数据库

     		db('indexuser')->where('username',"$username")->setField('logintime',"$time");
     		//把用户名存入session
     		$uid=$tpwd['id'];
     		 Session::set('index_user.name',"$username");
     		 Session::set('index_user.id',"$uid");



     		echo'1';
     	}else{
     		echo'0';
     	}
     	


	}



    public function do_register() {

        //获取登录ajax传过来的值

        $username=json_decode($_POST['username']);
        $pwd=$_POST['pwd'];




        //密码加密
//     	$mpwd=sha1($pwd);

        $time=time();
        //输入存入cookie
//         if($online==1){
//             setcookie('username',$username,time()+3600,'/','tp5.com');
//             setcookie('password',$mpwd,time()+3600,'/','tp5.com');
//         }
        // 从数据库中获取密码
        $tpwd=Db::name('indexuser')->where('username',"$username")->find();





        if($tpwd['password'])
        {
            echo'2';
        }else {


            //将注册信息存入数据库

            $data=[
                'username'=>$username,
                'password'=>$pwd,
                'regtime'=>$time
            ];

            db('indexuser')->insert($data);

            $user=Db::name('indexuser')->where('username',"$username")->find();

            //把用户名存入session
            $uid=$user['id'];
            Session::set('index_user.name',"$username");
            Session::set('index_user.id',"$uid");



            echo'1';
        }



    }

	public function create_table(){



       if(Db::query("SHOW TABLES LIKE 'lcz_indexuser'")){
           echo'table already exist';
       }else{
           $sql="CREATE TABLE lcz_indexuser (
       id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
       username VARCHAR(30) NOT NULL,
       password VARCHAR (255) NOT NULL,
       logintime INT(20) ,
       regtime INT(20) ,
       email VARCHAR (50)
      )";
           if(Db::query($sql)){
               echo"table created successful";
           }else{
               echo"创建错误";
           }
       }

    }

	public function loginout() {

    	session('index_user',null);
    	$this->redirect("login/index");
    	
    }
}
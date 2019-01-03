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
use think\Db;
use think\Session;

class Image extends BaseController{
	public function index(){

		  $allimage=Loader::model('ImageNode','model')->getallimage();

        $this ->view ->assign('images',$allimage);

		return $this->view->fetch('image');
	}

    public function search_image(){
        $mintime    =   $_GET['mintime'];
        $maxtime    =   $_GET['maxtime'];
        if(empty($mintime)){$mintime='1970-1-1';}
        if(empty($maxtime)){$maxtime=date("Y-m-d");}
        $image_name =   $_GET['image_name'];
//        print_r( $mintime);
//        print_r(  $maxtime);
//        print_r(  $image_name);
        $search_image=Loader::model('ImageNode','model')->search_image($mintime,$maxtime,$image_name);

        $this ->view ->assign('images',$search_image);

        return $this->view->fetch('image');
    }

	public function add_image()
	{
			return $this->view->fetch('picture-add');
	}



	public function edit_image()
	{
			return $this->view->fetch('picture-show');
	}

    public function change_image()
    {
        $id=$_GET['id'];
        $image=Loader::model('ImageNode','model')->getimage($id);
        $this ->view ->assign('image',$image);
        return $this->view->fetch('picture-edit');
    }

	public function del_image()
	{
			if (isset($_POST['id'])) {
				//进行删除操作
				 $delimage=Loader::model('ImageNode','model')->delimage($_POST['id']);
				 //删除失败返回2，成功返回1
				 if($delimage==0){
				 	echo'2';
				 }else{
				 	echo'1';
				 }
				
			}else{
				//传输id失败返回3
				echo'3';
			}
	}

    public function del_all()
    {
        if (isset($_POST['id'])) {
            //进行删除操作
            $delimage=Loader::model('ImageNode','model')->delimage($_POST['id']);
            //删除失败返回2，成功返回1
            if($delimage==0){
                echo'2';
            }else{
                echo'1';
            }

        }else{
            //传输id失败返回3
            echo'3';
        }
    }
//下架
    public function downshow()
    {
        if (isset($_POST['id'])) {
            //进行删除操作
            $shownum=Db::name('image')->where('id',$_POST['id'])->update(['is_show'=>'0']);
            //删除失败返回2，成功返回1
            if($shownum==0){
                echo'2';
            }else{
                echo'1';
            }

        }else{
            //传输id失败返回3
            echo'3';
        }
    }


//上架
    public function upshow()
    {
        if (isset($_POST['id'])) {
            //进行删除操作
            $shownum=Db::name('image')->where('id',$_POST['id'])->update(['is_show'=>'1']);
            //删除失败返回2，成功返回1
            if($shownum==0){
                echo'2';
            }else{
                echo'1';
            }

        }else{
            //传输id失败返回3
            echo'3';
        }
    }

    public function upload(){
                //获取表单上传文件
                $files = request()->file('image');

         print_r($_REQUEST);

        //把文件移动到应用根目录下载文件夹中/public/upload/
        $info = $files->move(ROOT_PATH.'public'.DS.'upload');
        if($info){
            $image=array();
            //上传成功后，获得上传信息
            //输出jpg
         	$info->getExtension();
            //输出路径
          	$image['path']              =       $info->getSaveName();
            //输出文件名
            $image['name']              =       $info->getFilename();
            //将上传图片信息写入$image
            $image['title']             =       trim($_REQUEST['title'] );
            //短标题
            $image['short_title']       =       trim($_REQUEST['short_title']);
            //关联的小说id
            $image['story_id']          =       trim($_REQUEST['story_id']) ;
            //排序值
            $image['order_num']         =       trim($_REQUEST['order_num']);
            //是否显示
            $image['is_show']           =       trim($_REQUEST['is_show']);
            //生效时间
            $image['start_time']        =       trim($_REQUEST['start_time']);
            //过期时间
            $image['stop_time']         =       trim($_REQUEST['stop_time']);
            //作者
            $image['author']            =       trim($_REQUEST['author']);
            //来源
            $image['source']            =       trim($_REQUEST['source']);
            //关键词
            $image['keyword']           =       trim($_REQUEST['keyword']);
            //摘要
            $image['abstract']          =       trim($_REQUEST['abstract']);
            //上传用户id
            $image['user_id']           =       Session::get('user.id');
            //上传用户名
            $image['username']         =       Session::get('user.name');
           

           $addimage=Loader::model('ImageNode','model')->addimage($image);

        }else{
            //上传失败获取错误信息
            echo $files->getError();
        }

    }



    public function edit(){
        //获取表单上传文件
        $files = request()->file('image');

        print_r($_REQUEST);
        $id = $_REQUEST['id'];
        //把文件移动到应用根目录下载文件夹中/public/upload/
        $info = $files->move(ROOT_PATH.'public'.DS.'upload');
        if($info){
            $image=array();
            //上传成功后，获得上传信息
            //输出jpg
            $info->getExtension();
            //输出路径
            $image['path']              =       $info->getSaveName();
            //输出文件名
            $image['name']              =       $info->getFilename();
            //将上传图片信息写入$image
            $image['title']             =       trim($_REQUEST['title'] );
            //短标题
            $image['short_title']       =       trim($_REQUEST['short_title']);
            //关联的小说id
            $image['story_id']          =       trim($_REQUEST['story_id']) ;
            //排序值
            $image['order_num']         =       trim($_REQUEST['order_num']);
            //是否显示
            $image['is_show']           =       trim($_REQUEST['is_show']);
            //生效时间
            $image['start_time']        =       trim($_REQUEST['start_time']);
            //过期时间
            $image['stop_time']         =       trim($_REQUEST['stop_time']);
            //作者
            $image['author']            =       trim($_REQUEST['author']);
            //来源
            $image['source']            =       trim($_REQUEST['source']);
            //关键词
            $image['keyword']           =       trim($_REQUEST['keyword']);
            //摘要
            $image['abstract']          =       trim($_REQUEST['abstract']);
            //上传用户id
            $image['user_id']           =       Session::get('user.id');
            //上传用户名
            $image['username']         =       Session::get('user.name');


            $editimage=Loader::model('ImageNode','model')->editimage($image,$id);

        }else{
            //上传失败获取错误信息
            echo $files->getError();
        }

    }
}
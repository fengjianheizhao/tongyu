<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-06-18 14:46:35
 * @version $Id$
 */
namespace app\admin\controller;

use app\admin\BaseController;
use think\View;
use think\Loader;
use think\Controller;
use think\Db;
use think\Session;

class Article extends BaseController {
    
 

    public  function index()
    {
        $article=Loader::model('articleNode','model')->getallarticle();
        $this->view->assign('allarticle',$article);
    	return $this->view->fetch('');
    }


    public function search_article(){
        $mintime    =   $_GET['mintime'];
        $maxtime    =   $_GET['maxtime'];
        if(empty($mintime)){$mintime='1970-1-1';}
        if(empty($maxtime)){$maxtime=date("Y-m-d");}
        $article_name =   $_GET['article_name'];
//        print_r( $mintime);
//        print_r(  $maxtime);
//        print_r(  $article_name);
        $search_article=Loader::model('articleNode','model')->search_article($mintime,$maxtime,$article_name);

        $this ->view ->assign('articles',$search_article);

        return $this->view->fetch('article');
    }

    public function add_article()
    {
        return $this->view->fetch('article-add');
    }



    public function edit_article()
    {
        return $this->view->fetch('picture-show');
    }

    public function change_article()
    {
        $id=$_GET['id'];
        $article=Loader::model('articleNode','model')->getarticle($id);
        $this ->view ->assign('article',$article);
        return $this->view->fetch('picture-edit');
    }

    public function del_article()
    {
        if (isset($_POST['id'])) {
            //进行删除操作
            $delarticle=Loader::model('articleNode','model')->delarticle($_POST['id']);
            //删除失败返回2，成功返回1
            if($delarticle==0){
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
            $delarticle=Loader::model('articleNode','model')->delarticle($_POST['id']);
            //删除失败返回2，成功返回1
            if($delarticle==0){
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
            $shownum=Db::name('article')->where('id',$_POST['id'])->update(['is_show'=>'0']);
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
            $shownum=Db::name('article')->where('id',$_POST['id'])->update(['is_show'=>'1']);
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
            $article=array();
            //上传成功后，获得上传信息
            //输出jpg
            $info->getExtension();
            //输出路径
            $article['path']              =       $info->getSaveName();
            //输出文件名
            $article['name']              =       $info->getFilename();
            //将上传图片信息写入$article
            $article['title']             =       trim($_REQUEST['title'] );
            //短标题
            $article['short_title']       =       trim($_REQUEST['short_title']);
            //关联的小说id
            $article['story_id']          =       trim($_REQUEST['story_id']) ;
            //排序值
            $article['order_num']         =       trim($_REQUEST['order_num']);
            //是否显示
            $article['is_show']           =       trim($_REQUEST['is_show']);
            //生效时间
            $article['start_time']        =       trim($_REQUEST['start_time']);
            //过期时间
            $article['stop_time']         =       trim($_REQUEST['stop_time']);
            //作者
            $article['author']            =       trim($_REQUEST['author']);
            //来源
            $article['source']            =       trim($_REQUEST['source']);
            //关键词
            $article['keyword']           =       trim($_REQUEST['keyword']);
            //摘要
            $article['abstract']          =       trim($_REQUEST['abstract']);
            //文章内容
            $article['content']          =       trim($_REQUEST['content']);
            //上传用户id
            $article['user_id']           =       Session::get('user.id');
            //上传用户名
            $article['username']         =       Session::get('user.name');


            $addarticle=Loader::model('articleNode','model')->addarticle($article);

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
            $article=array();
            //上传成功后，获得上传信息
            //输出jpg
            $info->getExtension();
            //输出路径
            $article['path']              =       $info->getSaveName();
            //输出文件名
            $article['name']              =       $info->getFilename();
            //将上传图片信息写入$article
            $article['title']             =       trim($_REQUEST['title'] );
            //短标题
            $article['short_title']       =       trim($_REQUEST['short_title']);
            //关联的小说id
            $article['story_id']          =       trim($_REQUEST['story_id']) ;
            //排序值
            $article['order_num']         =       trim($_REQUEST['order_num']);
            //是否显示
            $article['is_show']           =       trim($_REQUEST['is_show']);
            //生效时间
            $article['start_time']        =       trim($_REQUEST['start_time']);
            //过期时间
            $article['stop_time']         =       trim($_REQUEST['stop_time']);
            //作者
            $article['author']            =       trim($_REQUEST['author']);
            //来源
            $article['source']            =       trim($_REQUEST['source']);
            //关键词
            $article['keyword']           =       trim($_REQUEST['keyword']);
            //摘要
            $article['abstract']          =       trim($_REQUEST['abstract']);
            //文章内容
            $article['content']          =       trim($_REQUEST['content']);
            //上传用户id
            $article['user_id']           =       Session::get('user.id');
            //上传用户名
            $article['username']         =       Session::get('user.name');


            $editarticle=Loader::model('articleNode','model')->editarticle($article,$id);

        }else{
            //上传失败获取错误信息
            echo $files->getError();
        }

    }
}
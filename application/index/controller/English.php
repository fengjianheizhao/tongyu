<?php
namespace app\index\controller;

use think\View;
use think\Loader;
use think\Controller;
use think\Db;
use think\Session;
use think\Config;

class English  extends controller
{
    public function index()
    {

        return $this->view->fetch('index');
    }



    public function practice()
    {

        if($_POST['charter']==''){
            $charter='1';
        }else{
            $charter=$_POST['charter'];
        }
//        $data=Db::name('english')->where('unit',$charter)->where('correct','0')->order('RAND()')->limit('1')->find();
//
//        $this->view->assign('data',$data);
////      print_r($data);
//        return $this->view->fetch('practice');
        $this->show_word($charter);

        $remainingNumber=Db::name('english')->where('unit',$charter)->where('correct','0')->count('id');
        $this->view->assign('remainingNumber',$remainingNumber);
        return $this->view->fetch('practice');
    }

    public function show_word($unit)
    {
        $data=Db::name('english')->where('unit',$unit)->where('correct','0')->order('RAND()')->limit('1')->find();



        $this->view->assign('data',$data);

//        return $this->view->fetch('practice');
    }
    /*
    提交单词信息
     */
    public function enter_word()
    {
        // print_r($_POST) ;

        

        $data=array();
        $data['word_en']=$_POST['EN_word'];
         $data['word_cn']=$_POST['CN_word'];
         $data['unit']=$_POST['EN_charter'];
         $data['addtime']=time();

          Db::name('english')->insert($data);

         return 'success';
    }


    /*
     下一个单词
      */
    public function next_word()
    {

        $data=array();
        $data['word_id']=$_POST['word_id'];
        $data['correct']=$_POST['correct'];
        $data['unit']=$_POST['select_charter'];
        $data['editime']=time();

        Db::name('english')
            ->where('id',$data['word_id'])
            ->update([
                'editime' =>$data['editime'] ,
                'correct' =>$data['correct'],
            ]);

        return 'success';

    }

    /*
    选择章节跳转
     */
    public function select_charter()
    {
        // print_r($_POST) ;

        

       

         return 'success';
    }
    public function getuserinfo($type='json')
    {
    	if(!in_array($type, ['json','xml','jsonp'])){
    		$type='json';
    	}

    	Config::set('default_return_type',$type);

    	$data=[
    		'code'=>200,
    		'result'=>[
    		'username'=>'luchenzhi',
    		'usermail'=>'935923945@qq.com'
    		]
    	];
    	return $data;
    }
}

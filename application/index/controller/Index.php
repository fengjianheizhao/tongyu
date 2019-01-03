<?php
namespace app\index\controller;

use think\View;
use think\Loader;
use think\Controller;
use think\Db;
use think\Session;
use think\Config;

class Index  extends controller
{
    public function index()
    {
        $allimage=Db::name('image')->select();

        for ($i=0; $i <count($allimage) ; $i++) {
            $allimage[$i]['path']=str_replace('\\','/', $allimage[$i]['path']) ;
        }
         $this->view->assign('allimage',$allimage);
        return $this->view->fetch('index');
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

<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-05-27 15:32:46
 * @version $Id$
 */

namespace app\admin;

use think\Model;
use think\View;
use think\Request;
use think\Session;
use think\Db;
use think\Config;
use think\Loader;
use think\Exception;
use think\exception\HttpException;
use think\Controller;


class BaseController extends Controller  {


	/**
	 * @var  View 视图类实例
	 */
	protected $view;
	/**
	 * @var  Request  Request实例
	 */
	protected $request;
    
    function __construct(){

        parent::__construct();

        if (null === $this->view) {
            $this->view = View::instance(Config::get('template'), Config::get('view_replace_str'));
        }

        if (null === $this->request) {
            $this->request = Request::instance();
        }


        // if(session('admin_id')>0){
        // 	$this->view->fetch()

        // }

    }


    /*
     * 初始化操作
     */
    public function _initialize() 
    {


         $username = session('user');

         if($username==''){
                if(empty($_COOKIE['username'])||empty($_COOKIE['password']))
                {
                $this->error("请先登录",url('admin/login/index','','html'));
                }else{$username=$_COOKIE['username'];
                $pwd=$_COOKIE['password'];
                    if($this->getuser($username,$pwd)){

                        $this->check_priv();
                    }else{
                        $this->error("请先登录",url('admin/login/index','','html'));
                    }

                }
         }else{
             $this->check_priv();
         }
       
    }

    /**
     * 检查权限
     * @return bool
     */
    public function check_priv(){
        //获得类名和方法名
        $request = \think\Request::instance();
        $controller_name=$request->controller();
        $action_name=$request->action();
        //获取当前用户的可进入方法列表
        $uid=Session::get('user.id');

        $sql='select  action from lcz_group where id=(select gid from lcz_usergroup where uid='.$uid.')';
        $allow_list =Db::query($sql);
        //判断当前方法是否能进入
        if($controller_name=='Index'){
            return true;
        }else{
        if($allow_list['0']['action']=='all'){
            return true;
        }else{
        $allow_list=explode(',',$allow_list['0']['action']);
        $res1['id']=['in',$allow_list];
        $menu2=Db::name("system")->where($res1)->column('controller');
        $controller=$controller_name.'\\'.$action_name;
        if(in_array($controller,$menu2)){
            return true;
        }else{
            $this->error('当前用户没有操作权限',url('admin/index/index','','html'));
        }
        }
        }



    }

    function getMenu($uid){
        //获取用户角色
        $prefix = Config::get("database.prefix");
        $sql="select role,action from ". "{$prefix}group "."where id in (select gid from"." {$prefix}usergroup where uid = $uid )";
        $nodes = Db::query($sql);
        //获得角色名称
        $rolename=$nodes[0]['role'];
        $role=$nodes[0]['action'];
        if($role=='all'){
            $menu=Db::name("system")->where('level=0')->select();

            $menu2=Db::name("system")->where('level>0')->select();

            $allmenu=array();
            foreach($menu as $k=>$v){
                foreach($menu2 as $k1=>$v2){
                    if($v['id']==$v2['fid']){
                        $v['child']=$v2;
                        $allmenu[]=$v;
                    }
                }
            }

            $allmenu1=array();
            foreach ($allmenu as $key => $value) {
                $name1=$value['name'];

                $allmenu1[$name1][]=$value['child'];
            }
        }else{
            $action=explode(',', $role);
            $res['level']=['=',0];
            $res['id']=['in',$action];
            $menu=Db::name("system")->where($res)->select();
            //取出2级菜单
            $res1['level']=['>',0];
            $res1['id']=['in',$action];
            $menu2=Db::name("system")->where($res1)->select();

            $allmenu=array();
            foreach($menu as $k=>$v){
                foreach($menu2 as $k1=>$v2){
                    if($v['id']==$v2['fid']){
                        $v['child']=$v2;
                        $allmenu[]=$v;
                    }
                }
            }

            $allmenu1=array();
            foreach ($allmenu as $key => $value) {
                $name1=$value['name'];

                $allmenu1[$name1][]=$value['child'];
            }



        }

        return $allmenu1;
    }

    public function getuser($username,$pwd){
        $tpwd=Db::name('user')->where('username',"$username")->find();
        if($pwd==$tpwd['password']) {
            $uid=$tpwd['id'];
            Session::set('user.name',"$username");
            Session::set('user.id',"$uid");
            return true;}
            else{return false;}
    }
}
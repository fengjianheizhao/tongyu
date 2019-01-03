<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-06-02 11:48:43
 * @version $Id$
 */
namespace app\admin\model;

use think\Db;
use think\Config;
use think\Loader;

class AdminNode  {
    
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
}
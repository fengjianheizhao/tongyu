<?php
/**
 * Created by PhpStorm.
 * User: lu935
 * Date: 2017-07-06
 * Time: 14:17
 */

namespace app\admin\controller;


use app\admin\BaseController;
use think\Db;
use think\Loader;
class Admin  extends  BaseController
{
    /**
     *角色列表
     */
     public function group(){

         $sql='select username,d.role,d.id,d.action,d.text from lcz_user  as c, (select b.uid,a.id,a.role,a.action,a.text from lcz_usergroup as b,lcz_group as a  where b.gid=a.id) d where c.id = d.uid';
         $role=Db::query($sql);

         $this->view->assign('role',$role);
         return $this->view->fetch('group');
     }


    /**
     *角色添加
     */
    public function role_add(){

        $menu=Loader::model('AdminNode','model')->getMenu('1');

        $this->view->assign('menu',$menu);

        return $this->view->fetch('role-add');
        }


    public function add_role(){
                    print_r($_POST);
    }
}
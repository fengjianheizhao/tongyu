<?php
/**
 * Created by PhpStorm.
 * User: lu935
 * Date: 2017-07-16
 * Time: 15:00
 */

namespace app\admin\controller;

use app\admin\BaseController;
use think\Db;
use think\Loader;
class Goods extends BaseController
{
  public function brands(){
      return $this->view->fetch('goods');
  }
}
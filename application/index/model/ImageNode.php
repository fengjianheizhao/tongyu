<?php
/**
 * Created by PhpStorm.
 * User: lu935
 * Date: 2017/6/15
 * Time: 21:59
 */

namespace app\admin\model;
use think\Db;
use think\Config;
use think\Loader;

class ImageNode
{
		//获取所有图片
           public function getallimage()
       {
       		$allimage=Db::name('image')->select();
       		
       		// foreach ($allimage as $key => $value) {
       		// 	$allimage[]['path']=str_replace('\\','/', $value['path']) ;      		}
       		for ($i=0; $i <count($allimage) ; $i++) { 
       			$allimage[$i]['path']=str_replace('\\','/', $allimage[$i]['path']) ;      	
       		}
       			return $allimage;
       }


    //获取单张图片信息
    public function getimage($id)
    {
        $image=Db::name('image')->where('id',$id)->find();

        // foreach ($allimage as $key => $value) {
        // 	$allimage[]['path']=str_replace('\\','/', $value['path']) ;      		}
//        for ($i=0; $i <count($allimage) ; $i++) {
//            $allimage[$i]['path']=str_replace('\\','/', $allimage[$i]['path']) ;
//        }
        return $image;
    }


    //向数据库添加图片
        public function addimage($image)
        {


            $time =date("Y-m-d h:i:s");
           $data =[
               'name'=>$image['name'],
               'path'=>$image['path'],
               'time'=>$time,
               'title'=>$image['title'],
               'short_title'=>$image['short_title'],
               'story_id'=>$image['story_id'],
               'order_num'=>$image['order_num'],
               'is_show'=>$image['is_show'],
               'start_time'=>$image['start_time'],
               'stop_time'=>$image['stop_time'],
               'author'=>$image['author'],
               'source'=>$image['source'],
               'keyword'=>$image['keyword'],
               'abstract'=>$image['abstract'],
               'user_id'=>$image['user_id'],
               'username'=>$image['username'],


               ];
           Db::name('image')->insert($data);



        }

//修改图片信息
    public function editimage($image,$id)
    {


        $time =date("Y-m-d h:i:s");
        $data =[
            'name'=>$image['name'],
            'path'=>$image['path'],
            'time'=>$time,
            'title'=>$image['title'],
            'short_title'=>$image['short_title'],
            'story_id'=>$image['story_id'],
            'order_num'=>$image['order_num'],
            'is_show'=>$image['is_show'],
            'start_time'=>$image['start_time'],
            'stop_time'=>$image['stop_time'],
            'author'=>$image['author'],
            'source'=>$image['source'],
            'keyword'=>$image['keyword'],
            'abstract'=>$image['abstract'],
            'user_id'=>$image['user_id'],
            'username'=>$image['username'],


        ];
        Db::name('image')->where('id',$id)->update($data);



    }

    //搜索图片信息
    public function search_image($mintime,$maxtime,$image_name)
    {



        $allimage=Db::name('image')->where('title','like','%'.$image_name.'%')->where('time','between time',[$mintime,$maxtime])->select();
        for ($i=0; $i <count($allimage) ; $i++) {
            $allimage[$i]['path']=str_replace('\\','/', $allimage[$i]['path']) ;
        }
        return $allimage;


    }
        //删除选中的图片
         public function delimage($id)
        {


           
           $delimage=Db::name('image')->delete($id);
           return $delimage;



        }
}
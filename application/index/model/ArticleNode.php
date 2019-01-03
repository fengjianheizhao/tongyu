<?php
/**
 * Created by PhpStorm.
 * User: lu935
 * Date: 2017/6/15
 * Time: 21:59
 */

namespace app\index\model;
use think\Db;
use think\Config;
use think\Loader;

class ArticleNode
{
		//获取所有图片
           public function getallarticle()
       {
       		$allarticle=Db::name('article')->select();
       		
       		// foreach ($allarticle as $key => $value) {
       		// 	$allarticle[]['path']=str_replace('\\','/', $value['path']) ;      		}
       		for ($i=0; $i <count($allarticle) ; $i++) { 
       			$allarticle[$i]['path']=str_replace('\\','/', $allarticle[$i]['path']) ;      	
       		}
       			return $allarticle;
       }


    //获取单张图片信息
    public function getarticle($id)
    {
        $article=Db::name('article')->where('id',$id)->find();

        // foreach ($allarticle as $key => $value) {
        // 	$allarticle[]['path']=str_replace('\\','/', $value['path']) ;      		}
//        for ($i=0; $i <count($allarticle) ; $i++) {
//            $allarticle[$i]['path']=str_replace('\\','/', $allarticle[$i]['path']) ;
//        }
        return $article;
    }


    //向数据库添加图片
        public function addarticle($article)
        {


            $time =date("Y-m-d h:i:s");
           $data =[
               'name'=>$article['name'],
               'path'=>$article['path'],
               'time'=>$time,
               'title'=>$article['title'],
               'short_title'=>$article['short_title'],
               'story_id'=>$article['story_id'],
               'order_num'=>$article['order_num'],
               'is_show'=>$article['is_show'],
               'start_time'=>$article['start_time'],
               'stop_time'=>$article['stop_time'],
               'author'=>$article['author'],
               'source'=>$article['source'],
               'keyword'=>$article['keyword'],
               'abstract'=>$article['abstract'],
               'user_id'=>$article['user_id'],
               'username'=>$article['username'],
                'content'=>$article['content'],

               ];
           Db::name('article')->insert($data);



        }

//修改图片信息
    public function editarticle($article,$id)
    {


        $time =date("Y-m-d h:i:s");
        $data =[
            'name'=>$article['name'],
            'path'=>$article['path'],
            'time'=>$time,
            'title'=>$article['title'],
            'short_title'=>$article['short_title'],
            'story_id'=>$article['story_id'],
            'order_num'=>$article['order_num'],
            'is_show'=>$article['is_show'],
            'start_time'=>$article['start_time'],
            'stop_time'=>$article['stop_time'],
            'author'=>$article['author'],
            'source'=>$article['source'],
            'keyword'=>$article['keyword'],
            'abstract'=>$article['abstract'],
            'user_id'=>$article['user_id'],
            'username'=>$article['username'],
            'content'=>$article['content'],

        ];
        Db::name('article')->where('id',$id)->update($data);



    }

    //搜索图片信息
    public function search_article($mintime,$maxtime,$article_name)
    {



        $allarticle=Db::name('article')->where('title','like','%'.$article_name.'%')->where('time','between time',[$mintime,$maxtime])->select();
        for ($i=0; $i <count($allarticle) ; $i++) {
            $allarticle[$i]['path']=str_replace('\\','/', $allarticle[$i]['path']) ;
        }
        return $allarticle;


    }
        //删除选中的图片
         public function delarticle($id)
        {


           
           $delarticle=Db::name('article')->delete($id);
           return $delarticle;



        }
}
<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        var_dump("error");
    }
    public function ss(){

    }
    public function indexCarousel(){
    	header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json"); 
        $indexCarousel=D('Indexcarousel');
     	echo json_encode($indexCarousel->field('indexcarousel_file')->limit(3)->select()); 
   }
 	public function Activity(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
        $activity=D('Activity');
        $one=$activity->field('activity_theme,activity_brief,activity_poster,
        		activity_duration,activity_price,activity_procedure,activity_gameplace')
        		->order('activity_id desc')->limit(1) ->select();
        $two=$activity->field('activity_theme,activity_poster,
        	  activity_price,activity_gameplace') ->order('activity_id desc')->limit(1,3) ->select();
        $result=array('one'=>$one,'two'=>$two);
        //json的数据应该返回一个
        echo json_encode($result);
 	}
    public function Prop(){
    	header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json"); 
        $prop=D('Prop');
     	echo json_encode($prop->field('prop_name,prop_image,prop_price')->limit(7)->select()); 
   }
   
}
<?php
namespace Home\Controller;
use Think\Controller;
class MyorderController extends Controller {
	public function Myorder($uid=""){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
        //用户所有的订单
        $mytotalorder=D('Totalorder');
        echo json_encode($mytotalorder->where("user_id='%d'",I('get.uid'))->field('totalorder_time,totalorder_num,totalorder_total,totalorder_postage')->select()); 
        //用户所有的活动子订单
        $myactivity=D('Buyactivity');
        echo json_encode($myactivity->where("user_id='%d'",I('get.uid'))->field('buyactivity_id,buyactivity_num,totalorder_id,activity_id')->relation(true)->select()); 
        //用户所有的道具子订单
        $myprop=D('Buyprop');
        echo json_encode($myprop->where("user_id='%d'",I('get.uid'))->field('buyprop_id,buyprop_num,totalorder_id,prop_id')->relation(true)->select()); 
        
        
		
      /*   $Myorder=D('Totalorder');
		$myorders = $Myorder->find(1);
		// 表示对当前查询的数据对象进行关联数据获取
		$activity = $myorders->relationGet("Buyacitvity");
         echo json_encode($activity->select()); */
	}
}
<?php
namespace Home\Controller;
use Think\Controller;
class ShoppingcartController extends Controller {
	public function Shoppingcart($uid=""){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
       $buyactivity=D('Buyactivity');
        echo json_encode($buyactivity->where("user_id='%d' and totalorder_id='0'",I('get.uid'))->field('activity_id,buyactivity_num,buyactivity_total')->relation(true)->select());
 		 $buyprop=D('Buyprop');
        echo json_encode($buyprop->where("user_id='%d' and totalorder_id='0'",I('get.uid'))->field('prop_id,buyprop_num,buyprop_total')->relation(true)->select()); 
	}
	public function addcart($userid=""){
		echo 'test';
	}
	public function updatecart($userid=""){
		
	}
	public function deletecart($userid=""){
		
	}
}
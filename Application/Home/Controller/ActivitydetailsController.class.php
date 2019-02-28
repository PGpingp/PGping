<?php
namespace Home\Controller;
use Think\Controller;
class ActivitydetailsController extends Controller {
	public function Activity($id=""){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
        $activity=D('Activity');
        echo json_encode($activity->where("activity_id='%d'",I('get.id'))->field('activity_detail')->select()); 
 	}
}
<?php
namespace Home\Controller;
use Think\Controller;
class PersonalsettingController extends Controller {
	//个人设置
	public function Personalsetting($uid=""){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json"); 
        $personalsetting=D('User');
     	echo json_encode($personalsetting->where("user_id='%d'",I('get.uid'))
     		->field('user_name,user_add,user_sex,user_sexori,user_emotion,user_blood,
     			user_horoscope,user_email,user_qq,user_interest')->select()); 
	}
	//保存修改个人设置
	public function Personalsettingsave(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
		$user=D('User');
		$data=array(
			'user_name'=>I('post.name'),
			'user_add'=>I('post.add'),
			'user_sex'=>I('post.sex'),
			'user_sexori'=>I('post.sexori'),
			'user_emotion'=>I('post.emotion'),
			'user_blood'=>I('post.blood'),
			'user_horoscope'=>I('post.horoscope'),
			'user_email'=>I('post.email'),
			'user_qq'=>I('post.qq'),
			'user_interest'=>I('post.interest'),
		);
			if($user->where("user_id='%d'",I('post.uid'))->save())	
			{return json_encode(array('sucess'=>1));
			}
			else{
				return json_encode(array('sucess'=>0));
			}
     }
     //实名资料
	public function Realinformation($uid=""){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json"); 
        $realinformation=D('User');
     	echo json_encode($realinformation->where("user_id='%d'",I('get.uid'))
     		->field('user_realname,user_sex,user_idnumber,user_add,user_tel,user_emcontact1,
     			user_emtel1,user_emcontact2,user_emtel2,user_medical')->select()); 
	}
	//保存修改实名资料
	public function Realinformationsave(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
		$user=D('User');
		$data=array(
			'user_realname'=>I('post.reaname'),
			'user_sex'=>I('post.sex'),
			'user_idnumber'=>I('post.idnumber'),
			'user_add'=>I('post.add'),
			'user_tel'=>I('post.tel'),
			'user_emcontact1'=>I('post.emcontact1'),
			'user_emtel1'=>I('post.emtel1'),
			'user_emcontact2'=>I('post.emcontact2'),
			'user_emtel2'=>I('post.emtel2'),
			'user_medical'=>I('post.medical'),
		);
			if($user->where("user_id='%d'",I('post.uid'))->save())	
			{return json_encode(array('sucess'=>1));
			}
			else{
				return json_encode(array('sucess'=>0));
			}
        }
        //保存修改密码
	public function Pwdsave(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
		$users=D('User');
		$userpwd=$users->where("user_id='%d'",I('post.uid'))->getField('user_pwd');
		if($userpwd==I('post.pwd'))
		{
		$users->where("user_id='%d'",I('post.uid'))->setField('user_pwd','post.newpwd');
			return json_encode(array('sucess'=>1));
			}
			else{
				return json_encode(array('sucess'=>0));
			}
        }
}
	
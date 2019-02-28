<?php
namespace Home\Model;

use Think\Model;

class UserModel extends Model{
	
	//protected $patchValidate =true;//同时显示多个字段错误
	protected $_validate =array(
		array('user_name','require','用户名不能为空',0,'regex',3),
		array('user_email','email','邮箱格式不合法',0),
		array('user_tel','^[0-9]{11}','必须是11位纯数字',0,'regex'),
	);
	protected  $_auto= array ( 
				 array('user_blockade','0'), 
				 array('user_pwd','sha1',3) ,
				 array('user_sign','time',2),
				);
}
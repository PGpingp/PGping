<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	
	/*发送短信*/
	public function sendMessage($phone){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
		session(array('name'=>'lock','expire'=>30));
		if($_SESSION['lock']!=ture){
			session('lock','true');

            /*
            $a=new \Org\Util\Nowapi;
			 //其它接口根据文档修改其参数即可调用
			 $a_parm=array(
			    'app'=>'104001',
			    'phone'=>I('get.phone'),
			);
			if(!$result=$a->callapi($a_parm)){
			   return;
			}
			$number=rand(1000,9999);
			$a_api['result']='验证码：'.$number;

            */
            $number=rand(1000,9999);
            cookie('verify',sha1($number."769775b04b6294dc6312d7b4a27ea6d0"),30);
            $company="玩逗疯玩院";
/*
    ***聚合数据（JUHE.CN）短信API服务接口PHP请求示例源码
    ***DATE:2015-05-25
*/
            header('content-type:text/html;charset=utf-8');

            $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL

            $smsConf = array(
                'key'   => '5bc8e570b04926e6cf67d2b3e394fe20', //您申请的APPKEY
                'mobile'    => I('get.phone'), //接受短信的用户手机号码
                'tpl_id'    => '4496', //您申请的短信模板ID，根据实际情况修改
                'tpl_value' =>"#name#=".$company."&#code#=".$number //您设置的模板变量，根据实际情况修改
            );

            $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信

            if($content){
                /*$result = json_decode($content,true);
                $error_code = $result['error_code'];
                if($error_code == 0){
                    //状态为0，说明短信发送成功
                    echo "短信发送成功,短信ID：".$result['result']['sid'];
                }else{
                    //状态非0，说明失败
                    $msg = $result['reason'];
                    echo "短信发送失败(".$error_code.")：".$msg;
                }*/
                echo "发送成功";
            }else{
                //返回内容异常，以下可根据业务逻辑自行修改
                echo "请求发送短信失败";
            }

            /**
             * 请求接口返回内容
             * @param  string $url [请求的URL地址]
             * @param  string $params [请求的参数]
             * @param  int $ipost [是否采用POST形式]
             * @return  string
             */




			return json_encode(array('success'=>1));
		}
		else{
			return  json_encode("请等待30秒！");	
			}
	}
    //http://localhost/shopingmallweb/Home/user/sendMessage.html?phone=13729522491
    public function test1(){
        //cookie('verify',sha1($number."769775b04b6294dc6312d7b4a27ea6d0"),3000);
        session(array('name'=>'verify1','expire'=>100));
        session('verify1',sha1($number."769775b04b6294dc6312d7b4a27ea6d0"));  //设置session
        //session('verify1',null);
    }
    public function test2(){
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
        //echo cookie('verify')."<br/>";
        echo  json_encode(session('verify1'));
    }



	//用户手机注册
	public function addphone(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
        $value = cookie('verify');
        if(sha1(I('post.verify')."769775b04b6294dc6312d7b4a27ea6d0")==$value){
			$user=D('User');
			if($user->create())
			{
				$user_signtime=time();
				$user->add();
				return json_encode(array('sucess'=>1));
			}
			else{
				return json_encode(array('sucess'=>0));
			}
        }
	}
	
	//用户邮箱注册
	public function addemail(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
			$user=D('User');
			if($user->create())
			{
				$user->add();
				return json_encode(array('sucess'=>1));
			}
			else{
				return json_encode(array('sucess'=>0));
			}
        }

	//发送链接到用户邮箱激活
	public function sendMail(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
		$email=I('post.mail');
		$users=D('User');
		$blockade=$users->where("user_email='%s'",$email)->getField('user_blockade');
			if(!$blockade){
				$result=$users->where("user_email='%s'",$email)->select();
				$uid=$result['user_id'];
				$getPassTime=time();
				$token=md5($uid.$result['user_pwd']);
				$emailsubject  = "=UTF-8".base64_encode('邮箱激活')."?="; 
				$emailbody= "<html>
								<a href='".__ROOT__."/shopingmallweb/Home/user/emailVerify?&".$verify=$token."&uid=".$uid."' target= 
						'_blank'>".__ROOT__."/shopingmallweb/Home/user/emailVerify?&".$verify=$token."</a>
							如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。
							</html>";
		/*	$emailbody= "<html>
							<a href='http://geesoon.cn/index.php/home/regist/findBackPass?email=".$email."&verify=".$token."' target= 
					'_blank'>http://geesoon.cn/index.php/home/regist/findBackPass?email=".$email."&verify=".$token."</a>		
						如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。
						</html>"; 
						密码找回
						//发送邮件 */
				// 当发送 HTML 电子邮件时，请始终设置 content-type
			$header = "From: 发件人姓名 <username@domain.com>\n";
			$header .= "Return-Path: <username@domain.com>\n";     //防止被当做垃圾邮件，但在sina邮箱里不起作用
			$header .= "MIME-Version: 1.0\n";
			$header .= "Content-type: text/html; charset=utf-8\n";    //邮件内容为utf-8编码
			$header .= "Content-Transfer-Encoding: 8bit\r\n";    //注意header的结尾，只有这个后面有\r
			ini_set('sendmail_from', 'username@domain.com');     //解
			$send = mail($email,$emailsubject,$emailbody,$header);
			
			$udata=array(
				'user_id'=>$uid,
				'user_signtime'=>$getPassTime,
			);
			$users->save($udata);
			
			$linkMail=substr($email,stripos($email,"@")+1);
	
			$msg = "系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时激活您的账号！<a href='http://mail.$linkMail'>登录邮箱</a>"; 
		}else{
			$msg='noreg'; 
		}
		echo json_encode($msg);
	}

	//激活邮箱
	public function emailVerify($verify="",$uid=""){ 
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
		$verify = I('get.verify'); 
		$nowtime = time();
		$users=D('Users');
		$result=$users->where("user_id='%d'",I('get.uid'))->select();
		$token=md5($result['user_id'].$result['user_pwd']);
		if($token==$verify){
			if($nowtime>$result['user_signtime']+60){
				$msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.'; 
			}else{
				$msg = '激活成功！';
				$users->where("user_id='%d'",$result['user_id'])->setField('user_blockade','1');
				return json_encode(array('sucess'=>1));
			}
		}else{
			return json_encode(array('sucess'=>0));
		}
	}
	
	//用户登录
	public function login(){
		header("Access-Control-Allow-Origin: *");
        header("Cache-Control: max-age=0");
        header("Content-type: application/json");
		$user=D('User');
		$result=$user->select();
		foreach($result as $rel){
			if($rel['user_tel']==I('post.name')||$rel['user_email']== I('post.name')){
				if($rel['user_pwd']==I('post.pwd'))
				{return json_encode(array('success'=>1));}
				else{return json_encode(array('success'=>0));}
			}else{
				return json_encode(array('success'=>0));;
				
			}
		}
	}
	
//检测用户是否已经登录
public function checkIsLogin(){
		header("Access-Control-Allow-Origin: *");
		header("Cache-Control: max-age=0");
		header("Content-type: application/json");
		$users=D('User');
			if(I('post.token')!=""){
				$result=$users->select();
				foreach($result as $results)
				{
					if(I('post.Token')==$results['user_wechat_token']||I('post.Token')==$results['user_qq_token']||I('post.Token')==$results['user_weibo_token']){
						if(I('post.userId')!=""){
								echo json_encode(array('success'=>1));
							}
						}else{
							echo json_encode(array('success'=>0));
						}
					}
					//echo json_encode($moblieToken);
				
			}else{
				if(I('post.userId')!=""){
					echo json_encode(array('success'=>1));
				}	
			}
		
	}
}
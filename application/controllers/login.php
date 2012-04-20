<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		
    }
    
    function userLogin(){
    	$email = $_POST['loginEmail'];
    	$password = $_POST['loginPassword'];
    	$remCheck = $_POST['checkReme'];
    	
    	$password = md5($password);
    	$sql = "SELECT *  FROM master WHERE master.email='$email' AND master.password ='$password'";
    	$userArr = GetRow($sql);
    	$userAmount = count($userArr);
    	if($userAmount!=0){
    		$_SESSION['uid'] = $userArr['master_id'];
    		if (!get_magic_quotes_gpc()) {
    			$userArr['nick'] = stripslashes($userArr['nick']);
    		}
    		$_SESSION['uname']= $userArr['nick'];
    		if($remCheck==1){
    			$time=time()+60*60*24*30;
    			setcookie('auto_login' , 'true' , $time, '/');
    			setcookie('login_email' , $email , $time, '/');
    			setcookie('login_password' , $password , $time, '/');
    		}else{
    			$time=time()-60*60*24*30;
    			setcookie('auto_login' , 'false' , $time, '/');
    			setcookie('login_email' , $email , $time, '/');
    			setcookie('login_password' , $password , $time, '/');
    		}
    		echo json_encode($userArr['nick']);
    	}else{
    		echo 'noData';
    	}
    }
    
	public function mini(){
		/* if(islogin()){
			showjumpmsg('你已经登录了');
		} */
		$msg = '';
		
		if(submitcheck('loginsubmit')) {
			$email = $_POST['loginEmail'];
			$password = $_POST['loginPassword'];
			$remCheck = $_POST['checkReme'];
			 
			$password = md5($password);
			$sql = "SELECT * FROM master WHERE master.email='$email' AND master.password ='$password'";
			$userArr = GetRow($sql);
			$userAmount = count($userArr);
			if($userAmount != 0){
				$_SESSION['uid'] = $userArr['master_id'];
				if (!get_magic_quotes_gpc()) {
					$userArr['nick'] = stripslashes($userArr['nick']);
				}
				$_SESSION['uname']= $userArr['nick'];
				if($remCheck==1){
					$time=time()+60*60*24*30;
					setcookie('auto_login' , 'true' , $time, '/');
					setcookie('login_email' , $email , $time, '/');
					setcookie('login_password' , $password , $time, '/');
				}else{
					$time=time()-60*60*24*30;
					setcookie('auto_login' , 'false' , $time, '/');
					setcookie('login_email' , $email , $time, '/');
					setcookie('login_password' , $password , $time, '/');
				}
				// echo json_encode($userArr['nick']);
				$msg = '登录成功了！';
			}else{
				// echo 'noData';
				$msg = '登录失败！';
			}
		}
		
		$vars = array(
			'msg' => $msg
		);
		set_page_title('会员登录');
		$this->tpl->assign($vars);
		$this->tpl->display();
    }
}
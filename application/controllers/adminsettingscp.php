<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-8-7上午01:01:32
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminsettingscp extends CI_Controller {
	
	/**
	 *
	 * @var Adminuser_model
	 */
	public $adminusermod;
	
	/**
	 *
	 * @var Password_model
	 */
	public $pwdmod;
	
	/**
	 *
	 * @var Check_model
	 */
	public $ckmod;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Adminuser_model', 'adminusermod');
		$this->load->model('Password_model', 'pwdmod');
		$this->load->model('Check_model', 'ckmod');
		ck_adminlogin();
		set_module_title('管理员设置');
	}
	
	public function index(){
		$message = array();
		$msgtype = 'error';
		
		$adminuser = $this->adminusermod->get_adminuser($_SESSION['uyan_adminid']);		
		
		if(submitcheck('profilesubmit')){
			$POST = newhtmlspecialchars($_POST);
			
			//验证真实姓名
			$result = $this->ckmod->check_realname($POST['realname']);
			if($result != 'OK'){
				$message[] = $result;
			}
			
			if(empty($message)){
				$setarr = array(
					'realname' => $POST['realname']
				);
				updatetable('admin_user', $setarr, array('adminid'=>$_SESSION['uyan_adminid']));
				
				$msgtype = 'ok';
				$message[] = '基本资料已经成功更新！';
				
			}
			$adminuser = $POST;
		}
		
		$vars = array(
			'msgtype' => $msgtype,
			'message' => $message,
			'adminuser' => $adminuser
		);
		
		set_page_title('基本资料');
		$this->tpl->assign($vars);
		$this->tpl->display();
	}
	
	public function password(){

		$message = array();
		$msgtype = 'error';

		if(submitcheck('passwordsubmit')){

			//检查当前密码
			$result = $this->adminusermod->check_adminpwd_current($_SESSION['uyan_adminid'], $_POST['password_current']);
			if($result != 'OK'){
				$message[] = '当前'.$result;
			}
			
			//md5加密密码
			$passwordmd5 = '';
	
			//检查新密码并生成md5加密密码
			$result = $this->pwdmod->check_password_once($_POST['password_once']);
			if($result == 'OK'){
				$passwordmd5 = md5($_POST['password_once']);
			} else {
				$message[] = '新'.$result;
			}
	
	
			//检查二次输入的密码，确保与第一次输入的登录密码一致
			$result = $this->pwdmod->check_password_twice($_POST['password_twice'], $passwordmd5);
			if($result != 'OK'){
				$message[] = $result;
			}
			

			if(empty($message)){
				//修改密码
				$setarr = array(
					'password' => $passwordmd5
				);
				$result = updatetable('admin_user', $setarr, array('adminid'=>$_SESSION['uyan_adminid']));
				if($result){
					$msgtype = 'ok';
					$message[] = '密码修改成功，下次登录请使用你刚才设置的新密码。';
				} else {
					$message[] = '服务器开小差了，密码修改失败。请重试。';
				}
			}
		}

		$vars = array(
			'message' => $message,
			'msgtype' => $msgtype,
		);
		set_page_title('修改密码');
		$this->tpl->assign($vars);
		$this->tpl->display();
	}
}
<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-9-3下午08:17:55
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userticket extends CI_Controller {

	/**
	 * 
	 * @var User
	 */
	public $user;
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function index(){
		ajax_header();
		@header('Content-type:text/javascript; charset=UTF-8');
		if(islogin()) {
			$data = array('uid'=>$_SESSION["uid"], 'username'=>$_SESSION['uname']);
		} else {
			$data = array('uid'=>0, 'username'=>'');
		}
		echo 'var _uyan_userid=\''.$_SESSION["uid"].'\';try{_Uyan_UserTicket('.json_encode($data).')}catch(e){}';
	}
}
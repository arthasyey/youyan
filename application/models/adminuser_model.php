<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-8-7上午01:15:33
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminuser_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

	public function get_adminuser($adminid, $fieldname = '*'){
		$sql = "SELECT $fieldname 
			FROM ".tname('admin_user')." 
			WHERE adminid='$adminid'";
		
    	if($profile = GetRow($sql)){
    		return $profile;
    	}
		return FALSE;
	}
	
	//检查当前登录密码是否匹配
    public function check_adminpwd_current($adminid, $password){
    	
    	if($adminid > 0){
    		if($adminuser = $this->get_adminuser($adminid)){
	    		if(empty($password)){
					$result = '密码不能为空。';
				} else {
					$password_encryption = md5($password);
					if($adminuser['password'] != $password_encryption){
						$result = '密码不正确。';
					} else {
						$result = 'OK';
					}
				}
    		} else {
    			$result = '管理员不存在。';
    		}
    	} else {
    		$result = '管理员ID有误。';
    	}
		return $result;
    }
}
<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-8-1下午02:45:37
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_model extends CI_Model {

	/**
	 * 
	 * @var User
	 */
	public $user;
	
    public function __construct() {
        parent::__construct();
    }

	/**
     * @desc 检查用户名
     * @param $username
     */
	public function check_username($username){
		if(empty($username)) {
			$result = '用户名不能为空！';
		} else{
			if(!isusername($username)){
				$result = '用户名中包含有特殊字符。只允许汉字，大小写字母，数字作为用户名。';
			} else {
				$strlen = cnstrlen($username) * 2;
				if($strlen < 4 || $strlen > 20) {
					$result = '用户名的长度应该4-20个字符之间！';
				} else {
					$username_num = GetOne("SELECT COUNT(uid) FROM ".tname('member')." WHERE username='$username'");
					if($username_num){
						$result = '对不起，该用户名已经被注册。<br /><a href="'.SITE_URL.'/login/?memberid='.$username.'">直接使用该用户名登录</a>';
					} else {
						if($username_num === FALSE){
							$result = '数据库服务器繁忙，请稍后再试。';
						} else {
							$result = 'OK';
						}
					}
				}
			}
		}
		return $result;
    }
    
	/**
     * @desc 检查手机号的逻辑处理
     * @param $cellphone
     * @param $type 何种情况下进行的检查? 1=注册，2=修改资料
     */
    public function check_cellphone_logic($cellphone, $type=1){

    	if(empty($cellphone)) {
			$result = '手机号码不可为空';
		} elseif(!iscellphone(($cellphone))) {
			$result = '请输入11位正确的手机号码格式，无需加0';
		} else {
			$cellphone_exist = GetOne("SELECT cellphone FROM ".tname('member_profile')." WHERE cellphone='{$cellphone}'");
			if($cellphone_exist){
				if($type == 1){
					$result = '该手机号码已被使用。请更换';
				} else {
					$result = "抱歉，该手机号码已被使用，请更换 。";
				}
	    	} else {
	    		$result = 'OK';
	    	}
		}
		return $result;
    }
    
    
 	/**
     * @desc 检查邮箱帐号的逻辑处理
     * @param $email
     * @param $type 何种情况下进行的检查? 1=注册，2=修改email
     */
    public function check_email($email, $type){

    	if(empty($email)) {
			$result = '电子邮箱不可为空。';
		} elseif(!isemail(($email))) {
			$result = '你的邮箱地址格式不正确，请重新输入。';
		} else {			
			if($member = $this->user->get_member('email', $email)){
				if($type == 1){
					if($member['emailcert']){
		    			//已经通过邮箱验证
		    			$result = '该电子邮箱已经被注册。<br /><a href="'.SITE_URL.'/login/?memberid='.$email.'">直接使用该邮箱地址登录</a>';
		    		} else {
		    			$result = '该电子邮箱已经被注册。<br /><a href="'.SITE_URL.'/login/?memberid='.$email.'">直接使用该邮箱地址登录</a>';
//		    			$result = '该电子邮箱已被注册，但尚未激活。<br /><a href="'.SITE_URL.'/activate/?memberid='.$email.'">&raquo;立即激活此邮箱地址</a>';
		    		}
				} else {
					$result = "对不起，该电子邮箱已经被使用，请更换 。";
				}
	    	} else {
	    		$result = 'OK';
	    	}
		}
		return $result;
    }
    
	/**
     * @desc 检查验证码
     * @param $seccode
     */
    public function check_seccode($seccode){

    	if(empty($seccode)) {
			$result = '验证码不能为空';
		} elseif(strlen($seccode) != 4) {
			$result = '验证码的长度应该为4个字符';
		} else{
			if(!checkseccode($seccode)){
				$result = '验证码输入错误，如看不清，请点击图片刷新。';
			} else {
				$result = 'OK';
			}
		}
		return $result;
    }
    
    //检查真实姓名
    public function check_realname($realname){
    	if(empty($realname)) {
    		$result = '真实姓名不能为空';
    	} else {
			if(!isusername($realname)){
				$result = '真实姓名中包含有特殊字符。请填写你的中文真实姓名。';
			} else {
				$strlen = cnstrlen($realname) * 2;
				if($strlen > 20) {
					$result = '真实姓名的长度应该20个字符之内！一个汉字为2个字符';
				} else {
					$result = 'OK';
				}
			}
		}
		return $result;
    }
    
    //检查网址
    public function check_url($url){
    	if(empty($url)) {
			$result = '网站地址不能为空';
		} else {
			if(!is_url($url)){
				$result = '网址格式填写错误，请以“http://”开头，填写完整的网站首页地址。';
			} else {
				$result = 'OK';
			}
		}
		return $result;
    }
    
    public function check_qq($qq){
    	if(empty($qq)) {
			$result = 'qq号码不能为空';
		} else {
			if(is_numeric($qq)){
				$qqlen = strlen($qq);
				if($qqlen < 5 || $qqlen > 10){
					$result = 'QQ号码应该由5-10位的数字组成';
				} else {
					$result = 'OK';
				}
			} else {
				$result = 'QQ号码应该由5~10位数字组成';
			}
		}
		return $result;
    }
    
    public function check_telphone($telphone){
    	if(empty($telphone)) {
			$result = '联系电话不能为空';
    	} else {
    		if(iscellphone($telphone) || istelphone($telphone)){
    			$result = 'OK';
    		} else {
    			$result = '固定电话格式错误，座机请按照 “区号-电话号码-分机号码” 的格式来填写';
    		}
    	}
    	return $result;
    }
    
    public function check_address($address){
    	if(empty($address)) {
			$result = '联系地址不能为空！';
		} else{
			$strlen = cnstrlen($address) * 2;
			if($strlen > 300) {
				$result = '联系地址的长度应该300个字符之内！一个汉字为2个字符';
			} else {
				$result = 'OK';
			}
		}
		return $result;
    }
    
	public function check_webid($webid){
    	if(empty($webid)) {
			$result = 'webid是简短的媒体主网站的唯一标识符，不能为空。';
		} else{
			if(!is_webid($webid)) {
				$result = 'webID只能由1-32位的字母、数字构成，不能输入中文或其它特殊字符。';
			} else {
				$sql = "SELECT COUNT(mediaid) FROM ".tname('media')." WHERE webid='$webid'";
				$num = GetOne($sql);
				if($num > 0){
					$result = 'webID已经存在，请更换。';
				} else {
					$result = 'OK';
				}
			}
		}
		return $result;
    }
    
	public function check_cms_seourl($seourl){
    	if(empty($seourl)) {
			$result = 'seourl是为了使URL更加美化，对搜索引擎更友好，不能为空。';
		} else{
			if(!is_seourl($seourl)) {
				$result = 'seourl只能由1-100位的字母、数字、-_构成，不能输入中文或其它特殊字符。';
			} else {
				$sql = "SELECT COUNT(cmsid) FROM ".tname('cms')." WHERE seourl='$seourl'";
				$num = GetOne($sql);
				if($num > 0){
					$result = 'seourl已经存在，请更换。';
				} else {
					$result = 'OK';
				}
			}
		}
		return $result;
    }
    
	public function check_help_seourl($seourl){
    	if(empty($seourl)) {
			$result = 'seourl是为了使URL更加美化，对搜索引擎更友好，不能为空。';
		} else{
			if(!is_seourl($seourl)) {
				$result = 'seourl只能由1-100位的字母、数字、-_构成，不能输入中文或其它特殊字符。';
			} else {
				$sql = "SELECT COUNT(helpid) FROM ".tname('help')." WHERE seourl='$seourl'";
				$num = GetOne($sql);
				if($num > 0){
					$result = 'seourl已经存在，请更换。';
				} else {
					$result = 'OK';
				}
			}
		}
		return $result;
    }
}
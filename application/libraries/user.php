<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-7-29下午04:58:45
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User{
	private $CI;
	public $uid;
	public $session;
	public $member;

	public function __construct() {

		$this->CI =& get_instance();
		
		$this->init();
		$this->checkauth();
		$this->get_login_memberid();
		$this->invite();
	}

	public function init()
	{
		$this->uid = 0;
		$this->member = array();
		$this->session = array();
	}
	
	public function invite(){
		$inviter = isset($_GET['inviter']) ? $_GET['inviter'] : 0;
		$inviter = intval($inviter);
		if($inviter > 0){
			$inviter_exsit = $this->check_inviter($inviter);
			if($inviter_exsit){
				set_cookie('inviter', $inviter, 0);
			} else {
				$inviter = 0;
			}
		} else {
			$inviter = 0;
		}
		return $inviter;
	}
	
	public function check_inviter($inviter){
		$inviter_exsit = GetOne("SELECT uid FROM ".tname('member')." WHERE uid='{$inviter}'");
		return $inviter_exsit;
	}
	
	public function get_inviter(){
		$inviteuid = 0;
		$inviter = isset($_GET['inviter']) ? $_GET['inviter'] : 0;
		$inviter = intval($inviter);
		if($inviter > 0){
			$inviter_exsit = $this->check_inviter($inviter);
			if($inviter_exsit){
				$inviteuid = $inviter;
			}
		}
		
		if(!$inviteuid){
			$inviter_cookie = intval(get_cookie('inviter'));
			if($inviter_cookie > 0){
				$inviter_cookie_exsit = $this->check_inviter($inviter_cookie);
				if($inviter_cookie_exsit){
					$inviteuid = $inviter_cookie;
				}
			}
		}
		return $inviteuid;
	}
	
	public function get_login_memberid(){
		$loginprompt = $this->CI->config->item('loginprompt');
		$loginuser = get_cookie('loginuser');
		$loginuser = empty($loginuser) ? '' : $loginuser;
		if(!empty($_GET['memberid'])){
			$loginmemberid = sbc2dbc(trim($_GET['memberid']));
		}else if(!empty($_POST['memberid'])){
			$loginmemberid = sbc2dbc(trim($_POST['memberid']));
		} else if(!empty($loginuser)){
			$loginmemberid = $loginuser;
		} else {
			$loginmemberid = $loginprompt;
		}
		$vars = array(
			'loginuser' => $loginuser,
			'loginprompt' => $loginprompt,
			'loginmemberid' => $loginmemberid
		);
		$this->CI->tpl->assign($vars);
	}

	public function checkauth() {

		$member = array();

		$authcookie = get_cookie('auth');

		if($authcookie) {
			@list($authpwd, $uid) = explode("\t", $this->authcode($authcookie, 'DECODE'));
			$uid = intval($uid);
			if($authpwd && $uid) {
				if($member = $this->get_member_by_uid($uid)) {
					$query = $this->CI->db->query("SELECT * FROM ".tname('session')." WHERE uid='$uid'");
					if($query){
						if($session = $query->row_array()) {
							if($session['authpwd'] == $authpwd) {
								$session['lastactivity'] = SITE_TIME;
								updatetable('session', array('lastactivity'=>SITE_TIME), array('uid'=>$uid));
								$this->session = $session;
								$this->uid = $uid;
							}
						} else {
							if($member['authpwd'] == $authpwd) {
								$setarr = array('uid'=>$uid,'username'=>addslashes($member['username']),'authpwd'=>$authpwd);
								$this->insertsession($setarr);
								$this->uid = $uid;
							}
						}
					}
				}
			}
		}
		if(empty($this->uid) || empty($member)) {
			$this->clearcookie();
		} else {
			$this->member = $member;
		}
	}
	

	
	public function get_lastactivity($uid){
		$session = GetRow("SELECT lastactivity FROM ".tname('session')." WHERE uid='{$uid}'");
		if(!empty($session)){
			$lastactivity = $session['lastactivity'];
		} else {
			$lastactivity = 0;
		}
		return $lastactivity;
		
	}
	

	public function get_member_by_uid($uid, $fieldname = '*'){
		return $this->get_member('uid', $uid, $fieldname);
	}
	
	public function get_member($field, $value, $fieldname = '*'){
		if(in_array($field, array('uid', 'username', 'email'))){
			$sql = "SELECT $fieldname FROM ".tname('member')." 
				WHERE $field='$value'";
			
	    	if($member = GetRow($sql)){
	    		return $member;
	    	}
		}
		return FALSE;
	}
	
	public function get_profile($uid, $fieldname = '*'){
		$sql = "SELECT $fieldname FROM ".tname('member_profile')." 
			WHERE uid='$uid'";
		
    	if($profile = GetRow($sql)){
    		return $profile;
    	}
		return FALSE;
	}


	//会员登录
	public function memberlogin($setarr, $cookietime=0){

		$data = array();
		$data['lastlogintime'] = SITE_TIME;
		$data['lastloginip'] = getonlineip();
		
		if(empty($setarr['authpwd'])){
			$setarr['authpwd'] = md5(SITE_TIME);
			$data['authpwd'] = $setarr['authpwd'];
		}
		
		//清理在线session
		$this->insertsession($setarr);
		
		updatetable('member', $data, array('uid'=>$setarr['uid']));
		
		set_cookie('auth', $this->authcode("{$setarr['authpwd']}\t{$setarr['uid']}", 'ENCODE'), $cookietime);
		set_cookie('loginuser', $setarr['loginuser'], 31536000);
	}


	//清空cookie
	public function clearcookie() {

		set_cookie('auth', '', -86400 * 365);
		$this->init();
	}

	//添加在线session
	public function insertsession($setarr) {
		
		$session = array();
		$session['uid'] = $setarr['uid'];
		$session['username'] = $setarr['username'];
		$session['authpwd'] = $setarr['authpwd'];

		//清理在线
		$this->clearsession($session['uid']);

		//添加在线
		$ip = getonlineip();
		$session['lastactivity'] = SITE_TIME;
		$session['ip'] = $ip;
		$this->session = $session;
		return inserttable('session', $session, 0, 1);
	}

	//清理在线session
	public function clearsession($uid=0){

		$onlinehold = intval($this->CI->config->item('onlinehold'));
		$wheresql = "lastactivity<'".(SITE_TIME - $onlinehold)."'";
		if($uid){
			$wheresql .= " OR uid='$uid'";
		}
		$this->CI->db->query("DELETE FROM ".tname('session')." WHERE $wheresql");
	}

	public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

		$ckey_length = 4;
			// 随机密钥长度 取值 0-32;
			// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
			// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方。
			// 当此值为 0 时，则不产生随机密钥，也就是用户每次登录的加密值都一样，反之则每次登录产生的加密值都不一样。

		$key = md5($key ? $key : $this->CI->config->item('site_key'));
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
}
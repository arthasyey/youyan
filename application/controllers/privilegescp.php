<?php
/**
 * @copyright	© 2009-2011 JiaThis Inc.
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2011-3-29
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privilegescp extends CI_Controller {


	/**
	 *
	 * @var Password_model
	 */
	public $pwdmod;
	
	/**
	 *
	 * @var Adminuser_model
	 */
	public $adminusermod;
	
	public function __construct(){
		parent::__construct();
		ck_adminlogin();
		$this->load->model('Password_model', 'pwdmod');
		$this->load->model('Adminuser_model', 'adminusermod');
		set_module_title('权限管理');
	}
	
	public function index(){
		showmessage('跳转', SITE_URL.'/privilegescp/adminlist', 0);
	}
	
	public function editadmin($adminid){
		$adminid = isset($adminid) ? intval($adminid) : 0;
		if(!$adminid) showmessage('参数传递错误。', 0);
		
		$adminer = $this->adminusermod->get_adminuser($adminid);
		if(!$adminer) showmessage('该管理员不存在。', 0);
		
		
		//载入配置
		include APPPATH."config/adminmenu.php";
		$all_privileges = get_all_privileges($ADMIN_MENU);
		
		$message = array();
		$msgtype = 'error';
		
		if(submitcheck('dosubmit')){
			$POST = newhtmlspecialchars($_POST);
			
			
			if(empty($POST['adminname'])){
				$message[] = '管理员登录名不能为空。';
			} else if(!isusername($POST['adminname'])){
				$message[] = '登录名中包含有特殊字符。只允许汉字，大小写字母，数字作为登录名。';
			} else {
				$strlen = cnstrlen($POST['adminname']) * 2;
				
				if($strlen < 4 || $strlen > 20) {
					$result = '登录名的长度应该4-20个字符之间！';
				} else {
					if($POST['adminname'] != $adminer['adminname']){
						$adminname_num = GetOne("SELECT COUNT(*) 
							FROM ".tname('admin_user')." 
							WHERE adminname='{$POST['adminname']}'");
						if($adminname_num){
							$message[] = '相同的管理员登录名已经存在，请更换。';
						}
					}
					
				}
			}
			
			//md5加密密码
			$passwordmd5 = '';
			
			if(!empty($_POST['password_once']) || !empty($_POST['password_twice'])){
				//检查新密码并生成md5加密密码
				$result = $this->pwdmod->check_password_once($_POST['password_once']);
				if($result == 'OK'){
					$passwordmd5 = md5($_POST['password_once']);
				} else {
					$message[] = '登录'.$result;
				}
		
		
				//检查二次输入的密码，确保与第一次输入的登录密码一致
				$result = $this->pwdmod->check_password_twice($_POST['password_twice'], $passwordmd5);
				if($result != 'OK'){
					$message[] = $result;
				}
			}

			if(empty($POST['realname'])){
				$message[] = '真实姓名不能为空。';
			} else {
				$realname_len = cnstrlen($POST['realname']) * 2;
				if($realname_len < 4 || $realname_len > 20) {
					$result = '真实姓名的长度应该4-20个字符之间！';
				}
			}
			
			$POST['status'] = intval($POST['status']);
			
			if($POST['status'] != 0 && $POST['status'] != 1){
				$message[] = '状态选择错误';
			}
			
			if(empty($message)){
				$setarr = array(
					'adminname' => $POST['adminname'],
					'realname' => $POST['realname'],
					'status' => $POST['status']
				);
				
				if($passwordmd5){
					$setarr['password'] = $passwordmd5;
				}
				
				$result = updatetable('admin_user', $setarr, array('adminid'=>$adminid));
				
				if($result){
					$msgtype = 'ok';
					$message[] = '操作成功，资料已经更新！';
				} else {
					$message[] = '服务器繁忙，修改失败，请重试！';
				}
			}
			$adminer = $POST;
		}

		$statusarr = array($adminer['status']=>' checked');
		if(isset($statusarr[0])) {
			$statusarr[1] = '';
		} else {
			$statusarr[0] = '';
		}
		
		$vars = array(
			'statusarr' => $statusarr,
			'adminer' => $adminer,
			'message' => $message,
			'msgtype' => $msgtype
		);
		$this->tpl->assign($vars);
		
		set_page_title('修改管理员资料');
		$this->tpl->display();
	}
	
	public function edit($adminid){
		$adminid = isset($adminid) ? intval($adminid) : 0;
		if(!$adminid) showmessage('参数传递错误。', 0);
		
		$adminer = $this->adminusermod->get_adminuser($adminid);
		if(!$adminer) showmessage('该管理员不存在。', 0);
		
		
		//载入配置
		include APPPATH."config/adminmenu.php";
		$all_privileges = get_all_privileges($ADMIN_MENU);
		
		$message = array();
		$msgtype = 'error';
		
		if(submitcheck('dosubmit')){
			$POST = newhtmlspecialchars($_POST);
			$privileges = isset($POST['privileges']) ? $POST['privileges'] : '';
			$privileges = (!empty($privileges) && is_array($privileges)) ? $privileges : array();
			
			$privileges_ser = serialize($privileges);
			$all_privileges_ser = serialize($all_privileges);
			
			if($privileges_ser == $all_privileges_ser){
				$privileges_ser = 'ALL PRIVILEGES';
			}
			
			
			$setarr = array(
				'privileges' => $privileges_ser
			);
			
			$result = updatetable('admin_user', $setarr, array('adminid'=>$adminid));
			if($result){
				$msgtype = 'ok';
				$message[] = '操作成功，权限已经更新！';
			} else {
				$message[] = '服务器繁忙，修改失败，请重试！';
			}
			$adminer['privileges'] = $privileges_ser;
		}
		
		if(empty($adminer['privileges'])){
			$admin_privileges = array();
		} else {
			if($adminer['privileges'] == 'ALL PRIVILEGES'){
				$admin_privileges = $all_privileges;
			} else {
				$admin_privileges = unserialize($adminer['privileges']);
				$admin_privileges = is_array($admin_privileges)?$admin_privileges:array();
			}
		}
		
		$classmenu = array();
		
		foreach ($ADMIN_MENU as $key=>$val){
			$checkhtml = '';
			$ap = isset($admin_privileges[$key]) ? $admin_privileges[$key] : '';
			$ap = (isset($ap) && is_array($ap)) ? $ap : array();
			foreach($val['method'] as $class=>$method){
				$checkstr = '';
				$menuname = $method['menu'];
				if(in_array($class, $ap)){
					$checkstr = ' checked';
					$menuname = '<span style="color:green;">'.$method['menu'].'</span>';
				}
				
				$checkhtml .= "<input type=\"checkbox\" name=\"privileges[$key][]\" value=\"$class\" $checkstr /> $menuname &nbsp;";
			}
			$val['menuhtml'] = $val['menu'].' (<a href="javascript:;" onclick="checkPrivileges(\''.$key.'\', \'on\')">全选</a>/<a href="javascript:;" onclick="checkPrivileges(\''.$key.'\', \'off\')">反选</a>)';
			$val['checkhtml'] = $checkhtml;
			$privilegesmenu[$key] = $val;
			
			
			$classmenu[] = $key;
		}

		$vars = array(
			'adminer' => $adminer,
			'message' => $message,
			'msgtype' => $msgtype,
			'classmenu' => $classmenu,
			'privilegesmenu' => $privilegesmenu
		);
		$this->tpl->assign($vars);
		
		set_page_title('修改管理员权限');
		$this->tpl->display();
	}
	
	public function addadmin(){
		
		//初始化表单值
		$fields = array(
			'adminname' => '',
			'realname' => '',
			'status' => 1
		);
		
		$message = array();
		$msgtype = 'error';
		if(submitcheck('dosubmit')){
			$POST = newhtmlspecialchars($_POST);
			
			
			if(empty($POST['adminname'])){
				$message[] = '管理员登录名不能为空。';
			} else if(!isusername($POST['adminname'])){
				$message[] = '登录名中包含有特殊字符。只允许汉字，大小写字母，数字作为登录名。';
			} else {
				$strlen = cnstrlen($POST['adminname']) * 2;
				
				if($strlen < 4 || $strlen > 20) {
					$result = '登录名的长度应该4-20个字符之间！';
				} else {
					$adminname_num = GetOne("SELECT COUNT(*) 
						FROM ".tname('admin_user')." 
						WHERE adminname='{$POST['adminname']}'");
					if($adminname_num){
						$message[] = '相同的管理员登录名已经存在，请更换。';
					}
				}
			}
			
			
			//md5加密密码
			$passwordmd5 = '';
	
			//检查新密码并生成md5加密密码
			$result = $this->pwdmod->check_password_once($_POST['password_once']);
			if($result == 'OK'){
				$passwordmd5 = md5($_POST['password_once']);
			} else {
				$message[] = '登录'.$result;
			}
	
	
			//检查二次输入的密码，确保与第一次输入的登录密码一致
			$result = $this->pwdmod->check_password_twice($_POST['password_twice'], $passwordmd5);
			if($result != 'OK'){
				$message[] = $result;
			}
			
			if(empty($POST['realname'])){
				$message[] = '真实姓名不能为空。';
			} else {
				$realname_len = cnstrlen($POST['realname']) * 2;
				if($realname_len < 4 || $realname_len > 20) {
					$result = '真实姓名的长度应该4-20个字符之间！';
				}
			}
			
			$POST['status'] = intval($POST['status']);
			
			if($POST['status'] != 0 && $POST['status'] != 1){
				$message[] = '状态选择错误';
			}
			
			if(empty($message)){
				$setarr = array(
					'adminname' => $POST['adminname'],
					'password' => $passwordmd5,
					'realname' => $POST['realname'],
					'addtime' => SITE_TIME,
					'privileges' => '',
					'status' => $POST['status']
				);
				
				$adminid = inserttable('admin_user', $setarr, 1);
				
				if($adminid){
					showmessage('操作成功', SITE_URL.'/privilegescp/?addsuccess=1', 0);
				} else {
					$message[] = '服务器繁忙，增加失败，请重试！';
				}
			}
			
			$fields = array(
				'adminname' => $POST['adminname'],
				'realname' => $POST['realname'],
				'status' => $POST['status']
			);
		}
		
		$statusarr = array($fields['status']=>' checked');
		if(isset($statusarr[0])) {
			$statusarr[1] = '';
		} else {
			$statusarr[0] = '';
		}
		
		$vars = array(
			'statusarr' => $statusarr,
			'fields' => $fields,
			'message' => $message,
			'msgtype' => $msgtype,
		);
		$this->tpl->assign($vars);
		
		set_page_title('新增管理员');
		$this->tpl->display();
	}
	
	public function adminlist(){

		$GET = newhtmlspecialchars($_GET);
		$adminname = empty($GET['adminname']) ? '' : $GET['adminname'];
		$adminid = empty($GET['adminid']) ? '' : intval($GET['adminid']);
		$stime = empty($GET['stime']) ? '' : $GET['stime'];
		$etime = empty($GET['etime']) ? '' : $GET['etime'];
		
		$wheresql = "1";
		if(!empty($adminname)) $wheresql .= " AND adminname LIKE '%{$adminname}%'";
		if(!empty($adminid)) $wheresql .= " AND adminid='{$adminid}'";
		if(!empty($stime)) $wheresql .= " AND addtime>='".strtotime($stime.' 00:00:00')."'";
		if(!empty($etime)) $wheresql .= " AND addtime<='".strtotime($etime.' 23:59:59')."'";
		
		$this->load->library('page');
		$this->page->pernum = 5;//页码偏移量
		$pagesize = 20;//每页显示数量
		$total = GetOne("SELECT COUNT(adminid) FROM ".tname('admin_user')." WHERE $wheresql");
		$total = $total?intval($total):0;
		$page = $this->page->getpage($total, $pagesize);
		
		$sql = "SELECT *  
			FROM ".tname('admin_user')."
			WHERE $wheresql 
			ORDER BY adminid ASC  
			LIMIT {$this->page->limit}";
		
		
		$query = $this->db->query($sql);
		$list = array();
		if($query){
			foreach ($query->result_array() as $row){
				$row['adddate'] = sgmdate('Y-m-d', $row['addtime'], 1);
				$list[] = $row;
			}
		}
		
		$search = array(
			'adminname' => $adminname,
			'adminid' => $adminid,
			'stime' => $stime,
			'etime' => $etime
		);
		
		$vars = array(
			'list' => $list,
			'page' => $page,
			'search' => $search
		);
		$this->tpl->assign($vars);
		$this->tpl->display();
	}
}
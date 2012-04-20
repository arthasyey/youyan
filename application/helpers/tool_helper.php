<?php
/**
 * @copyright	© 2009-2011 JiaThis Inc.
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2011-10-10
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//是否是管理员
function isadmin(){
	if(empty($_SESSION['uyan_adminid']) || empty($_SESSION['uyan_adminname'])){
		return FALSE;
	} else {
		return TRUE;
	}
}

function get_all_privileges($ADMIN_MENU){
	$admin_privileges = array();
	foreach ($ADMIN_MENU as $key=>$val){
		$row = array();
		foreach($val['method'] as $class=>$method){
			$row[] = $class;
		}
		$admin_privileges[$key] = $row;
	}
	return $admin_privileges;
}

function check_privileges($privileges, $class, $method){
	$class_arr = isset($privileges[$class]) ? $privileges[$class] : array();
	$result = FALSE;
	if($class_arr){
		if(in_array($method, $class_arr)){
			$result = TRUE;
		}
	}
	return $result;
}

function get_admin_menu($ADMIN_MENU, $admin_privileges, $class, $method){
	$menu_class = $menu_method = '';
	foreach ($ADMIN_MENU as $key=>$val){
		$class_arr = isset($admin_privileges[$key]) ? $val : array();
		
		$menu_method_num = 0;
		
		if(!empty($class_arr)){
			$menu_class_url = SITE_URL."/$key";
			foreach ($class_arr['method'] as $m=>$v){
				if(in_array($m, $admin_privileges[$key]) && $v['status']){
					if($class == $key){
						$menu_method_current = ($method == $m) ? 'nav_sub_now' : 'nav_sub';
						$menu_method_url = $menu_class_url."/$m";
						$menu_method .= "<div class=\"{$menu_method_current}\"><a href=\"{$menu_method_url}\">{$v['menu']}</a></div>\r\n";
					}
					$menu_method_num++;
				}
			}
		}
		if($menu_method_num && $val['status']){
			$menu_class_current = ($class == $key) ? ' class="current"' : '';
			$menu_class .= "<li {$menu_class_current}><a href=\"{$menu_class_url}\">{$val['menu']}</a></li>\r\n";
		}
		
	}
	
	$adminmenu = array(
		'menu_class' => $menu_class,
		'menu_method' => $menu_method,
	);
	$CI =& get_instance();
	$CI->tpl->assign('adminmenu', $adminmenu);
	return $adminmenu;
}

//检查管理员是否登录
function ck_adminlogin() {
	if(!isadmin()) {
		showmessage('你需要登录后才能进行本次操作。',SITE_URL.'/admincp/login', 0);
	} else {
		$privileges = GetOne("SELECT privileges FROM ".tname('admin_user')." WHERE adminid='{$_SESSION['uyan_adminid']}'");
		$privileges = empty($privileges) ? '' : $privileges;
		
		$RTR =& load_class('Router');
		$class  = strtolower($RTR->fetch_class());
		$method = strtolower($RTR->fetch_method());
		
		//载入配置
		include APPPATH."config/adminmenu.php";
		$all_privileges = get_all_privileges($ADMIN_MENU);
		
		if(empty($privileges)){
			$admin_privileges = array();
		} else {
			if($privileges == 'ALL PRIVILEGES'){
				$admin_privileges = $all_privileges;
			} else {
				$admin_privileges = unserialize($privileges);
				$admin_privileges = is_array($admin_privileges)?$admin_privileges:array();
			}
		}
		
		if(check_privileges($all_privileges, $class, $method)){
			if(!check_privileges($admin_privileges, $class, $method)){
				
				$flag = empty($admin_privileges) ? TRUE : FALSE;
				
				if($ADMIN_MENU[$class]['method'][$method]['isajax']){
					ajax_output('对不起，您没有权限进行此操作。');
				}
				if(!$ADMIN_MENU[$class]['method'][$method]['status'] && !INAJAX){
					$flag = true;
				}
				
				if(!$flag){
					$jumpurl = '';
					$admin_flag = isset($admin_privileges[$class])? TRUE : FALSE;
					if($admin_flag){
						$admin_privileges = array($class=>$admin_privileges[$class]);
					}
					foreach ($admin_privileges as $key=>$val){
						foreach ($val as $vars){
							if($ADMIN_MENU[$key]['method'][$vars]['status']){
								$jumpurl .= "/$key/{$vars}";
								break 2;
							}
						}
					}
					if($jumpurl){
						showmessage('对不起，您没有权限进行此操作。', SITE_URL.$jumpurl, 0);
					} else {
						$flag = TRUE;
					}				
				}
				
				if($flag){
					$msgTilte = '对不起，您没有权限进行此操作。';
					$msgTodo = '请确定您是否有足够的权限访问此页面。';
					$msgBody = array();
					showinformation($msgTilte,$msgTodo,$msgBody);
				}
			}
		}
		
		get_admin_menu($ADMIN_MENU, $admin_privileges, $class, $method);
	}
}

//检查验证码
function checkseccode($seccode){
	$CI =& get_instance();
	$key = date('Y-m-d H').$CI->config->item('site_key');
	$appkey = md5($key);
	$api = "http://a.jiathis.com/s/ckcode.php?appkey=$appkey&sessionID=".SESSIONID."&seccode=$seccode";
//	$api = "http://192.168.1.22/a.jiathis.com/s/ckcode.php?appkey=$appkey&sessionID=".SESSIONID."&seccode=$seccode";
	$result = jfopen($api);
	return $result=='ok'?true:true;
}

function get_user_table($uid){
	if($uid){
		//每张表的区间
		$partition = 500;
		//倍数
		$multiple = ($uid-1) / $partition;
		return intval($multiple);
	}
	return -1;
}
<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-7-24下午07:12:09
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function showmessage($message, $url_forward='-1', $second=1, $error=0) {

	$CI =& get_instance();
	tplinit();
	$compile_dir = SMARTY_COMPILE_DIR.'/showmessage/';
	$cache_dir = SMARTY_CACHE_DIR.'/showmessage/';

	$CI->tpl->template_dir = SMARTY_TEMPLATES_DIR.'/showmessage/';
	$CI->tpl->compile_dir = $compile_dir;
	$CI->tpl->cache_dir = $cache_dir;

	if(!is_dir($compile_dir)){
		@mkdir($compile_dir,0777,true);
	}
	if(!is_dir($cache_dir)){
		@mkdir($cache_dir,0777,true);
	}

	if(!INAJAX && $url_forward && empty($second)) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");
	} else {
		if(INAJAX) {
			if($url_forward && $url_forward!='-1') {
				if($url_forward == 'ref') {
					$url_forward = $_SERVER['HTTP_REFERER'];
				}
				$message = '<a href="'.$url_forward.'">'.$message.'</a>';
			}
			$message = '<DIV style="width:450px;text-align:center;font-size:14px; padding:30px 0 30px">'.$message.'</div><ajaxok>';
			$CI->tpl->xml_out($message);
		} else {
			if($url_forward) {
				if($url_forward == '-1') {
					$url_forward = $_SERVER['REQUEST_URI'];
				} else if($url_forward == 'ref') {
					$url_forward = $_SERVER['HTTP_REFERER'];
				}
				$url_forward = empty($url_forward) ? SITE_URL : $url_forward;
				$message = "<a href=\"$url_forward\" style=\"font-size:14px;\">{$message}</a>";
				$message .= "<script>setTimeout('window.location.href =\"$url_forward\";', ".($second*1000).");</script>";
			}
			
			$vars = array(
				'message' => $message,
				'url_forward' => $url_forward,
				'error' => $error,
				'cssimgpath' => PATH_IMAGES.'/showmessage'
			);
			
			$CI->tpl->assign($vars);
			$CI->tpl->display('showmessage.html');
		}
	}
	exit;
}

function pagenotfound(){
//	header("HTTP/1.1 404 Not Found");
	showmessage('抱歉，你所访问的页面不存在。', 0, 0, 1);
}

/**
 * 
 * @param $msgType
 * @param $msgTilte
 * @param $msgTodo
 * @param $msgBody
 * @example
	$msgTilte = '抱歉，你所访问的页面不存在。';
	$msgTodo = '可能是你输入的地址不正确。请检查你所输入的URL是否正确。';
	$msgBody = array('检查网址是否正确','到 <a href="#">首页</a>');
	showsuccess($msgTilte,$msgTodo,$msgBody);
 */
function throwmsg($msgType, $msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1) {

	$CI =& get_instance();
	tplinit();
	if($msgTilte == '') exit;

	$msgTypeArr = array('success','error','exclaimed','information','prohibition','question','sorry');
	if(!in_array($msgType,$msgTypeArr)) $msgType = 'information';

	$compile_dir = SMARTY_COMPILE_DIR.'/throwmsg/';
	$cache_dir = SMARTY_CACHE_DIR.'/throwmsg/';

	$CI->tpl->template_dir = SMARTY_TEMPLATES_DIR.'/throwmsg/';
	$CI->tpl->compile_dir = $compile_dir;
	$CI->tpl->cache_dir = $cache_dir;


	if(!is_dir($compile_dir)){
		mkdir($compile_dir,0777,true);
	}
	if(!is_dir($cache_dir)){
		mkdir($cache_dir,0777,true);
	}
	
	$vars = array(
		'msgTilte' => $msgTilte,
		'msgTodo' => $msgTodo,
		'msgType' => $msgType,
		'msgBody' => $msgBody,
		'cssimgpath' => PATH_IMAGES.'/throwmsg',
		'showhead' => $showhead,
		'showfoot' => $showfoot
	);

	$CI->tpl->assign($vars);
	$CI->tpl->display('throwmsg.html');
	exit;
}


//成功(绿色打钩符号)
function showsuccess($msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1){
	throwmsg('success', $msgTilte, $msgTodo, $msgBody, $showhead, $showfoot);
}
//错误(红色打叉符号)
function showerror($msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1){
	throwmsg('error', $msgTilte, $msgTodo, $msgBody, $showhead, $showfoot);
}
//惊叹/惊叫(黄色叹号)
function showexclaimed($msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1){
	throwmsg('exclaimed', $msgTilte, $msgTodo, $msgBody, $showhead, $showfoot);
}
//信息提示(蓝色“i”符号)
function showinformation($msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1){
	throwmsg('information', $msgTilte, $msgTodo, $msgBody, $showhead, $showfoot);
}
//禁止(红色“—”符号)
function showprohibition($msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1){
	throwmsg('prohibition', $msgTilte, $msgTodo, $msgBody, $showhead, $showfoot);
}
//询问(绿色问号符号)
function showquestion($msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1){
	throwmsg('question', $msgTilte, $msgTodo, $msgBody, $showhead, $showfoot);
}
//抱歉(双手摊开表情)
function showsorry($msgTilte, $msgTodo='', $msgBody=array(), $showhead=1, $showfoot=1){
	throwmsg('sorry', $msgTilte, $msgTodo, $msgBody, $showhead, $showfoot);
}
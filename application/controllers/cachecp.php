<?php
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-9-10下午02:29:17
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cachecp extends CI_Controller {
	
    public function __construct(){
    	parent::__construct();
    	ck_adminlogin();
    	set_module_title('缓存管理');
    }

    //全部缓存
	public function index(){
		$msgtype = 'ok';
		$message = array();
		if(submitcheck('all_cache_submit')){
			cache_update();
			$message[] = '全部缓存已经成功更新！';
    	}
    	$vars = array(
			'message' => $message,
			'msgtype' => $msgtype,
		);
		$this->tpl->assign($vars);
		set_page_title('更新全部缓存');
		$this->tpl->display();	
	}
	
	//内容分类缓存
	public function cms_category(){
		$msgtype = 'ok';
		$message = array();
		if(submitcheck('cms_category_cache_submit')){
			cache_update('tuijian_cms_category');
			$message[] = '缓存已经成功更新！';
    	}
    	$vars = array(
			'message' => $message,
			'msgtype' => $msgtype,
		);
		$this->tpl->assign($vars);
		set_page_title('更新内容分类缓存');
		$this->tpl->display();
	}
	
	//内容目录缓存
	public function cms_directory(){
		$msgtype = 'ok';
		$message = array();
		if(submitcheck('cms_directory_cache_submit')){
			cache_update('tuijian_cms_directory');
			$message[] = '内容目录缓存已经成功更新！';
    	}
    	$vars = array(
			'message' => $message,
			'msgtype' => $msgtype,
		);
		$this->tpl->assign($vars);
		set_page_title('更新内容目录缓存');
		$this->tpl->display();
	}
}
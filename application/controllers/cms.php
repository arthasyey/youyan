<?php
/**
 * @copyright	© 2009-2010 JiaThis Inc.
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-11-12
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

	/**
	 * 
	 * @var Cms_model
	 */
	public $cmsmod;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Cms_model', 'cmsmod');
	}
		
	public function html($seourl){
		
		$seourl = isset($seourl) ? $seourl : '';
		$cms = array();
		if(!empty($seourl)){
			$cms = $this->cmsmod->get_cms($seourl, 'seourl');
		}
		if(empty($cms)){
			showerror('你访问的内容不存在。');
		}
		$meta_description = getstr($cms['content'], 300, 0, 0, -1);
		
		$vars = array(
			'seourl' => $seourl,
			'cms' => $cms
		);
		$this->tpl->assign($vars);
		set_page_title($cms['subject']);
		set_meta_description($meta_description);
		$this->tpl->display();
	}
}
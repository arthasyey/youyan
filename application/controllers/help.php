<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {

	/**
	 * 
	 * @var Cms_model
	 */
	public $cms;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Cms_model', 'cmsmod');
	}
    
    public function index(){
        $this->html();
    }
    
	public function html($seourl='faq'){
		$seourl = isset($seourl) ? $seourl : '';
		$cms = FALSE;
		if(!empty($seourl)){
			$cms = $this->cmsmod->get_cms($seourl, 'seourl');
		}
		$message = '';
		if($cms === FALSE){
			$message = '服务器繁忙，请稍后访问。';
		} else if(empty($cms)) {
			$message = '你访问的帮助内容不存在。';
		}
		if(!empty($message)){
			showerror($message);
		}
		$cms['content'] = str_ireplace('{help_images_path}', $this->config->item('imgdir'), $cms['content']);
		
		//帮助目录
		$directory = $this->cmsmod->get_directory('help');

		$meta_description = getstr($cms['content'], 300, 0, 0, -1);
		$vars = array(
			'seourl' => $seourl,
			'directory' => $directory,
			'cms' => $cms
		);
		$this->tpl->assign($vars);
		set_page_title($cms['subject']);
		set_meta_description($meta_description);
		$this->tpl->display('help/index.html');
	}

}
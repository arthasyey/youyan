<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getcode extends CI_Controller{
    function __construct() {
        parent::__construct();
        if(!islogin()) {
        	$RTR =& load_class('Router');
        	$method = strtolower($RTR->fetch_method());
        	if(!in_array($_SERVER["PHP_SELF"], array('/index.php/getcode/wordpress/install', '/index.php/getcode/wordpress/install/online', '/index.php/getcode/wordpress/install/download'))) header('Location:'.SITE_URL.'/register/index/'.$method);
        }
        $this->load->model('cms_model', 'cmsmod');
    }
    
    public function index(){
    	$vars = array(
    		'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('获取代码');
    	$this->tpl->display();
    }
    
    public function wordpress($type, $seourl = 'online'){
    	if($type) {
    		$cms = $this->cmsmod->get_cms_byseourl($seourl);
    	} else {
        	$cms = $this->cmsmod->get_cms_byseourl('wordpress');
    	}
    	$vars = array(
            'codetype' => 'wordpress',
            'codecms' => $cms,
            'showcode' =>false
    	);
    	$this->tpl->assign($vars);
    	set_page_title('wordpress');
    	if($type) {
    		$this->tpl->display();
    	} else {
    		$this->tpl->display('getcode/index.html');
    	}
    }
    
    public function dedecms(){
    	$cms = $this->cmsmod->get_cms_byseourl('dedecms');
    	$vars = array(
    		'codetype' => 'dedecms',
    		'codecms' => $cms,
            'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('dedecms');
    	$this->tpl->display('getcode/index.html');
    }
    
    public function ecshop(){
    	$cms = $this->cmsmod->get_cms_byseourl('ecshop');
    	$vars = array(
    		'codetype' => 'ecshop',
    		'codecms' => $cms,
            'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('ecshop');
    	$this->tpl->display('getcode/index.html');
    }
    
    public function phpcms(){
    	$cms = $this->cmsmod->get_cms_byseourl('phpcms');
    	$vars = array(
    		'codetype' => 'phpcms',
    		'codecms' => $cms,
            'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('phpcms');
    	$this->tpl->display('getcode/index.html');
    }
    
    public function php168(){
    	$cms = $this->cmsmod->get_cms_byseourl('php168');
    	$vars = array(
    		'codetype' => 'php168',
    		'codecms' => $cms,
            'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('php168');
    	$this->tpl->display('getcode/index.html');
    }
    
    public function zblog(){
    	$cms = $this->cmsmod->get_cms_byseourl('zblog');
    	$vars = array(
    		'codetype' => 'zblog',
    		'codecms' => $cms,
            'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('zblog');
    	$this->tpl->display('getcode/index.html');
    }
    
    public function blogbus(){
    	$cms = $this->cmsmod->get_cms_byseourl('blogbus');
    	$vars = array(
    		'codetype' => 'blogbus',
    		'codecms' => $cms,
            'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('blogbus');
    	$this->tpl->display('getcode/index.html');
    }
    
    public function empirecms(){
    	$cms = $this->cmsmod->get_cms_byseourl('empirecms');
    	$vars = array(
    		'codetype' => 'empirecms',
    		'codecms' => $cms,
            'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('empirecms');
    	$this->tpl->display('getcode/index.html');
    }
    
    public function diandian(){
    	$cms = $this->cmsmod->get_cms_byseourl('diandian');
    	$vars = array(
    			'codetype' => 'diandian',
    			'codecms' => $cms,
    			'showcode' =>true
    	);
    	$this->tpl->assign($vars);
    	set_page_title('diandian');
    	$this->tpl->display('getcode/index.html');
    }
    
}
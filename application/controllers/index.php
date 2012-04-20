<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	/**
	 * 
	 * @var Test_model
	 */
	public $testmod;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Test_model', 'testmod');
	}
	
	public function index(){		
		$list = $this->testmod->get_list();
		
		$vars = array(
			'list' => $list,
		);
		$this->tpl->assign($vars);
		$this->tpl->display();
	}
	
	public function throwmsg(){
		$msgTilte = '对不起，该网页内可能含有不符合规定内容，不能转发！';
		$msgTodo = '根据相关法律，JiaThis禁止为提供政治、色情、宗教、民族、暴力、煽动等内容的网站提供转发服务！ ';
		$msgBody = array(
			'<a href="'.SITE_URL.'">&raquo;返回首页</a>',
			'<a href="'.SITE_URL.'/index/showmsg">&raquo;信息提示</a>'
		);
		showprohibition($msgTilte, $msgTodo, $msgBody, 0, 0);
	}
	
	public function showmsg(){
		showmessage(ICON_OK.'成功。', 0);
//		showmessage('跳转', SITE_URL.'/index/throwmsg');
	}
}
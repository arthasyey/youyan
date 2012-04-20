<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
        set_page_title("看好第三方社交评论系统！JiaThis宣布收购友言");
		$this->tpl->display();
	}

}
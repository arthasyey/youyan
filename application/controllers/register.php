<?php
class Register extends CI_Controller {
    
  function __construct(){
    parent::__construct();
  }
  
  function index($info = ''){
    $vars = array(
            'clickType' =>'getcode',
            'info' => $info,
    );
    
    $this->tpl->assign($vars);
    set_page_title("登录注册");
    $this->tpl->display();
  }
  
}
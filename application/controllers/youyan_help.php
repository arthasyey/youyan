<?php
//session_start();
class YouYan_Help extends CI_Controller {

  function __construct(){
    parent::__construct();
    session_start();
  }

  function index($name = ''){
  	$RTR =& load_class('Router');
	$class  = strtolower($RTR->fetch_class());
	$method = strtolower($RTR->fetch_method());
	
    if($name){
        $this->load->view($name, array('class' => $class, 'method' => $method, 'name' => $name));
    }else{
        $this->load->view('youyan_help_view', array('class' => $class, 'method' => $method, 'name' => $name));
    }
  }
  
  function wp_install(){
    $this->load->view('youyan_wp_install_view');
  }
  
  function wp_setting(){
    $this->load->view('youyan_wp_setting_view');
  }
  
  function wp_manage(){
    $this->load->view('youyan_wp_manage_view');
  }
  
  function general(){
  	header('Location:'.SITE_URL.'/getcode');
    $this->load->model('user_model');
    $this->user_model->isAutoLogin();
    if(!isset($_SESSION['uid'])||$_SESSION['uid']==''){
      $url = "/index.php/youyan_register";
      Header("HTTP/1.1 303 See Other");
      Header("Location: $url");
      exit;
    }
    $this->load->view('youyan_general_view');
  }
  
    function register(){
    $this->load->view('youyan_register_view');
  }
}

?>

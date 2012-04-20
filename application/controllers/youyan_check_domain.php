<?php
//session_start();


/**
 * 要求用户验证域名的逻辑
 */
class YouYan_Check_Domain extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('webdata_model');
  }
  function index(){
    $this->load->model('user_model');
    $this->user_model->isAutoLogin();
    if(!isset($_SESSION['uid'])||$_SESSION['uid']==''||!isset($_SESSION['showDomain'])||$_SESSION['showDomain']==''){
      $url = "/";
      Header("HTTP/1.1 303 See Other");
      Header("Location: $url");
      exit;
    }
    $this->load->model('webdata_model');
	$verify_state = $this->webdata_model->getVerify();
    $domainURL = $_SESSION['showDomain'];
    $data['verify'] = $verify_state;
	$data['domain'] = $domainURL;
    $data['main_content'][0] = 'youyan_check_domain_view';
    $this->load->view('include/template',$data);
  }

}
?>

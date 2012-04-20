<?php
/**
 * 网站主登陆后选择网站列表的界面
 */

//session_start();
class YouYan_Admin_Pre extends CI_Controller {

  function __construct(){
    parent::__construct();
  }

  function index(){
    $this->load->model('user_model');
    $this->user_model->isAutoLogin();
    if(!isset($_SESSION['uid'])||$_SESSION['uid']==''){
      $url = "http://uyan.cc";
      Header("HTTP/1.1 303 See Other");
      Header("Location: $url");
      exit;  
    }
    $this->load->model('webdata_model');
    $comment_domain = $this->webdata_model->geturlList();
    $data['title'] = '网站管理';
    $data['domainContent'] =  $comment_domain;
    $data['main_content'][0] = 'youyan_admin_pre_view';
    $this->load->view('include/template',$data);
  }
}

?>

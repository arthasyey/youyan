<?php
session_start();
class YouYan_Main extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('comment_model');
    $this->load->model('webdata_model');
  }

  /**
   * 对评论者的个人主页
   */

  function index($currentSelect = 'article'){

    if(!isset($_SESSION['login'])||$_SESSION['login']==''){
      $url = "/";
      Header("HTTP/1.1 303 See Other");
      Header("Location: $url");
      exit;
    }
    $this->load->model('comment_model');
    
	$data['uid'] = $_SESSION['login']['youyan']['id'];
	
	$this->load->model('user_model');
	$data['userData'] = $this->user_model->getTargetUserProfile($data['uid']);
	$data['likeWeb'] = $this->user_model->getTargetUserWebsite($data['uid']);
	$this->load->model('webdata_model');
	//$data['notiNews'] = $this->webdata_model->getNotificationNews($data['uid']);
	$data['notList'] = $this->webdata_model->getNotificationList($data['uid']);
	$data['reply'] = $this->webdata_model->getNotificationMain($data['uid']);
	$data['likeNoti'] = $this->webdata_model->getNotificationLike($data['uid']);
	$data['currentSelect'] = $currentSelect;
	$data['userType']= 'user';
	$data['main_content'][0] = 'youyan_main_view';
    $this->load->view('include/template',$data);
  }


}
?>

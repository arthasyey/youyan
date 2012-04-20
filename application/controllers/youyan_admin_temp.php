<?php
/**
 * 管理员发放页面临时管理权限的逻辑
 */
class YouYan_Admin_Temp extends CI_Controller {
function __construct(){
    parent::__construct();
    $this->load->model('comment_model');
    $this->load->model('webdata_model');
}
function index($secret_str){
	$from_item = 0;
    $this->load->model('user_model');
    $this->user_model->isAutoLogin();
	//check current state
	$checkSecret = $this->webdata_model->checkSecret($secret_str);  
	if($checkSecret==0){
      $url = "/";
      Header("HTTP/1.1 303 See Other");
      Header("Location: $url");
      exit;		
	}else{
		if(!isset($_SESSION["uid"])){
			$_SESSION["uid"]=25;
		}
		if(!isset($_SESSION['uname'])){
			$_SESSION['uname']='编辑帐户';
		}
		$page = $checkSecret['page'];
		if($checkSecret['page']==''){
		  $url = "/";
		  Header("HTTP/1.1 303 See Other");
		  Header("Location: $url");
		  exit;
		}
		
		$this->load->model('comment_model');
		$this->load->model('webdata_model');
		$comment_arr = $this->webdata_model->getDomainByPage($page);
		$_SESSION['showDomain'] = $comment_arr['domain'];
    	$domainURL = $_SESSION['showDomain'];
    //$domainURL = 'localhost';
	
	
    $comment_domain = $this->comment_model->getCommentsByDomain($domainURL,0);    
    $pagination_domain = $this->webdata_model->domainCommentsPagination();
    $verify_state = $this->webdata_model->getVerify();
	$article_domain = $this->webdata_model->getArticleByDomain($domainURL,$from_item);

    $data['verify'] = $verify_state;
    $data['main_content'][0] = 'youyan_admin_temp_view';
    $data['domain_information'][0] = $domainURL;
    $data['current_domain'] = $domainURL;  
    $data['comment_domain'] = $comment_domain;
    $data['pagination'] = $pagination_domain;
	$data['pageInfo'] = $checkSecret;
    $this->load->view('include/template',$data);
	
	}
}
function getMoreCommentsByDomain($from_num){
	  $this->load->model('comment_model');
	  $domainURL = $_SESSION['showDomain'];
	  echo json_encode( $this->comment_model->getCommentsByDomain($domainURL,$from_num));
}
}
?>

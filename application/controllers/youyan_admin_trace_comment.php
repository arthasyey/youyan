<?php
//session_start();

/**
 * 按照评论统计逻辑
 */

class YouYan_Admin_Trace_Comment extends CI_Controller {
  function __construct(){
    parent::__construct();
	$this->load->model('webdata_model');
  }
  function index($from_item = 0){
	$this->load->model('webdata_model');
	$domainURL = $_SESSION['showDomain'];
	$verify_state = $this->webdata_model->getVerify();
	$data['verify'] = $verify_state;
	if($verify_state!='1'){
		$objArray = array ( "domain" => '' , "n_pages" => 0 , "n_users" => 0 , "n_comments" => 0 , "n_sina_users" => 0 , "n_sina_comments" => 0 , "n_renren_users" => 0 , "n_renren_comments" => 0 , "n_tencent_users" => 0 , "n_tencent_comments" => 0 , "n_sohu_users" => 0 , "n_sohu_comments" => 0 , "n_neteasy_users" => 0 , "n_neteasy_comments" => 0 , "n_douban_users" => 0 , "n_douban_comments" => 0 , "n_qq_users" => 0 , "n_qq_comments" => 0 , "n_kaixin_users" => 0 , "n_kaixin_comments" => 0  ) ;	  
		$object =(object)$objArray ;
		$data['basic_domain'] =  array( "0" => $object );		
		$data['fav_user'] = array();
		$data['visited_user'] = array();
		$data['pagination'] = '';
		$commentArray = array("n_comments_all" => 0, "n_comments" => 0, "traceamount" =>0,"domain" => "" );
		$commentObject = (object)$commentArray;
		$data['domainTrace'] = array( "0" => $commentObject );		
		$commentItemArray = array("comment_id" => '', "from_type" => '', "page" => '', "page_url" =>  '', "domain" => '', "page_title" => 'Sample' , "user_id" => 15 , "content" => 'Sample' , "time" => '', "sina_url" => '', "tencent_t_url" => '', "sohu_t_url" => '', "neteasy_t_url" => '', "n_up" => 0 , "n_down" => 0 , "reply_to_comment_id" => 0 , "del" => 0 , "comment_author" => '', "comment_author_email" => '', "comment_author_url" => '', "notified" => 0 , "hotness" => 1 , "IP" => '', "wp_import_export_id" => -1 , "sina_trace_id" => 0 , "tencent_trace_id" => 0 , "renren_trace_id" => 0 , "kaixin_trace_id" => 0 , "neteasy_trace_id" => 0 , "sohu_trace_id" => 0 , "qq_trace_id" => 0 , "veryfy_status" => 0 , "traceid" => '', "traceamount" => '', "user_name" => '', "show_name" => '', "profile_img" =>  '', "password" =>'', "email" => '', "sina_id" => '' , "sina_access_token" => '', "sina_access_secret" =>'', "sina_show_name" => '', "sina_profile_img" => '' , "renren_id" => 0 , "renren_access_token" => '', "renren_refresh_token" => '', "renren_show_name" => '', "renren_profile_img" => '', "tencent_id" => '', "tencent_access_token" => '', "tencent_access_secret" =>'' , "tencent_show_name" => '', "tencent_profile_img" => '', "qq_id" => '', "qq_access_token" => '', "qq_access_secret" => '', "qq_show_name" => '', "qq_profile_img" => '', "kaixin_id" => 0 , "kaixin_access_token" => '', "kaixin_access_secret" => '', "kaixin_show_name" => '', "kaixin_profile_img" => '', "sohu_id" => 0 , "sohu_access_token" => '', "sohu_access_secret" => '', "sohu_show_name" => '', "sohu_profile_img" =>'', "neteasy_id" => '', "neteasy_access_token" => '', "neteasy_access_secret" => '', "neteasy_show_name" => '', "neteasy_screen_name" => '', "neteasy_profile_img" => '', "douban_id" => 0 , "douban_access_token" => '', "douban_access_secret" => '', "douban_show_name" => '', "douban_profile_img" => '', "taobao_id" => 0 , "alipay_id" => 0 , "cellphone" => 0 , "valid" => 0 , "register_date" => 2011-08-25 , "n_comments" => 0 , "n_comments_all" => 0 , "n_sina_comments" => 0 , "n_renren_comments" => 0 , "n_tencent_comments" => 0 , "n_qq_comments" => 0 , "n_sohu_comments" => 0 , "n_neteasy_comments" => 0 , "n_kaixin_comments" => 0 , "n_anon_comments" => 0);
		$commentItemObject = (object)$commentItemArray;
		$data['commentTrace'] =array( "0" => $commentItemObject );
	}else{
		$basic_domain = $this->webdata_model->getDomainBasicInformation($domainURL);
		$data['basic_domain'] = $basic_domain;
		$fav_user_domain = $this->webdata_model->getFavUser($domainURL);
		$data['fav_user'] = $fav_user_domain;
		$visited_user_domain = $this->webdata_model->getLastVisitedUser($domainURL);		
		$data['visited_user'] = $visited_user_domain;	
		$pagination_domain = $this->webdata_model->domainTracePagination('comment');
		$data['pagination'] = $pagination_domain;
		$pageDomain = $this->webdata_model->getTraceDomain($domainURL);
		$data['domainTrace'] = $pageDomain;
		$commentTrace = $this->webdata_model->getTraceComment($domainURL,$from_item);	
		$data['commentTrace'] = $commentTrace;
	}
    $data['main_content'][0] = 'youyan_admin_trace_comment_view';	
    $this->load->view('include/template',$data);
  }
}
?>

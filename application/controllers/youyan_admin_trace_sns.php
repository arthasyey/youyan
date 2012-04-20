<?php
//session_start();
/**
 * 按照社交网络统计逻辑
 */

class YouYan_Admin_Trace_SNS extends CI_Controller {
  function __construct(){
    parent::__construct();
	$this->load->model('webdata_model');
  }
  function index($from_item = 0){
	$this->load->model('webdata_model');
	$domainURL = $_SESSION['showDomain'];
	

	//added
	
	$verify_state = $this->webdata_model->getVerify();
	$data['verify'] = $verify_state;
	
	if($verify_state!='1'){
      $objArray = array ( "domain" => '' , "n_pages" => 0 , "n_users" => 0 , "n_comments" => 0 , "n_sina_users" => 0 , "n_sina_comments" => 0 , "n_renren_users" => 0 , "n_renren_comments" => 0 , "n_tencent_users" => 0 , "n_tencent_comments" => 0 , "n_sohu_users" => 0 , "n_sohu_comments" => 0 , "n_neteasy_users" => 0 , "n_neteasy_comments" => 0 , "n_douban_users" => 0 , "n_douban_comments" => 0 , "n_qq_users" => 0 , "n_qq_comments" => 0 , "n_kaixin_users" => 0 , "n_kaixin_comments" => 0  ) ;	  
      $object =(object)$objArray ;
      $data['basic_domain'] =  array( "0" => $object );
      $data['fav_user'] = array();
      $data['visited_user'] = array();
	  $snsArray = array ("domain" => '' , "n_pages" => 0 , "n_users" => 0 , "n_comments" => 0 , "n_comments_all" => 0 , "n_sina_users" => 0 , "n_sina_comments" => 0 , "n_renren_users" => 0 , "n_renren_comments" => 0 , "n_tencent_users" => 0 , "n_tencent_comments" => 0 , "n_sohu_users" => 0 , "n_sohu_comments" => 0 , "n_neteasy_users" => 0 , "n_neteasy_comments" => 0 , "n_douban_users" => 0 , "n_douban_comments" => 0 , "n_qq_users" => 0 , "n_qq_comments" => 0 , "n_kaixin_users" => 0 , "n_kaixin_comments" => 0 , "n_email_users" => 0 , "n_email_comments" => 0 , "n_wordpress_comments" => 0 , "width" => 0 , "numLimit" => 0 , "numCommentsPerPage" => 0 , "commentStyle" => 0 , "digName" => '', "digDownName" => '', "mailNotify" => 0 , "descWord" => '', "delStyle" => 0 , "supportAnon" => 0 , "defaultSort" => 0 , "SINA_APP_KEY" => '', "SINA_APP_SECRETE" => '', "SINA_ACCESS_TOKEN" => '', "SINA_ACCESS_SECRETE" => '', "anon_word" => '', "account_order" => 0 , "anon_url" => '', "display_name" => '', "from_type" => 'Sample' , "traceamount" => 0 );
	  $snsObject =(object)$snsArray ;
	  $data['snsTrace'] =  array( "0" => $snsObject );
	  $snsTotalArray = array("n_comments_all" => 0, "n_comments" => 0, "traceamount" => 0, "domain" => '');
	  $snsTotalObject =(object)$snsTotalArray ; 
	  $data['domainTrace'] =  array( "0" => $snsTotalObject );
	}else{
		$basic_domain = $this->webdata_model->getDomainBasicInformation($domainURL);
		$data['basic_domain'] = $basic_domain;
		$fav_user_domain = $this->webdata_model->getFavUser($domainURL);
		$data['fav_user'] = $fav_user_domain;
		$visited_user_domain = $this->webdata_model->getLastVisitedUser($domainURL);
		$data['visited_user'] = $visited_user_domain;
		$snsTrace = $this->webdata_model->getTraceSNS($domainURL,$from_item);
		$data['snsTrace'] = $snsTrace;
		$pageDomain = $this->webdata_model->getTraceDomain($domainURL);
		$data['domainTrace'] = $pageDomain;
	}
	//end
    $data['main_content'][0] = 'youyan_admin_trace_sns_view';
	
	
    $this->load->view('include/template',$data);
  }
}
?>

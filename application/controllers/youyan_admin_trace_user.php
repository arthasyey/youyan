<?php
/**
 * 按照用户统计逻辑
 */


class YouYan_Admin_Trace_User extends CI_Controller {
  function __construct(){
    parent::__construct();
	$this->load->model('webdata_model');
  }

  function initialize_remote_info(){
    $_SESSION['uid'] = $_GET['uid'];
    $_SESSION['uname'] = $_GET['uname'];
    $domain = $_GET['domain'];

    $_SESSION['showDomain'] = $domain;

    $sql = "select * from domain where domain='$domain'";
    $query = $this->db->query($sql);
    $row = $query->row_array();
    $_SESSION['domain_data'] = $row;
  }


  function index($from_item = 0){
    if(isset($_GET['uid']) and isset($_GET['uname'])){
      echo 'initialize';
      $this->initialize_remote_info();
    }

	$this->load->model('webdata_model');
	$domainURL = $_SESSION['showDomain'];

$verify_state = $this->webdata_model->getVerify();
	$data['verify'] = $verify_state;

	
	//end
	if($verify_state!='1'){
      $data['comment_domain'] = array();
      $objArray = array ( "domain" => '' , "n_pages" => 0 , "n_users" => 0 , "n_comments" => 0 , "n_sina_users" => 0 , "n_sina_comments" => 0 , "n_renren_users" => 0 , "n_renren_comments" => 0 , "n_tencent_users" => 0 , "n_tencent_comments" => 0 , "n_sohu_users" => 0 , "n_sohu_comments" => 0 , "n_neteasy_users" => 0 , "n_neteasy_comments" => 0 , "n_douban_users" => 0 , "n_douban_comments" => 0 , "n_qq_users" => 0 , "n_qq_comments" => 0 , "n_kaixin_users" => 0 , "n_kaixin_comments" => 0  ) ;	  
      $object =(object)$objArray ;
      $data['basic_domain'] =  array( "0" => $object );
      $data['fav_user'] = array();
      $data['visited_user'] = array();
      $data['pagination'] = '';
	  $domainTraceArray = array("n_comments_all"=> 0, "n_comments" => 0, "traceamount" => 0, "domain"=>'' );
	  $domainTrace =(object)$domainTraceArray ;
	  $data['domainTrace'] = array ( "0" => $domainTrace ) ;
	  $userTraceArray = array("show_name"=> 'Sample',"user_id"=>1, "usercommentamount"=>0, "traceamount"=>0 );
	  $userTrace = (object)$userTraceArray;
	  $data['userTrace'] = array("0" => $userTrace);		
	}else{
		$basic_domain = $this->webdata_model->getDomainBasicInformation($domainURL);
		$data['basic_domain'] = $basic_domain;
		$fav_user_domain = $this->webdata_model->getFavUser($domainURL);
		$data['fav_user'] = $fav_user_domain;
		$visited_user_domain = $this->webdata_model->getLastVisitedUser($domainURL);		
		$data['visited_user'] = $visited_user_domain;
		$pagination_domain = $this->webdata_model->domainTracePagination('user');
		$data['pagination'] = $pagination_domain;
		$pageDomain = $this->webdata_model->getTraceDomain($domainURL);
		$data['domainTrace'] = $pageDomain;
		$userTrace = $this->webdata_model->getTraceUsers($domainURL,$from_item);
		$data['userTrace'] = $userTrace;
	}
	
    $data['title'] = '统计与分析';	
    $data['main_content'][0] = 'youyan_admin_trace_user_view';
	
    $this->load->view('include/template',$data);
  }
}
?>

<?php
/**
 * 评论管理页面的逻辑
 */

class YouYan_Admin extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('comment_model');
    $this->load->model('webdata_model');
  }


  /**
   * 获取网站基本信息
   */
  function initialize_remote_info(){
    $_SESSION['uid'] = $_GET['uid'];
    $_SESSION['uname'] = $_GET['uname'];
    $domain = $_GET['domain'];

    $_SESSION['showDomain'] = $domain;

    $sql = "select * from domain where domain='$domain'";
    $query = $this->db->query($sql);
    $row = $query->row_array();
    $_SESSION['domain_data'] = $row;
    //var_dump($_SESSION);
  }


  /**
   * 获取评论（从$from_item 开始)
   */
  function index($from_item = 0){
    if(isset($_GET['uid']) and isset($_GET['uname'])){
      echo 'initialize';
      $this->initialize_remote_info();
    }

    $this->load->model('user_model');
    $this->user_model->isAutoLogin();
    if(!isset($_SESSION['uid'])||$_SESSION['uid']==''||!isset($_SESSION['showDomain'])||$_SESSION['showDomain']==''){
      $url = "/";
      Header("HTTP/1.1 303 See Other");
      Header("Location: $url");
      exit;
    }
    $this->load->model('comment_model');
    $this->load->model('webdata_model');
    $domainURL = $_SESSION['showDomain'];
    //$domainURL = 'localhost';
    $comment_domain = $this->comment_model->getCommentsByDomain($domainURL,0);    
    $pagination_domain = $this->webdata_model->domainCommentsPagination();
    $verify_state = $this->webdata_model->getVerify();
	
	$article_domain = $this->webdata_model->getArticleByDomain($domainURL,$from_item);

    $data['verify'] = $verify_state;
    $data['main_content'][0] = 'youyan_admin_view';
    $data['domain_information'][0] = $domainURL;
    $data['current_domain'] = $domainURL;

    $data['UYUserID'] = $_SESSION['uid'];

    if($verify_state!='1'){
      $data['comment_domain'] = array();
      $object = new stdClass(); 
      $objArray = array ( "domain" => '' , "n_pages" => 0 , "n_users" => 0 , "n_comments" => 0 , "n_sina_users" => 0 , "n_sina_comments" => 0 , "n_renren_users" => 0 , "n_renren_comments" => 0 , "n_tencent_users" => 0 , "n_tencent_comments" => 0 , "n_sohu_users" => 0 , "n_sohu_comments" => 0 , "n_neteasy_users" => 0 , "n_neteasy_comments" => 0 , "n_douban_users" => 0 , "n_douban_comments" => 0 , "n_qq_users" => 0 , "n_qq_comments" => 0 , "n_kaixin_users" => 0 , "n_kaixin_comments" => 0  ) ;	  
      $object =(object)$objArray ;
	  
	  $articleArray =  array ( "page" => '' , "page_url" =>'' , "page_title" => '' , "n_users" => 0 , "n_comments" => 0 , "n_comments_all" => 0 , "n_sina_users" => 0 , "n_sina_comments" => 0 , "n_renren_users" => 0 , "n_renren_comments" => 0 , "n_tencent_users" => 0 , "n_tencent_comments" => 0 , "n_neteasy_users" => 0 , "n_neteasy_comments" => 0 , "n_douban_users" => 0 , "n_douban_comments" => 0 , "n_qq_users" => 0 , "n_qq_comments" => 0 , "n_kaixin_users" => 0 , "n_kaixin_comments" => 0 , "n_sohu_users" => 0 , "n_sohu_comments" => 0, "n_email_users" => 0 , "n_email_comments" => 0, "n_wordpress_comments" => 0 , "domain" => '' , "time" => '2011-09-07' ) ;		  
	  $object_article = (object)$articleArray ;
      $data['basic_domain'] =  array( "0" => $object );
      $data['fav_user'] = array();
      $data['visited_user'] = array();
      $data['pagination'] = '';	
	  $data['article_domain'] = array( "0" => $object_article );

    }else{
      $data['comment_domain'] = $comment_domain;
	  $data['article_domain'] = $article_domain;	 
      $data['pagination'] = $pagination_domain;
    }
    $data['title'] = '评论管理';	
    $this->load->view('include/template',$data);
  }


  /**
   * 某个网站的评论
   */
  function getMoreCommentsByDomain($from_num){
	  $this->load->model('comment_model');
	  $domainURL = $_SESSION['showDomain'];
	  echo json_encode( $this->comment_model->getCommentsByDomain($domainURL,$from_num));
  }

  /**
   * 某个页面的评论
   */
  function getMoreCommentsByPage($from_num){
	  $this->load->model('comment_model');
	  $domainURL = $_SESSION['showDomain'];
	  echo json_encode( $this->comment_model->getCommentsByPage($domainURL,$from_num));	  
  }
}
?>

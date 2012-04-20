<?php
//session_start();
/**
 * 统计逻辑
 */

class YouYan_Admin_Trace extends CI_Controller {
  function __construct(){
    parent::__construct();
	$this->load->model('webdata_model');
  }
  function index($from_item = 0){
	$this->load->model('webdata_model');
	$domainURL = $_SESSION['showDomain'];
	$pageTrace = $this->webdata_model->getTracePages($domainURL,$from_item);
	$pageDomain = $this->webdata_model->getTraceDomain($domainURL);
	$pagination_domain = $this->webdata_model->domainTracePagination('page');
	$verify_state = $this->webdata_model->getVerify();
	$data['verify'] = $verify_state;
    $data['main_content'][0] = 'youyan_admin_trace_view';
	$data['pageTrace'] = $pageTrace;
	$data['domainTrace'] = $pageDomain;
	$data['pagination'] = $pagination_domain;
    $this->load->view('include/template',$data);
  }
}
?>

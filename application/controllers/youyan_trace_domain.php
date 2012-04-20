<?php
class YouYan_Trace_Domain extends CI_Controller {

  /**
   * 跟踪某一网站信息
   */
  function __construct(){
    parent::__construct();
  }
  function index($from_item = 'user'){
	$data['main_content'] = 'youyan_trace_domain_view';	
	$data['type'] = $from_item;
	$this->load->view('youyan_trace_domain_view',$data);
  }
}
?>

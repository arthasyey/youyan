<?php

/**
 * 网站主信息查询
 */
class YouYan_Trace_Master extends CI_Controller {
  function __construct(){
    parent::__construct();
  }
  function index(){
	$data['main_content'] = 'youyan_trace_master_view';	  			
	$this->load->view('youyan_trace_master_view',$data);
  }
}
?>

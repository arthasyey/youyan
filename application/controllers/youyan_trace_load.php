<?php

/**
 * 跟踪PV等数据
 */
class YouYan_Trace_Load extends CI_Controller {
  function __construct(){
    parent::__construct();
  }
  function index(){
	$data['main_content'] = 'youyan_trace_load_view';	
	$this->load->view('youyan_trace_load_view',$data);
  }
}
?>

<?php
class YouYan_Trace extends CI_Controller {

  /**
   * 整体跟踪功能
   */
  function __construct(){
    parent::__construct();
  }
  function index(){
	$data['main_content'] = 'youyan_trace_view';	  			
	$this->load->view('youyan_trace_view',$data);
  }

  function view(){

  }
}
?>

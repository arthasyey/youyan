<?php
class YouYan_Trace_Comment extends CI_Controller {
  /**
   * 跟踪评论统计
   */
  function __construct(){
    parent::__construct();
  }
  function index(){
	$data['main_content'] = 'youyan_trace_comment_view';	  			
	$this->load->view('youyan_trace_comment_view',$data);
  }
}
?>

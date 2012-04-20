<?php
class YouYan_Email_Done extends CI_Controller {
  function __construct(){
    parent::__construct();
  }

  /**
   * 群发邮件完成
   */
  function index(){
	$data['main_content'] = 'youyan_email_done_view';	  			
	$this->load->view('youyan_email_done_view',$data);
  }
}
?>

<?php
class YouYan_Email extends CI_Controller {

  function __construct(){
    parent::__construct();
  }


  /**
   * 群发邮件
   */
  function index(){
	$data['main_content'] = 'youyan_email_view';	  			
	$this->load->view('youyan_email_view',$data);
  }
}
?>

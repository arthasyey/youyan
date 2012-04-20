<?php
//session_start();
class YouYan_upload_image extends CI_Controller {

  /**
   * 上传头像
   */
  function __construct(){
    parent::__construct();	
  }

  function index(){
    session_start();
    $this->load->view('youyan_upload_image_view');

  }

}

?>

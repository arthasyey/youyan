<?php
session_start();
class YouYan_Middle_Frame extends CI_Controller {
  function __construct(){
    parent::__construct();
  }

  /**
   * 跨域中间页
   */
  function index(){
    $this->load->view('youyan_middle_frame_view');
    $_SESSION['uyan_remote'] = true;
  }
}
?>

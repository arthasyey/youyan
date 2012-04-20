<?php
session_start();
class YouYan_WP_Admin_Frame extends CI_Controller {

  /**
   * 插件跨域中间页
   */
  function __construct(){
    parent::__construct();
  }
  function index(){
    $_SESSION['uyan_remote'] = true;
    $this->load->view('youyan_wp_admin_frame_view');
  }
}
?>

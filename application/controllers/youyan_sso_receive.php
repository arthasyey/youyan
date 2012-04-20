<?php
class YouYan_SSO_Receive extends CI_Controller {

  function __construct(){
    parent::__construct();
  }
  function index(){
	$this->load->view('youyan_sso_receive_view');
  }
}
?>

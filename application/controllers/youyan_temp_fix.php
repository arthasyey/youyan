<?php
//session_start();
class YouYan_Temp_Fix extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('comment_model');
    $this->load->model('webdata_model');
  }
  function index(){
	$this->load->model('webdata_model');
 	$this->webdata_model->fixLikeNum();
  }
}
?>

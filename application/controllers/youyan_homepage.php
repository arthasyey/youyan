<?php
//session_start();
class YouYan_Homepage extends CI_Controller {

  function __construct(){
    parent::__construct();
	$this->load->model('user_model');
  }


  /**
   * 主页
   */
  function index(){
    session_start();
	$this->load->model('user_model');
	$this->user_model->isAutoLogin();
    $this->db->set('count', 'count+1', false);
    $this->db->where('page', 'youyan_homepage')->update('page_view');
    //$data['main_content'][0] = 'youyan_homepage_view';
    $this->load->view('youyan_homepage_view');

  }

}

?>

<?php
session_start();
class YouYan_register extends CI_Controller {

  /**
   * 注册友言功能
   */
  function __construct(){
    parent::__construct();
    $this->load->model('user_model');
  }
  function index(){
    $data['main_content'][0] = 'youyan_register_view';
    $data['clickType'] = 'getcode';
    $data['info'] = trim(isset($_GET['info']) ? $_GET['info'] : '');
    $this->load->view('youyan_register_view',$data);
  }
}

?>

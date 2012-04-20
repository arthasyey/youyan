<?php
//session_start();
class YouYan_Backpassword extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('webdata_model');
  }

  function index($from_item = 0){

    $this->load->model('webdata_model');

    $data['main_content'][0] = 'youyan_backpassword_view';

    $this->load->view('youyan_backpassword_view.php');
  }

}
?>

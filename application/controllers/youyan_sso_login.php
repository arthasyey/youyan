<?php
session_start();
class YouYan_SSO_Login extends CI_Controller {
  function __construct(){
    parent::__construct();
  }

  /**
   * 单点登录功能页
   */
  function index(){
    $sso_info = json_decode($_POST['sso_info'], true);
    
    $sso_id = $sso_info['sso_name'] . '_' . $sso_info['id'];
    $this->load->model('user_model'); 
    if($this->user_model->user_exist('sso_id', $sso_id)){
      $login_query_result = $this->user_model->login(false, 'sso_id', $sso_id);
      //var_dump($login_query_result);
      $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
    }
    else{
      $new_user_id = $this->user_model->create_user('sso', $sso_info);
      $login_query_result = $this->user_model->login(false, 'sso_id', $new_user_id);
      //var_dump($login_query_result);
      $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
    }

    echo json_encode($_SESSION['login']);
    //var_dump($sso_info);
  }
}

?>

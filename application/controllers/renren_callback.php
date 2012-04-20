<?php
/**
 * 人人网登陆回调逻辑
 */

session_start();
include_once( APPPATH.'inc/renren_config.php');
include_once( APPPATH.'sdk/RESTClient.class.php');
include_once( APPPATH.'sdk/RenRenOauth.class.php');
include_once( APPPATH.'sdk/RenRenClient.class.php');


class Renren_CallBack extends CI_Controller{

  function index(){
    $renren_o = new RenrenOauth; 
    $access_token_ret = $renren_o->getAccessToken($_REQUEST['code']);
    $session_key = $renren_o->getSessionKey($access_token_ret['access_token']);

    //var_dump($access_token_ret);
    //var_dump($session_key);

    $needBindWithYouYan = 0;

    $renren_id = $session_key['user']['id'];
    $renren_access_token = $access_token_ret['access_token'];
    $renren_refresh_token = $access_token_ret['refresh_token'];
    $renren_session_key = $session_key['renren_token']['session_key'];

    $client = new RenRenClient();
    $client->setSessionKey($renren_session_key);
    $info = $client->POST('users.getInfo', array($renren_id, 'tinyurl,name'));
    //var_dump($info);

    $this->load->model('user_model');

    $metadata = array(
      'renren_id' => $session_key['user']['id'],
      'renren_access_token' => $renren_access_token,
      'renren_refresh_token' => $renren_refresh_token,
      'renren_profile_img' => $info[0]['tinyurl'],
      'renren_show_name' => $info[0]['name']
    );

    $single_account = false;

    if($_SESSION['renren_callback_type'] == 'login'){
      if($this->user_model->user_exist('renren_id', $renren_id)){
        $single_account = false;
        $login_query_result = $this->user_model->login(false, 'renren_id', $renren_id);
        //echo 'user ' . $sina_id . ' exist!';
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
        $_SESSION['login']['renren']['access_token'] = $renren_access_token;
        $_SESSION['login']['renren']['session_key'] = $renren_session_key;
      }

      // If renren account not in the database, create new account and log in with 
      // the new account
      else{
        $new_user_id = $this->user_model->create_user('renren', $metadata);
        $_SESSION['login']['renren'] = array('id' => $renren_id, 'access_token' => $renren_access_token, 'refresh_token' => $renren_refresh_token, 'session_key' => $renren_session_key);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'show_name' => $info[0]['name'], 'profile_img' => $info[0]['tinyurl']);

        /*$needBindWithYouYan = 1;
        $_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'renren';*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['renren'] = array('id' => $renren_id, 'access_token' => $renren_access_token, 'refresh_token' => $renren_refresh_token, 'session_key' => $renren_session_key);
      $_SESSION['login']['renren']['session_key'] = $renren_session_key;
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'renren', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"renren":' . json_encode($_SESSION['login']['renren']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    //$data['main_content'] = 'youyan_callback_view';
    $this->load->view('youyan_callback_view', $data);
  }
}
?>


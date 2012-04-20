<?php
/**
 * 腾讯微薄登陆回调逻辑
 */

session_start();
include_once( APPPATH. 'inc/tencent_config.php');
include_once( APPPATH. 'sdk/tencent/tencentOAuth.php');
require_once( APPPATH. 'sdk/tencent/tencentClient.php');


class Tencent_CallBack extends CI_Controller{

  function index(){
    $tencent_o = new MBOpenTOAuth(TENCENT_AKEY, TENCENT_SKEY, $_SESSION['tencent_request_token']['oauth_token'], $_SESSION['tencent_request_token']['oauth_token_secret']);
    $access_token = $tencent_o->getAccessToken($_REQUEST['oauth_verifier']);

    //var_dump($access_token);
    $tencent_id = $access_token['name'];
    
    $tencent_c = new MBApiClient( TENCENT_AKEY , TENCENT_SKEY , $access_token['oauth_token'] , $access_token['oauth_token_secret']);
    $my_info = $tencent_c->getUserInfo();
    //var_dump($my_info);

    $this->load->model('user_model'); 

    $needBindWithYouYan = 0;
    if($my_info['data']['head'] != '')
      $new_img = $my_info['data']['head'] . '/50';  
    else
      $new_img = "";
    $metadata = array(
      'tencent_id' => $tencent_id,
      'tencent_access_token' => $access_token['oauth_token'],
      'tencent_access_secret' => $access_token['oauth_token_secret'],
      'tencent_show_name' => $my_info['data']['nick'],
      'tencent_profile_img' => $new_img
    );

    $single_account = false;

    if($_SESSION['tencent_callback_type'] == 'login'){
      if($this->user_model->user_exist('tencent_id', $tencent_id)){
        $login_query_result = $this->user_model->login(false, 'tencent_id', $tencent_id);
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
      }

      // If renren account not in the database, create new account and log in with 
      // the new account
      else{
        $new_user_id = $this->user_model->create_user('tencent', $metadata);
        $_SESSION['login']['tencent'] = array('id' => $tencent_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'show_name' => $my_info['data']['nick'], 'profile_img' => $metadata['tencent_profile_img']);
        /*$_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'tencent';
        $needBindWithYouYan = 1;*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['tencent'] = array('id' => $tencent_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'tencent', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"tencent":' . json_encode($_SESSION['login']['tencent']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    //$data['main_content'] = 'youyan_callback_view';
    $this->load->view('youyan_callback_view', $data);
  }
}
?>




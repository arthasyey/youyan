<?php
session_start();
require_once( APPPATH.'inc/msn_config.php');
require_once( APPPATH.'sdk/msn/msn_sdk.php');
require_once( APPPATH.'sdk/SimpleImage.php');


class MSN_CallBack extends CI_Controller{

  function index(){
    if (!$tokens = getTokens(APP_CLIENT_ID, APP_REDIRECT_URI, APP_CLIENT_SECRET, null, $_GET['code'])) {
      logMessage('Error retrieving tokens. Code execution has stopped.');
      die();
    }

    $results_me = callRestApi($tokens['access_token'], 
      REST_PATH_ME, 
      REST_API_GET);    

    $this->load->model('user_model');

    $msn_id = $results_me['id'];

    $msn_profile_img = 'https://apis.live.net/v5.0/me/picture?access_token=' . $tokens['access_token'];
    $metadata = array(
      'msn_id' => $msn_id,
      'msn_access_token' => $tokens['access_token'],
      'msn_authentication_token' => $tokens['authentication_token'],
      'msn_refresh_token' => $tokens['refresh_token'],
      'msn_show_name' => $results_me['name'],
      'msn_link' => $results_me['link']
    );

    $single_account = false;

    $needBindWithYouYan = 0;

    if($_SESSION['msn_callback_type'] == 'login'){
      //echo 1;
      if($this->user_model->user_exist('msn_id', $msn_id)){
        $login_query_result = $this->user_model->login(false, 'msn_id', $msn_id);
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
        $_SESSION['login']['msn']['access_token'] = $tokens['access_token'];
        //$_SESSION['login']['msn']['access_secret'] = $access_token['oauth_token_secret'];
      }

      else{
        $simpleImage = new SimpleImage();
        $resized_img = 'msn_images/' . $msn_id . '.jpeg';
        $simpleImage->load($msn_profile_img);
        $simpleImage->resize(50, 50);
        $simpleImage->save($resized_img);
        $metadata['msn_profile_img'] = 'http://uyan.cc/' . $resized_img;

        $new_user_id = $this->user_model->create_user('msn', $metadata);
        $_SESSION['login']['msn'] = array('id' => $msn_id, 'access_token' => $tokens['access_token'], 'link'=>$results_me['link']); //, 'access_secret' => $access_token['oauth_token_secret']);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'profile_img' => 'http://uyan.cc/' . $resized_img, 'show_name' => $results_me['name']);
        /*$needBindWithYouYan = 1;
        $_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'msn';*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['msn'] = array('id' => $msn_id, 'access_token' => $tokens['access_token'], 'link'=>$results_me['link']); //, 'access_secret' => $access_token['oauth_token_secret']);
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'msn', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"msn":' . json_encode($_SESSION['login']['msn']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    $this->load->view('youyan_callback_view', $data);

  }
}

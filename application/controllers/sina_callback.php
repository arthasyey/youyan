<?php
/**
 * 新浪微博登陆回调逻辑
 */
session_start();
include_once( APPPATH.'inc/sina_config.php');
include_once( APPPATH.'sdk/weibooauth.php');


class Sina_CallBack extends CI_Controller{

  /**
   * After sina weibo authentication, there're two kinds of actions:
   * 1. User exist, log in with the account
   * 2. User does not exist, create the account and log in with the new account
   *
   * The view part of this page uses ajax to call the weibo_callback() function in 'youyan' 
   * controller, and make the decision
   */
  function index(){
    $o = new WeiboOAuth( SINA_AKEY , SINA_SKEY , $_SESSION['sina_request_token']['oauth_token'] , $_SESSION['sina_request_token']['oauth_token_secret']);
    $access_token = $o->getAccessToken($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']);

    //var_dump($access_token);

    $needBindWithYouYan = 0;

    $this->load->model('user_model');
    
    $c = new WeiboClient( SINA_AKEY , SINA_SKEY , $access_token['oauth_token'] , $access_token['oauth_token_secret']  );
    $me = $c->verify_credentials();
    //var_dump($me);

    $sina_id = $access_token['user_id'];
    $metadata = array(
      'sina_id' => $sina_id,
      'sina_access_token' => $access_token['oauth_token'],
      'sina_access_secret' => $access_token['oauth_token_secret'],
      'sina_show_name' => $me['screen_name'],
      'sina_profile_img' => $me['profile_image_url']
    );

    $single_account = false;

    if($_SESSION['sina_callback_type'] == 'login'){
      //echo 1;
      if($this->user_model->user_exist('sina_id', $sina_id)){
        $login_query_result = $this->user_model->login(false, 'sina_id', $sina_id);
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
        $_SESSION['login']['sina']['access_token'] = $access_token['oauth_token'];
        $_SESSION['login']['sina']['access_secret'] = $access_token['oauth_token_secret'];
      }

      else{
        $new_user_id = $this->user_model->create_user('sina', $metadata);
        $_SESSION['login']['sina'] = array('id' => $sina_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'profile_img' => $me['profile_image_url'], 'show_name' => $me['screen_name']);
        /*$needBindWithYouYan = 1;
        $_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'sina';*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['sina'] = array('id' => $sina_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'sina', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"sina":' . json_encode($_SESSION['login']['sina']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    $this->load->view('youyan_callback_view', $data);
  }
}

<?php
/**
 * 开心网登陆回调逻辑
 */
session_start();
include_once( APPPATH. 'inc/kaixin_config.php');
include_once( APPPATH. 'sdk/OAuth.php');
include_once( APPPATH. 'sdk/kaixin/kxclient.php');
include_once( APPPATH. 'sdk/kaixin/kxoauth.php');


class Kaixin_CallBack extends CI_Controller{

  function index(){
    $kaixin_o = new KXClient(KAIXIN_CONSUMER_KEY, KAIXIN_CONSUMER_SECRET, $_SESSION['kaixin_request_token']['oauth_token'], $_SESSION['kaixin_request_token']['oauth_token_secret']);
    $access_ret = $kaixin_o->getAccessToken($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']);

    if($access_ret['httpcode'] != 200){
      return;
    }

    $needBindWithYouYan = 0;   // 留空为以后做绑定做准备
    $access_token = $access_ret['response'];
    $connection = new KXClient(KAIXIN_CONSUMER_KEY, KAIXIN_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret'] );
    $my_info = $connection->users_me();
    $info_response = $my_info['response'];

    //var_dump($info_response);
    $kaixin_id = $info_response->uid;

    $this->load->model('user_model');

    //var_dump($kaixin_id);

    $metadata = array(
      'kaixin_id' => $kaixin_id,
      'kaixin_access_token' => $access_token['oauth_token'],
      'kaixin_access_secret' => $access_token['oauth_token_secret'],
      'kaixin_show_name' => $info_response->name,
      'kaixin_profile_img' => $info_response->logo50
    );

    $single_account = false;                                //输出单个账号, 还是全部账号(

    if($_SESSION['kaixin_callback_type'] == 'login'){       //回调形式，现在只做了登陆
      if($this->user_model->user_exist('kaixin_id', $kaixin_id)){
        $login_query_result = $this->user_model->login(false, 'kaixin_id', $kaixin_id);
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
        $_SESSION['login']['kaixin']['access_token'] = $access_token['oauth_token'];
        $_SESSION['login']['kaixin']['access_secret'] = $access_token['oauth_token_secret'];
      }
      // If renren account not in the database, create new account and log in with 
      // the new account
      else{
        $new_user_id = $this->user_model->create_user('kaixin', $metadata);
        $_SESSION['login']['kaixin'] = array('id' => $kaixin_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'show_name' => $info_response->name, 'profile_img' => $info_response->logo50);
        /*$_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'renren';
        $needBindWithYouYan = 1;*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['kaixin'] = array('id' => $kaixin_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'kaixin', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"kaixin":' . json_encode($_SESSION['login']['kaixin']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    $this->load->view('youyan_callback_view', $data);
  }
}
?>


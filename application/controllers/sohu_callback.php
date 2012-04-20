<?php
/**
 * 搜狐微博登陆回调逻辑
 */

session_start();
include_once( APPPATH. 'inc/sohu_config.php');
include_once( APPPATH. 'sdk/sohu/SohuOAuth.php');


class Sohu_CallBack extends CI_Controller{

  function index(){
    $sohu_o = new SohuOAuth(SOHU_CONSUMER_KEY, SOHU_CONSUMER_SECRET, $_SESSION['sohu_request_token']['oauth_token'], $_SESSION['sohu_request_token']['oauth_token_secret']);
    $access_token = $sohu_o->getAccessToken($_REQUEST['oauth_verifier']);

    $url = 'http://api.t.sohu.com/users/show.json';
    $my_info = $sohu_o->get($url);

    //var_dump($my_info);
    $sohu_id = $my_info->id;

    $this->load->model('user_model'); 

    $needBindWithYouYan = 0;

    $metadata = array(
      'sohu_id' => $sohu_id,
      'sohu_access_token' => $access_token['oauth_token'],
      'sohu_access_secret' => $access_token['oauth_token_secret'],
      'sohu_show_name' => $my_info->screen_name,
      'sohu_profile_img' => $my_info->profile_image_url
    );

    $single_account = false;

    if($_SESSION['sohu_callback_type'] == 'login'){
      if($this->user_model->user_exist('sohu_id', $sohu_id)){
        $login_query_result = $this->user_model->login(false, 'sohu_id', $sohu_id);
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
        $_SESSION['login']['sohu']['access_token'] = $access_token['oauth_token'];
        $_SESSION['login']['sohu']['access_secret'] = $access_token['oauth_token_secret'];
      }

      // If renren account not in the database, create new account and log in with 
      // the new account
      else{
        $new_user_id = $this->user_model->create_user('sohu', $metadata);
        $_SESSION['login']['sohu'] = array('id' => $sohu_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'profile_img' => $my_info->profile_image_url, 'show_name' => $my_info->screen_name);

        /*$_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'sohu';
        $needBindWithYouYan = 1;*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['sohu'] = array('id' => $sohu_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'sohu', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"sohu":' . json_encode($_SESSION['login']['sohu']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    //$data['main_content'] = 'youyan_callback_view';
    $this->load->view('youyan_callback_view', $data);
  }
}
?>



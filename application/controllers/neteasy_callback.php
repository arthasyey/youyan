<?php
session_start();
include_once( APPPATH. 'inc/neteasy_config.php');
include_once( APPPATH. 'sdk/neteasy/NeteasyOAuth.php');


class Neteasy_CallBack extends CI_Controller{


  function remote_file_exist($url){
    $header_array = get_headers ( $url );  
    if ($header_array [0] == 'HTTP/1.1 200 OK') {  
      return true;
    } else {  
      return false;
    }   
  }    

  function index(){
    $neteasy_o = new OAuth(NETEASY_WB_AKEY, NETEASY_WB_SKEY, $_SESSION['neteasy_request_token']['oauth_token'], $_SESSION['neteasy_request_token']['oauth_token_secret']);
    $access_token = $neteasy_o->getAccessToken($_REQUEST['oauth_token']);

    $tblog = new TBlog(NETEASY_WB_AKEY, NETEASY_WB_SKEY, $access_token['oauth_token'], $access_token['oauth_token_secret']);

    $my_info = $tblog->show_user_id("");

    //var_dump($my_info);
    $neteasy_id = $my_info['id'];

    $this->load->model('user_model'); 

    $needBindWithYouYan = 0;
    $neteasy_img = $my_info['profile_image_url'];
    /*if($this->remote_file_exist($neteasy_img)){
      #echo 111;
      $new_neteasy_img = $neteasy_img;
      #echo $new_neteasy_img;
    }
else{*/
      $pos = strpos($neteasy_img, '.com');
      $new_neteasy_img = substr($neteasy_img, 0, $pos+5) . '/' . substr($neteasy_img, $pos+5) . '&gif=1';
    //}

    $metadata = array(
      'neteasy_id' => $neteasy_id,
      'neteasy_access_token' => $access_token['oauth_token'],
      'neteasy_profile_img' => $new_neteasy_img . "&gif=1",
      'neteasy_screen_name' => $my_info['screen_name']
    );
    if($my_info['name'] != ""){
      $metadata['neteasy_show_name'] = $my_info['name'];
    }
    else{
      $metadata['neteasy_show_name'] = $my_info['screen_name'];
    }

    $single_account = false;

    if($_SESSION['neteasy_callback_type'] == 'login'){
      if($this->user_model->user_exist('neteasy_id', $neteasy_id)){
        $single_account = false;
        $login_query_result = $this->user_model->login(false, 'neteasy_id', $neteasy_id);
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
        $_SESSION['login']['youyan']['profile_img'] = $new_neteasy_img;
        $_SESSION['login']['neteasy']['access_token'] = $access_token['oauth_token'];
        $_SESSION['login']['neteasy']['access_secret'] = $access_token['oauth_token_secret'];
      }

      // If renren account not in the database, create new account and log in with 
      // the new account
      else{
        $new_user_id = $this->user_model->create_user('neteasy', $metadata);
        $_SESSION['login']['neteasy'] = array('id' => $neteasy_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'show_name' => $metadata['neteasy_show_name'], 'profile_img' => $metadata['neteasy_profile_img']);
        /*$_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'neteasy';
        $needBindWithYouYan = 1;*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['neteasy'] = array('id' => $neteasy_id, 'access_token' => $access_token['oauth_token'], 'access_secret' => $access_token['oauth_token_secret']);
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'neteasy', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"neteasy":' . json_encode($_SESSION['login']['neteasy']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    //$data['main_content'] = 'youyan_callback_view';
    $this->load->view('youyan_callback_view', $data);
  }
}
?>

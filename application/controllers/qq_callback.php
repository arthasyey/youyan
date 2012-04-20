<?php
/**
 * QQ登陆回调逻辑
 */

session_start();
require_once( APPPATH. 'inc/qq_config.php');
require_once( APPPATH. 'sdk/qq/oauth/get_access_token.php');
require_once( APPPATH. 'sdk/qq/user/get_user_info.php');

class QQ_CallBack extends CI_Controller{

  function index(){

    if (!is_valid_openid($_REQUEST["openid"], $_REQUEST["timestamp"], $_REQUEST["oauth_signature"])){
      echo "###invalid openid\n";
      echo "sig:".$_REQUEST["oauth_signature"]."\n";
      exit;
    }

    $access_str = get_access_token(QQ_APPID, QQ_APPKEY, $_REQUEST["oauth_token"], $_SESSION["secret"], $_REQUEST["oauth_vericode"]);
    $result = array();
    parse_str($access_str, $result);

    if (isset($result["error_code"])){
      echo "get access token error<br>"; echo "error msg: $request_token<br>";
      echo "点击<a href=\"http://wiki.opensns.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91%E5%85%AC%E5%85%B1%E8%BF%94%E5%9B%9E%E7%A0%81%E8%AF%B4%E6%98%8E\" target=_blank>查看错误码</a>";
      exit;
    }

    $user_info = get_user_info(QQ_APPID, QQ_APPKEY, $result["oauth_token"], $result["oauth_token_secret"], $_REQUEST['openid']);
    #var_dump($user_info);

    $single_account = false;

    $this->load->model('user_model'); 
    $needBindWithYouYan = 0;
    $qq_id = $_REQUEST['openid'];
    $metadata = array(
      'qq_id' => $qq_id,
      'qq_access_token' => $result["oauth_token"],
      'qq_access_secret' => $result["oauth_token_secret"],
      'qq_show_name' => $user_info['nickname'],
      'qq_profile_img' => $user_info['figureurl_1']
    );


    if($_SESSION['qq_callback_type'] == 'login'){
      if($this->user_model->user_exist('qq_id', $qq_id)){
        $login_query_result = $this->user_model->login(false, 'qq_id', $qq_id);
        $_SESSION['login'] = $this->user_model->get_binded_accounts($login_query_result);
        $_SESSION['login']['qq']['access_token'] = $result['oauth_token'];
        $_SESSION['login']['qq']['access_secret'] = $result['oauth_token_secret'];
      }

      // If renren account not in the database, create new account and log in with 
      // the new account
      else{
        $new_user_id = $this->user_model->create_user('qq', $metadata);
        $_SESSION['login']['qq'] = array('id' => $qq_id, 'access_token' => $result['oauth_token'], 'access_secret' => $result['oauth_token_secret']);
        $_SESSION['login']['youyan'] = array('id' => $new_user_id, 'profile_img' => $user_info['figureurl_1'], 'show_name' => $user_info['nickname']);

        /*$_SESSION['candidate_bind_data'] = $metadata;
        $_SESSION['candidate_bind_type'] = 'qq';
        $needBindWithYouYan = 1;*/
      }
    }

    else{       // for the case of "binding"
      $single_account = true;
      $_SESSION['login']['qq'] = array('id' => $qq_id, 'access_token' => $result['oauth_token'], 'access_secret' => $result['oauth_token_secret']);
      $this->user_model->bind_account($_SESSION['login']['youyan']['id'], 'qq', $metadata);
    }

    if($single_account){
      $data['login_info'] = '{"qq":' . json_encode($_SESSION['login']['qq']). '}';
    }
    else
      $data['login_info'] = json_encode($_SESSION['login']);

    $data['needBindWithYouYan'] = $needBindWithYouYan;
    //$data['main_content'] = 'youyan_callback_view';
    $this->load->view('youyan_callback_view', $data);
  }
}
?>

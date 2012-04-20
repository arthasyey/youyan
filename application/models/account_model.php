<?php

/**
 * 处理跟网站主(Master)账号相关的内容逻辑
 */
class Account_Model extends CI_Model {

  /**
   * 
   */
  function unBindMasterToSina(){
    $domain = $_REQUEST['domain'];
    $data = array(
      'SINA_ACCESS_TOKEN' => '',
      'SINA_ACCESS_SECRETE' => ''
    );
    $this->db->where('domain', $domain);
    $this->db->update('domain', $data);
  }


  function bindMasterToSina(){
    $domain = $_REQUEST['domain'];
    $access_token = $_REQUEST['access_token'];
    $access_secret = $_REQUEST['access_secret'];
    $data = array(
      'SINA_ACCESS_TOKEN' => $access_token,
      'SINA_ACCESS_SECRETE' => $access_secret
    );
    $this->db->where('domain', $domain);
    $this->db->update('domain', $data);
  }


  /**
   * 处理是否保存原有wp评论这一选项
   */
  function saveWpUseOrigSetting(){
    $domain = $_REQUEST['domain'];
    $setting = array(
      'domain' => $domain,
      'wp_use_orig' => $_REQUEST['wp_use_orig']
    );
    $this->db->where('domain', $domain)->update('domain', $setting);
  }


  /**
   * 保存设置
   */
  function saveSetting(){
    $domain = $_REQUEST['domain'];
	$sns_messag_type = strip_tags($_REQUEST['sns_message']);
    $setting = array(
      'width' => $_REQUEST['width'],
      'numLimit' => $_REQUEST['numLimit'],
      'commentStyle' => $_REQUEST['commentStyle'],
      'digName' => $_REQUEST['digName'],
      'digDownName' => $_REQUEST['digDownName'],
      'mailNotify' => $_REQUEST['mailNotify'],
      'descWord' => $_REQUEST['descWord'],
      'delStyle' => $_REQUEST['delStyle'],
      'numCommentsPerPage' => $_REQUEST['numCommentsPerPage'],
      'defaultSort' => $_REQUEST['defaultSort'],
      'account_order' => $_REQUEST['account_order'],
      'anon_url' => $_REQUEST['anon_url'],
      'domain_name' => $_REQUEST['domain_name'],
	  'buttonStyle' => $_REQUEST['buttonNum'],	  
      'login_bar_auto_hide' => $_REQUEST['autoHideNum'],
      'reply_position' => $_REQUEST['replyPosition'],
      'num_replys_per_thread' => $_REQUEST['replyItemAmount'],
	  'use_emotions' => $_REQUEST['emotionDisplay'],  
	  'use_community' => $_REQUEST['comunityDisplay'],
	  'message_sns'=> $sns_messag_type,
	  'image_style' => $_REQUEST['sendImageDisplay'],
	  'veryfyCheck'=> $_REQUEST['veryfyCheck'],
	  'profile_bar'=> $_REQUEST['profileCheck'],
	  'showScoreItem'=> $_REQUEST['showScoreItem'],
	  'forceStar'=> $_REQUEST['forceStar']
    );
	//update session
	$session_name = 'uyan_'.$domain;
	$_SESSION[$session_name]['width'] = $_REQUEST['width'];
	$_SESSION[$session_name]['numLimit'] = $_REQUEST['numLimit'];
	$_SESSION[$session_name]['commentStyle'] = $_REQUEST['commentStyle'];
	$_SESSION[$session_name]['digName'] = $_REQUEST['digName'];
	$_SESSION[$session_name]['digDownName'] = $_REQUEST['digDownName'];
	$_SESSION[$session_name]['mailNotify'] = $_REQUEST['mailNotify'];
	$_SESSION[$session_name]['descWord'] = $_REQUEST['descWord'];
	$_SESSION[$session_name]['delStyle'] = $_REQUEST['delStyle'];
	$_SESSION[$session_name]['numCommentsPerPage'] = $_REQUEST['numCommentsPerPage'];
	$_SESSION[$session_name]['defaultSort'] = $_REQUEST['defaultSort'];
	$_SESSION[$session_name]['account_order'] = $_REQUEST['account_order'];
	$_SESSION[$session_name]['anon_url'] = $_REQUEST['anon_url'];
	$_SESSION[$session_name]['domain_name'] = $_REQUEST['domain_name'];
	$_SESSION[$session_name]['buttonStyle'] = $_REQUEST['buttonNum'];
	$_SESSION[$session_name]['login_bar_auto_hide'] = $_REQUEST['autoHideNum'];
	$_SESSION[$session_name]['reply_position'] = $_REQUEST['replyPosition'];
	$_SESSION[$session_name]['num_replys_per_thread'] = $_REQUEST['replyItemAmount'];
	$_SESSION[$session_name]['use_emotions'] = $_REQUEST['emotionDisplay'];
	$_SESSION[$session_name]['use_community'] = $_REQUEST['comunityDisplay'];
	$_SESSION[$session_name]['message_sns'] = $sns_messag_type;
	$_SESSION[$session_name]['image_style'] = $_REQUEST['sendImageDisplay'];
	$_SESSION[$session_name]['veryfyCheck'] = $_REQUEST['veryfyCheck'];
	$_SESSION[$session_name]['profile_bar'] = $_REQUEST['profileCheck'];
	$_SESSION[$session_name]['showScoreItem'] = $_REQUEST['showScoreItem'];
	$_SESSION[$session_name]['forceStar'] = $_REQUEST['forceStar'];
    if(isset($_REQUEST['styleNum'])){
      $setting['styleNum'] = $_REQUEST['styleNum'];
	  $_SESSION[$session_name]['styleNum'] = $_REQUEST['styleNum'];
	}else{
      $setting['styleNum'] = 3;
	  $_SESSION[$session_name]['styleNum'] = 3;
	}
    if(isset($_REQUEST['wp_use_orig'])){
      $setting['wp_use_orig'] = $_REQUEST['wp_use_orig'];
	  $_SESSION[$session_name]['wp_use_orig'] = $_REQUEST['wp_use_orig'];
	}
    $this->db->where('domain', $domain)->update('domain', $setting);

    $query = $this->db->query("select * from domain where domain='$domain'");
    $query_row = $query->row_array();
    $_SESSION['domain_data'] = $query_row;
    return $setting;
  }
}


<?php
/**
 * 网站配置页面的逻辑
 */

session_start();

class YouYan_Admin_Edit extends CI_Controller {
  function __construct(){
    parent::__construct();
  }

  function initialize_remote_info(){
    $_SESSION['uid'] = $_GET['uid'];
    $_SESSION['uname'] = $_GET['uname'];
    $domain = $_GET['domain'];

    $_SESSION['showDomain'] = $domain;

    $sql = "select * from domain where domain='$domain'";
    $query = $this->db->query($sql);
    $row = $query->row_array();
    $_SESSION['domain_data'] = $row;
  }

  function index(){
    if(isset($_GET['uid']) and isset($_GET['uname'])){
      $this->initialize_remote_info();
    }

    if(!isset($_SESSION['uid'])||$_SESSION['uid']==''){
      $url = "http://uyan.cc";
      Header("HTTP/1.1 303 See Other");
      Header("Location: $url");
      exit;  
    }

    $this->load->model('webdata_model');
    $verify_state = $this->webdata_model->getVerify();
    $data['title'] = '安装与设置';
    $data['verify'] = $verify_state;
    $data['main_content'][0] = 'youyan_admin_edit_view';
    $this->load->view('include/template',$data);
  }


  /**
   * 不再使用，曾用于插件中
   */
  function saveSettingCrossDomain(){
    $dal = $_GET['callback'];
    $this->load->model('account_model');
    $jar = json_encode($this->account_model->saveWpUseOrigSetting());
    echo $dal.'('.$jar.')';
  }

  /**
   * 保存设置
   */
  function saveSetting(){
    $this->load->model('account_model');
    $jar = json_encode($this->account_model->saveSetting());
    echo $jar;
  }


  /**
   * 保存SSO设置
   */
  function submitSSO(){
    $sso_name = $_POST['sso_name'];
    if(mb_strlen($sso_name, 'utf-8') != strlen($sso_name)){
      echo 0;
      return;
    }
    $query = $this->db->where('sso_name', $sso_name)->from('domain')->count_all_results();
    if($query != 0){
      echo 0;
      return;
    }
    $this->db->set('sso_name', $sso_name)->where('domain', $_SESSION['domain_data']['domain'])->update('domain');
    echo 1;
  }

  /**
   * 创建CSS文件
   */
  function createCSS($crossDomain = false){
    $this->load->model('webdata_model');
    if(!$crossDomain){
      $this->webdata_model->createCSS(); 
    }
    else{
      $dal = $_GET['callback'];
      $this->load->model('webdata_model');
      $jar = json_encode($this->webdata_model->createCSSCrossDomain());
      echo $dal.'('.$jar.')';
    }
  }

  
  /**
   * 绑定网站新浪微博账号
   */
  function bindMasterToSina(){
    $this->load->model('account_model');
    $this->account_model->bindMasterToSina();
  }

  /**
   * 解除绑定
   */
  function unBindMasterToSina(){
    $this->load->model('account_model');
    $this->account_model->unBindMasterToSina();
  }


  /**
   * 没有使用
   */
  function unBindMasterToSinaCrossDomain(){
    $dal = $_GET['callback'];
    $this->load->model('account_model');
    $jar = json_encode($this->account_model->unBindMasterToSina());
    echo $dal.'('.$jar.')';
  }

  /**
   * 保存网站新浪APP KEY
   */
  function saveAPPCrossDomain(){
    $dal = $_GET['callback'];
    $domain = $_REQUEST['domain'];

    $query = $this->db->query("select SINA_APP_KEY, SINA_APP_SECRETE from domain where domain='$domain'");
    $row_array = $query->row_array();
    if($row_array['SINA_APP_KEY'] == $_REQUEST['SINA_APP_KEY'] && $row_array['SINA_APP_SECRETE'] == $_REQUEST['SINA_APP_SECRETE'])
      $jar = 0;
    else{
      $update_data = array(
        'SINA_APP_KEY' => $_REQUEST['SINA_APP_KEY'],
        'SINA_APP_SECRETE' => $_REQUEST['SINA_APP_SECRETE']
      );
      $this->db->where('domain', $domain)->update('domain', $update_data);
      $jar = 1;
    }
    echo $dal.'('.$jar.')';
  }


  /**
   * 绑定网站腾讯微薄账号
   */
  function bindMasterToTencent(){
    $domain = $_REQUEST['domain'];
    $access_token = $_REQUEST['access_token'];
    $access_secret = $_REQUEST['access_secret'];

    $data = array(
      'TENCENT_ACCESS_TOKEN' => $access_token,
      'TENCENT_ACCESS_SECRETE' => $access_secret
    );

    $this->db->where('domain', $domain);
    $this->db->update('domain', $data);
  }

  /**
   * 没有使用
   */
  function saveTencentAPPCrossDomain(){
    $dal = $_GET['callback'];
    $domain = $_REQUEST['domain'];

    $query = $this->db->query("select TENCENT_APP_KEY, TENCENT_APP_SECRETE from domain where domain='$domain'");
    $row_array = $query->row_array();
    if($row_array['TENCENT_APP_KEY'] == $_REQUEST['TENCENT_APP_KEY'] && $row_array['TENCENT_APP_SECRETE'] == $_REQUEST['TENCENT_APP_SECRETE'])
      $jar = 0;
    else{
      $update_data = array(
        'TENCENT_APP_KEY' => $_REQUEST['TENCENT_APP_KEY'],
        'TENCENT_APP_SECRETE' => $_REQUEST['TENCENT_APP_SECRETE']
      );

      $this->db->where('domain', $domain)->update('domain', $update_data);
      $jar = 1;
    }
    echo $dal.'('.$jar.')';
  }

  /**
   * 没有使用
   */
  function unBindMasterToTencentCrossDomain(){
    $dal = $_GET['callback'];

    $domain = $_REQUEST['domain'];
    $data = array(
      'TENCENT_ACCESS_TOKEN' => '',
      'TENCENT_ACCESS_SECRETE' => ''
    );
    $this->db->where('domain', $domain);
    $jar = $this->db->update('domain', $data);
    echo $dal.'('.$jar.')';
  }


  /**
   * 保存wordpress相关的设置
   */
  function savePluginSetting(){
    $this->load->model('webdata_model');
    $this->webdata_model->savePluginSetting();
  }

  /**
   * 保存黑名单
   */
  function saveBlackList(){
    $this->load->model('webdata_model');
    $this->webdata_model->saveBlackList();	  
  }

  /**
   * 获取spam信息
   */
  function getSpam(){
    $this->load->model('webdata_model');
    echo json_encode($this->webdata_model->getSpam());		  
  }

  /**
   * 保存敏感词
   */
  function saveBlackWords(){
	$this->load->model('webdata_model');
    $this->webdata_model->saveSpamWords();		  
  }
  
  /**
   * 删除敏感词
   */
  function delBlackSpam(){
	$this->load->model('webdata_model');
    $this->webdata_model->delBlackSpam();		  
  }

  /**
   * 添加用户至黑名单
   */
  function userAddToBlack(){
	$this->load->model('webdata_model');
    $this->webdata_model->userAddToBlack();	  
  }
}

?>

<?php
session_start();
class YouYan_login extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('user_model');
  }
  function index(){
    $data['main_content'][0] = 'youyan_login_view';
    $this->load->view('youyan_login_view',$data);
  }

  /**
   * 注册用户
   */
  function signupMaster(){
    $this->load->model('user_model');
    echo $this->user_model->signupMaster();
  }

  /**
   * 注册用户，来自插件跨域注册
   */
  function signupMasterCrossDomain(){
    $dal = $_GET['callback'];
    $this->load->model('user_model');
    $jar = json_encode($this->user_model->signupMasterCrossDomain());
    echo $dal.'('.$jar.')';
  }


  /**
   * 没有使用
   */
  function addWebMaster(){
    $this->load->model('user_model');
    echo $this->user_model->addWebMaster();
  }

  /**
   * 检查域名结束
   */
  function checkURLDone(){
    $this->load->model('user_model');
    $this->user_model->checkURLDone();
  }


  /**
   * 网站主登陆
   */
  function userLogin(){
    $this->load->model('user_model');
    $this->user_model->userLogin();	  
  }

  /**
   * 网站主登陆，用于插件跨域
   */
  function userLoginCrossDomain(){
    $dal = $_GET['callback'];
    $this->load->model('user_model');
    $jar = json_encode($this->user_model->userLoginCrossDomain());
    echo $dal.'('.$jar.')';
  }


 /**
  * 跨域自动登录
  */ 
  function userAutoLoginCrossDomain(){
    $dal = $_GET['callback'];
    $this->load->model('user_model');
    $jar = json_encode($this->user_model->userAutoLoginCrossDomain());
    echo $dal.'('.$jar.')';
  }


  /**
   * 退出
   */
  function userLogout(){
    $this->load->model('user_model');
    echo json_encode($this->user_model->userLogout());	  
  }

  /**
   * 获取网站主及其网站信息
   */
  function userDomain(){
    $this->load->model('user_model');
    echo json_encode($this->user_model->userDomain());	  
  }

  /**
   * 验证对网站所有权
   */
  function userCheckDomain(){
    $this->load->model('user_model');
    echo json_encode($this->user_model->userCheckDomain());	  
  }

  /**
   * 删除网站
   */
  function delDomain(){
    $this->load->model('user_model');
    echo json_encode($this->user_model->delDomain());	  
  }
  
  /**
   * 检验域名下的验证文件
   */
  function checkDomainFile(){
    $this->load->model('user_model');
    echo $this->user_model->checkDomainFile();	  
  }
  
  /**
   * 设置用户email
   */
  function setEmail(){
    $this->load->model('user_model');
    echo $this->user_model->setEmail();	  
  }
  
  /**
   * 获取用户各方面信息
   */
  function userData(){
    $this->load->model('user_model');
    echo json_encode($this->user_model->userData());	  
  }
  
  /**
   * 设置用户title
   */
  function setTitle(){
    $this->load->model('user_model');
    echo $this->user_model->setTitle();	 	  
  }
}

?>

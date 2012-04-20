<?php 
//session_start();
require(APPPATH. '/inc/config.php');

class YouYan_webdata extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->model('webdata_model');
  }  
  
  
  /**
   * 取时间表
   */
  function getTable($timeArea){
    $this->load->model('webdata_model');
	echo $this->webdata_model->getTable($timeArea);
  }
  
  
  /**
   * 修改时间表
   */
  function changeTable($timeArea){
    $this->load->model('webdata_model');
	//echo json_encode($this->webdata_model->getTable($timeArea));
	echo $this->webdata_model->changeTable($timeArea);
  }
  
  
  /**
   * 更新邮件提醒数字
   */
  function updateLimitAmount(){
	$this->load->model('webdata_model');
	$this->webdata_model->updateLimitAmount();
  }
  
  
  /**
   * 没有使用
   */
  function updateLimitCrossDomain(){	  
    $limitAmount = $_GET['limitAmount'];
	$uid = $_GET['uid'];
    $this->load->model('webdata_model');
    $this->webdata_model->updateLimitAmountCross($limitAmount,$uid);
	return $limitAmount;
  }
  
  /**
   * 
   */
  function createShareLink(){
    $this->load->model('webdata_model');
   	echo  $this->webdata_model->createShareLink();	  
  }
  
  /**
   * 修改时间表
   */
  function bakupData(){
    $this->load->model('webdata_model');
   	$this->webdata_model->bakupData();		  
  }
}
?>

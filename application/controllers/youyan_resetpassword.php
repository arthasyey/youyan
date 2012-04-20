<?php
//session_start();
class YouYan_Resetpassword extends CI_Controller {

  /**
   * 重置密码
   */
  function __construct(){
    parent::__construct();
    $this->load->model('webdata_model');
  }
  function index($reset_id){
    $this->load->model('webdata_model');
	$backLink = 0;
	if(isset($reset_id)&&$reset_id!=''){
		$resetMd5 = $reset_id;
		$psState = $this->webdata_model->getRestPassword($resetMd5);
		if($psState==1){
			$backLink=1;
		}
		$data['email'] = $psState;			
	}else{

		$backLink =1;
	}
	$data['main_content'][0] = 'youyan_resetpassword_view';
	
	$data['backLink'] = $backLink;
    $this->load->view('youyan_resetpassword_view.php',$data);
  }

}
?>

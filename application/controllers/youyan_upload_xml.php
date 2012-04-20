<?php
//session_start();
class YouYan_upload_xml extends CI_Controller {

  /**
   * 上传XML文件(所导出评论)
   */
  function __construct(){
    parent::__construct();	
  }

  function index(){
    session_start();
    $this->load->view('youyan_upload_xml_view');

  }

}

?>

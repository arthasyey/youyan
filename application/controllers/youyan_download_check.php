<?php
session_start();
class YouYan_Download_Check extends CI_Controller {

  function __construct(){
    parent::__construct();
  }
  function index(){
	if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 8.0")||strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 7.0")||strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 6.0")||strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 9.0")){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/zip'); 
		header("Content-Disposition:filename=".md5($_SESSION['uid']).".zip");
	}else{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: txt/html'); 
		header("Content-Disposition:filename=".md5($_SESSION['uid']).".html");
	}
  }
}

?>

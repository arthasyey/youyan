<?php

class YouYan_Download extends CI_Controller {

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
		header("Content-Disposition:filename=proxy.zip");
		echo file_get_contents("proxy.zip");
	}else{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: txt/html'); 
		header("Content-Disposition:filename=proxy.html");
		echo file_get_contents("proxy.html");
	}
  }
  function getCSS(){
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: txt/html');
    header("Content-Disposition:filename=youyan_style_sample.css");
	echo file_get_contents("css/youyan_style_sample.css");
  }
}

?>

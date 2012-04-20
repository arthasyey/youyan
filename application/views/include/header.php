<?php 
	$the_host = $_SERVER['HTTP_HOST'];
	$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
	if($the_host !='uyan.cc'){
		header('HTTP/1.1 301 Moved Permanenty');
		header('Location:http://uyan.cc'.$request_uri);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title; ?> -- 友言管理后台</title>
	<link rel="shortcut icon" href="http://uyan.cc/images/favicon.ico" />
	<link rel="Bookmark" href="http://uyan.cc/images/favicon.ico" />
    <meta name="keywords" content="友言,友言网,社交媒体评论框,评论框,SNS评论框,社交评论解决方案" />
    <meta name="author" content="友言" />
    <meta name="description" content="DIY自己网站的社交媒体评论框，稳步增加网站流量。" />
    <link href="/css/global.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="/jquery.ui/jquery-1.4.2.min.js"></script>
	<script type="text/javascript">
    
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-25792179-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    
    </script>
  </head>
  <body>
 <?php if(isset($userType)&&$userType=='user'){?>
   <div class="headerWrapper">
  	<div class="headerContainer">
  		<a class="logoPart" href="/"></a>
        <div class="loggedinRight">
        <a class="topNaviName"><?php echo $_SESSION['login']['youyan']['show_name'];?></a>        
      
        <a class="topNaviItem" onclick="userLogout();">退出</a>
        </div>
  		<div class="clear"></div>
    </div>
  </div>
 <?php }else{?>
<?php if($main_content[0]=='youyan_basic_view'||$main_content[0]=='youyan_homepage_view' ){?>
<?php }else{?>
  <div class="headerWrapper">
  	<div class="headerContainer">
  		<a class="logoPart" href="/"></a>
        <?php if($_SESSION['uid']!=25){?>
        <a class="createCode" href="http://uyan.cc/getcode">获取代码</a>
        <a class="createCode" href="http://uyan.cc/help/html">帮助中心</a>
        <?php }?>
        <div class="loggedinRight">       
        <?php if($_SESSION['uid']!=25){?>
        <a class="topNaviItem" href="http://uyan.cc/index.php/youyan_admin_pre/index/">网站管理</a>
        <?php }?>
        <a class="topNaviName"><?php echo $_SESSION['uname'];?></a>
        <a class="topNaviName" style="cursor:pointer" href="javascript:void(0);" onclick="userLogout();">( 退出 )</a>
        </div>
  		<div class="clear"></div>
    </div>
  </div>
<?php }}?>
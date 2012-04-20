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
    <title>友言-----社交评论解决方案--找回密码</title>
    <meta name="keywords" content="友言,友言网,社交媒体评论框,评论框,SNS评论框,社交评论解决方案" />
    <meta name="author" content="友言" />
    <meta name="description" content="DIY自己网站的社交媒体评论框，稳步增加网站流量。" />
    <link href="/css/global.css" rel="stylesheet" type="text/css" />
	<script language="javascript" src="/js/global.js"></script>
	<script language="javascript" src="/js/youyan_admin_view.js"></script>
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
	<link href="../css/global.css" rel="stylesheet" type="text/css" />
	<link href="../css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="headerWrapper">
		<div class="headerContainer">
			<a class="logoPart" href="/"></a>
			<div class="loggedinRight">
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="backPassContainer">
		<div class="backPassTitle">找回友言网密码</div>
		<div class="backPassIntro">登录友言系统使用的邮箱</div>
		<input type="text" id="enterEmail" class="enterEmail"/>
		<div class="backActionPane">
			<a class="submitReset" onclick="resetPass()">重设密码</a>
			<a class="backLink" href="http://uyan.cc">返回</a>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>
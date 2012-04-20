<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>友言-----社交评论解决方案</title>
    <meta name="keywords" content="友言,友言网,社交媒体评论框,评论框,SNS评论框,社交评论解决方案" />
    <meta name="author" content="友言" />
    <meta name="description" content="DIY自己网站的社交媒体评论框，稳步增加网站流量。" />
    <link href="../css/global.css" rel="stylesheet" type="text/css" />
    <link href="../css/boxy.css" rel="stylesheet" type="text/css" />
    <link href="../css/login.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
    <script language="javascript" src="../js/youyan_admin_view.js"></script>
  </head>
<body>
    <div class="contentWrapper">
       <div class="innerContainer">
           <div class="contentTitle"><a class="unselectedTab currentTab" id="loginUyan" onclick="$('#loginUyan').addClass('currentTab');$('#signupUyan').removeClass('currentTab');$('#loginpart').css({'display':'block'});$('#signuppart').css({'display':'none'});">登录友言</a><a class="unselectedTab" onclick="$('#signupUyan').addClass('currentTab');$('#loginUyan').removeClass('currentTab');$('#loginpart').css({'display':'none'});$('#signuppart').css({'display':'block'});" id="signupUyan">注册</a><div class="clear"></div></div>
           <div id="loginpart">
           		<div class="detailTitle">Email</div>
           		<input type="text" id="email" name="email" />
           		<div class="detailTitle">密码</div>
           		<input type="password" id="password" name="password" />  
           		<div class="submitWrapper">
                	<a class="loginSubmit" href="youyan_admin_pre">登录</a>
           			<div class="clear"></div>
           		</div>        
           		<div class="clear"></div>  
           </div>
           <div id="signuppart">
           		<div class="detailTitle">用户名</div>
           		<input type="text" id="nickname" name="nickname" />
           		<div class="detailTitle">Email</div>
           		<input type="text" id="signupemail" name="signupemail" />
           		<div class="detailTitle">密码(6位以上)</div>
           		<input type="password" id="signuppassword" name="signuppassword" />  
           		<div class="submitWrapper">
                	<a class="loginSubmit" id="signupSubmit" href="youyan_admin_pre">注册</a>
           			<div class="clear"></div>
           		</div>        
           		<div class="clear"></div>  
           </div>
       </div>        
   </div>    
</body>
</html>



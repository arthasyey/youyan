<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录注册</title>
<link href="/css/article.css" rel="stylesheet" type="text/css" />
<link href="/css/global.css" rel="stylesheet" type="text/css">
<link href="/css/boxy.css" rel="stylesheet" type="text/css">
<link href="/css/homepage.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/global.js"></script>
    <script language="javascript" src="/jquery.ui/jquery-1.4.2.min.js"></script>
    <script language="javascript" src="/js/jquery.boxy.js"></script>
<script language="javascript" src="/js/youyan_homepage_view.js"></script>
<script language="javascript" src="/js/youyan_admin_view.js"></script>
</head>

<body>
<?php
	include("include/front_header.php");
?>
<div class="main">
  <div class="registration_txt"><a href="javascript:void(0);">1.注册</a><span class="arrow"><img src="/images/arrow.jpg"></span><a href="javascript:void(0);" style="color:#ccc">2.获取代码</a></div>
    <div class="line"></div>
    <div class="registration_box" style="margin-bottom:100px;">
    	<div class="registration_content">
        	<div class="registration_content_row">
            <p class="p1">网站域名：</p>
            <input class="txt2" name="signupOutDomain" id="signupOutDomainMain" onblur="checkOutDomain('Main')" type="text" value="http://">
            </div>
            <!-- <div class="clear"></div>
            <div class="line"></div>
            <div class="registration_content_row">
            <p class="p1">用户名：</p>
            <input class="txt2" name="signupOutName" id="signupOutNameMain" onblur="checkOutUserName('Main')" type="text">
			</div> -->
            <div class="clear"></div>
            <div class="registration_content_row">
            <p class="p1">登录邮箱：</p>
            <input class="txt2" name="signupOutEmail" id="signupOutEmailMain" onblur="checkOutEmail('Main')" type="text">
            </div>
            <div class="clear"></div>
            <div class="registration_content_row">
            <p class="p1">登录密码：</p>
            <input class="txt2" name="signupOutPassword" id="signupOutPasswordMain" onblur="checkOutPassword('Main')" type="password">
			</div>
            <div class="clear"></div>
            <p class="p_btn" style=" padding-left:86px;"><input type=submit value="注册" class="registration_box_btn" onclick="submitOutSignup('Main'<?php if($info) echo ', \''.$info.'\''; ?>)" id="signupOutBTNMain"><span style="line-height:45px;height: 37px;overflow: hidden; padding-left:20px;">已有帐号？<span style="color:#0000ff;cursor:pointer;" onclick="boxLogin.show();$('#alertLogin').html('');$('#loginForm').attr('class','outlineLogin');">登录</span>吧</span></p>
            <div class="clear"></div>
        </div>
    	<form action="javascript:submitLogin('Main'<?php if($info) echo ', \''.$info.'\''; ?>)" id="loginFormMain">
	        <div class="login_content">
	        	<!-- <div class="content_title">登录<p class="p3">已注册了？请登录</p></div>
	        	<div class="clear"></div>
	        	<div style="height:20px;color:#ff0000;"><span id="alertLoginMain"></span></div>
	            <input onfocus="this.style.display='none';document.getElementById('loginEmailMain').style.display='';document.getElementById('loginEmailMain').focus();" class="txt3" style="color:#cccccc;" id="loginEmailMainTmp" type="text" value="登录邮箱">
	            <input onblur="" class="txt3" style="display:none;" name="loginEmail" id="loginEmailMain" type="text" value="">
	            <div class="clear"></div>
	            <input onfocus="this.style.display='none';document.getElementById('loginPasswordMain').style.display='';document.getElementById('loginPasswordMain').focus();" class="txt3" style="color:#cccccc;" id="loginPasswordMainTmp" type="text" value="登录密码">
	            <input onblur="" class="txt3" style="display:none;" name="loginPassword" id="loginPasswordMain" type="password" value="">
	            <div class="clear"></div>
	            <p class="p4"><input name="checkReme" id="checkRemeMain" type="checkbox">&nbsp;记住我的密码</p>
	            <p class="p_btn"><input type="submit" value="登录" class="registration_box_btn"><a href="javascript:;">忘记密码？</a></p>
	            <input type="hidden" name="clicktype" id="clickTypeMain" value="" />
	            <div class="clear"></div> -->
	        </div>
	        <div class="clear"></div>
    	</form>    
    </div>
</div>
<?php
	include("include/front_footer.php");
?>
</body>
</html>

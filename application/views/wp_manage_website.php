<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站管理 -- 友言</title>
<link rel="shortcut icon" href="http://uyan.cc/images/favicon.ico" />
<link rel="Bookmark" href="http://uyan.cc/images/favicon.ico" />
<link href="/css/article.css" rel="stylesheet" type="text/css" />
<link href="/css/global.css" rel="stylesheet" type="text/css">
<link href="/css/boxy.css" rel="stylesheet" type="text/css">
<link href="/css/homepage.css" rel="stylesheet" type="text/css">
<script src="/js/ga.js" async="" type="text/javascript"></script><script language="javascript" src="/js/global.js"></script>
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
	<div class="headline"><p>帮助中心</p></div>
	<!-- login sidebar-->
	<div class="sidebar">
    <div class="sidebar">
      <div class="sidebar_nav">
		<?php
        	include("include/article_menu.php");
        ?>
        <div style="margin-top:15px; margin-bottom:5px"><a href="http://wpa.qq.com/msgrd?v=3&uin=1735067958&site=qq&menu=yes" target="_blank"><img src="/images/qqbig.png" width="121" height="40" alt="客服QQ" border="0" /></a></div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
    <!-- login main_content-->
    <div class="main_content">
    	<!--管理-->
	<a name="website"></a>
      <h2 class="main_title">网站管理：</h2>

<p class="p_definition">
          　　站长可以同时管理多个网站。一个账号可以绑定多个网站，只要插入同一段代码到其它网站，系统会自动将此网站绑定至友言网站管理后台。便于站长同时管理各个网站。
    </p>
    
<div class="clear"></div><br/>
        <p><img src="/images/12.png"></p><br/>
        <div class="clear"></div>
        <!--设置-->
        <p class="p_definition">　　当网站没有嵌入评论代码时，系统会提示您需要嵌入代码后才能自动验证。如果被删除的URL仍旧嵌友言的代码，当其被加载时，仍将添加到该账号下。</p><br/>      <p class="p_definition">　　<b>注意：</b>当提交两个相同主域名时，系统会提示您验证网站权限，您可以点击"下载验证文件"，将其上传到网站根目录中，最后点击"验证权限"后即可正常使用友言评论管理。</p>
        <div class="clear"></div>
        <br/><p><img src="/images/13.png"></p>
        <p><img src="/images/14.png"></p><div class="clear"></div><br/>

    </div>
    <div class="clear"></div>
</div>
<?php
	include("include/front_footer.php");
?>
</body>
</html>
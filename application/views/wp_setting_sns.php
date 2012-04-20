<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>绑定SNS -- 友言</title>
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
    	<!--设置-->
		<a name="sns"></a>
        <h2 class="main_title">绑定SNS</h2>
        <p class="p_definition" style="color:#109db6;"><b>绑定有哪些好处？</b></p>
      <p class="p_definition">
          　　<b style="color:#109db6; font-weight:normal;">&gt;&gt;</b> 博客文章自动同步至您的官方微博。<br/>
          　　<b style="color:#109db6; font-weight:normal;">&gt;&gt;</b> 网友在官方微博的评论自动同步至您的网站<br/>
          　　<b style="color:#109db6; font-weight:normal;">&gt;&gt;</b> 网站的评论者将转发文章到评论者的微博。<br/>
    </p><br/><div class="clear"></div><br/>
  <p class="p_definition" style="color:#109db6;"><b>如何绑定？</b></p><div class="clear"></div><br/>
<p><span class="sum">1</span>
<p class="p_definition">获得新浪微博APPKEY</p>

<p class="p_definition">
          　　登录您的官方微博帐号后，打开<span class="introductionTitle"><a href="http://open.weibo.com/" target="_blank">新浪微博开放平台</a></span>，在右侧点击申请Appkey按钮，填写网站基本信息表格后，在<b>"我的应用"</b>中获得网站对应的App key与App secret。（绑定腾讯微博操作步骤一致）<br/></p>
<div class="clear"></div><br/>


<p><span class="sum">2</span>
<p class="p_definition">设置友言绑定</p>

<p class="p_definition">
          　　在Wordpress 友言设置界面<b>"绑定SNS"</b>标签栏中输入Appkey与Secretkey，选择<b>"保存Appkey"</b>。再点击微博绑定按钮，绑定至刚申请App key的官方帐号。（注意一定要按照先输入Appdkey与Secretkey再绑定的顺序来操作）<br/></p>
          		<p><img src="/images/7.png"></p>
<div class="clear"></div>
</div>
    <div class="clear"></div>
</div>
<?php
	include("include/front_footer.php");
?>
</body>
</html>
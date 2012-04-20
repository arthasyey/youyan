<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WordPress插件——安装</title>
<link rel="shortcut icon" href="http://uyan.cc/images/favicon.ico" />
<link rel="Bookmark" href="http://uyan.cc/images/favicon.ico" />
<link href="/css/article.css" rel="stylesheet" type="text/css" />
<link href="/css/global.css" rel="stylesheet" type="text/css">
<link href="/css/boxy.css" rel="stylesheet" type="text/css">
<link href="/css/homepage.css" rel="stylesheet" type="text/css">
<script src="/js/ga.js" async="" type="text/javascript"></script>
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
  <div class="headline">
    <p>WordPress插件</p>
  </div>
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
    <!--安装-->
    <h2 class="main_title">下载安装</h2>
    <div class="clear"></div>
    <br/>
    <p><span class="sum">1</span>
    <p class="p_definition"><span class="introductionTitle"><a href="http://wordpress.org/extend/plugins/youyan-social-comment-system/" target="_blank">下载</a></span> 友言评论插件（youyan-social-comment-system），将此文件(文件夹名不能更改)解压保存至您的WordPress根目录wp-content/plugins。</p>
    <p><img src="/images/5.png"></p>
    <div class="clear"></div>
    <br/>
    <p><span class="sum">2</span>
    <p class="p_definition">登录WordPress 管理中心&ldquo;<b>启用</b>&rdquo;友言插件即可。</p>
    <p><img src="/images/6.png"></p>
    <div class="clear"></div>
    <br/>
    <p><span class="sum">3</span>
    <p class="p_definition">安装完毕后可进入&ldquo;<b>评论</b>&rdquo;&gt;&ldquo;<b>友言评论系统</b>&rdquo;进行一系列的自定义设置。</p>
    <p><img src="/images/4.png"></p>
    <div class="clear"></div>
    <br/>
    <br/>
  </div>
  <div class="clear"></div>
</div>
<?php
	include("include/front_footer.php");
?>
</body>
</html>

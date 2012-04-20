<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>wordpress -- 友言</title>
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
    <p>帮助中心</p>
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
    <a name="online"></a>
    <h2 class="main_title">在线安装</h2>
    <br/>
    <div> <span class="sum">1</span>
      <p class="p_definition">进入WordPress（2.7及以上版本）后台管理系统，选择”<b>插件</b>”>”<b>安装插件</b>”，搜索关键字”<b>youyan</b>”。</p>
      <div class="clear"></div>
    </div>
    <br/>
    <p><img src="/images/1.png"></p>
    <div class="clear"></div>
    <br/>
    <br/>
    <div> <span class="sum">2</span>
      <p class="p_definition">搜索到友言评论系统，点击“<b>现在安装”</b>。</p>
      <div class="clear"></div>
    </div>
    <br/>
    <p><img src="/images/2.png"></p>
    <div class="clear"></div>
    <br/>
    <br/>
    <p><span class="sum">3</span>
    <p class="p_definition">安装成功后“<b>启用插件</b>”即可。</p>
    <img src="/images/3.png">
    </p>
    <div class="clear"></div>
    <br/>
    <br/>
    <p><span class="sum">4</span>
    <p class="p_definition">安装完毕后可进入“<b>评论</b>”>“<b>友言评论系统</b>”进行一系列的自定义设</p>
    <img src="/images/4.png">
    </p>
    <div class="clear"></div>
    <br/>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论管理 -- 友言</title>
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
	<a name="comment"></a>
      <h2 class="main_title">评论管理：</h2>
      <p class="p_definition">
          　　全面的评论审核系统。支持发布后审核或是审核后发布。四种审核状态：正常，待审核，垃圾评论，已删除。
    </p>
    <div class="clear"></div><br/>
        
      <p class="p_definition"><b style="color:#109db6; font-weight:normal;">&gt;&gt;</b> 站长可以将任意评论删除，同时也可以将删除的评论恢复</p><br/>
      <p><img src="/images/15.png"></p>
        <p><img src="/images/16.png"></p><br/>
        <div class="clear"></div><br/>
        
      <p class="p_definition"><b style="color:#109db6; font-weight:normal;">&gt;&gt;</b>添加至黑名单的用户或包含敏感词的评论将自动添加至垃圾分类中，并不会再前台显示，站长可以手动将评论恢复为正常评论或是将其从黑名单中删除。</p>
      <br/>
         <p><img src="/images/17.png"></p>
        <p><img src="/images/18.png"></p><br/>
        <div class="clear"></div><br/>
 
      <p class="p_definition"><b style="color:#109db6; font-weight:normal;">&gt;&gt;</b>当站长将评论设置为审核后显示时，所有评论将默认分类至待审核中，前台将不会出现评论，在站长确认后评论才会显示出来。</p>
      <br/>
         <p><img src="/images/19.png"></p>
        <p><img src="/images/20.png"></p><br/>
<div class="clear"></div><br/>
    </div>
    <div class="clear"></div>
</div>
<?php
	include("include/front_footer.php");
?>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用代码 -- 友言</title>
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
    <p>通用代码</p>
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
    <div class="installation">
      <!--通用代码-->
      <div id="showCodePane"> 注册完成后会出现如下图界面<img src="/images/general_code.jpg" alt="通用代码安装" /> </div>
      <div style="color: red;" class="f14" id="copycode_msg"></div>
      <br>
      <h3 class="introductionTitle">
        <div class="itemTitleLine">如何使多个页面的评论合并？</div>
        <br />
      </h3>
      <div class="introductionContent">程序默认将每个URL识别为独立的评论页面，如果您遇到错误的
        识别, 希望多个页面使用同一个评论框, 
        或者页面为模板动态生成，请在javascript中赋予全局变量UYId页面辨别参数。UYId可以为动态生成的值。例如: UYId = 
        &lt;?php echo $_GET['page'];?&gt;;</div>
      <code class="introCodeWrapper">
      <div class="lineF">&lt;meta name="UYId" content="评论框标识ID" /&gt;</div>
      </code>
      <h3 class="introductionTitle">
        <div class="itemTitleLine">一般放在网站哪里？</div>
        <br />
      </h3>
      <div id="where" class="introductionContent">复制并粘贴JS代码,放到您的网页，可以在&lt;body&gt;和&lt;/body&gt;的之间网页的任意位置放置。如果您的网站使用的模板，您也可以复制代码到您的模板，评论将在所有网页自动出现。 </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<?php
	include("include/front_footer.php");
?>
</body>
</html>

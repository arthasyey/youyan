<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FAQ -- 友言</title>
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
<div style="margin-top:15px; margin-bottom:5px"> <a href="http://wpa.qq.com/msgrd?v=3&uin=1735067958&site=qq&menu=yes" target="_blank"><img src="/images/qqbig.png" width="121" height="40" alt="客服QQ" border="0" /></a></div>
<div class="clear"></div>
</div>
</div>
<script type="text/javascript">
 function show_cms_menu(n){
    var obj = document.getElementById("cms_menu_"+n);
	var classname = obj.className;
	var $j = jQuery.noConflict();
	if(classname.indexOf("hide") == -1){
		$j("#cms_ul_"+n).slideUp();
		obj.className = "hide";
	} else {
		$j("#cms_ul_"+n).slideDown();
		obj.className = "show";
	}
}
</script>
</div>
<!-- login main_content-->
<div class="main_content">
  <h2 class="main_title">1. 友言是一个什么工具？做什么的？</h2>
  <p class="p_definition">一个简单而强大的社交评论及聚合平台。用户可以直接用自己的社交网络账户在第三方网站发表评论，并将内容和自己的评论分享给好友；第三方网站既能简单的为自己的网站搭建起一个强大的评论系统，方便用户的使用，也能够通过社会化分享扩大自己内容的传播。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">2. 友言能给网站带来什么？</h2>
  <p class="p_definition">增加网站社交属性，通过友言发出的评论将可自动同步到新浪微博等社交媒体去，实名制提高评论质量，帮助您的网站实现社交网络优化(SMO)，吸引更多的社交回流量。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">3. 友言提供给什么样的用户使用？</h2>
  <p class="p_definition">网站主通过社会化评论框，增加用户粘度，同时也让网站链接分享到互联网各个角落。个人用户可以查看自己在互联网上的所有评论、喜欢自己的评论数、社区评论情况。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">4.会不会影响网页打开速度？</h2>
  <p class="p_definition">友言评论框是通过异步加载的方式来获取数据,不会影响到页面其它内容的加载速度。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">5. 为何注册后不用验证邮箱即可登录？</h2>
  <p class="p_definition">为了简化安装体验流程，提交注册信息后随即登录，无需验证邮箱。站长可直接将获取的通用评论代码插入网站相应位置即可正常使用友言。站长可以通过注册邮箱设置开启用户新鲜事提醒功能，随时掌握网站动态。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">6. 我可以更改友言用户名、密码和注册邮箱吗？</h2>
  <p class="p_definition">友言用户名和注册邮箱一但注册成功是无法更改的。如果您需要变更，可以重新注册一个友言账号。如果您忘记密码，可以通过注册邮箱重置密码。</p>
  <p class="p_definition">站长在友言评论框里回复时采用的是站长的社交账号，并不受站长管理账号的影响，站长管理账号仅用于网站评论管理。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">7. 如何安装友言？都支持哪些平台？</h2>
  <p class="p_definition">任何网站都可以使用友言社交评论系统，只需在首页提交网站域名、用户名、邮箱地址、密码后，即可成功注册并获得友言评论代码，将其复制粘贴到您网站需要评论框的相应位置。</p>
  <p class="p_definition">如果您网站建立在WorldPress博客平台上，友言为WorldPress平台提供了完美植入插件，具体安装方法请参见：<a href="/index.php/youyan_help/wp_install">WorldPress评论插件安装全攻略</a></p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">8. Wordprss插件有哪些社交特性？</h2>
  <p class="p_definition">>>博客文章自动同步至您网站的官方微博。</p>
  <p class="p_definition">>>网友在官方微博的评论自动同步至您的网站。</p>
  <p class="p_definition">>>网站的评论者将转发文章到评论者的微博。</p>
  <p class="p_definition">显著提高网站社交活跃度，形成网站良好的社区氛围！</a></p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">9. 站长如何管理网站的留言信息？</h2>
  <p class="p_definition">友言将评论分为4类，正常评论、待审核评论、垃圾评论及已删除评论。</p>
  <p class="p_definition">>>站长可以任意删除评论，同时也可以将已删除的评论恢复。</p>
  <p class="p_definition">>>添加至黑名单或包含敏感词的评论将自动添加至垃圾评论分类中，不会在前台显示，站长可以手动将评论恢复为正常评论，也可将其从黑名单中删除。</p>
  <p class="p_definition">>>将评论设置为审核后显示时，所有评论将默认分类至待审核中，前台将不会出现该评论，站长确认后评论才会显示。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">10. 个人用户如何管理自己的留言信息？</h2>
  <p class="p_definition">个人用户登陆绑定社交媒体后，可在友言评论系统中查看个人评论记录：</p>
  <p class="p_definition">>>个人的新鲜事与活跃社区展示。</p>
  <p class="p_definition">>>回复、喜欢提醒：在有用户回复您时，您可以在任意使用友言系统的网站中看到。</p>
  <p class="p_definition">>>文章更新提醒：当任意您曾评论过的网站中有文章更新时，友言评论框中会有提醒。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">11.  如果长期不登陆友言，评论数据会不会被删除？</h2>
  <p class="p_definition">所有注册友言并已产生评论的网站，其评论数据会永久保存。</p>
  <div class="clear"></div>
  <br/>
  <br/>
  <h2 class="main_title">12. 使用友言评论代码，安全吗？</h2>
  <p class="p_definition">友言是通过OAuth 2.0系统来实现，服务器多层数据加密权限验证机制，以及多层硬件和软件的多重审核防护，不会泄露任何用户隐私，防护墙保护性很高，可以防止任何恶意攻击，全方位保证用户的使用安全。</p>
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

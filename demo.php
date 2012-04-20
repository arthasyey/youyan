<?php 

header('Location: http://uyan.cc/demo#uyan_frame');
exit;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="zh-CN">
<head>
<style type="text/css"></style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>看好第三方社交评论系统！JiaThis宣布收购友言</title>
<link rel="stylesheet" type="text/css" media="all" href="54654_files/style.css">
<meta name="keywords" content="友言, 社交评论">
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="css/boxy.css" rel="stylesheet" type="text/css">
<link href="css/homepage.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/global.js"></script>
<script language="javascript" src="jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="js/jquery.boxy.js"></script>
<script language="javascript" src="js/youyan_homepage_view.js"></script>
<script language="javascript" src="js/youyan_admin_view.js"></script>
</head>
<body>
<?php
	ini_set('session.save_handler', 'memcache');
	ini_set('session.save_path', 'tcp://localhost:11211');
	header('Content-type:text/html; charset=UTF-8');
	session_start();
	include("application/views/include/front_header.php");
?>
<br />
<div id="wrapper" style="width:715px;">
<div id="content" class="is_singular">
<div class="post single_post" id="post-54654">
<div class="p_content">
  <div class="p_date"> <span class="p_date_ym">2012.01</span> <span class="p_date_d">01</span></div>
  <h2 class="title">看好第三方社交评论系统！JiaThis宣布收购友言</h2>
  <div class="post_info_t"> <span class="p_author"><a href="http://www.36kr.com/p/author/peterburg" title="由 马超—怕水的鱼 发布" rel="author">山雨</a></span> <span class="p_normal" title="2012 年 1 月 1 日 上午 8:10">发表于 2012-01-01 </span>
    <div class="p_share_t"><span id="t_sina_btn"></span> <span id="t_tqq_btn"></span>
    </div>
  </div>
  <div class="entry">
    <p>近日，中国最大的社会化分享工具提供商JiaThis成功收购社会化评论提供商”友言”，通过此次收购，友言的全部业务将整合到JiaThis公司当中。这是自JiaThis成立以来首次重大战略收购。</p>

<p>“友言”(UYAN.CC)是国内领先的第三方实时社交评论工具，上线3个月便有6000多个网站主开始使用此工具。网站主可以利用友言为网站创建自己的社会化评论框，以达到提高网站的访问量及回流量的目的。访问者可以将评论一键同步到各大微博及社交网络上去（目前支持7个社交网站），友言的“完全社交化”的功能，还可以将您网站的官方微博上的评论同步至你的网站。方便用户与用户之间进行更深入的交流。</p>

<p>JiaThis是国内最大的社会化分享工具提供商，目前有50万家网站主正在使用其分享工具。聚合117家社交网站的分享按钮和精准的数据分析，JiaThis推广社会化优化，帮助站长稳步提升网站流量。</p>
    <p><a rel="attachment wp-att-54655"><img class="size-full wp-image-54655 aligncenter" title="youyan" src="54654_files/youyan.png" alt="" height="418" width="536"></a></p>
    <p>Jiathis非常重视本次收购：</p>

<p>此次收购后，Jiathis将利用本身的技术实力，帮助友言开始对平台加大硬件投入，同时进行全面升级，包括利用Memcache、CDN等分布式的技术，全力提升友言的加载速度和性能。</p>

<p>同时，在功能上Jiathis也将与友言团队一起不断完善整套社会化评论解决方案，包括前台JS代码和后台的各项功能。让它对用户更“友”好，对网站主更“友”好。</p>

<p>希望广大站长一如既往的支持友言！</p>
<br />
<br />
  </div>
  <!-- UY BEGIN -->
  <div id="uyan_frame"></div>
  <script type="text/javascript" id="UYScript" src="http://uyan.cc/js/iframe.js?UYUserId=6" async=""></script>
  <!-- UY END -->
</div></div></div></div>
<?php
	include("application/views/include/front_footer.php");
?>
</body>
</html>

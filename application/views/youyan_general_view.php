<?php 
$the_host = $_SERVER['HTTP_HOST'];
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
if($the_host !='uyan.cc'){
  header('HTTP/1.1 301 Moved Permanenty');
  header('Location:http://uyan.cc'.$request_uri);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通用代码获取</title>
<link rel="shortcut icon" href="http://uyan.cc/images/favicon.ico" />
<link rel="Bookmark" href="http://uyan.cc/images/favicon.ico" />
<link href="/css/article.css" rel="stylesheet" type="text/css" />

<link href="/css/global.css" rel="stylesheet" type="text/css">

<link href="/css/boxy.css" rel="stylesheet" type="text/css">

<!--<link href="/css/homepage.css" rel="stylesheet" type="text/css">-->
<style type="text/css">
#aboutUsPane{
	width:415px;
	height:218px;
	position:relative;
	display:none;
}
#loginPane{
	width:415px;
	height:192px;
	position:relative;
	display:none;
}
#alertLogin{
	margin-left:15px;
	font-size:13px;
	font-weight:normal;
}
#closediag,#closediagSpam{
	position:absolute;
	top:-15px;
	right:-15px;
	_top:0;
	_right:0;
	background:url(/images/closeDialog.png) 0 0 no-repeat;
	_background:url(/images/closeDialogIE.png) 0 0 no-repeat;
	width:31px;
	height:31px;
	display:block;
	z-index: 100000;
}
.loginAfterPane h3{
	font-size:14px;
	font-family:微软雅黑,黑体,simsun;
	padding:6px 0 0 37px;
	color:#333;
}
a.introSelfLink{
	text-decoration:none;
	color:#346a9c;
	font-weight:normal;	
}
.loginTitlePane{
	height:29px;
	background-color:#e3eef2;
	border-bottom:1px solid #c9c9c9;
	color:#393939;
	font-family:微软雅黑,黑体,simsun;
	padding-left:36px;
	padding-top:15px;
	font-size:15px;
	margin-bottom:1px;
	font-weight:bold;
}
</style>

<script src="/js/ga.js" async="" type="text/javascript"></script>
<script language="javascript" src="/js/global.js"></script>
<script language="javascript" src="/jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="/js/jquery.boxy.js"></script>
<script language="javascript" src="/js/youyan_homepage_view.js"></script>
<script language="javascript" src="/js/youyan_admin_view.js"></script>
<script language="javascript" src="/js/common.js"></script>
<script type="text/javascript">	
	$("#inputURL").ready( function (){
	  $("#inputURL").val('<?php if(isset($_SESSION["domain"])){echo "http://".$_SESSION["domain"];}?>');
	  <?php if(isset($_SESSION["domain"])){?>
	  //checkDomain();
	  <?php }?>
	});
	$("#pixelWidth").ready( function (){
	  $("#pixelWidth").val('450');							  
	});
	boxWidth = 0;
	itemAmount = 10;
	currentURL='';
	extendPaneState = 0;
	UYUserID = <?php if(isset($_SESSION['uid'])) echo $_SESSION['uid']; else echo 'undefined'; ?>;

<?php if(isset($_SESSION['uid'])){?>
UYUserID = '<?php echo $_SESSION['uid'];?>';<?php }?>
</script>
</head>
<body>
<?php
	include("include/front_header.php");
?>
<div class="main">
  <div class="registration_txt"><a href="javascript:void(0);" style="color:#ccc">1.注册</a><span class="arrow"><img src="/images/arrow.jpg"></span><a href="javascript:void(0);">2.获取代码</a></div>
  <div class="line"></div>
  <div class="registration_box">
    <div class="installation">
      <div class="navigationInstall" style="display:block; height:38px; overflow:hidden;"> 
      <!--      <span style="display:block; float:left; width:600px;"><a class="installNavi installNaviSelected" >通用代码</a> <a class="installNavia " href="/index.php/youyan_help/wp_install">Wordpress用户请点这里</a></span> -->                
      <span class="Platform">
                <p class="p5">选择平台：</p>
            <select name=fruits class="txt5">
                    <option>Banana
                    <option selected>Apple
                    <option value=My_Favorite>Orange
            </select></span>
      <span class="navigationInstall_btn"><a <?php if(isset($_SESSION["uid"])){?> href="/index.php/youyan_admin_pre/index/"<?php }else{?>href="javascript:void(0);" onclick="boxLogin.show();$('#alertLogin').html('');$('#loginForm').attr('class','outlineLogin');"<?php }?>>登录管理后台</a></span>
        <div class="clear"></div>
      </div>
      <!--通用代码-->
      <h3 class="introductionTitle">
        <div class="itemTitleLine">将如下代码插入到网站中需要评论框的位置中</div>
      </h3>
      <div id="showCodePane">
        <div class="codePaneWindow">
          <div class="designPaneTop"></div>
          <div class="designPaneMid">
            <textarea id="getmycode" class="getCodePane" rows="5" wrap="off" onclick="select()"><!-- UY BEGIN -->
<div id="uyan_frame"></div>
<script type="text/javascript" id="UYScript" src="http://uyan.cc/js/iframe.js?UYUserId=<?php echo isset($_SESSION['uid']) ? $_SESSION['uid'] : ''; ?>" async=""></script>
<!-- UY END --></textarea>
            <div class="designPaneCodeArrow"></div>
          </div>
        </div>
      </div>
      <input class="button100" type="button" onclick="setcopy('getmycode');" value="复制代码">
      <br/>
      <div style="color: red;" class="f14" id="copycode_msg"></div>
      <br/>
      <div onclick="divpop('merge');" style="cursor:pointer">
        <h3 class="introductionTitle">
          <div class="itemTitleLine">如何使多个页面的评论合并？<a href="javascript:void(0);" style=" padding-left:6px; font-size:16px;color:#434242; text-decoration:none;"><img id="icon_img_merge" src="/images/xjtd.jpg" border="0"></a></div>
        </h3>
        <div id="merge" style="display:none;">
          <div class="introductionContent">程序默认将每个URL识别为独立的评论页面，如果您遇到错误的识别, 希望多个页面使用同一个评论框, 或者页面为模板动态生成，请在javascript中赋予全局变量UYId页面辨别参数。UYId可以为动态生成的值。例如: UYId = &lt;?php echo $_GET['page'];?&gt;;</div>
          <code class="introCodeWrapper">
          <div class="lineF">&lt;meta name="UYId" content="评论框标识ID" /&gt;</div>
          </code></div>
      </div>
      <div onclick="divpop('where');" style="cursor:pointer">
        <h3 class="introductionTitle">
          <div class="itemTitleLine">一般放在网站哪里？<a href="javascript:void(0);" style=" padding-left:6px; font-size:16px;color:#434242; text-decoration:none;"><img id="icon_img_where" src="/images/xjtd.jpg" border="0"></a></div>
        </h3>
        <div id="where" style="display:none" class="introductionContent">复制并粘贴JS代码,放到您的网页，可以在&lt;body&gt;和&lt;/body&gt;的之间网页的任意位置放置。如果您的网站使用的模板，您也可以复制代码到您的模板，评论将在所有网页自动出现。 </div>
      </div>
      <br />
      <br />
      <div style="font-size:16px;">如在使用过程中出现任何问题欢迎随时发邮件给我们help@uyan.cc 或 QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=1735067958&site=qq&menu=yes" target="_blank">1735067958</a>联系客服！</div>
  </div>
  </div>
</div>
</div>
<?php
	include("include/front_footer.php");
?>
<script type="text/javascript">
function divpop(obj) { 
	var oDiv = document.getElementById(obj); 
	if(oDiv.style.display == 'block'){
		oDiv.style.display = 'none';
		document.getElementById('icon_img_' + obj).src = '/images/xjtd.jpg';
	}else{
		oDiv.style.display = 'block';
		document.getElementById('icon_img_' + obj).src = '/images/xjtd2.jpg';
	}
}
</script>
</body>
</html>

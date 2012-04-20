<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>友言-----社交评论解决方案</title>
    <meta name="keywords" content="友言,友言网,社交媒体评论框,评论框,SNS评论框,社交评论解决方案">
    <meta name="author" content="友言">
    <meta name="description" content="DIY自己网站的社交媒体评论框，稳步增加网站流量。">

<!---
<script language='javascript' src="http://uyan.cc/js/easyXDM.min.js">  
var sso_socket = new easyXDM.Socket({
    swf: "http://uyan.cc/easyXDM/easyxdm.swf"
  });
</script>
!--->

    <script src="js/ga.js" async="" type="text/javascript"></script><script language="javascript" src="js/global.js"></script>
    <script language="javascript" src="jquery.ui/jquery-1.4.2.min.js"></script>
    <script language="javascript" src="js/jquery.boxy.js"></script>
    <script language="javascript" src="js/youyan_homepage_view.js"></script>
    <script language="javascript" src="js/youyan_admin_view.js"></script>

<script type="text/javascript">	
$("#inputURL").ready( function (){
  $("#inputURL").val('');
  });
$("#pixelWidth").ready( function (){
  $("#pixelWidth").val('450');							  
});
boxWidth = 0;
itemAmount = 10;
currentURL='';
extendPaneState = 0;
UYUserID = undefined;
</script>
<link rel="shortcut icon" href="http://uyan.cc/images/favicon.ico" />
<link rel="Bookmark" href="http://uyan.cc/images/favicon.ico" />
<link href="css/global.css" rel="stylesheet" type="text/css">
<link href="css/boxy.css" rel="stylesheet" type="text/css">
<link href="css/homepage.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-25792179-1']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
</head>
<body>
<div class="header">
	<div class="header_top" id="userStatus">
	<?php if(!isset($_SESSION["uid"])){?>
    	<a href="javascript:void(0)" onclick="boxLogin.show();$('#alertLogin').html('');$('#loginForm').attr('class','outlineLogin');">登录</a><a href="/index.php/youyan_register">注册</a>
	 <?php }else{?>
		<a href="javascript:void(0)" onclick="userLogout();">( 退出 )</a><a><?php echo $_SESSION["uname"];?></a>
     <?php }?>
    </div>
</div>
<div class="radial">
    <div class="topWrapper">
        <div class="topContainer">
            <a class="logo" href="http://uyan.cc/" title="评论框预览"></a><a style="text-decoration:none;" href="http://www.jiathis.com" class="introLogoPane" target="_blank">JiaThis旗下产品</a>
            <div class="loginWrapper"> 
                <a id="getcode" href="<?php if(isset($_SESSION["uid"])){?>/index.php/youyan_help/general<?php }else{?>/index.php/youyan_register<?php }?>" onmouseover="mypop('MoreButton', 'show');"
    onmouseout="mypop('MoreButton', 'hide');">获取代码<span class="jiao">▼</span></a>
                <a href="index.php/youyan_help" target="_blank">帮助中心</a> 
                <a id="admin_optid" <?php if(isset($_SESSION["uid"])){?> href="index.php/youyan_admin_pre/index/"<?php }else{?>href="javascript:void(0);" onclick="boxLogin.show();$('#alertLogin').html('');$('#loginForm').attr('class','outlineLogin');$('#clickType').val('admin');"<?php }?> >后台管理</a>    
                <div class="clear"></div>
                <ul id="MoreButton" class="morebutton" style="display:none" onmouseover="mypop('MoreButton', 'show');"
    onmouseout="mypop('MoreButton', 'hide');">
                   <li><a href="<?php if(isset($_SESSION["uid"])){?>/index.php/youyan_help/general<?php }else{?>/index.php/youyan_register<?php }?>">通用代码</a></li>
                   <li><a href="/index.php/youyan_help/index/wp_install_online">WordPress</a></li>
                </ul>
            </div>
             
            <div class="clear"></div>
        </div>
    </div>
    <div class="blueWrapper">
        <div class="blueContainer">
            <div class="devIntro" title="评论框预览" style="cursor:pointer;" onclick="document.location.href='http://uyan.cc/demo.php#uyan_frame';" onmouseover="document.getElementById('demoBTN').style.background='url(../images/demoBTN_ie6.png) 0 -38px no-repeat';" onmouseout="document.getElementById('demoBTN').style.background='url(../images/demoBTN_ie6.png) 0 0 no-repeat';"><div class="demoContainer"><a id="demoBTN" class="demoBTN" href="javascript:;"></a></div></div> 
			<div class="devCreatePane">
                <div class="mainIntro">简单、友好的社会化评论框!
                <p>网站评论框不再是冷冰冰的用户名和email，而是来自各大微博及社交网络的真实用户的言论，增加了交流氛围和乐趣。</p>
                </div>
                <div class="singupWordPressContainer"><a href="#" style="position:absolute; color:#fff; font-size:24px; text-decoration:none; z-index:100; margin-top:12px; margin-left:240px;">▼</a><a style="position:relative; z-index:10;" class="createCodeWPBTN" href="<?php if(isset($_SESSION["uid"])){?>/index.php/youyan_help/general<?php }else{?>/index.php/youyan_register<?php }?>"></a></a></div>
                
                <ul id="MoreButton_btn" class="morebutton_btn" onmouseover="mypop('MoreButton', 'show');"
    onmouseout="mypop('MoreButton', 'hide');">
                   <li><a href="<?php if(isset($_SESSION["uid"])){?>/index.php/youyan_help/general<?php }else{?>/index.php/youyan_register<?php }?>">通用代码</a></li>
                   <li><a href="/index.php/youyan_help/index/wp_install_online">WordPress</a></li>
                </ul>
                <div class="signupContainer"><p></p><a href="/index.php/youyan_help/wp_install">WordPress用户？&nbsp;&nbsp;请点这里</a><div class="clear"></div></div>
                           
            </div>            
            <div class="clear"></div>
            <div style="margin: 26px auto 0; width: 940px;font-size: 16px; color: #FFFFFF;text-shadow: 0 -1px 0 #666;">6000+网站主已经开始使用友言</div>
	        <div class="bannerContainer">
		        <a class="bannerLeftArrow">
		            <img id="larrow" src="/images/leftArrowImage.png" onClick="rollImg(this);" ></img>
		        </a>
		        <div id="scrollImageOut"  onMouseOver="stopscroll();" onMouseOut="doscroll();">
		        <div id="scrollImageInner">
		        <a href="http://www.36kr.com" target="_blank"><img src="/images/logo/36kr.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.134000.net/" target="_blank"><img src="/images/logo/134000.jpg" style="innerLogoImage" ></a>
		        <a href="http://caorun.net" target="_blank"><img src="/images/logo/caorun.jpg" style="innerLogoImage" ></a>
		        <a href="http://team.chengdu.cn/" target="_blank"><img src="/images/logo/chengdu.jpg" style="innerLogoImage" ></a>
		        <a href="http://d-luffy.diandian.com/" target="_blank"><img src="/images/logo/d-luffy.diandian.jpg" style="innerLogoImage" ></a>
		        <a href="http://huodongkong.com/" target="_blank"><img src="/images/logo/huodongkong.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.ingeeks.com" target="_blank"><img src="/images/logo/ingeeks.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.ladymax.cn" target="_blank"><img src="/images/logo/ladymax.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.mp4works.cn/" target="_blank"><img src="/images/logo/mp4works.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.rybbaby.com" target="_blank"><img src="/images/logo/rybbaby.jpg" style="innerLogoImage" ></a>
		        <a href="http://since1984.cn/blog/" target="_blank"><img src="/images/logo/since1984.jpg" style="innerLogoImage" ></a>
		        <a href="http://since1989.org/" target="_blank"><img src="/images/logo/since1989.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.socialbeta.cn" target="_blank"><img src="/images/logo/socialbeta.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.soslx.com/ " target="_blank"><img src="/images/logo/soslx.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.t753.com/" target="_blank"><img src="/images/logo/t753.com.jpg" style="innerLogoImage" ></a>
		        <a href="http://technode.com" target="_blank"><img src="/images/logo/technode.jpg" style="innerLogoImage" ></a>
		        <a href="http://www.thinkpage.net/" target="_blank"><img src="/images/logo/thinkpage.jpg" style="innerLogoImage" ></a>
		        <a href="http://tvbppp.us15.beidc.net/" target="_blank"><img src="/images/logo/tvbppp.us15.jpg" style="innerLogoImage" ></a>
		        <a href="http://uxrun.com/" target="_blank"><img src="/images/logo/uxrun.jpg" style="innerLogoImage" ></a>
		        <a href="http://web20share.com" target="_blank"><img src="/images/logo/web20share.jpg" style="innerLogoImage" ></a>
		        <a href="http://travel.msra.cn/" target="_blank"><img src="/images/logo/msra.jpg" style="innerLogoImage" ></a>
		        </div>
		        </div>
		        <a class="bannerRightArrow">
		            <img id="rarrow" src="/images/rightArrowImage.png"  onClick="rollImg(this);"></img>
		        </a>
		        <div class="clear"></div>
		    </div>
	    	<script language="javascript">
				//scroll images
				var jumpWid = 5;	
				var scrollCnt = 0;//像素滚动次数
				var scrollType = "normal";
				var sc;		
				var scrollImageOut = document.getElementById("scrollImageOut"); 
				var scrollImageInner = document.getElementById("scrollImageInner"); 									 
				var scrollImgCnt = scrollImageOut.offsetWidth/jumpWid;
				var scrollWid=scrollImageOut.scrollWidth;									 
				scrollImageInner.innerHTML+=scrollImageInner.innerHTML;
				doscroll();
			</script>
            
            <div class="clear"></div>
        </div>
          
    </div>
</div>

<div class="grayEmptyWrapper"></div>
<div class="bottomWrapper" id="bottomWrapper">
    <div class="bottomIntroContainer">
        <div class="bottomFeatureTitle">为什么使用社交评论?</div>
        <div class="bottomFeatureItem"><div class="bottomItemPic" id="firstFeature"></div><div class="bottomFeatureIntroPane"><strong>精确定位用户</strong><br>不再是冷冰冰的用户名与邮箱，在他们授权后，您可以看到他们丰富多彩的社交网络信息。</div></div>
        <div class="bottomFeatureSeperate"></div>
        <div class="bottomFeatureItem"><div class="bottomItemPic" id="scecondFeature"></div><div class="bottomFeatureIntroPane"><strong>更多的流量与访客</strong><br>通过社交媒体优化(SMO)，为您带来留言者的好友，增加网络流量，口碑营销更加高效。</div></div>
        <div class="bottomFeatureSeperate"></div>
        <div class="bottomFeatureItem"><div class="bottomItemPic" id="thirdFeature"></div><div class="bottomFeatureIntroPane"><strong>高质量的评论</strong><br>实名制的留言系统，将大大提高评论的质量。</div></div>
        <div class="bottomFeatureSeperate"></div>
        <div class="bottomFeatureItem"><div class="bottomItemPic" id="fourthFeature"></div><div class="bottomFeatureIntroPane"><strong>智能统计</strong><br>系统针对您的网站提供更加全面有效的统计功能，完全掌控网站的信息动向。</div></div>
    </div>
    <div class="footer">
	<div class="footer_bottom">
        <div class="bottomLeftCopyright">© 2011-2012 All Rights Reserved.</div><div class="bottomRightFunction"><span> 浙ICP备11043769号-1</span><a>法律条款</a><a onclick="boxAbout.show();">关于我们</a><a target="_blank" style="margin-top: -3px;" href="http://wpa.qq.com/msgrd?v=3&uin=1735067958&site=qq&menu=yes"><img src="/images/QQkefu_b.png" alt="在线帮助"  /></a><div class="clear"></div></div><div class="clear"></div>
	</div>
</div>
</div>
<!-- login pane-->

<!-- signup pane-->



<!-- about us pane-->







<script language="javascript" type="text/javascript">
$("#loginPane").ready
  (
    function()
    {
      boxLogin=new Boxy($("#loginPane"), {
        modal: false,
          show: false
      });	
    }
);
$("#signupPane").ready
  (
    function()
    {
      boxSignup=new Boxy($("#signupPane"), {
        modal: false,
          show: false
      });	
    }
);
$("#aboutUsPane").ready
  (
    function()
    {
      boxAbout=new Boxy($("#aboutUsPane"), {
        modal: false,
          show: false
      });	
    }
);


</script>
    <style type="text/css">

    /* 460是IE6下top的指定高度 */
    * html #dock {
            position: absolute;
            top: expression((460 + (ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop)) + 'px');
    }

    /* 76%是非IE6浏览器可以指定百分比top高度 */
    #dock_wrap > #dock {
            position: fixed;
            top: 76%;
    }
    #dock_wrap {
            position: relative;
            z-index: 20;
    }
    </style>


<table style="display: none; z-index: 15337; visibility: visible; left: 465.5px; top: 164.5px;" class="boxy-wrapper fixed" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="top-left"></td><td class="top"></td><td class="top-right"></td></tr><tr><td class="left"></td><td class="boxy-inner"><div class="boxy-content" style="display: block;" id="loginPane">
<a class="close" href="#" id="closediag"></a>
<div class="loginTitlePane">登录友言<span id="alertLogin"></span></div>
<div class="loginAfterPane">
<form action="javascript:submitLogin()" id="loginForm" class="currentlogin">
    <div class="loginItemWrapper"><div class="loginItemTitle">Email</div><input class="inputStyle" name="loginEmail" id="loginEmail" type="text"><div class="clear"></div></div>
    <div class="loginItemWrapper"><div class="loginItemTitle">登录密码</div><input class="inputStyle" name="loginPassword" id="loginPassword" type="password"><div class="clear"></div></div>
    <div class="bottomLoginWrapper"><input name="checkReme" id="checkReme" type="checkbox"><div class="checkRemeIntro">记住我</div><input class="loginBTNPane" value="登录" type="submit"><div class="clear"></div></div>
    <input type="hidden" name="clicktype" id="clickType" value="" />
</form>
</div>
</div></td><td class="right"></td></tr><tr><td class="bottom-left"></td><td class="bottom"></td><td class="bottom-right"></td></tr></tbody></table><table style="display: none; z-index: 15338; visibility: visible; left: 451px; top: 110.5px;" class="boxy-wrapper fixed" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="top-left"></td><td class="top"></td><td class="top-right"></td></tr><tr><td class="left"></td><td class="boxy-inner"><div class="boxy-content" style="display: block;" id="signupPane">
<a class="close" href="#" id="closediag"></a>
<div class="loginTitlePane">注册友言<span id="alertLogin"></span></div>
<div class="loginAfterPane">
    <div class="loginItemWrapper"><div class="loginItemTitle"><strong>网站域名</strong></div><input class="inputStyle" name="signupOutDomain" id="signupOutDomain" onblur="checkOutDomain()" type="text"><div class="clear"></div></div>
    <div class="outLinIntro">例如:www.uyan.cc</div>
    <div class="loginItemWrapper"><div class="loginItemTitle">用户名</div><input class="inputStyle" name="signupOutName" id="signupOutName" onblur="checkOutUserName()" type="text"><div class="clear"></div></div>
    <div class="loginItemWrapper"><div class="loginItemTitle">Email</div><input class="inputStyle" name="signupOutEmail" id="signupOutEmail" onblur="checkOutEmail()" type="text"><div class="clear"></div></div>
    <div class="loginItemWrapper"><div class="loginItemTitle">密码</div><input class="inputStyle" name="signupOutPassword" id="signupOutPassword" onblur="checkOutPassword()" type="password"><div class="clear"></div></div>
    <div class="outLinIntro">6位以上</div>
    <div class="bottomSignupWrapper"><a class="loginBTNPane" onclick="submitOutSignup()" id="signupOutBTN">注册</a><div class="clear"></div></div>
</div>
</div></td><td class="right"></td></tr><tr><td class="bottom-left"></td><td class="bottom"></td><td class="bottom-right"></td></tr></tbody></table>
<table style="display: none; z-index: 15339; visibility: visible; left: 465.5px; top: 151.5px;" class="boxy-wrapper fixed" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="top-left"></td><td class="top"></td><td class="top-right"></td></tr><tr><td class="left"></td><td class="boxy-inner"><div class="boxy-content" style="display: block;" id="aboutUsPane">
<a class="close" href="#" id="closediag"></a>
<div class="loginTitlePane">关于友言<span id="alertLogin"></span></div>
<div class="loginAfterPane">
    <h3>官方新浪微博 <a href="http://weibo.com/2325396472" class="introSelfLink" target="_blank">http://weibo.com/2325396472</a></h3>
    <h3>腾讯微博 <a href="http://t.qq.com/uyan_cc" class="introSelfLink" target="_blank">http://t.qq.com/uyan_cc</a></h3>
    <h3>网易微博 <a href="http://t.163.com/8939136856" class="introSelfLink" target="_blank">http://t.163.com/8939136856</a></h3>
    <h3>新浪博客 <a href="http://blog.sina.com.cn/u/2325396472" class="introSelfLink" target="_blank">http://blog.sina.com.cn/u/2325396472</a></h3>
    <h3>搜狐博客 <a href="http://uyannet.blog.sohu.com/" class="introSelfLink" target="_blank">http://uyannet.blog.sohu.com</a></h3>
    <h3>客服邮箱 <a href="mailto:help@uyan.cc" class="introSelfLink" target="_blank">help@uyan.cc</a></h3>
</div>
</div></td><td class="right"></td></tr><tr><td class="bottom-left"></td><td class="bottom"></td><td class="bottom-right"></td></tr></tbody></table></body></html>
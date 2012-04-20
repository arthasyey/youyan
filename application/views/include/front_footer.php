<div class="footer">
	<div class="footer_bottom">
        <div class="bottomLeftCopyright">© 2011-2012 All Rights Reserved.</div><div class="bottomRightFunction"><span> 浙ICP备11043769号-1</span><a>法律条款</a><a onclick="boxAbout.show();">关于我们</a><a target="_blank" style="margin-top: -3px;" href="http://wpa.qq.com/msgrd?v=3&uin=1735067958&site=qq&menu=yes"><img src="/images/QQkefu_b.png" alt="在线帮助"  /></a><div class="clear"></div></div><div class="clear"></div>
	</div>
</div>
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
<script> 
$("li").click(function(){
$(this).addClass("selecthover").siblings().removeClass("selecthover");
}).hover(function(){
$(this).addClass("lihover");
},function () {
$(this).removeClass("lihover");
})
</script>

<table style="display: none; z-index: 15337; visibility: visible; left: 465.5px; top: 164.5px;" class="boxy-wrapper fixed" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td class="top-left"></td><td class="top"></td><td class="top-right"></td></tr><tr><td class="left"></td><td class="boxy-inner"><div class="boxy-content" style="display: block;" id="loginPane">
<a class="close" href="#" id="closediag"></a>
<div class="loginTitlePane">登录友言<span id="alertLogin"></span></div>
<div class="loginAfterPane">
<form action="javascript:submitLogin(''<?php if($info) echo ', \''.$info.'\''; ?>)" id="loginForm" class="currentlogin">
    <div class="loginItemWrapper"><div class="loginItemTitle">Email</div><input class="inputStyle" name="loginEmail" id="loginEmail" type="text"><div class="clear"></div></div>
    <div class="loginItemWrapper"><div class="loginItemTitle">登录密码</div><input class="inputStyle" name="loginPassword" id="loginPassword" type="password"><div class="clear"></div></div>
    <div class="bottomLoginWrapper"><input name="checkReme" id="checkReme" type="checkbox"><div class="checkRemeIntro">记住我</div><input class="loginBTNPane" value="登录" type="submit"><div class="clear"></div></div>
    <input type="hidden" name="clicktype" id="clickType" value="<?php echo (isset($clickType) ? $clickType : ''); ?>" />
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
</div></td><td class="right"></td></tr><tr><td class="bottom-left"></td><td class="bottom"></td><td class="bottom-right"></td></tr></tbody></table>

<div style="display:none">
	<script src="http://s96.cnzz.com/stat.php?id=3762260&web_id=3762260" language="JavaScript"></script>
</div>
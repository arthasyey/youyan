<div class="UYPane">
	<div class="UYTitle"><div></div>		
    	<div class="recommendWrapper"><a class="pageUp" onclick="showShareMenu('up')"><img class="pageUpImage" src="../../images/style4/upDig.png" /><div class="clear"></div></a><a class="pageDown" onclick="pageVoteDowns('up')"><img src="../../images/style4/downDig.png" /></a><div class="clear"></div></div>    
		<div class="recommendAmount" >共有<span id="favPageAmount"></span>人喜欢</div>        
        <a class="UYrightLoginBTN" onclick="UYShowSNS();">登录</a>
		<?php if($_SESSION[$session_name]['use_community']==1){?>
        <a class="UYrightBoxBTN" onclick="UYShowCommunity()">社区</a>
		<?php }?>
	<div class="clear"></div></div>

    <div class="UYIntroducePane"><span id="UYTitleTXT"></span></div>    
    <div class="UYLoginSerious">
        <div class="clear"></div>
    </div>
	<?php if($_SESSION[$session_name]['showScoreItem']==1){?>
	<div class="UYLoginRateWrapper">
		<a class="UYVoteStar" id="UYVoteStar1" onmouseover="UYChangeStar(1)" onmouseout="UYClearStar()" onclick="UYVoteStar(1);"></a>
		<a class="UYVoteStar" id="UYVoteStar2" onmouseover="UYChangeStar(2)" onmouseout="UYClearStar()" onclick="UYVoteStar(2);"></a>
		<a class="UYVoteStar" id="UYVoteStar3" onmouseover="UYChangeStar(3)" onmouseout="UYClearStar()" onclick="UYVoteStar(3);"></a>
		<a class="UYVoteStar" id="UYVoteStar4" onmouseover="UYChangeStar(4)" onmouseout="UYClearStar()" onclick="UYVoteStar(4);"></a>
		<a class="UYVoteStar" id="UYVoteStar5" onmouseover="UYChangeStar(5)" onmouseout="UYClearStar()" onclick="UYVoteStar(5);"></a>
		<div class="UYVoteItemNoti">评分成功</div>
		<div class="clear"></div>
	</div>
	<?php }?>
	<textarea name="comment" cols="100%" rows="8" id="UYCommentCheckBoxS" style="display:block;width:0;height:0;margin:0;padding:0; resize:none;outline:none;border:none;"></textarea>
	<div class="UYInputWrapper" id="UYInputReady">
		<div id="UYinputPhoto"></div>
		<div class="UYInputAllPane">
			<div class="UYInputFrame" id="UYInputPane" >				
				<textarea name='submitUY' id='submitUY' onblur = 'showIntro();' onfocus='hideIntro();if(use_emotions==1){showEmo();}' onkeyup="$('#UYCurrentAmount').html(calc_rest($('#submitUY').val(), 0));" onkeydown="if (event.ctrlKey && event.keyCode == 13){UYCommentButtonClick(document.getElementById('UYSubmitInputBTNConnected'), 'comment');}" ></textarea>
                <div id="UYEmotionBTN" onclick="showEmotionPane()">表情</div>
				<div id="UYEmotionPane"></div>
				<div id='UYLeftNumber'><span id="UYCurrentAmount"></span><span id="UYTotalAmount"></span></div>
			</div>
			<div class="UYMoreFunctionsWrapper"></div>
			<div class="UYLeftArrow"></div>                    	
		</div>
    <div class="clear"></div></div>
    <div class="UYIntroCurrentPage">显示第<span id="UYCurrentPageNum">1-10</span>条 共<span id="UYCommentAmount"></span>条评论</div>    
    <div class="UYsortWrapper"><a class="sortBTN" onclick="showSortMenu()">按热度排序</a>
    <div class="clear"></div></div>
    
    <div class="UYLiteProfileWrapper"></div>
    
	<div class="UYEmptyBoxWrapper"></div>
    
	<div style="clear:both;font-size:0;"></div>
    
	<div class="UYShowList">
		<div style="clear:both;font-size:0;"></div>
		<div class = "UYEmptyComment" style = "display:none"></div>
		<div class = "UYEmptyCommentEnd" style = "display:none"></div>
	</div>
    
	<a class="UYMoreItemsWrapper" onclick="getComments()">查看更多<img src="../images/style4/sorttype.png" class="blueArrowDown" /></a>
    
	<div id="Pagination" class="pagination"></div>
    
	<div id="UYFromPower">
    	<a href="http://uyan.cc" target="_blank">Powered by 友言</a>
    </div> 
<div class="clear"></div></div>

<div id="disqusPane">
<a class="close" href="#" id="closediagLogin" ></a><div></div>
<div class="UYDisqusLeftPane">
	<a class="UYDisqusLefItem UYSinaItem currentDisqusLeftItem" onclick="UYChangeToLogin('sina',this)">新浪微博</a>
    <a class="UYDisqusLefItem UYTencentItem" onclick="UYChangeToLogin('tencent',this)">腾讯微博</a>
    <a class="UYDisqusLefItem UYQQzoneItem" onclick="UYChangeToLogin('qq',this)">QQ空间</a>
    <a class="UYDisqusLefItem UYRenrenItem" onclick="UYChangeToLogin('renren',this)">人人网</a>
    <a class="UYDisqusLefItem UYEasynetItem" onclick="UYChangeToLogin('easyweb',this)">网易微博</a>
    <a class="UYDisqusLefItem UYSohuItem" onclick="UYChangeToLogin('sohu',this)">搜狐微博</a>
    <a class="UYDisqusLefItem UYKaixinItem" onclick="UYChangeToLogin('kaixin',this)">开心网</a>
    <a class="UYDisqusLefItem UYEmailItem" onclick="UYChangeToLogin('email',this)">匿名登录</a>
</div>
<div class="UYDisqusRightPane">
	<div class="UYDisqusLoginPanes" id="UYDisqusLoginSINA">
    	<div class="UYDisLoginInto">使用新浪微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至新浪微博</div>
        <a class="UYDisLoginConBTN connectBTNSINA"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginTENCENT">
        <div class="UYDisLoginInto">使用腾讯微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至腾讯微博</div>
        <a class="UYDisLoginConBTN connectBTNTENCENT"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginQQ">
        <div class="UYDisLoginInto">使用QQ空间帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至QQ空间</div>
        <a class="UYDisLoginConBTN connectBTNQQ"></a>    
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginSOHU">
        <div class="UYDisLoginInto">使用搜狐微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至搜狐微博</div>
        <a class="UYDisLoginConBTN connectBTNSOHU"></a>    
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginRENREN">
        <div class="UYDisLoginInto">使用人人网帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至人人网</div>
        <a class="UYDisLoginConBTN connectBTNRENREN"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginNETEASY">
        <div class="UYDisLoginInto">使用网易微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至网易微博</div>
        <a class="UYDisLoginConBTN connectBTNNETEASY"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginKAIXIN">
        <div class="UYDisLoginInto">使用开心网帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至开心网</div>
        <a class="UYDisLoginConBTN connectBTNKAIXIN"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginMSN">
        <div class="UYDisLoginInto">使用MSN帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至MSN</div>
        <a class="UYDisLoginConBTN connectBTNMSN"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginEMAIL">
    	<div class="loginTitlePane">匿名评论（自动支持Gravatar头像）<span id="alertLoginInner"></span></div>
        <div class="loginAfterPane">
        	<div class="loginItemWrapper"><div class="loginItemTitle">Email*</div><input onkeydown="synchroUAE('Inner');" onkeyup="synchroUAE('Inner');" class="inputStyleInner" type="text" name="UYloginEmailADInner" id="UYloginEmailADInner" /><div class="clear"></div></div>
            <div class="loginItemWrapper"><div class="loginItemTitle">昵&nbsp;&nbsp;称&nbsp;</div><input class="inputStyleInner" style="background-color: #E6E6E6;" onblur="this.style.backgroundColor='#E6E6E6';" onfocus="this.style.backgroundColor='';" type="text" name="UYloginEmailNameInner" id="UYloginEmailNameInner" /><div class="clear"></div></div>
            <div class="loginItemWrapper" style="display:none;"><div class="loginItemTitle">网址/博客</div><input class="inputStyleInner" type="text" name="UYloginEmailURLInner" id="UYloginEmailURLInner" /><div class="clear"></div></div>
            <div class="bottomLoginWrapper"><a class="loginBTNPane" onclick="anLoginInner()">确定</a><div class="clear"></div></div>
        </div>
    </div>
</div>
<div class="clear"></div>
</div>
<script language="javascript" type="text/javascript">
$("#disqusPane").ready
(
  function()
  {
	boxDisqus=new Boxy($("#disqusPane"), {
		modal: false,
		show: false,
		fixed:false,
		center:true,
		y:250
	});

	bindFuncToIcons();
  }
  
);
function synchroUAE(type) {
	if(type == null) type = '';
	$('#UYloginEmailName'+type).val($('#UYloginEmailAD'+type).val().split('@')[0]);
}
</script>

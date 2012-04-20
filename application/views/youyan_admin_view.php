<script language="javascript" src="../../../js/md5.js"></script>
<script language="javascript">
var styleNum = 4;

</script>
<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../../../js/jquery.boxy.js"></script>
<script language="javascript" src="../../../js/youyan_view.js"></script>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../../../js/excanvas.min.js"></script><![endif]-->
<script language="javascript" src="../../../js/youyan_admin_view.js"></script>
<script language="javascript" src="../../../js/youyan_basic_view.js"></script>
<script language="javascript" src="../../../js/youyan_basic_style4_view.js"></script>
<script language="javascript" src="../../../jquery.ui/jquery-1.4.2.min.js"></script>
<!--<script language="javascript" src="js/jquery.pagination.js"></script>-->
<script language="javascript" type="text/javascript" src="../../../js/jquery.flot.min.js"></script>
<script language="javascript" type="text/javascript" src="../../../js/jquery.flot.selection.min.js"></script>

<script language="javascript">
<?php 
if(isset($_COOKIE['uyan_login_cookie'])){ ?>
var loginInfo = '<?php echo $_COOKIE['uyan_login_cookie'];?>';
<?php
$_SESSION['login'] = json_decode($_COOKIE['uyan_login_cookie'], true);
} else { ?>
var loginInfo = '[]';
<?php } ?>

var domain;
var UYUserID;
var currentMore = 0;
var currentPage = '<?php echo strip_tags($article_domain[0]->page);?>';
$("#shareLinkTo").ready(function(){
	$("#shareLinkTo").html('页面: <?php echo strip_tags($article_domain[0]->page_title);?>');
});
function bindToSNS(){
  domain = '<?php echo strip_tags($current_domain);?>';
  UYUserID = '<?php echo $UYUserID;?>';
  window.open('http://uyan.cc/index.php/sina_bind?UYUserID='+UYUserID+'&domain='+domain,'新浪微博','location=yes,left=200,top=100,width=600,height=400,resizable=yes');
}

function unbindToSNS(){
  domain = '<?php echo strip_tags($current_domain);?>';
  UYUserID = '<?php echo $UYUserID;?>';
  $.post('http://uyan.cc/index.php/sina_bind/unbind', {UYUserID: UYUserID, domain: domain}, function(data){
    $("#unBindWrapper").css("display","block");	
    $("#bindedWrapper").css("display","none");	
  });
}

function verifyBinded(){
  domain = '<?php echo strip_tags($current_domain);?>';
  UYUserID = '<?php echo $UYUserID;?>';
  $.post('http://uyan.cc/index.php/sina_bind/verifyBind', {UYUserID: UYUserID, domain: domain}, function(data){
    if(data == '1'){
      $("#unBindWrapper").css("display","none");	
      $("#bindedWrapper").css("display","block");	
    }
  });
}

normalCommentToogle = 1;
readyCommentToogle = 1;
trashCommentToogle = 0;
delCommentToogle = 0;
var session_name = '';
var use_emotions = 0;
var login_bar_auto_hide= 1;
var profile_bar = 0;
window.onload=function(){
updateLoginInfo(loginInfo);
}
var session_name = 'uyan_'+'<?php echo strip_tags($current_domain);?>';
var encoded_default_profile = '<?php echo $_SESSION['domain_data']['default_profile'];?>';
</script>

<link href="../../../css/global.css" rel="stylesheet" type="text/css" />
<link href="../../../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../../../css/youyan_style4.css" rel="stylesheet" type="text/css" />
<link href="../../../css/admin.css" rel="stylesheet" type="text/css" />

<div class="contentWrapper">

	<!--menu-->
    <div class="categoryMenuTopWrapper">
    	<div class="categoryMenuTopContainer">
			<div class="siteNameContainer" id="siteNameContainer"><?php echo strip_tags($_SESSION['showDomain']);?> <?php if($verify==0){echo '<span class="verifyState">[请验证域名所属，在插入评论框代码后将自动验证]</span>';				
        }else if($verify==2){echo '<a class="verifyState" href="http://uyan.cc/index.php/youyan_check_domain">[点击此处验证域名所属]</a>';}?></div>
            <a class="menuTopButton" href="/index.php/youyan_admin_edit">安装与设置</a>
            <a class="menuTopButton" href="/index.php/youyan_admin_trace_user/index/">统计与分析</a>
            <a class="menuTopButton menuTopCurrent" >评论管理</a>
            <div class="clear"></div>
        </div>
    </div>    
    <div class="contentContainer" id="basicContainer">
        <div class="leftWrapper">
        	<div class="leftmenuTitle"></div>
            <a class="menuItem currentMenuItem" onclick="changeToDomain(this)" id="allPagesTab" title="全部页面">
            	<div class="articleTitle">全部页面</div>
                <div class="articleTime"></div>
            </a>
            <?php if($verify!=1){?>
            <a class="menuItem" title="验证">
            	<div class="articleTitle" style="font-size:12px; cursor:default;">域名验证后，<br/>您有评论的页面会在此处列出</div>
                <div class="articleTime"></div>
            </a>
            <?php }?>
        <?php 		
		$startItem = 0;
		foreach($article_domain as $row){?>
        <?php if($row->page_title!=''){?>
        <?php if($startItem ==0){?>
           <a class="menuItem" onclick='changeToPage("<?php echo $row->page;?>", "<?php echo addslashes($row->page_title);?>",this)' title="<?php echo addslashes($row->page_title);?>">
        <?php }else{?>
        	<a class="menuItem" onclick='changeToPage("<?php echo strip_tags($row->page);?>","<?php echo addslashes($row->page_title);?>",this)' title="<?php echo addslashes($row->page_title);?>">
        <?php }?>
           		<div class="articleTitle"><?php echo mb_strimwidth(strip_tags($row->page_title),0,35,'..','utf-8');?></div>
                <div class="articleTime"><?php echo $row->time;?> (评论 <?php echo $row->n_comments;?>)</div>
           </a>
  	    <?php  $startItem++;}}
		echo ($pagination);?>
        </div>
        <div class="rightWrapper">
			<div class="topCommentNavi">
				<a class="newCommentsTab currentNewComments"  onclick="changeCommentNavi('comment',this)">最新评论</a>
				<a class="newCommentsTab" onclick="changeCommentNavi('trend',this)">评论趋势</a>
				<a class="shareLinks actionPaneWrapper" onclick="getRightLink(currentPage);" style="display:none;">发放页面管理权限</a>
		
				<div class="clear"></div>
			</div>
			<div id="commentTabContainer">
			<div class="commentTypeWrapper">
				<div class="selectCommentType normalComment" id="normalCommentType"><input type="checkbox" id="normalCommentCheck" class="commentTypeCheck" value="1" name="normalComment" onclick="changeTypeState('normalComment')" checked="checked" /><div class="selecCommentIntro">正常评论<span id="newNormal"></span></div></div>
				<div class="selectCommentType readyComment" id="readyCommentType"><input type="checkbox" id="readyCommentCheck" class="commentTypeCheck" value="1" name="readyComment" onclick="changeTypeState('readyComment')" checked="checked" /><div class="selecCommentIntro">待审核<span id="newReady"></span></div></div>
				<div class="selectCommentType defaulTypeColor" id="trashCommentType"><input type="checkbox" id="trashCommentCheck" class="commentTypeCheck" value="1" name="trashComment" onclick="changeTypeState('trashComment')" /><div class="selecCommentIntro">垃圾评论<span id="newTrash"></span></div></div>
				<div class="selectCommentType defaulTypeColor" id="delCommentType"><input type="checkbox" id="delCommentCheck" class="commentTypeCheck" value="1" name="delComment" onclick="changeTypeState('delComment')" /><div class="selecCommentIntro">已删除<span id="newDel"></span></div></div>
				<div class="clear"></div>
			</div>			
            <!-- Basic information-->
            <div id="messagesContainer">       
  				<?php if($verify!=1){?>
					<div class="noMessageComment">验证域名后在此处管理评论</div>
				<?php }else{?>
				<script language="javascript">
					getMoreComment();					
				</script>
				<?php if(isset($article_domain)&&$article_domain!=''){?>
				<div id="afterMessage"></div>
				<div class="noMessageState" style="display:none;" >还有没来自用户的评论</div>		
				<div class="unGetmoreCommentBTN"  style="display:none;" >没有更多评论了</div>	
                <?php if(!isset($article_domain[0])){?>
                <div class="unGetmoreCommentBTN"  >还没有评论</div>	
                <?php }else{?>
				<a class="getmoreCommentBTN" onclick="getMorePageComment('<?php echo strip_tags($article_domain[0]->page);?>');" style="display:none;">查看更多</a>
				<?php }}?>				
				<?php }?>
				
			</div>
			</div>
			<div id="trendTabContainer">
			<?php if($verify!=1){?>
				<div class="noMessageComment">验证域名后在此处查看评论趋势</div>
			<?php }else{?>
				<div class="dataWrapper">
					<span id="hidePageLink" style="display:none;"></span>
					<div class="dataTitle"><div class="dataLeftTitleWrapper"><span class="dataLeftTitleTrace">全部页面</span><a href="#" class="linkTo" target="_blank" ></a><div class="clear"></div></div><a id="changeDataAll" onclick="prepareData('all')">全部时间</a><a id="changeDataYear" onclick="prepareData(365)">最近一年</a><a id="changeDataSix" onclick="prepareData(183)">最近六个月</a><a id="changeDataThree" onclick="prepareData(91)">最近三个月</a><a id="changeDataMonth" onclick="prepareData(30)">最近一个月</a><a id="changeDataSeven" onclick="prepareData(7)">最近七天</a><div class="clear"></div></div>	
					<div id="placeholder" style="width:680px;height:160px;"></div>
				</div>
			<?php }?>
			</div>           
</div>    
<div class="clear"></div>
</div>    
</div>
<div id="createLinkPane">
	<a class="close" href="#" id="closediag"></a>
    <div id="shareLinkTo"></div>
	<div class="introCreateLinkTitle">请将此链接发送给编辑，此链接具有编辑当前页面的权限。</div>
    <div class="createLinkCode" contentEditable='true'>http://www.uyan.cc/index.php/youyan_admin_temp/index/PXIEOW312IESC/</div>
</div>
<div id="disqusPane">

<a class="close" href="#" id="closediagLogin" ></a><div></div>
<div class="UYDisqusLeftPane">
	<a class="UYDisqusLefItem UYSinaItem UYSINAItem currentDisqusLeftItem" onclick="UYChangeToLogin('sina',this)">新浪微博</a>
    <a class="UYDisqusLefItem UYTencentItem UYTENCENTItem" onclick="UYChangeToLogin('tencent',this)">腾讯微博</a>
    <a class="UYDisqusLefItem UYQQzoneItem UYQQItem" onclick="UYChangeToLogin('qq',this)">QQ空间</a>
    <a class="UYDisqusLefItem UYRenrenItem UYRENRENItem" onclick="UYChangeToLogin('renren',this)">人人网</a>
    <a class="UYDisqusLefItem UYEasynetItem UYNETEASYItem" onclick="UYChangeToLogin('easyweb',this)">网易微博</a>
    <a class="UYDisqusLefItem UYKaixinItem UYKAIXINItem" onclick="UYChangeToLogin('kaixin',this)">开心网</a>
    <a class="UYDisqusLefItem UYEmailItem UYEMAILItem" onclick="UYChangeToLogin('email',this)">匿名登录</a>
</div>
<div class="UYDisqusRightPane">
	<div class="UYDisqusLoginPanes" id="UYDisqusLoginsina">
    	<div class="UYDisLoginInto">使用新浪微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至新浪微博</div>
        <a class="UYDisLoginConBTN connectBTNSINA"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLogintencent">
        <div class="UYDisLoginInto">使用腾讯微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至腾讯微博</div>
        <a class="UYDisLoginConBTN connectBTNTENCENT"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginqq">
        <div class="UYDisLoginInto">使用QQ空间帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至QQ空间</div>
        <a class="UYDisLoginConBTN connectBTNQQ"></a>    
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginsohu">
        <div class="UYDisLoginInto">使用搜狐微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至搜狐微博</div>
        <a class="UYDisLoginConBTN connectBTNSOHU"></a>    
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginrenren">
        <div class="UYDisLoginInto">使用人人网帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至人人网</div>
        <a class="UYDisLoginConBTN connectBTNRENREN"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLogineasyweb">
        <div class="UYDisLoginInto">使用网易微博帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至网易微博</div>
        <a class="UYDisLoginConBTN connectBTNNETEASY"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginkaixin">
        <div class="UYDisLoginInto">使用开心网帐号登录</div>
        <div class="UYDisLoginIntoTwo">点击按钮登录至开心网</div>
        <a class="UYDisLoginConBTN connectBTNKAIXIN"></a>
    </div>
    <div class="UYDisqusLoginPanes" id="UYDisqusLoginemail">
    	<div class="loginTitlePane">匿名评论<span id="alertLoginInner"></span></div>
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
<div id="emailTypeLogin">
<a class="close" href="#" id="closediag"></a>
<div class="loginTitlePane">匿名评论<span id="alertLogin"></span></div>
<div class="loginAfterPane">
	<div class="loginItemWrapper"><div class="loginItemTitle">Email*</div><input onkeydown="synchroUAE();" onkeyup="synchroUAE();" class="inputStyle" type="text" name="UYloginEmailAD" id="UYloginEmailAD" /><div class="clear"></div></div>
    <div class="loginItemWrapper"><div class="loginItemTitle">昵&nbsp;&nbsp;称&nbsp;</div><input class="inputStyle" style="background-color: #E6E6E6;" onblur="this.style.backgroundColor='#E6E6E6';" onfocus="this.style.backgroundColor='';" type="text" name="UYloginEmailName" id="UYloginEmailName" /><div class="clear"></div></div>
    <div class="loginItemWrapper" style="display:none;"><div class="loginItemTitle">网址/博客</div><input class="inputStyle" type="text" name="UYloginEmailURL" id="UYloginEmailURL" /><div class="clear"></div></div>
    <div class="bottomLoginWrapper"><a class="loginBTNPane" onclick="anLogin()">确定</a><div class="clear"></div></div>
</div>
</div>
<script id="source" language="javascript" type="text/javascript">
verifyBinded();
$("#createLinkPane").ready
(
  function()
  {
	boxCreateLink=new Boxy($("#createLinkPane"), {
		modal: false,
		show: false
	});	
  }
);

</script>
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

	bindFuncToIconsAdmin();
  }
);
$("#emailTypeLogin").ready
(
  function()
  {
    boxEmailLogin=new Boxy($("#emailTypeLogin"), {
        modal: false,
        show: false,
        fixed:false,
        center:true,
        y:250
    });
  }
);
function synchroUAE(type) {
	if(type == null) type = '';
	$('#UYloginEmailName'+type).val($('#UYloginEmailAD'+type).val().split('@')[0]);
}
</script>

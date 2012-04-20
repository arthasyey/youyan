<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>YouYan</title>
    <meta name="keywords" content="YouYan" />
    <meta name="author" content="YouYan" />
    <meta name="description" content="YouYan SNS Talk Service" />
<script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../js/jquery.boxy.js"></script>  
<script language="javascript" src="../js/youyan_view.js"></script>
</head>
<body>

<script type="text/javascript">
<?php if(isset($_SESSION['login'])){/* */ ?>
loginInfo = '<?php echo json_encode($_SESSION['login']); ?>';
<?php }else if(isset($_COOKIE['uyan_login_cookie'])){ ?>
loginInfo = '<?php echo $_COOKIE['uyan_login_cookie'];?>';
<?php
$_SESSION['login'] = json_decode($_COOKIE['uyan_login_cookie'], true);
} else { ?>
loginInfo = '[]';
<?php } ?>

<?php if(isset($_GET['SSOName'])){
  $_SESSION['SSOName'] = $_GET['SSOName'];
  $_SESSION['SSOButton'] = $_GET['SSOButton'];
  $_SESSION['SSOIcon'] = $_GET['SSOIcon'];
  $_SESSION['SSOUrl'] = $_GET['SSOUrl'];
  $_SESSION['SSOLogout'] = $_GET['SSOLogout'];
  $_SESSION['SSOWidth'] = $_GET['SSOWidth'];
  $_SESSION['SSOHeight'] = $_GET['SSOHeight'];
?>
SSOName = '<?php echo addslashes($_GET['SSOName']);?>';
SSOButton = '<?php echo $_GET['SSOButton'];?>';
SSOIcon = '<?php echo $_GET['SSOIcon'];?>';
SSOUrl = '<?php echo $_GET['SSOUrl'];?>';
SSOLogout = '<?php echo $_GET['SSOLogout'];?>';
SSOWidth = '<?php echo $_GET['SSOWidth'];?>';
SSOHeight = '<?php echo $_GET['SSOHeight'];?>';
  /*console.log(SSOName);
console.log(SSOButton);
console.log(SSOIcon);
  console.log(SSOUrl);
  console.log(SSOLogout);
  console.log(SSOWidth);
  console.log(SSOHeight);*/

<?php }?>



domain = '<?php echo $_GET['domain'];?>';
page = '<?php echo $_GET['pageId'];?>';  
title = "<?php echo addslashes($_GET['title']);?>";
pageURL = '<?php echo $_GET['url'];?>';
pageImg = '<?php echo $_GET['pageImg'];?>';
commentStyle = <?php echo $_SESSION[$session_name]['commentStyle'];?>;
digName = '<?php echo $_SESSION[$session_name]['digName'];?>';
digDownName = '<?php echo $_SESSION[$session_name]['digDownName'];?>';
delStyle = <?php echo $_SESSION[$session_name]['delStyle'];?>;
descWord = '<?php echo $_SESSION[$session_name]['descWord'];?>';
mailNotify = <?php echo $_SESSION[$session_name]['mailNotify'];?>;
defaultSort = <?php echo $_SESSION[$session_name]['defaultSort'];?>;
if(defaultSort == 0)
  defaultSort = 'time';
else
  defaultSort = 'hotness';
width = '<?php echo $_SESSION[$session_name]['width'];?>';
if(width == -1)
  width = '100%';
numLimit = <?php echo $_SESSION[$session_name]['numLimit'];?>;
styleNum = '<?php echo $_SESSION[$session_name]['styleNum'];?>';
account_order = '<?php echo $_SESSION[$session_name]['account_order'];?>';
numCommentsPerPage = <?php echo $_SESSION[$session_name]['numCommentsPerPage'];?>;
anon_word = '<?php echo $_SESSION[$session_name]['anon_word'];?>';
anon_url = '<?php echo $_SESSION[$session_name]['anon_url'];?>';
domain_name = '<?php echo $_SESSION[$session_name]['domain_name'];?>';
default_profile = '<?php echo $_SESSION[$session_name]['default_profile'];?>';
button_style = '<?php echo $_SESSION[$session_name]['buttonStyle'];?>';

encoded_default_profile = encodeURIComponent(default_profile);

login_bar_auto_hide = '<?php echo $_SESSION[$session_name]['login_bar_auto_hide'];?>';
use_emotions = '<?php echo $_SESSION[$session_name]['use_emotions'];?>';
use_community = '<?php echo $_SESSION[$session_name]['use_community'];?>';
veryfyCheck = <?php echo $_SESSION[$session_name]['veryfyCheck'];?>;
reply_position = '<?php echo $_SESSION[$session_name]['reply_position'];?>';
profile_bar = '<?php echo $_SESSION[$session_name]['profile_bar'];?>';
showScoreItem = <?php echo $_SESSION[$session_name]['showScoreItem'];?>;
forceStar = <?php echo $_SESSION[$session_name]['forceStar'];?>;
profile_img_url = default_profile;
curSort = defaultSort;

session_name = '<?php echo $session_name;?>';
var clickVote = -1;
SNSTypeToName['EMAIL'] = anon_word;
SNSTypeToBase['EMAIL'] = anon_url;

window.onload=function(){
  /*调用动态数据和和呈现 */
  docReadyFunc();

  /*自适应高度*/
  var getHeight = function(){
    return document.body.scrollHeight;
  };

  var preHeight = getHeight();
  var checkHeight = function(){
    var currentHeight = getHeight();
    if(currentHeight != preHeight){
      parent.socket.postMessage(currentHeight);
      preHeight = currentHeight;
    }
    setTimeout(checkHeight,500);
  };
  setTimeout(checkHeight,500);
};
</script>

<?php if($_SESSION[$session_name]['styleNum']==''||$_SESSION[$session_name]['styleNum']==0){$_SESSION[$session_name]['styleNum']=4;}?>
<script language="javascript" src="../js/youyan_basic_view.js"></script>
<script language="javascript" src="../js/md5.js"></script>
<script language="javascript" src="../js/youyan_basic_style<?php echo $_SESSION[$session_name]['styleNum'];?>_view.js"></script>
<link href="../css/youyan_style<?php echo $_SESSION[$session_name]['styleNum'];?>.css" rel="stylesheet" type="text/css" />
<link href="../user_css/<?php echo $_REQUEST['domain'];?>.css" rel="stylesheet" type="text/css" />
<link href="../css/boxy.css" rel="stylesheet" type="text/css" />

<?php 
  require_once("youyan_basic_style".$_SESSION[$session_name]['styleNum']."_view.php");
?>

<!-- unchanged-->            


<!-- login pane-->
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
<!-- communitybox pane-->
<div id="UYwebsitePane">
    <a class="close" href="#" id="closediagwebsite"></a>
    <div id="UYWebsiteTopPane"><span id="UYWebsiteName"></span><span id="UYWebsiteURL"></span></div>
    <div id="UYGeneralInfoWrapper">
        <div class="UYGeneralWebWrapper UYGeneralComments"><span class="UYGeneralNum" id="UYGeneralCommentNum"></span><br/><span class="UYGeneralIntro">评论数</span></div>
        <div class="UYGeneralWebWrapper UYGeneralLike"><span class="UYGeneralNum"  id="UYGeneralLikeNum"></span><br/><span class="UYGeneralIntro">喜欢数</span></div>
        <div class="UYGeneralWebWrapper UYGeneralUser" style="border:none;"><span class="UYGeneralNum" id="UYGeneralUserNum"></span><br/><span class="UYGeneralIntro">用户数</span></div>
        <div class="clear"></div>
    </div>
    <div class="UYGeneralItemsWrapper">
        <div class="UYGeneralLeftPane">
            <div class="UYGeneralInnerTitle">最活跃的用户</div>            
            <div id="UYGeneralActiveAdd"></div>

        </div>
        <div class="UYGeneralRightPane">
            <div class="UYGeneralInnerTitle">最受支持的用户</div>
            <div id="UYGeneralLikeAdd"></div>
        </div>
        <div class="clear"></div>
    </div>    
    <div class="UYProfileBottom">
        <a class="UYProfileBottomLink" href="http://www.uyan.cc" target="_blank">友言</a>
        <div class="clear"></div>
    </div>
</div>
<!-- profile pange-->
<div id="profiePane">
    <div id="hideUserId"></div>
<a class="close" href="#" id="closediag"></a>
    <div id="UYProfileTopPane">
        <img id="UYProfileImg" src="../images/photoDefault.png" />
        <div class="UYProfileRightWrapper">
            <div class="UYBasicInfoWrapper">
                <a href="#" id="UYProfileName" target="_blank"></a><div class="UYProfileTopItemWrapper UYProfileTalkIcon" id="UYProfileComment">32</div><div class="UYProfileTopItemWrapper UYProfileLikeIcon" id="UYProfileLiked">32</div><div class="clear"></div>
            </div>
            <div class="UYBasicLinkWrapper">
                <a href="#" id="UYBasicLink" target="_blank">http://www.ieo.com/fe221</a>
            </div>
        </div>        
        <div class="clear"></div>
    </div>
    <div class="UYProfileNavi">
        <a class="UYProfileNaviBTN UYProfileNavBTNCurrent" id="UYNewsBTN" onclick="profileChangeNav('news',this);">新鲜事</a>
        <a class="UYProfileNaviBTN" onclick="profileChangeNav('social',this);">活跃社区</a>
        <div class="clear"></div>
    </div>
    <div class="UYProfileItemContainer">
        <div id="UYProfileItemTarget"></div>
    </div>
    <div class="UYProfileItemSocialContainer">
        <div id="UYProfileItemSocialTarget"></div>
    </div>

    <div class="UYProfileBottom">
        <a class="UYProfileBottomLink" href="http://www.uyan.cc" target="_blank">友言</a>
        <div class="clear"></div>
    </div>
</div>


<script type="text/javascript">
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
$("#UYwebsitePane").ready
(
  function()
  {
    boxWebsite=new Boxy($("#UYwebsitePane"), {
        modal: false,
        show: false,
        fixed:false,
        center:true,
        y:250
    });
  }
);
$("#profiePane").ready
(
  function()
  {
    boxProfile=new Boxy($("#profiePane"), {
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
</body>
</html>

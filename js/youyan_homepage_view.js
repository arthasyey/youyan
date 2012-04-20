var currentURL;
var extendPaneState;
var $targetURL;

String.prototype.startWith=function(str){
  var reg=new RegExp("^"+str);
  return reg.test(this);        
} 

var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent.indexOf('safari') != -1); 
var inputtype = 0;

function showEditWP(){
  //control pane visual
  $("#pluginWrapper").css({"display":"block"});
  $("#stepOneWrapper").css({"display":"none"});
  $("#stepTwoWrapper").css({"display":"none"});
  //toogle
  $(".signupContainer").css({"display":"block"});
  $(".afterCreate").remove();

  $("html,body").animate({scrollTop:$("#pluginWrapper").offset().top},1000);
  $(".bottomWrapper").css({"bottom":"0"});
  $(".singupWordPressContainer").css({"display":"none"});
  $(".singupWordPressContainer").after("<div class='afterWPCreate'>简单安装获得您的社交评论框</div>");
}

function showEditFirst(){
  //control pane visual
  $("#pluginWrapper").css({"display":"none"});
  $("#stepOneWrapper").css({"display":"block"});
  if(extendPaneState==1){
    $("#stepTwoWrapper").css({"display":"block"});
  }else{
    $("#stepTwoWrapper").css({"display":"none"});
  }
  //toogle
  $(".singupWordPressContainer").css({"display":"block"});
  $(".afterWPCreate").remove();

  $("html,body").animate({scrollTop:$("#stepOneWrapper").offset().top},1000);
  $(".bottomWrapper").css({"bottom":"0"});
  $(".signupContainer").css({"display":"none"});
  $(".signupContainer").after("<div class='afterCreate'>仅需三步获得您的社交评论框</div>");
  $(".alertSignup").remove();  
}


function checkDomain(type){
  if(type == null) type = '';
  $targetURL = $("#inputURL" + type).val();
  var strRegex = "^((https|http|ftp|rtsp|mms)?://)"  
         + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@  
         + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184  
         + "|" // 允许IP和DOMAIN（域名） 
         + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.  
         + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名  
        + "[a-z]{2,6})" // first level domain- .com or .museum  
        + "(:[0-9]{1,4})?" // 端口- :80  
        + "((/?)|" // a slash isn't required if there is no file name  
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";    
  var $state = $targetURL.match(strRegex); 
  changeTag($state,$("#inputURL" + type));

  return $state;
}

function checkOutDomain(type){
  if(type == null) type = '';
  $targetURL = $("#signupOutDomain" + type).val();
  if($targetURL.length>=50){
	  var $state = null;
  }else{
	 var strRegex = "^((https|http|ftp|rtsp|mms)?://)"  
         + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@  
         + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184  
         + "|" // 允许IP和DOMAIN（域名） 
         + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.  
         + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名  
        + "[a-z]{2,6})" // first level domain- .com or .museum  
        + "(:[0-9]{1,4})?" // 端口- :80  
        + "((/?)|" // a slash isn't required if there is no file name  
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";  
  	var $state = $targetURL.match(strRegex);
  }
  var $msg = new Array();
  $msg.success = '';
  $msg.error = '例如http://www.uyan.cc';
  changeTag($state,$("#signupOutDomain" + type),$msg); 
  return $state;
}

function checkUserName(type){
  if(type == null) type = '';
  var $targetName = $("#inputUserName" + type).val();
  var length = $targetName.replace(/[^\x00-\xff]/g,"**").length;  
  if(length<=0||length>20){
    var $state = null;
  }else{
    var $state = true;
  }
  changeTag($state,$("#inputUserName" + type));

  return $state;
}

function checkOutUserName(type){
  if(type == null) type = '';
  var $targetName = $("#signupOutName" + type).val();
  var length = $targetName.replace(/[^\x00-\xff]/g,"**").length;  
  if(length<=0||length>20){
    var $state = null;
  }else{
    var $state = true;
  }
  if($targetName.indexOf(' ')>=0)
  {
	var $state = null;
  }
  
  changeTag($state,$("#signupOutName" + type));
  return $state;
}

function checkPassword(type){
  if(type == null) type = '';
  var $targetPS = $("#inputPassword" + type).val();
  var length =$targetPS.length;  
  if(length<=6||length>32){
    var $state = null;
  }else{
    var $state = true;
  }
  //alert($targetPS);
  if($targetPS.indexOf(' ')>=0)
  {
	var $state = null;
  }
  changeTag($state,$("#inputPassword" + type));	

  return $state;
}

function checkOutPassword(type){
  if(type == null) type = '';
  var $targetPS = $("#signupOutPassword" + type).val();
  var length =$targetPS.length;  
  if(length<6||length>32){
    var $state = null;
  }else{
    var $state = true;
  }
   //alert($targetPS);
  if($targetPS.indexOf(' ')>=0)
  {
	var $state = null;
  }
  var $msg = new Array();
  $msg.success = '';
  $msg.error = '可输入6-32个字符';
  changeTag($state,$("#signupOutPassword" + type),$msg);	
  return $state;
}

function checkEmail(type){
  if(type == null) type = '';
  var $targetEmail = $("#inputEmail" + type).val();
  var $state =  $targetEmail.match(/^[\w][\w+\.\_]*@\w+(\.\w+)*\.[A-z]{2,}$/g);  
  changeTag($state,$("#inputEmail" + type));

  return $state;
}

function checkOutEmail(type){
  if(type == null) type = '';
  var $targetEmail = $("#signupOutEmail" + type).val();
  var $state =  $targetEmail.match(/^[\w][\w+\.\_]*@\w+(\.\w+)*\.[A-z]{2,}$/g);
  var $msg = new Array();
  $msg.success = '';
  $msg.error = '请输入您的常用邮箱';
  changeTag($state,$("#signupOutEmail" + type),$msg);
  return $state;
}

function changeTag($state,$node,$msg){
  var $info = new Array();
  $info.success = $msg != null ? '<div class="remarks"><span class="remarks_img"><img src="/images/btn_left.gif"></span><span class="txt">' + $msg.success + '</span></div>' : '';
  $info.error = $msg != null ? '<div class="remarks"><span class="remarks_img"><img src="/images/btn_left.gif"></span><span class="txt">' + $msg.error + '</span></div>' : '';
  if($state===null){
    if($node.next().attr("class")!="errorInput"){
      if($node.next().attr("class")=="correctInput"){
        $node.next().remove(); 
      }
      $node.after('<div class="errorInput"></div>'+$info.error);
    }
  }else{
    if($node.next().attr("class")!="correctInput"){
      if($node.next().attr("class")=="errorInput"){
        $node.next().remove();
        if($info.error != '') $node.next().remove();
      }
      $node.after('<div class="correctInput"></div>');
    }	  
  }	
}

function submitURL(){
  $targetURL = $("#inputURL").val();
  if(!$targetURL.match(/^(https?|ftp|mms):\/\//)){
    $targetURL = "http://" + $targetURL;
  }
  if(checkDomain() !==null &&checkUserName() !==null &&checkEmail() !==null &&checkPassword() !==null){
    var targetEmail = $("#inputEmail").val();
    var targetPS = $("#inputPassword").val();
    var targetName = $("#inputUserName").val();
    var targetURL = $("#inputURL").val();
	$targetURL = targetURL;
    $("#URLSubmit").attr("disabled","disabled");
    $("#URLSubmit").html("提交中");		

    $.post("/index.php/youyan_login/signupMaster",
           {
             targetEmail:targetEmail,targetPS:targetPS,targetName:targetName,targetURL:targetURL
           },
           function(data){
             if(data == '0'){
               $("#inputEmail").val("[此邮箱已经注册]");
			   $("#URLSubmit").removeAttr("disabled");
               checkEmail();
             }else{
               var $dataArray = data.split("{}");
			   
			   //update code 
			   $("#text0").val('<!-- UY BEGIN -->\n<div id="uyan_frame"></div>\n<script type="text/javascript" id="UYScript" src="http://uyan.cc/js/iframe.js?UYUserId='+$dataArray[2]+'" async=""></script>\n<!-- UY END -->');
               $(".inputUpTag").css({"display":"none"});
               $(".inputURLWS").css({"display":"none"});
               $(".lgoinPane").css({"display":"none"});
               directlyConfirm();
               $("#showMid").html('<div id="uyan_frame"></div>');
               showEditSecond();
				
               var inputtype = 0;
               $(".bottomWrapper").css({"bottom":"0"});	
               $("#stepOneWrapper").css({"height":"250px"});
	               $("#inputURLpart").before("<div class='accountWrapper'>您好, "+$dataArray[0]+".</div><div class='spreadLine'></div>");
               $("#stepTwoWrapper").css({"display":"block"});
			   $(".introductionCode").show();
               $("html,body").animate({scrollTop:$(".introductionCode").offset().top - 0},1000);
               currentURL = $dataArray[1];
               UYUserID = $dataArray[2];
			   var htmlStr = '<div class="loggedinWrapper"><div class="loggedinLeft"></div><div class="loggedinMid"><a class="topNaviItem homepageNaviItem" href="http://uyan.cc/index.php/youyan_admin_pre/index/">网站管理</a><a class="topNaviItem homepageNaviItem" href="http://uyan.cc/index.php/youyan_admin_help/index/">帮助中心</a><a class="topNaviName homepageNaviName">'+$dataArray[0]+'</a><a class="quitItem" onclick="userLogout();">(退出)</a></div><div class="clear"></div></div>';
               extendPaneState = 1;
               $(".loginWrapper").after(htmlStr);
               $(".loginWrapper").remove();
             }
             $("#URLSubmit").removeAttr("disabled");
             $("#URLSubmit").html("确定");
			 $("#URLSubmit").removeAttr("onclick");			 
			 var newclick1 = new Function("submitURLAL()");
			 $("#URLSubmit").unbind();
			 $("#URLSubmit").attr("onclick","").click(newclick1);
           });
  }
}

function submitOutSignup(type, info){
  if(type == null) type = '';
  if(info == null) info = '';
  $targetURL = $("#signupOutDomain" + type).val();
  if(!$targetURL.match(/^(https?|ftp|mms):\/\//)){
    $targetURL = "http://" + $targetURL;  
  }
    if(checkOutDomain(type) !==null && checkOutEmail(type) !==null && checkOutPassword(type) !==null){
    var targetEmail = $("#signupOutEmail" + type).val();
    var targetPS = $("#signupOutPassword" + type).val();
    // var targetName = $("#signupOutName" + type).val();
    var targetURL = $("#signupOutDomain" + type).val();
	/*$targetURL = targetURL;
    $("#signupOutBTN" + type).attr("disabled","disabled");
    $("#signupOutBTN" + type).html("提交中");*/
    $.post(
      "/index.php/youyan_login/signupMaster",
      {
        // targetEmail:targetEmail,targetPS:targetPS,targetName:targetName,targetURL:targetURL
        targetEmail:targetEmail,targetPS:targetPS,targetURL:targetURL
      },
      function(data){
        if(data == '0'){
          $("#signupOutEmail" + type).val("[此邮箱已经注册]");
          checkOutEmail(type);
		}else if(type != ''){
			location.href="/getcode/"+info;
		}else{
		  var $dataArray = data.split("{}");
		  if($dataArray[3] == '2'){
		    location.href="http://uyan.cc/index.php/youyan_check_domain";	
		  }else{
          	location.href="http://uyan.cc/index.php/youyan_admin_edit";
		  }
        }
      }
      );
  }
}

function submitURLAL(){
  $targetURL = $("#inputURL").val();
  $("#URLSubmit").attr("disabled","disabled");
  $("#URLSubmit").html("提交中");
  if(!$targetURL.match(/^(https?|ftp|mms):\/\//)){
    $targetURL = "http://" + $targetURL;
  }
  if(checkDomain() !==null){
    var targetURL = $("#inputURL").val();
	$targetURL = targetURL;
    $.post(
      "index.php/youyan_login/addWebMaster",
      {
        targetURL:targetURL
      },
      function(data){
        $(".inputUpTag").css({"display":"none"});
        $(".inputURLWS").css({"display":"none"});
        $(".lgoinPane").css({"display":"none"});
        directlyConfirm();
        $("#showMid").html('<div id="uyan_frame"></div>');
        showEditSecond();
        inputtype = 0;
        $(".bottomWrapper").css({"bottom":"0"});	
        $("#stepOneWrapper").css({"height":"250px"});
		
        $("#URLSubmit").attr("enabled","enabled");
		$("#URLSubmit").removeAttr("disabled");
        $("#URLSubmit").html("确定");
        $("#stepTwoWrapper").css({"display":"block"});
		$(".introductionCode").show();
        $("html,body").animate({scrollTop:$(".introductionCode").offset().top - 0},1000);
        currentURL = data;
        extendPaneState = 1;
      });
  }else{
    $("#URLSubmit").attr("enabled","enabled");
	$("#URLSubmit").removeAttr("disabled");
    $("#URLSubmit").html("确定");		
  }
}

  function controlSelect(){
    $unselected = $(".URLKeySelector");
    $unselected.each(function (){
      $prevNode = $(this).prev();
      $prevNode.after('<div class="URLKeyUnselectedConfirm">'+$(this).children(".URLKeySelectorMid").html()+'</div>');	
      $(this).remove();
    })
    $selected = $(".URLSelctedTargetWrapper");
    $selected.each(function (){
      $prevNode = $(this).prev();
      $prevNode.after('<div class="URLKeyUnchangedConfirm">'+$(this).children(".selectedItemWords").html()+'</div>');	
      $(this).remove();
    })
  }

function showEditSecond(){
/*  var oScript= document.createElement("script");
  oScript.id = "UYScript";
  oScript.type = "text/javascript";

  oScript.src = "http://uyan.cc/js/iframe.js?UYUserId=6";
  oScript.async = "";
  var divNode = document.getElementById("uyan_frame");
  divNode.parentNode.insertBefore(oScript, divNode);*/


  $(".selectConfirmBTN").after("<div class='doneBasicWrapper'><div class='doneBasic'>已完成</div><a class='redoBasic' onclick='redoStepOne()'>重新编辑</a><div class='clear'></div></div>");
  $(".selectConfirmBTN").remove();
  $(".slectInputIntro").html('');
  $(".slectInputIntro").css({"padding-top": "0"});
  controlSelect();
}

function directlyConfirm(){
  $(".URLKeySelector").remove();
  $(".URLSelctedTargetWrapper").remove();
  $(".seperateURLPart").remove();
  $(".basicURLPart").html($targetURL);
  $("#inputURLpart").css({"display":"none"});
  $("#selectURLpart").css({"display":"block"});
}

function backtoURL(){
  $("#inputURLpart").css({"display":"block"});
  $("#selectURLpart").css({"display":"none"});
  $("#stepOneWrapper").css({"height":"350px"});
  $("#stepTwoWrapper").css({"display":"none"});
  $(".inputUpTag").css({"display":"none"});
  $(".inputURLWS").css({"display":"none"});
  $("#spreadLineAll").css({"display":"none"});
}

function cancelSelectedKey(currentNode){
  $currentNode=$(currentNode);
  $prevNode = $currentNode.parent('.URLSelctedTargetWrapper').prev();
  $prevNode.after('<a class="URLKeySelector"  onclick="selectKey(this)"><div class="URLKeySelectorMid">'+$currentNode.next(".selectedItemWords").html()+'</div><div class="URLKeySelectorRight"></div><div class="clear"></div></a>');
  $currentNode.parent('.URLSelctedTargetWrapper').remove();
}

function selectKey(currentNode){
  $currentNode=$(currentNode);
  $prevNode = $currentNode.prev();
  $prevNode.after('<div class="URLSelctedTargetWrapper"><a class="URLSelectedTarget" onclick="cancelSelectedKey(this)"></a><div class="selectedItemWords">'+$currentNode.children(".URLKeySelectorMid").html()+'</div><div class="clear"></div></div>');
  $currentNode.remove()	
}

function redoStepOne(){
  backtoURL();
  targetURL = $(".basicURLPart").html();
  $targetURL = targetURL;
  $("#showMid").html("");
  $("#UYalertNoConnection").remove();
  $.post(
    "index.php/youyan_login/checkURLDone",
    {
      targetURL:targetURL
    }
  );	
}


  function changeItemAmount(currentNode){
    $currentNode=$(currentNode);
    $("#amountControl").html($currentNode.val());
    $("#amountControl").css();
  }

  function changeInputPosition(currentNode){
    $currentNode=$(currentNode);
    var strTemp = '<div class="UYInputWrapper">'+$(".UYInputWrapper").html()+'</div><div class="UYLiteProfileWrapper">'+$(".UYLiteProfileWrapper").html()+'</div>';

    switch($currentNode.val()){
      case '2':
      $(".UYInputWrapper").remove();
      $(".UYLiteProfileWrapper").remove();
      $(".pageWrapper").after(strTemp);
      break;
      case '3':
      $(".UYInputWrapper").remove();
      $(".UYLiteProfileWrapper").remove();
      $(".UYTitle").after(strTemp);
      $(".pageWrapper").after(strTemp);
      break;
      default:
      $(".UYInputWrapper").remove();
      $(".UYLiteProfileWrapper").remove();
      $(".UYTitle").after(strTemp);			
    }
  }

  function changeTransparent(currentNode){
    $currentNode=$(currentNode);
    if($currentNode.attr("checked")==true){
      $(".longWrapper").css({"background-color":"transparent"});			
      $(".pageWrapper").css({"background-color":"transparent"});
      $(".itemWrapper").css({"background-color":"transparent"});
      $(".UYLiteProfileWrapper").css({"background-color":"transparent"});
      $(".UYInputWrapper").css({"background-color":"transparent"});
    }else{
      $(".longWrapper").css({"background-color":"#fff"});			
      $(".pageWrapper").css({"background-color":"#fff"});
      $(".itemWrapper").css({"background-color":"#fff"});
      $(".UYLiteProfileWrapper").css({"background-color":"#fff"});
      $(".UYInputWrapper").css({"background-color":"#fff"});		
    }
  }

function generateCodeShow(){//提交后台设置
  if(currentURL != undefined)
    domain = currentURL;
  var itemAmount = $('#selectItemAmount').val();
  var widthState = $("input[name='widthRadio']:checked").val();
  var width;
  if(widthState == 1){
    width = $("#pixelWidth").val();
  }
  else
  width = -1;

  var limitState = $("input[name='limitRadio']:checked").val();
  var numLimit;
  if(limitState == 1){
    numLimit = $("#limitNumber").val();
  }
  else
  numLimit = -1;

  var commentStyle = $("input[name='digRadio']:checked").val();
  var digName = $('#digName').val();
  var digDownName = $("#digDownName").val();

  var mailNotify;
  if(!$("#checkAlertEmail").attr('checked')){
    mailNotify = -1;
  }
  else
  mailNotify = $("#emailAmount").val();

  var descWord = $("#titleWords").val();
  var delStyle = $("input[name='delRadio']:checked").val();
  var defaultSort = $("input[name='sortRadio']:checked").val();

  var account_order = buildAccountOrder();

  var anon_url = $("#anon_url").val();
  if(!anon_url.startWith('http://')){
    anon_url = 'http://' + anon_url;
  }

  var domain_name = $("#domain_name").val();

  var styleNum = parseInt($("input[name='selectStyleRadio']:checked").val()) + 3;
  
  //top button style
  var buttonState = $("input[name='selectBTNRadio']:checked").val();
  var buttonNum;
  if(buttonState == 3){
    buttonNum = 3;
  }else if(buttonState == 2){
	buttonNum = 2;  
  }else{
  	buttonNum = 1;
  }
  var topButtonStateCheck = $("input[name='topLoginBTNRadio']:checked").val();
  if(topButtonStateCheck == 0){
  	buttonNum = 0;
  }
  
  //auto hide login button
  var autoHideState = $("input[name='topLoginRadio']:checked").val();
  var autoHideNum;
  if(autoHideState == 1){
    autoHideNum = 1;
  }
  else
  autoHideNum = 0;
  //position for new comment
  var replyPositionRadioState = $("input[name='replyPositionRadio']:checked").val();
  var replyPosition;
  if(replyPositionRadioState == 1){
    replyPosition = 1;
  }
  else
  replyPosition = 0;
  //reply num for one comment
  var replyItemAmount = $('#selectReplyItemAmount').val();
  //emotion state
  var emotionRadioState = $("input[name='emotionRadio']:checked").val();
  var emotionDisplay;
  if(emotionRadioState == 1){
    emotionDisplay = 1;
  }
  else
  emotionDisplay = 0;  
  //emotion state
  var comunityRadioState = $("input[name='comunityRadio']:checked").val();
  var comunityDisplay;
  if(comunityRadioState == 1){
    comunityDisplay = 1;
  }
  else
  comunityDisplay = 0;    

  //change sns message
  var sns_message = $("#sns_message").val();
  if(sns_message ==''){
	  sns_message='{user_comment} —— 评论于《{page_title}》{website_info}{short_link}';
  }
  //get images state
  var sendImageState = $("input[name='snsWithPhoto']:checked").val();
  var sendImageDisplay;
  if(sendImageState == 1){
    sendImageDisplay = 1;
  }
  else
  sendImageDisplay = 0;    
  //after veryfy
  var checkCommentState = $("input[name='checkCommentRadio']:checked").val();
  var veryfyCheck;
  if(checkCommentState == 1){
    veryfyCheck = 1;
  }
  else
  veryfyCheck = 0;
  //profile
  var profileState = $("input[name='profileRadio']:checked").val();
  var profileCheck;
  if(profileState == 1){
    profileCheck = 1;
  }
  else
  profileCheck = 0;  
  //profile
  var starState = $("input[name='selectStarBTNRadio']:checked").val();
  var starCheck;
  if(starState == 1){
    starCheck = 1;
  }
  else
  starCheck = 0; 
  //force star
  
  var forceStar;
  if(!$("#selectForceVote").attr('checked')){
    forceStar = 0;
  }
  else
  forceStar = 1;
  $.post("http://uyan.cc/index.php/youyan_admin_edit/saveSetting",
         {
           domain: domain,
           width: width,
           numCommentsPerPage: itemAmount,
           numLimit: numLimit,
           commentStyle: commentStyle,
           digName: digName,
           digDownName: digDownName,
           mailNotify: mailNotify,
           descWord: descWord,
           delStyle: delStyle,
           defaultSort: defaultSort,
           account_order: account_order,
           anon_url: anon_url,
           domain_name: domain_name,
		   styleNum : styleNum,
		   buttonNum: buttonNum,
		   autoHideNum: autoHideNum,
		   replyPosition: replyPosition,
		   replyItemAmount: replyItemAmount,
		   emotionDisplay: emotionDisplay,
		   comunityDisplay: comunityDisplay,
		   sns_message: sns_message,
		   sendImageDisplay: sendImageDisplay,
		   veryfyCheck: veryfyCheck,
		   profileCheck:profileCheck,
		   showScoreItem:starCheck,
		   forceStar:forceStar

         });

  $(".generateWrapper").css({"background":"url('images/arrowDown.png') no-repeat scroll 220px 0 transparent"});
  $("#showCodePane").css({"display":"block"});
  $("#seperateLineCreate").css({"display":"block"});
  $(".introductionCode").css({"display":"block"});
  //$("#stepTwoWrapper").css({"min-height":"1840px"});
  $(".generateWrapper").css({"padding":"0"});
  $(".bottomWrapper").css({"background":" url('images/sucessBottom.png') no-repeat scroll center 66px transparent"});
  $(".bottomDetailWrapper").css({"background":"url('../images/bottomTopLine.png') repeat-x scroll 0 0 #6E7C4F"});
  $(".bottomDetailContainer").css({"background":"url('/images/bottomShadowGreen.png') repeat-x scroll 0 55px #5d644f"});
  $("html,body").animate({scrollTop:$(".introductionCode").offset().top},1000);
  //$("#showCodePaneBTN").html("重新生成");
  regenerateCode();
}

function regenerateCode(){
  var retCode = '<!-- UY BEGIN -->\n<div id="uyan_frame"></div>\n<script type="text/javascript" id="UYScript" src="http://uyan.cc/js/iframe.js?UYUserId='+UYUserID + '" async=""></script>\n<!-- UY END -->'; 
  $(".getCodePane").val(retCode);
}


function getCode(id){
  text = $("#text0").val();
  $("#text0").select();
  if(text == null || text == "") {
    $("#copyAlert").html('没有要复制的内容');
    return false;
  }
  if(is_ie) {
    clipboardData.setData('Text', text);
    $("#copyAlert").html('代码复制成功,<br/>直接可以粘贴使用');
  }else{
    $("#copyAlert").html('你使用的是非IE核心浏览器，<br/>请按下 Ctrl+C 复制代码到剪贴板');
  }
}

function submitLogin(type, info){
  if(type == null) type = '';
  if(info == null) info = '';
  var email = $("#loginEmail" + type).val();
  var loginPassword = $("#loginPassword" + type).val();
  var clickType = $("#clickType" + type).val();
  if($("#checkReme" + type).attr("checked")){
    var rem = 1;
  }else{
    var rem = 0;
  }
  var state =  email.match(/^[\w][\w+\.\_]*@\w+(\.\w+)*\.[A-z]{2,}$/g);
  $("#alertLogin" + type).html("");
/*  $(".loginBTNPane").html("加载中");*/
  if(state && loginPassword!=''){
    $.post(
      "/index.php/youyan_login/userLogin",
      {
        email: email,
        loginPassword:loginPassword,
        rem:rem
      },
      function(data){
        if(data=='noData'){
          $("#alertLogin" + type).html("您输入的邮箱或密码有误");
/*          $(".loginBTNPane").html("登录");*/
        }else if(clickType == ''){
        	boxLogin.hide();
            backtoURL();
			data = data.replace(/\"/g,"");
            $("#userStatus").html('<a href="javascript:void(0)" onclick="userLogout();">( 退出 )</a><a>'+data+'</a>');
            $("#admin_optid").attr('href', '/index.php/youyan_admin_pre/index');
            $("#admin_optid").attr('onclick', '');
        }else if(clickType == 'admin'){
        	location.href="/index.php/youyan_admin_pre/index";
        }else if(clickType == 'getcode'){
        	location.href="/getcode/"+info;
        }else if(type != ''){
        	location.href="/index.php/youyan_help/general";
        }else{
        	location.href="/index.php/youyan_help/general";
        	
        	
          /*console.log('is going to post');
          //$(".loginBTNPane").html("登录成功");
          //uyan_socket.postMessage(data);

          if($("#loginForm" + type).attr('class')=='outlineLogin'){
            location.href="/index.php/youyan_admin_pre/index/";
          }else{
            boxLogin.hide();
            backtoURL();
			data = data.replace(/\"/g,"");
            $("#inputURLpart").before("<div class='accountWrapper'>您好, "+data+".</div><div class='spreadLine'></div>");
			$("#URLSubmit").removeAttr("onclick");			 
			 var newclick1 = new Function("submitURLAL()");
			 $("#URLSubmit").unbind();
			 $("#URLSubmit").attr("onclick","").click(newclick1);
          }
		  data = data.replace(/\"/g,"");
		  var htmlStr = '<div class="loggedinWrapper"><div class="loggedinLeft"></div><div class="loggedinMid"><a class="topNaviItem homepageNaviItem" href="http://uyan.cc/index.php/youyan_admin_pre/index/">网站管理</a><a class="topNaviItem homepageNaviItem" href="http://uyan.cc/index.php/youyan_admin_help/index/">帮助中心</a><a class="topNaviName homepageNaviName">'+data+'</a><a class="quitItem" onclick="userLogout();">(退出)</a></div><div class="clear"></div></div>';
          $(".loginWrapper").after(htmlStr);
          $(".loginWrapper").remove();
          $(".lgoinPane").remove();*/
        }
      });
  }else{
    $("#alertLogin" + type).html("请输入格式正确的邮箱及密码");
    $(".loginBTNPane").html("登录");
  }
}

function changeDigState(){
  $upVal = $("#digName").val();
  $downVal = $("#digDownName").val();
  $(".upAl").html($upVal);
  $(".downAl").html($downVal);
}

function moreEmail(type){
  if(type=='more'){
    $(".checkEmailIntro").after("<div class='clear'></div><div class='moreEmailDetail'><span class='emailAmountIntro'>每<input name='emailInternal' type='text' id='emailAmount' value='5'/>条评论发一封邮件</span><div class='clear'></div></div>");		
  }else{
    $(".moreEmailDetail").remove();
  }
}

/****
*
prepare for image scroll
*
***/

function doMarquee()
{
	scrollCnt++;
			
	if(scrollType == "normal"){
			
		if(scrollImageOut.scrollLeft<(scrollImageOut.scrollWidth-scrollImageOut.offsetWidth)){
			scrollImageOut.scrollLeft=scrollImageOut.scrollLeft+1;
		}else{
			scrollImageOut.scrollLeft=scrollWid-scrollImageOut.offsetWidth;
		}
		
	}else if(scrollType == "speedForward"){//点击前进箭头
		if(scrollCnt < scrollImgCnt){
			if(scrollImageOut.scrollLeft<(scrollImageOut.scrollWidth-scrollImageOut.offsetWidth)){
				scrollImageOut.scrollLeft=scrollImageOut.scrollLeft+5;
			}else{
				scrollImageOut.scrollLeft=scrollWid-scrollImageOut.offsetWidth;
			}
		}else{
			scrollCnt = 0;
			stopscroll();		
			doscroll();		
		}
		
	}else if(scrollType == "speedBack"){//点击后退箭头

		if(scrollCnt < scrollImgCnt){
/*			alert(scrollImageOut.scrollLeft);
			alert(scrollWid-scrollImageOut.offsetWidth);*/
			if(scrollImageOut.scrollLeft>(scrollWid-scrollImageOut.offsetWidth)){
				scrollImageOut.scrollLeft=scrollImageOut.scrollLeft-5;
			}else{
				scrollImageOut.scrollLeft=scrollImageOut.scrollWidth-scrollImageOut.offsetWidth;
			}
			
		}else{
			scrollCnt = 0;
			stopscroll();
			doscroll();
		}
	}	
}

//点击箭头向后加快翻动图片(点击向左箭头)
function speedForward()
{
	scrollType = "speedForward";		
	sc=setInterval(doMarquee,1);

		
}

//点击箭头向前加快翻动图片(点击向右箭头)
function speedBack()
{
	scrollType = "speedBack";	
	sc=setInterval(doMarquee,1);
}

function doscroll()
{
	scrollType = 'normal';
  	sc=setInterval(doMarquee,15);
}

function stopscroll()
{
	 	clearInterval(sc);
  
}

//左右翻动图片
function rollImg(obj){
	
	stopscroll();
	scrollCnt = 0;
	if(obj.id == "larrow"){//向后翻动图片(点击向左箭头)
		speedForward();
	}else if(obj.id == "rarrow"){//向前翻动图片(点击向右箭头)
		speedBack();
	}

}
function toogleDemoBTN(type){
	if(type==1){
		$(".demoBTN").show();
	}else{
		$(".demoBTN").hide();
	}
}

function mypop(obj, sType) { 
	var oDiv = document.getElementById(obj); 
	if (sType == 'show') {oDiv.style.display = 'block';
		$("#getcode").attr("style", "background: none repeat scroll 0 0 #109DB6;border-radius:3px 3px 3px 3px");} 
	if (sType == 'hide') {oDiv.style.display = 'none';$("#getcode").removeAttr("style");}
}

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

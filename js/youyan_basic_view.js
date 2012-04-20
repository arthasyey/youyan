var IE6 = 0;
var autoFixWidth;
var InputAmount;
var $emotionReplySTR='';
var profileItemNum=0;
var profileSocialNum = 0;

String.prototype.trim=function(){
     return this.replace(/(^\s*)(\s*$)/g, '');
}
/**
 * 默认的输入框内容
 */
switch(styleNum){
  case '4':
  var UYPrepareInputWord='输入您的评论...';
  break;
  default:
  var UYPrepareInputWord='我想说...';
  break;
}
/**
 * 通过用户提供的email获取gravatar头像,如果从gravatar官网无返回值，则返回站长自定义头像
 */
function get_gravatar(email){
    return 'http://www.gravatar.com/avatar/' + hex_md5(email) + "?s=50&d=" + encoded_default_profile;
}
/**
 * 获得当前页面的推荐数，有多少人喜欢
 */
function getRecommend(){
  $.ajax({
    type:"POST",
    url:"youyan_content/getRecommend",
    dataType: 'json',
    data:{
      page: page
    },
    success: function(data){
      $("#favPageAmount").html(data.n_up);
    },
    cache:false,
    error:function(data){
    }
  });
}

/*function updateLoginInfoSSO(str){
  var data;
  if(str){
    data = jQuery.parseJSON(str);
  }
}*/

/**
 * 获得网站社区基本信息，包括网站名、用户量等，更新至打开的社区页面
 */
function getWebBox(){
  $.ajax({
    type:"POST",
    url:"youyan_content/getWebBox",
    dataType: 'json',
    data:{
      domain: domain
    },
    success: function(data){
      $("#UYWebsiteName").html(data.domain_name);
      $("#UYWebsiteURL").html(data.domain);
      $("#UYGeneralCommentNum").html(data.n_comments_all);
      $("#UYGeneralLikeNum").html(data.n_up);
      $("#UYGeneralUserNum").html(data.n_users);
    },
    cache:false,
    error:function(data){
    }
  });
}
/**
 * 在网站社区中，进一步加载热门用户、最受支持用户等信息。
 */
function getMoreWebUserInfo(){
  $(".UYGeneralItemsWrapper").append("<span id='loadingMoreUser'>加载中..</span>");
  $(".UYGeneralInnerTitle").hide();
  $.ajax({
    type:"POST",
    url:"youyan_content/getWebBoxUser",
    dataType: 'json',
    data:{
      domain: domain
    },
    success: function(data){
      $(".UYGeneralInnerTitle").show();
      $(".UYGeneralPeople").remove();
      var dataActive = data.active;
      var data_img = '';
	  /**
	   * 评论最多用户等信息
	   */	  
      $.each(dataActive, function(data_key, data_val){
        data_img = data_val.profile_img;
        if(data_val.n_comments==null)data_val.n_comments=0;
        if(data_val.show_name!=''&&data_val.show_name!=null&&data_val.user_id!='100'){
          if(data_val.profile_img=='')data_img = 'http://uyan.cc/images/photoDefault.png';			
          $("#UYGeneralActiveAdd").before('<div class="UYGeneralPeople"><div class="UYavatar" onclick="openProfile(\''+data_val.user_id+'\',this);"><img src="'+data_img+'"></div><div class="namePartWrapper"><a class="UYnameAvatar" onclick="openProfile(\''+data_val.user_id+'\',this);">'+data_val.show_name+'</a><div class="UYcommentsAvatar">'+data_val.real_comments+' 次评论</div></div><div class="clear"></div></div>');
        }
      });  
      var dataLiked = data.like;
	  /**
	   * 最受支持用户等信息
	   */
      $.each(dataLiked, function(data_key, data_val){
        data_img = data_val.profile_img;
        if(data_val.n_comments==null)data_val.n_comments=0;
        if(data_val.profile_img=='')data_img = 'http://uyan.cc/images/photoDefault.png';
        if(data_val.show_name!=''&&data_val.show_name!=null&&data_val.user_id!='100'){
          $("#UYGeneralLikeAdd").before('<div class="UYGeneralPeople"><div class="UYavatar" onclick="openProfile(\''+data_val.user_id+'\',this);"><img src="'+data_img+'"></div><div class="namePartWrapper"><a class="UYnameAvatar" onclick="openProfile(\''+data_val.user_id+'\',this);">'+data_val.show_name+'</a><div class="UYcommentsAvatar">'+data_val.real_up+' 喜欢</div></div><div class="clear"></div></div>');
        }
      }); 
      $('#loadingMoreUser').remove();
      var currentHeight = $("#UYwebsitePane").height();
      var topHeight = $(".UYTitle").height()+$(".UYIntroducePane").height()+$(".UYLoginSerious").height()+$(".UYInputWrapper").height()+$(".UYIntroCurrentPage").height()+$(".UYsortWrapper").height()+$(".UYLiteProfileWrapper").height()+$(".UYEmptyBoxWrapper").height()+$(".UYShowList").height();
      if(topHeight+20<currentHeight){
        if(IE7||IE6){

        }else{
          $(".UYShowList").height(currentHeight-topHeight+$(".UYShowList").height());
        }
      }		
    },
    cache:false,
    error:function(data){
      $('#loadingMoreUser').remove();
    }
  });	
}
/**
 * 调用评论框时判断站长是否自定义css，如果有，加载到页面的head中
 */
function loadcssfile(filename, filetype) {
  if (filetype == "css") {
    var fileref = document.createElement("link");
    fileref.setAttribute("rel", "stylesheet");
    fileref.setAttribute("type", "text/css");
    fileref.setAttribute("href", filename)
  }
  if (typeof fileref != "undefined") document.getElementsByTagName("head")[0].appendChild(fileref)
}


/**
 * 返回google短链接
 */

function getShortURL(){
  var thelongUrl = location.href;
  var shortUrl;

  $.ajax({
    type:"POST",
    url:"google_urlshortener/shorten",
    data:{
      longUrl: thelongUrl
    },
    success: function(data){
      shortUrl = data;
    },
    cache:false,
    error:function(){
    }
  });
  return shortUrl;
}

/**
 * 页面全局点击判断，侦听全部页面元素点击状况，主要用于用户点击非菜单范围，隐藏菜单功能
 */
document.onclick=function showme(event){
  var targ;
  var e=event;
  if (!e) var e = window.event;
  if (e.target) targ = e.target;
  else if (e.srcElement) targ = e.srcElement;
  if (targ.nodeType == 3)// defeat Safari bug
  targ = targ.parentNode;
  $target = $(targ);
/**
 * 隐藏表情菜单
 */
  if($target.attr("id")!="UYEmotionBTN"&&$target.attr("id")!="submitUY"&&$target.attr("id")!="UYEmotionPane"&&$target.attr("class")!="emotion"&&$target.attr("class")!="hoverplace"&&$target.attr("class")!="aliEmotionWrapper"&&$target.attr("class")!="emotionNavWrapper"&&$target.attr("class")!="currentEmotionTab"&&$target.attr("class")!="unselectEmotionTab"){
    hideEmo();
  }
/**
 * 隐藏回复处的表情菜单
 */
  if($target.attr("id")!="UYEmotionReplyBTN"&&$target.attr("id")!="UYreplyInput"&&$target.attr("id")!="UYEmotionReplyPane"&&$target.attr("class")!="emotion"&&$target.attr("class")!="hoverplace"&&$target.attr("class")!="emotionNavWrapper"&&$target.attr("class")!="unselectEmotionTab"&&$target.attr("class")!="currentEmotionTab"&&$target.attr("class")!="snEmotionWrapper"&&$target.attr("class")!="aliEmotionWrapper"){
    hideReplyEmo();
  }
/**
 * 隐藏排序菜单
 */
  if($target.attr("id")!='sortTypeMenu'&&$target.attr("id")!='UYCommentAmount'&&$target.attr("id")!='UYTitleTXT'&&$target.attr("class")!='sortBTN'&&$target.attr("class")!='typeIntro'&&$target.attr("class")!='sortLink'&&$target.attr("class")!='sortLink currentSort'){
    $("#sortTypeMenu").remove();
  }
/**
 * 隐藏顶菜单
 */
  if($target.attr("class")!='pageUp'&&$target.attr("class")!='pageUpImage'&&$target.attr("id")!='shareTypeMenu'&&$target.attr("class")!='shareIntro'&&$target.attr("class")!='shareLine'&&$target.attr("class")!='sharecheckbox'&&$target.attr("class")!='shareImageIntro SINAshare'&&$target.attr("class")!='shareImageIntro RENRENshare'&&$target.attr("class")!='shareImageIntro QQshare'&&$target.attr("class")!='actionSharePane'&&$target.attr("class")!='doShare'&&$target.attr("class")!='cancelShare'){
    $("#shareTypeMenu").remove();
  }
/**
 * 隐藏回复提醒菜单
 */
  if($target.attr("id")!='UYnotiboxWrapper'&&$target.attr("class")!='UYnotiTitleLeft'&&$target.attr("class")!='UYnotiShowAll'&&$target.attr("class")!='UYnotiboxTitleWrapper'&&$target.attr("class")!='UYnotiItemWrapper'&&$target.attr("class")!='UYnotiPhoto'&&$target.attr("class")!='UYnotiName'&&$target.attr("class")!='UYnotiIntro'&&$target.attr("class")!='UYProfileNotification'&&$target.attr("class")!='UYProfileNotiIntro'){
    $("#UYnotiboxWrapper").hide();
  } 
/**
 * 隐藏文章提醒菜单
 */
  if($target.attr("id")!='UYnotiboxArticleWrapper'&&$target.attr("class")!='UYnotiTitleLeft'&&$target.attr("class")!='UYnotiShowAll'&&$target.attr("class")!='UYnotiboxTitleWrapper'&&$target.attr("class")!='UYnotiItemWrapper'&&$target.attr("class")!='UYnotiPhoto'&&$target.attr("class")!='UYnotiName'&&$target.attr("class")!='UYnotiIntro'&&$target.attr("class")!='UYProfileNotiArtiIntro'&&$target.attr("class")!='UYnotiboxArticleWrapper'&&$target.attr("class")!='UYnotiIntroAr'&&$target.attr("class")!='UYnotiNameURLAr'&&$target.attr("class")!='UYProfileArticle'&&$target.attr("class")!='backTolistTitle'&&$target.attr("class")!='UYnotiNameURL'){
    $("#UYnotiboxArticleWrapper").hide();
  }
}
/**
 * 从数据库中站长设置的置顶菜单按钮排序来生成置顶登录按钮
 */
function getTopLogin(){
  var inner = '';	
  if(SSOName != undefined){
      if(button_style==2){
        var item = '<a class="UYDisqusTopItemSmall connectBTNSSO connectBTNSSOSmall" style="background-image:url(' + SSOIcon + '); width:25px;height:24px;border:none;outline:none;"></a>';
      }else{
        var item = '<a class="UYDisqusTopItem connectBTNSSO" style="background-image:url(' + SSOButton + '); width:72px;height:16px;border:none;outline:none;"></a>';
      }
    inner += item;
  }

  if(account_order.search(/_/)!=-1){
    var account_array = account_order.split('_');
    var account_top = account_array[0];
    for(var pos = 0; pos <account_top.length; pos++){
      var sns_id = parseInt(account_top.substr(pos, 1));
      var snsType = SNSTypes[sns_id];
      var snsName = SNSTypeToName[snsType];
      if(button_style==3){
        var item = '<a class="UYDisqusTopItemBasic connectBTN'+snsType+' connectBTN'+snsType+'Basic" ></a>';
      }else if(button_style==2){
         var item = '<a class="UYDisqusTopItemSmall connectBTN'+snsType+' connectBTN'+snsType+'Small" ></a>';
      }else if(button_style==1){
		var item = '<a class="UYDisqusTopItem connectBTN'+snsType+'" ></a>';  
	  }else{
		var item = '';
	  }
      inner += item;
    }
    if(button_style==2){
      inner+='<div class="clickIntro">点击按钮登录</div>';
    }
    $(".UYLoginSerious").prepend(inner);
    bindFuncToIcons();
  }
}
/**
 * 显示表情菜单的按钮，在focus输入框时触发
 */
function showEmo(){
  $('#UYEmotionBTN').css({"display":"block"});
}
/**
 * 显示回复表情菜单的按钮，在focus回复输入框时触发
 */
function showEmoReply(){
  $('#UYEmotionReplyBTN').css({"display":"block"});
  $('#UYreplyInput').click(
    function(){
      //hideReplyEmo();
      //showReplyEmo();
      $('#UYreplyInput').unbind();
    });
}
/**
 * 显示表情选择菜单
 */
function showEmotionPane(){ 
  prepareEmotion();
  $('#UYEmotionPane').css({"display":"block"});
  $('#submitUY').click(
    function(){
      hideEmo();
      showEmo();
      $('#submitUY').unbind();
    });
}
/**
 * 显示回复时的表情选择菜单 
 */
function showEmotionPaneReply(){
  prepareReplyEmotion();
  $('#UYEmotionReplyPane').css({"display":"block"});	
}
/**
 * 切换阿狸或默认表情
 */
function changeEmotionTab(type){
  if(type=="default"){
    $("#defaultEmotion").addClass("currentEmotionTab");
    $("#defaultEmotion").removeClass("unselectEmotionTab");
    $("#aliEmotion").addClass("unselectEmotionTab");
    $("#aliEmotion").removeClass("currentEmotionTab");

    $("#defaultEmotionReply").addClass("currentEmotionTab");
    $("#defaultEmotionReply").removeClass("unselectEmotionTab");
    $("#aliEmotionReply").addClass("unselectEmotionTab");
    $("#aliEmotionReply").removeClass("currentEmotionTab");
    $("#LEmotionReplyNor").css({"display":"block"});
    $("#LEmotionReply").css({"display":"none"});

    $(".snEmotionWrapper").css({"display":"block"});
    $("#LEmotionNor").css({"display":"block"});
    $(".aliEmotionWrapper").css({"display":"none"});
    $("#LEmotion").css({"display":"none"});
  }else{
    $("#aliEmotion").addClass("currentEmotionTab");
    $("#aliEmotion").removeClass("unselectEmotionTab");
    $("#defaultEmotion").addClass("unselectEmotionTab");
    $("#defaultEmotion").removeClass("currentEmotionTab");

    $("#aliEmotionReply").addClass("currentEmotionTab");
    $("#aliEmotionReply").removeClass("unselectEmotionTab");
    $("#defaultEmotionReply").addClass("unselectEmotionTab");
    $("#defaultEmotionReply").removeClass("currentEmotionTab");

    $(".snEmotionWrapper").css({"display":"none"});
    $("#LEmotionNor").css({"display":"none"});
    $(".aliEmotionWrapper").css({"display":"block"});
    $("#LEmotion").css({"display":"block"});
    $("#LEmotionReplyNor").css({"display":"none"});
    $("#LEmotionReply").css({"display":"block"});
  }

}
/**
 * 点击表情栏的表情时，输入表情到输入框
 */
function inputEmotion(keyWords,type){
  if(type=='reply'){
    $currentContent = $("#UYreplyInput").val();
    if($currentContent==""){
      $("#UYreplyInput").val(keyWords);
      $("#UYreplyInput").css("color", "#272727");
    }else{
      $("#UYreplyInput").val($currentContent+keyWords);
    }	  

  }else{
    $currentContent = $("#submitUY").val();
    if($currentContent==UYPrepareInputWord){
      $("#submitUY").val(keyWords);
      $("#submitUY").css("color", "#272727");
    }else{
      $("#submitUY").val($currentContent+keyWords);
    }	  
  }
}
/**
 * 隐藏表情框和按钮
 */
function hideEmo(){
  $('#UYEmotionBTN').css({"display":"none"});
  $('#UYEmotionPane').css({"display":"none"});
}
/**
 * 隐藏回复的表情框和按钮
 */
function hideReplyEmo(){
  $('#UYEmotionReplyBTN').css({"display":"none"});
  $('#UYEmotionReplyPane').css({"display":"none"});
}
/**
 * 表情框hover时在右侧显示大图
 */
function changeEmotionHover(stateCube,type,kind){
  if(kind=='ali'){
    if(type=='reply'){
      $("#LEmotionReply").html("<img src='/images/emotions/ali/"+stateCube+".gif' class='hoverplace'>");
    }else{
      $("#LEmotion").html("<img src='/images/emotions/ali/"+stateCube+".gif' class='hoverplace'>");
    }
  }else{
    if(type=='reply'){
      $("#LEmotionReplyNor").html("<img src='/images/emotions/default/"+stateCube+".png' class='hoverplace'>");
    }else{
      $("#LEmotionNor").html("<img src='/images/emotions/default/"+stateCube+".png' class='hoverplace'>");
    }
  }
}
/**
 * 登录后的回复框
 */
function submitReplyBTNChange(){
  $('#UYSubmitReplyBTN').attr('id', 'UYSubmitReplyBTNConnected');
  $('.replyBTNText').attr('class', 'replyBTNTextConnected');
  if(user_id!=100){
    $('#UYSubmitReplyBTNConnected').before('<div class="UYChooseConnect"><input type="checkbox" id="UYConnectToSNSReply" checked="checked"/><div class="UYCheckBoxIntro">同步到社交网站</div><div class="clear"></div></div>');
  }
}
/**
 * 登录前的回复框
 */
function submitReplyBTNConnectedChange(){
  $('#UYSubmitReplyBTNConnected').attr('id', 'UYSubmitReplyBTN');
  $('.replyBTNTextConnected').attr('class', 'replyBTNText');
}
/**
 * 触发发布评论,如果用户没登录则弹出登录，若已登录则评论
 * type为判断回复或是发布评论
 */
function UYCommentButtonClick(currentNode, type){
	
  $node = $(currentNode);
  if($node.data('disabled'))
  return;

  if(user_id == undefined){
    UYShowSNS(currentNode, type);	// 显示登录框
  }
  else{
    if(type == 'comment'){
	  if(forceStar!=1){	// 是否强制打分
      	UYSubmitInput($node);	// 没要求打分直接发布
	  }else{
		  //当用户强制打分后评论时触发
		  if(clickVote!=-1){	// 是否打过分
			  UYSubmitInput($node);
			  
		  }else{
			 $('.UYVoteItemNoti').html('请在评分后评论');
			 $('.UYVoteItemNoti').animate({
				opacity: 'toggle'

	   		}, 200, function() {
			// Animation complete.
			setTimeout("$('.UYVoteItemNoti').animate({opacity: 'toggle'}, 300, function() {});",3000);
	    });
		  }
	  }
    }else{
      UYSubmitReply($node);	// 发表回复
    }
  }
}

/**
 * 隐藏登录菜单
 */
function hideMenu(currentNode,type){
  $node = $(currentNode);
  if(type=='reply'){
    $node.parent(".connecntReplyMenu").remove();
  }else{		
    $node.parent(".connecntMenu").remove();
  }
}
/**
 * 隐藏阅读更多按钮
 */
function removeMoreItemBar(){
  $(".UYMoreItemsWrapper").hide();
}

/**
 * 当一条评论都没有时加载
 */
function loadEmptyBox(){
  var content = '<div class="UYEmptyBox"><div class="UYEmptyBox"><div class="UYEmtypWord">还没有人留言</div></div> <div class="UYEmtypBoxBottom"></div></div></div>'
  $('.UYEmptyBoxWrapper').html(content);
}

/**
 * 显示删除评论按钮
 */
function dealWithDel(){
  if(user_id == undefined ||user_id =='100'){
    $(".UYDelItem").css({"display":"none"});
  }else{
    $(".UYDelItem").each(function(){
      if($(this).next(".UYCUid").html()!=user_id){
        $(this).css({"display":"none"});				
      }else{
        $(this).css({"display":"block"});
      }
    });
  }
}

/**
 * 判断当前用户对当前页面各条评论的投票状况，如果已投票则暂时已投票效果
 */
function dealWithUps(){ 
  $(".UYUpIcon").each(function(index){
    var node = $(this);
    var $comment_id = node.parent().parent().parent().attr("id");
    if(user_id == undefined){
      //用户未登录时
      if(GetCookie('vote_up')!=null&&GetCookie('vote_up').match($comment_id)!=null){				
        node.removeClass("UYUpIcon").addClass("UYUpIconColor");	
      }
    }else{
      //用户已登录
      $.ajax({
        type:"POST",
        url:"youyan_content/checkUp",
        data: {
          user_id: user_id,
          comment_id: $comment_id
        },
        success: 
        function(data){
          if(data != '0'){
            node.removeClass("UYUpIcon").addClass("UYUpIconColor");
          }
        }
      });
    }
  });
}
/**
 * 判断当前用户对当前页面各条评论的投票状况，如果已投票则暂时已投票效果
 */
function dealWithDowns(){
  $(".UYDownIcon").each(function(index){
    var node = $(this);
    $comment_id = node.parent().parent().parent().attr("id");

    if(user_id == undefined){
		//用户未登录
      if(GetCookie('vote_down')!=null&&GetCookie('vote_down').match($comment_id)!=null){				
        node.removeClass("UYDownIcon").addClass("UYDownIconColor");	
      }	  

    }else{
		//用户已登录
      $.ajax({
        type:"POST",
        url:"youyan_content/checkDown",
        data: {
          user_id: user_id,
          comment_id: $comment_id
        },
        success: 
        function(data){
          if(data != '0'){
            node.removeClass("UYDownIcon").addClass("UYDownIconColor");
          }
        }
      });	  
    }	  
  });
}

/**
 * 检查用户是否未输入内容，或者内容为默认介绍
 */
function checkInput(checkStr){
  if(checkStr!=''&&checkStr!=UYPrepareInputWord)
  return 1;
  else return 0;
}

/**
 * 打开sns登录
 */
function bindDialog(type, bindLocation){
  if(arguments.length == 1)
  bindLocation = "register";
  bind_success = false; 
  var bindWindow;
  switch(type){
    case 'SINA':
    bindWindow = window.open('youyan/bind/sina/'+user_id,'新浪微博','location=yes,left=200,top=100,width=502,height=400,resizable=yes'); 
    break;
    case 'RENREN':
    url =  'youyan/bind/renren/'+user_id;
    bindWindow = window.open('youyan/bind/renren/'+user_id,'人人网','location=yes,left=200,top=100,width=802,height=400,resizable=yes'); 
    break;
    case 'KAIXIN':
    url =  'youyan/bind/kaixin/'+user_id;
    bindWindow = window.open('youyan/bind/kaixin/'+user_id,'开心网','location=yes,left=200,top=100,width=502,height=400,resizable=yes'); 
    break;
    case 'SOHU':
    url =  'youyan/bind/sohu/'+user_id;
    bindWindow = window.open('youyan/bind/sohu/'+user_id,'搜狐微博','location=yes,left=200,top=100,width=700,height=550,resizable=yes'); 
    break;
    case 'NETEASY':
    url =  'youyan/bind/neteasy/'+user_id;
    bindWindow = window.open('youyan/bind/neteasy/'+user_id,'网易微博','location=yes,left=200,top=100,width=502,height=400,resizable=yes'); 
    break;
    case 'DOUBAN':
    url =  'youyan/bind/douban/'+user_id;
    bindWindow = window.open('youyan/bind/douban/'+user_id,'豆瓣','location=yes,left=200,top=100,width=502,height=400,resizable=yes'); 
    case 'TENCENT': url =  'index.php/youyan/bind/tencent/'+user_id;
    bindWindow = window.open('youyan/bind/tencent/'+user_id,'腾讯微薄','location=yes,left=200,top=100,width=502,height=400,resizable=yes'); 
    break;
  }
}

function validateSignupForm(){
  $("#signupForm").validate({
    rules: {
      UYUserName: {
        required: true,
        minlength: 5,
        maxlength: 20
      },
      UYEmail: {
        required: true,
        email: true
      },
      UYPassword: {
        required: true,
        minlength: 5,
        maxlength: 20
      }
    },
    messages: {
      UYUserName: {
        required: "用户名不能为空",
        minlength: "用户名为5-20位英文字母，数字，或'_'",
        maxlength: "用户名为5-20位英文字母，数字，或'_'"
      },
      UYEmail: {
        required: "email不能为空",
        email: "请输入正确email格式"
      },
      UYPassword: {
        required: "密码不能为空",
        minlength: "密码为5-20位英文字母，数字，或'_'",
        maxlength: "密码为5-20位英文字母，数字，或'_'"
      }
    }
  });
}
/**
 * 隐藏输入框预写内容
 */
function hideIntro(){
  if($("#submitUY").val()==UYPrepareInputWord){
    $("#submitUY").val("");
    $("#submitUY").css("color", "#272727");
  }	
}
/**
 * 显示输入框预写内容
 */
function showIntro(){
  if($("#submitUY").val() == ""){
    $("#submitUY").val(UYPrepareInputWord);
    $("#submitUY").css("color", "#BDBBBB");
  }	
}

/**
 * 老版函数，已作废
 */
function unBind(type){
  $targetNode = $(".UY_"+type+"_Bind").parent();
  $targetNode.addClass("UY_bindBTNWrapper");
  $targetNode.removeClass("UY_bindBTNWrapper_connected");
  $targetNode.removeAttr("onclick");
  $targetNode.attr("onclick", "bindDialog(\'" + type + "\')");
  $targetNode.html('<div class="UY_bindBTNIntro">同步到</div><div class="UY_Bind_BTN UY_SINA_Bind"></div>');
  unBindDone(type);
}
/**
 * 老版函数，已作废
 */
function unBindDone(type){
  var selector = '#' + type + 'SmallConnected';
  $("#UYunreadyIntro").before('<a href="#" id="' + type + 'Login" class="' + type + 'Small" onclick=bindDialog(\'' + type + '\')"></a>');

  $(selector).remove()
  ConnectAmount--;
}

/**
 * 老版函数，已作废
 */
function successBind(type){
  $targetNode = $(".UY_"+type+"_Bind").parent();
  $targetNode.removeClass("UY_bindBTNWrapper");
  $targetNode.addClass("UY_bindBTNWrapper_connected");
  $targetNode.removeAttr("onclick");
  $targetNode.html('<a class="UYunconnectBTN onclick="unBind('
                   + type
                   + '"></a><div class="UYconnectIntro">已同步</div>'
                   + '<a class="UYconnectedName">汪精卫</a><div class="connectShowWrapper">'
                   + '<div class="YYSmall UYpositionY"></div><div class="'+type+'Small UYpositionU"></div>'
                   + '<div class="clear"></div></div>');
  bindDone(type);
  $("#UYalertNoConnection").css({"display":"none"});
}

/**
 * 老版函数，已作废
 */
      function bindDone(type){
        var idName = "#"+type+"Login";
        var selector = '#' + type + 'SmallConnected';

        $("#UYConnected").css("display", "block");
        $("#UYunreadyIntro").html("未同步");
        $("#"+type+"Login").remove();

        if(($(selector)).length == 0){
          $("#UYreadyConnect").before('<a onclick="unBind(\'' + type + '\')" class="' + type + 'Small" id="' +type + 'SmallConnected" href="#"></a>' );
          ConnectAmount++;
        }

        if(ConnectAmount > 0)
        $('.UYLiteProfile').css("display", "block");
      }



/**
 * 老版函数，已作废
 */
function showConnectPane(){
  boxy.show();	
}



/**
 * 生成SNS用户的个人页面访问地址
 */
function getUserSNSHome(data){
  if(data.user_id == 100){
    if(data.comment_author_url)
    return data.comment_author_url;
    else
    return anon_url;
  }
  var id_type = data.from_type.toLowerCase() + "_id";
  //alert(id_type);
  if(id_type == 'qq_id'){
    return 'http://qzone.qq.com/';
  }
  else if (id_type == 'neteasy_id'){
    return SNSTypeToPrefix['NETEASY'] + data.neteasy_screen_name;
  }
  else if (id_type == 'msn_id'){
    return data.msn_link;
  }
  else if (id_type == 'sso_id'){
    if(data.sso_link)
      return data.sso_link;
    else
      return data.sso_home;
  }
  return SNSTypeToPrefix[data.from_type] + data[id_type];
}

/**
 * 删除评论函数
 */
function UYdel(currentNode){
  $node = $(currentNode);
  if($node.data('executing'))
  return;
  $node.data('executing', true);

  $node.html("...");

  var $infoAction = $node.parent(".UYInfoAction");
  var commentId = $infoAction.parent().parent().attr('id');

  var $count = 1;
  var $itemWrapper = $infoAction.parent().parent();
  var $itemIter = $itemWrapper;

  if($itemWrapper.attr('class') == 'itemWrapper'){
    while($itemIter.next().attr('class') == 'itemWrapperSC'){
      if(!$itemIter.next().children('.UYInfoWrapperSC').children('.UYInfo').children('.commentContent').hasClass('commentDel')){  // If the child is marked as removed
                                                                                                                                $count ++;
                                                                                                                               }
      $itemIter = $itemIter.next();
    }
  }
  if($itemWrapper.attr('class') == 'itemWrapperSC'){
    var $prevWrapper = $itemWrapper.prevAll(".itemWrapper").first();
    if($prevWrapper.children('.UYInfoWrapper').children('.UYInfo').children('.commentContent').hasClass('commentDel')){     // If parent is marked as removed
                                                                                                                       $count = 0;
                                                                                                                      }
  }


  $.ajax({
    type:"POST",
    url:"youyan_content/delComment/"+commentId,
    data: {
      delStyle: delStyle,
      count : $count
    },
    dataType:"json",
    success: function(reply_data){
      $node.html("已删除");
      $commentContent = $infoAction.parent().children(".UYInfo").children(".commentContent");
      if(delStyle == 1){
        $infoAction.remove();
        $commentContent.html("(该评论已被删除)");
        $commentContent.addClass("commentDel");
      }
      else{
        $itemIter = $itemWrapper;
        if($itemWrapper.attr('class') == 'itemWrapper'){
          while($itemIter.next().attr('class') == 'itemWrapperSC'){
            $itemIter = $itemIter.next();
            $itemWrapper.remove();
            $itemWrapper = $itemIter;
          }
        }
        $itemWrapper.remove();
        numComments -= $count;
        $("#UYCommentAmount").html(numComments);
      }
      $node.removeData('executing');
    },
    error:function(){
      alert("网络线路问题，暂时无法删除评论，请稍候再试");
    }
  });
}
/**
 * 将评论正文的表情替换为图片
 */
function createEmotion(content){
	//emotionKey对应阿狸表情的 顺序
  $emotionKey = new Array("纠结","心动","用力","抱","鬼脸","喃喃","啪地","狂泪","忍耐","跳舞","狸猫","虫子","面跳舞","喝茶","给力","思考","紧张","睡醒","离家","怒气","吃","囧","惹嫌","潜水","开心","捏脸","怒火","鬼","疑问","暴跳","不甘心","下班","失意","相拥","暖和","示爱","无语","害羞","礼物","狂笑");
    //emotionKeyNormal对应默认标准版的表情顺序
  var $emotionKeyNormal = new Array("纠结","心动","生气","开心","调皮","眨眼","害羞","失落","酷","愤怒","惊讶","无语","哭泣","笑","大哭","调皮","惊讶","呆","口哨","天使","恶魔","恶魔笑","闭嘴","满意","睡觉","得意","生病","怀疑","专注","外星人","史莱克","游戏","爱心","家","地球","邮件","音乐","编辑","电话","照相");  
  for(var i=1;i<=40;i++){	
    reg=new RegExp("(\\(al"+$emotionKey[(i-1)]+"\\))","g"); 
    content = content.replace(reg,'<img src="/images/emotions/ali/'+i+'.gif"/>');
    regDefault = new RegExp("(\\("+$emotionKeyNormal[(i-1)]+"\\))","g"); 
    content = content.replace(regDefault,'<img src="/images/emotions/default/'+i+'.png"/>');
  }	
  return content;
}
/**
 * 顶一条评论
 */
function UYUp(currentNode){
  //if(user_id == undefined)

  var parentNode = $(currentNode).parent();
  // If it's current not up'ed, 
  if(parentNode.children(".UYUpIcon").length!=0){
    parentNode.children(".UYUpIcon").removeClass('UYUpIcon').addClass('UYUpIconColor');
    var $upAmountNode = parentNode.children(".UYUpInfo").children(".UYupAmount");
    var $upAmount = parseInt($upAmountNode.html());
    $upAmountNode.html($upAmount+1);

    UYIncreaseCnt(currentNode, 'up');

    // If it's already up'ed, remove the up
    if(parentNode.children(".UYDownIconColor").length!=0){
      parentNode.children(".UYDownIconColor").removeClass('UYDownIconColor').addClass('UYDownIcon');
      var $amount = parseInt(parentNode.children(".UYDownInfo").children(".UYdownAmount").html());
      parentNode.children(".UYDownInfo").children(".UYdownAmount").html($amount-1);	
      UYDecreaseCnt(currentNode, 'down');
    }
    //down cancel
  }
  // If it's currently already up'ed, unmark the up...
  else{
    parentNode.children(".UYUpIconColor").removeClass('UYUpIconColor').addClass('UYUpIcon');
    var $amount = parseInt(parentNode.children(".UYUpInfo").children(".UYupAmount").html());
    parentNode.children(".UYUpInfo").children(".UYupAmount").html($amount-1);	

    UYDecreaseCnt(currentNode, 'up');
  }
}
/**
 * 踩一条评论
 */
function UYDown(currentNode){
  var parentNode = $(currentNode).parent();
  // If it's current not down'ed, 
  if(parentNode.children(".UYDownIcon").length!=0){
    parentNode.children(".UYDownIcon").removeClass('UYDownIcon').addClass('UYDownIconColor');
    var $downAmountNode = parentNode.children(".UYDownInfo").children(".UYdownAmount");
    var $downAmount = parseInt($downAmountNode.html());
    $downAmountNode.html($downAmount+1);

    UYIncreaseCnt(currentNode, 'down');

    // If it's already up'ed, remove the up
    if(parentNode.children(".UYUpIconColor").length!=0){
      parentNode.children(".UYUpIconColor").removeClass('UYUpIconColor').addClass('UYUpIcon');
      var $amount = parseInt(parentNode.children(".UYUpInfo").children(".UYupAmount").html());
      parentNode.children(".UYUpInfo").children(".UYupAmount").html($amount-1);	
      UYDecreaseCnt(currentNode, 'up');
    }
    //down cancel
  }
  // If it's currently already down'ed, unmark the up...
  else{
    parentNode.children(".UYDownIconColor").removeClass('UYDownIconColor').addClass('UYDownIcon');
    var $amount = parseInt(parentNode.children(".UYDownInfo").children(".UYdownAmount").html());
    parentNode.children(".UYDownInfo").children(".UYdownAmount").html($amount-1);	

    UYDecreaseCnt(currentNode, 'down');
  }
}
/**
 * 顶和踩操作统一调用的数据处理函数A
 */
function UYIncreaseCnt(currentNode, up_or_down){
  var $comment_id = $(currentNode).parent().parent().parent().attr("id");
  var $node = $(currentNode);
  if(user_id==undefined){user_id=100};
  $.ajax({
    type:"POST",
    url:"youyan_content/increaseCnt/" + up_or_down,
    data:{
      user_id: user_id,
      comment_id: $comment_id,
      domain:domain
    },
    cache:false,
    dataType: 'text',
    success:function(data){
      var idNum = $node.parent('.UYInfoAction').parent('.UYInfoWrapper').parent('.itemWrapper').attr('id');
      if(up_or_down == 'up'){
        var vote_up_str = GetCookie('vote_up');
        if(vote_up_str!=null){
          vote_up_str = vote_up_str+idNum+',';
        }else{
          vote_up_str = idNum+',';
        }
        setCookie('vote_up',vote_up_str,30);

        var vote_down_str = GetCookie('vote_down');
        var rstr =new RegExp(idNum+',',"g");
        vote_down_str = vote_down_str.replace(rstr,'');				
        setCookie('vote_down',vote_down_str,30);

      }else{
        var vote_up_str = GetCookie('vote_up');
        var rstr =new RegExp(idNum+',',"g");
        vote_up_str = vote_up_str.replace(rstr,'');				
        setCookie('vote_up',vote_up_str,30);

        /*        var vote_down_str = GetCookie('vote_down');
        if(vote_down_str!=null){
        vote_down_str = vote_down_str+idNum+',';	
      }else{
        vote_down_str = idNum+',';
      }
        setCookie('vote_down',vote_down_str,30);*/
      }
    },
    error:function(){
      alert("increase failed");
    }
  });	
}
/**
 * 顶和踩操作统一调用的数据处理函数B
 */
function UYDecreaseCnt(currentNode, up_or_down){
  var $comment_id = $(currentNode).parent().parent().parent().attr("id");
  var $node = $(currentNode);
  if(user_id==undefined)user_id=100;
  $.ajax({
    type:"POST",
    url:"youyan_content/decreaseCnt/" + up_or_down,
    data:{
      user_id: user_id,
      comment_id: $comment_id,
      domain:domain
    },
    cache:false,
    dataType: 'text',
    success:function(data){
      var idNum = $node.parent('.UYInfoAction').parent('.UYInfoWrapper').parent('.itemWrapper').attr('id');
      var idNUmStr = idNum+',';
      if(up_or_down == 'up'){
        var vote_down_str = GetCookie('vote_down');
        if(vote_down_str!=null){
          vote_down_str = vote_down_str+idNum+',';
        }else{
          vote_down_str = idNum+',';
        }
        setCookie('vote_down',vote_down_str,30);

        var vote_up_str = GetCookie('vote_up');
        var rstr =new RegExp(idNum+',',"g");
        vote_up_str = vote_up_str.replace(rstr,'');				
        setCookie('vote_up',vote_up_str,30);
      }else{
        var vote_down_str = GetCookie('vote_down');
        var rstr =new RegExp(idNum+',',"g");
        vote_down_str = vote_down_str.replace(rstr,'');				
        setCookie('vote_down',vote_down_str,30);
        /*      var vote_down_str = GetCookie('vote_down');
        if(vote_down_str!=null){
        vote_down_str = vote_down_str+idNum+',';	
      }else{
        vote_down_str = idNum+',';
      }
        setCookie('vote_down',vote_down_str,30);*/
      }		

    },
    error:function(){
      alert("decrease failed");
    }
  });	
}
/**
 * JS过滤html标签
 */
function removeTag(str){
  str = str.replace(/<[^>].*?>/g,"");  
  return str;
}
/**
 * 回复一条评论
 */
function postReply($node){
  var content = $("textarea#UYreplyInput").val();
  var parentComment = $("#UYreplySystem").prevAll(".itemWrapper").first();
  var in_reply_to_id = parentComment.attr("id");

  var postToSNS = $("#UYConnectToSNSReply").attr("checked");

  if(comment_author == undefined){
    comment_author='';
  }
  if(comment_author_email == undefined){
    comment_author_email='';
  }
  if(comment_author_url == undefined){
    comment_author_url='';
  }
  $.ajax({
    type:"POST",
    url:"youyan_content/postComment",
    data:{
      page_img: pageImg,
      title: title,
      page_url: pageURL,
      content: content,
      page: page,
      domain: domain,
      user_id: user_id,
      in_reply_to: in_reply_to_id,
      from_type: logins,
      postToSNS: postToSNS,
      comment_author:comment_author,
      comment_author_email:comment_author_email,
      comment_author_url:comment_author_url,
	  vote_score:clickVote,
      veryfyCheck:veryfyCheck
    },
    dataType:"json",
    cache:false,
    success: function(data){
      //spam
      if(data=='short'){
        $("#UYreplyInput").val("您的发布频率过快，请歇息一下哦: )");
      }
      if(data=='spam'){
        location.href='http://uyan.cc/spam.html';
      }
	  
      var comment_id;
      if(data!='again'&&data!='spam'&&data!='short'){
        var new_entry = buildCommentEntry(data, 'reply');
        if(reply_position == 0){
          parentComment.after(new_entry);
        }else{
          var nextComments = $("#UYreplySystem").nextAll(".itemWrapper");

          if(nextComments.length != 0){
            nextComments.first().before(new_entry);
          }else{
            var nextReplies = $("#UYreplySystem").nextUntil(".itemWrapper", ".itemWrapperSC");
            if(nextReplies.length != 0){
              nextReplies.last().after(new_entry);
            }else{
              var prePos = $("#UYreplySystem").prev();
              prePos.after(new_entry);
            }
          }
        }
        $("#UYreplySystem").remove();
        numComments++;
        $("#UYCommentAmount").html(numComments);
        comment_id = data.comment_id;
      }
      //end
      if(styleNum=='3'){
        $('.replyBTNTextConnected').css({"color":"#fff"});
        $('.replyBTNTextConnected').html('回复');
        $('#UYSubmitReplyBTNConnected').css({"border":"1px solid #29447e","background-color":"#5f78ab","cursor":"pointer","-moz-box-shadow":"0 1px 0 #d9d9d9","-webkit-box-shadow":"0 1px 0 #d9d9d9","box-shadow":"0 1px 0 #d9d9d9"});		  
        $node.removeData('executing');
        $("#UYSubmitReplyBTNConnected").removeAttr("onclick");
        $("#UYSubmitReplyBTNConnected").removeAttr("disabled");
        $("#UYSubmitReplyBTNConnected").attr("onclick",function(){return function(){UYCommentButtonClick(this, 'reply');}});

      }else{
        $('.replyBTNTextConnected').css({"color":"#000"});
        $('.replyBTNTextConnected').html('回复');

        $node.removeData('executing');
        $("#UYSubmitReplyBTNConnected").removeAttr("onclick");
        $("#UYSubmitReplyBTNConnected").removeAttr("disabled");
        $("#UYSubmitReplyBTNConnected").attr("onclick",function(){return function(){UYCommentButtonClick(this, 'reply');}});		  
      }


      $('.UYInfoWrapper').ready( function(){
        //when post reply
        switch(styleNum){
          case '4':
          if(IE6){
            $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"});
            $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
            $('.UYInfoTopBanner').css({"width":(DIYWidth-150)+"px"});
          }else if(IE6&&autoFixWidth){
            $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"});
            $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
          }else{
            $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"}); 
            $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
          }
          break;
          default:
          if(IE6&&autoFixWidth){
            $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"}); 
            $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
            $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});
            $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
          }else{
            $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"}); 
            $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
            $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});
            $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
          }
          break;	
        }
      }); 

      //spam 
      if(data!='again'&&data!='spam'&&data!='short'){
        //end
        $.post("youyan_content/postCommentPostWork",
               {
                 content: content,
                 page: page,
                 page_url: pageURL,
                 page_img: pageImg,
                 domain: domain,
                 title: title,
                 user_id: user_id,
                 from_type: logins,
                 postToSNS: postToSNS,
                 in_reply_to: in_reply_to_id,
                 comment_author:comment_author,
                 comment_author_email:comment_author_email,
                 comment_author_url:comment_author_url,
                 comment_id: comment_id,
                 session_name: session_name,
				 vote_score:clickVote,
                 veryfyCheck:veryfyCheck
               });
      }
      },
      error:function(){
        alert("由于网络不稳定，post 操作失败。");
      }
      });
      }

/**
 * 检查匿名用户的邮箱
 */
function checkemail(strValue){
  re=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
  if(strValue.match(re)==null){
    return false;
  }
  else{
    return true;
  }
}

function setCursorPosition(id, pos){
  ctrl = document.getElementById('UYreplyInput');
  if(ctrl.setSelectionRange){
    ctrl.focus(); 
    ctrl.setSelectionRange(pos,pos); 
  }
  else if (ctrl.createTextRange) { 
    var range = ctrl.createTextRange(); 
    range.collapse(true); 
    range.moveEnd('character', pos); 
    range.moveStart('character', pos); 
    range.select(); 
  }
} 
/**
 * 处理加载评论的一些样式//单独加载查看更多的效果
 */
function loadComments(items){
  if(commentPageNum == 1){
    $('.UYEmptyComment').after(items);
    updateLoginInfo(loginInfo);
  }
  else
  $('.UYEmptyCommentEnd').before(items);

  if(styleNum==4){
    $(".UYMoreItemsWrapper").html('查看更多<img class="blueArrowDown" src="../images/style4/sorttype.png">');
  }else{
    $(".UYMoreItemsWrapper").html('查看更多<img class="blueArrowDown" src="../images/arrowDownMore.png">');
  }
  $('.UYInfoWrapper').ready( function(){
    //when load comment
    switch(styleNum){
      case '4':
      if(IE6){
        $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"});
        $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
      }else if(IE6&&autoFixWidth){
        $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"});
        $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
      }else{
        $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"});
        $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
      }
      break;
      default:
      if(IE6&&autoFixWidth){
        $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"});
        $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
        $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});
      }else{
        $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"});
        $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
        $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});

      }
      break;
    }
  });
}
/**
 * 用户点击获取更多评论的回复
 */
function processReply(comment_id){
  var items = '';
  $.post("youyan_content/getReplies/" + curSort, 
         {
           comment_id: comment_id,
           delStyle: delStyle,
           reply_page_no: comment_reply_pages[comment_id],
           session_name: session_name
         },
         function(reply_data){
           var finished = reply_data[0];
           reply_data = reply_data[1];
           comment_reply_pages[comment_id]++;

           if(reply_data.length != 0){               // If there're some response items or current item is not deleted
                                      $.each(reply_data, function(reply_key, reply_val){
                                        items += buildCommentEntry(reply_data[reply_key], 'reply');
                                      });

                                      if($("#UYMoreReply" + comment_id).length != 0){           // The bar is there
                                                                                     $("#UYMoreReply" + comment_id).before(items);
                                                                                    }else{                                        // The bar is not there
                                                                                          if(finished != 1){
                                                                                            items += '<a class="UYMoreRepliesWrapper" id="UYMoreReply' + comment_id + '" onclick="processReply(' + comment_id + ')">查看更多<img src="../images/arrowDownMore.png" class="blueArrowDown" /></a>';
                                                                                            $("#"+comment_id).after(items);
                                                                                          } else{
                                                                                            $("#"+comment_id).after(items);
                                                                                          }
                                                                                         }
                                      switch(styleNum){
                                        case '4':
                                        if(IE6&&autoFixWidth){
                                          $('.UYInfoWrapperSC').css({"width":DIYWidth-125});
                                          $('.UYMoreRepliesWrapper').css({"width":DIYWidth-145});
                                        }else{
                                          $('.UYInfoWrapperSC').css({"width":DIYWidth-125});
                                          $('.UYMoreRepliesWrapper').css({"width":DIYWidth-145});
                                        }		  
                                        break;
                                        default:
                                        if(IE6&&autoFixWidth){
                                          $('.UYInfoWrapperSC').css({"width":DIYWidth-148});
                                          $('.UYMoreRepliesWrapper').css({"width":DIYWidth-72});
                                          $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
                                        }else{
                                          $('.UYInfoWrapperSC').css({"width":DIYWidth-148});
                                          $('.UYMoreRepliesWrapper').css({"width":DIYWidth-72});
                                          $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
                                        }
                                        break;	
                                      }
                                      dealWithDel();

                                      if(finished == 1){             // If it's finished, remove the bar;
                                                        $("#UYMoreReply" + comment_id).remove();
                                                       }
                                     }
         },
'json'
);
}
/**
 * 加载页面评论内容
 */
function getComments(){
  $(".UYMoreItemsWrapper").html("加载评论中..");
  var items = '';
  $.ajax({
    url : "youyan_content/getComments/" + curSort,
    type:"POST",
    dataType: 'json',
    data : {
      delStyle: delStyle,
      page: page,
      commentPageNum: commentPageNum,
      numCommentsPerPage: numCommentsPerPage
    },
    success: function(data){
      commentPageNum++;
      if(data==null || data.length == 0){
        if(commentPageNum == 1){
          loadEmptyBox();
          updateLoginInfo(loginInfo);
          removeMoreItemBar();
        }
        else{
          removeMoreItemBar();
        }
      }
      else{
        $.each(data, function(key, val){
          var item = buildCommentEntry(data[key], 'comment');	//开始渲染
          items += item;
        });
        loadComments(items);
        if($("#UYCurrentPageNum").length>=1){
          $("#UYCurrentPageNum").html("1-"+(numCommentsPerPage * commentPageNum));
        }

        var comment_ids = Array();
        $.each(data, function(key, val){
        var comment_id = data[key].comment_id;
        comment_reply_pages[comment_id] = 0;
        comment_ids.push(comment_id);
        //processReply(comment_id);
      });

        processReplies(comment_ids);//加载每条评论的回复
        dealWithDel();	//显示删除评论按钮
        dealWithPageVote();//判断当前用户是否顶或踩过当前页面，并对应处理前端
        //dealWithUps();
        //dealWithDowns();
      }
    },
    error: function(data){
      console.log('error: ' + data);
    }
  });
}


/**
 * 获取评论的回复，在加载评论的过程中调用
 */
function processReplies(comment_ids){
  $.post("youyan_content/getRepliesTogether/" + curSort, 
         {
           comment_ids: comment_ids,
           page: page,
           delStyle: delStyle,
           reply_page_no: comment_reply_pages, //[comment_id],
           session_name: session_name
         },
         function(reply_data_entries){
           //console.log(reply_data_entries);
           $.each(reply_data_entries, function(key, val){
             var comment_id = key;
             //console.log(comment_id);
             var reply_data = reply_data_entries[key];

             var comment_id = reply_data[0];
             var finished = reply_data[1];
             reply_data = reply_data[2];
             comment_reply_pages[comment_id]++;

             if(reply_data.length != 0){               // If there're some response items or current item is not deleted
                                        var items = '';
                                        $.each(reply_data, function(reply_key, reply_val){
                                          items += buildCommentEntry(reply_data[reply_key], 'reply');
                                        });

                                        if($("#UYMoreReply" + comment_id).length != 0){           // The bar is there
                                                                                       $("#UYMoreReply" + comment_id).before(items);
                                                                                      }else{                                        // The bar is not there
                                                                                            if(finished != 1){
                                                                                              items += '<a class="UYMoreRepliesWrapper" id="UYMoreReply' + comment_id + '" onclick="processReply(' + comment_id + ')">查看更多<img src="../images/arrowDownMore.png" class="blueArrowDown" /></a>';
                                                                                              $("#"+comment_id).after(items);
                                                                                            } else{
                                                                                              $("#"+comment_id).after(items);
                                                                                            }
                                                                                           }
                                        switch(styleNum){
                                          case '4':
                                          if(IE6&&autoFixWidth){
                                            $('.UYInfoWrapperSC').css({"width":DIYWidth-125});
                                            $('.UYMoreRepliesWrapper').css({"width":DIYWidth-145});
                                          }else{
                                            $('.UYInfoWrapperSC').css({"width":DIYWidth-125});
                                            $('.UYMoreRepliesWrapper').css({"width":DIYWidth-145});
                                          }		  
                                          break;
                                          default:
                                          if(IE6&&autoFixWidth){
                                            $('.UYInfoWrapperSC').css({"width":DIYWidth-148});
                                            $('.UYMoreRepliesWrapper').css({"width":DIYWidth-72});
                                            $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
                                          }else{
                                            $('.UYInfoWrapperSC').css({"width":DIYWidth-148});
                                            $('.UYMoreRepliesWrapper').css({"width":DIYWidth-72});
                                            $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
                                          }
                                          break;	
                                        }
                                        dealWithDel();

                                        if(finished == 1){             // If it's finished, remove the bar;
                                                          $("#UYMoreReply" + comment_id).remove();
                                                         }
                                       }
});
},
'json'
);
}

/**
 * 在JS中设置cookie
 */
function setCookie(c_name,value,expiredays){
  var exdate=new Date();
  exdate.setDate(exdate.getDate()+expiredays);
  document.cookie=c_name+ "=" +escape(value)+ ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
}
/**
 * 在js中获取cookie
 */
function GetCookie(sName){
  var aCookie = document.cookie.split("; ");
  for (var i=0; i < aCookie.length; i++)
  {
    // a name/value pair (a crumb) is separated by an equal sign
    var aCrumb = aCookie[i].split("=");
    if (sName == aCrumb[0])
    return unescape(aCrumb[1]);
  }
  // a cookie with the requested name does not exist
  return null;
}


/**
 * 新浪、人人等分享
 */

function sinaShare(){
  var shareURL = 'http://service.weibo.com/share/share.php?url=' + escape(pageURL) + '&title=' + title;
  if(pageImg != 'none'){
    shareURL += '&pic=' + escape(pageImg);
  }

  window.open(shareURL, 'SinaShare', 'location=yes, left=200, top=100, width=500, height=350, resizable=yes');
}

function renrenShare(){
  var shareURL = 'http://share.renren.com/share/buttonshare?link=' + escape(pageURL) + '&title=' + title;
  window.open(shareURL, 'RenrenShare', 'location=yes,left=200,top=100,width=500,height=350,resizable=yes'); 
}

function qqShare(){
  var shareURL = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' + escape(pageURL) + '&title=' + title;
  if(pageContent != 'none')
  shareURL += '&summary=' + pageContent;
  if(pageImg != 'none')
  shareURL += '&pics=' + pageImg;
  shareURL += '&site=' + domain;
  window.open(shareURL, 'QQShare', 'location=yes,left=200,top=100,width=500,height=350,resizable=yes');
}


/**
 * 评论框中打开个人页面切换Tab到活跃社区
 */
function profileChangeNav(type,node){
  $node =$(node);
  $(".UYProfileNaviBTN").removeClass("UYProfileNavBTNCurrent");
  $node.addClass("UYProfileNavBTNCurrent");

  var cur_uid= $("#hideUserId").html();
  if(type=='social') {
    $('.UYProfileItemSocial').remove();

    profileSocialNum=0;
    $(".UYProfileItemSocialContainer").show();
    $(".UYProfileItemContainer").hide();
    prepareSocialProfile(cur_uid);
  }else{
    $(".UYProfileItemSocialContainer").hide();
    $(".UYProfileItemContainer").show();		
  }
}
/**
 * 切换Tab到活跃社区时加载的数据
 */
function prepareSocialProfile(uid){
  $('#UYProfileSocialMoreBTN').remove();
  $.ajax({
    type:"POST",
    dataType:"json",
    url:"youyan_content/getUserProfileSocial",
    data:{
      uid:uid,profileSocialNum:profileSocialNum
    },
    success: function(data){
      chageProfileSocialWindow(data);
      profileSocialNum++;
    },
    cache:false,
    error:function(){
    }
  });		
}
/**
 * 触发，在评论框中打开用户个人页面
 */
function openProfile(uid,currentNode){
  if(uid==null||uid=='')return;
  profileItemNum=0;
  node= document.getElementById('UYNewsBTN');
  profileChangeNav('news',node);
  $currentNode = $(currentNode);
  $("#hideUserId").html(uid);
  $(".UYProfileItem").remove();
  $("#UYProfileMoreBTN").remove();
  if (window.MessageEvent && !document.getBoxObjectFor){
    var innerHeight = ($(".UYShowList").height()- $currentNode.offset().top + $(".UYShowList").offset().top);
    var changeToHeight = $currentNode.offset().top - $(".UYShowList").offset().top + 340;
    if(innerHeight<360){
      $(".UYShowList").css({"height":changeToHeight+"px"});
    }
  }

  $.ajax({
    type:"POST",
    dataType:"json",
    url:"youyan_content/getUserProfile",
    data:{
      uid:uid,profileItemNum:profileItemNum
    },
    success: function(data){
      chageProfileWindow(data);
      var yState = $currentNode.offset().top-200;
      if(yState<45){
        yState = 45;
      }
      boxProfile.center('x');
      var xPosition = boxProfile.left;
      boxProfile.moveTo(xPosition,yState);
      boxProfile.show();
      profileItemNum++;
    },
    cache:false,
    error:function(){
    }
  });	
}
/**
 * 打开个人页面后进一步加载个人数据
 */
function chageProfileWindow(data){
  //get user's profile link
  var sns_link = getUserSNSHome(data[0]);
  $("#UYProfileMoreBTN").remove();
  $("#UYProfileImg").attr("src",data[0].profile_img);
  $("#UYProfileName").html(data[0].show_name);
  $("#UYProfileComment").html(data[0].n_comments);
  $("#UYProfileLiked").html(data[0].n_up_received);
  $("#UYBasicLink").html(sns_link);
  $("#UYBasicLink").attr("href",sns_link);
  $("#UYProfileName").attr("href",sns_link);

  if(data.length>0){
    $.each(data, function(data_key, data_val){
      var item ='<div class="UYProfileItem">'
      +'<img src="'+data_val.profile_img+'" class="UYProfileItemImg" />'
      +'<div class="UYProfileItemRightWrapper">'
      +'<div class="UYProfileItemFirstLine">'
      +'<div class="UYProfileItemFirstLeft">'
      +'在<a href="'+data_val.page_url+'" target="_blank" class="UYProfileItemLink">'+data_val.page_title+'</a>上发布评论'
      +'</div>'
      +'<div class="UYProfileItemTime">'+stringToDateTime(data_val.time)+'</div>'
      +'<div class="clear"></div>'
      +'</div>'
      +'<div class="UYProfileItemContent">'
      +createEmotion(data_val.content)
      +'</div>'
      +'</div>'
      +'<div class="clear"></div>'
      +' </div>';
      $("#UYProfileItemTarget").before(item);
    });
  }
  if(data.length>=20){
    $("#UYProfileItemTarget").after("<a class='UYMoreItemsWrapper' id='UYProfileMoreBTN' onclick='getMoreProfileItem(\""+data[0].user_id+"\")'>查看更多<img class='blueArrowDown' src='../images/arrowDownMore.png'></a>");
  }else{
    $("#UYProfileMoreBTN").remove();
  }
}
/**
 * 阅读更多个人数据
 */
function getMoreProfileItem(cr_user_id){
  $.ajax({
    type:"POST",
    dataType:"json",
    url:"youyan_content/getUserProfile",
    data:{
      uid:cr_user_id,profileItemNum:profileItemNum
    },
    success: function(data){
      profileItemNum++;
      chageProfileWindow(data);
    },
    cache:false,
    error:function(){
    }
  });

}
/**
 * 打开个人页面的活跃社区后进一步加载个人数据
 */
function chageProfileSocialWindow(data){
  if(data.length>0){
    $.each(data, function(data_key, data_val){
      var item='<div class="UYProfileItemSocial">'
      +'<div class="UYProfileSocialLink">';
      if(data_val.domain_name!=''){
        item+='<a href="http://'+data_val.domain+'" class="socialLink" target="_blank">'+data_val.domain_name+'</a>';
      }else{
        item+='<a href="http://'+data_val.domain+'" class="socialLink" target="_blank">'+data_val.domain+'</a>';	
      }				
      item+='</div>'
      +'<div class="UYProfileSocialIcons">'
      +'<div class="UYProfileSocialIconItem UYProfileSocialIconItemTalk">'+data_val.n_comments+'条评论</div>'
      +'<div class="UYProfileSocialIconItem UYProfileSocialIconItemLike">'+data_val.n_up+'人喜欢</div>'
      +'<div class="UYProfileSocialIconItem UYProfileSocialIconItemLike">'+data_val.n_users+'位评论者</div>'
      +'<div class="clear"></div>'
      +'</div>'
      +'</div>';
      $("#UYProfileItemSocialTarget").before(item);						  
    });
  }
  if(data.length>=20){
    $("#UYProfileItemSocialTarget").after("<a class='UYMoreItemsWrapper' id='UYProfileSocialMoreBTN' onclick='prepareSocialProfile(\""+data[0].user_id+"\")'>查看更多<img class='blueArrowDown' src='../images/arrowDownMore.png'></a>");
  }else{
    $("#UYProfileSocialMoreBTN").remove();
  }
}
/**
 * 在评论框中打开社区内容栏
 */
function UYShowCommunity(){
  boxWebsite.center('x');
  boxWebsite.moveTo('',30);
  boxWebsite.show();
  getMoreWebUserInfo();
}
/**
 * 显示用户提醒信息
 */
function showProfileNoti(currentNode,limit){
  var $node = $(currentNode);
  var $xPos = $node.offset().left;
  var $yPos = $node.offset().top+15;

  if($("#UYnotiboxWrapper").length>=1){
    $("#UYnotiboxWrapper").toggle();
  }else{		
    var type = 'notification';
    $.ajax({
      type:"POST",
      dataType:"json",
      url:"youyan_content/getNotification",
      data:{
        user_id:user_id,type:type,limit:limit
      },
      success: function(data){
        $.each(data, function(noti_key, noti_val){
          buildNotiEntry(data[noti_key], 'noti');
        });
        $('#UYnotiLoading').remove();
      },
      cache:false,
      error:function(){
      }
    });

    var $notibox = "<div id='UYnotiboxWrapper'><div class='UYnotiboxTitleWrapper'><div class='UYnotiTitleLeft'>信息提醒</div><a href='http://uyan.cc/index.php/youyan_main/index/noti' target='_blank' style='backgound-image:none;' class='UYnotiShowAll'>查看全部</a><div class='clear'></div></div><div id='UYnotiItemPend'></div></div>";
    $('.UYProfileWrapper').after($notibox);
    $("#UYnotiItemPend").after("<a class='UYnotiItemWrapper' id='UYnotiLoading'>loading</a>");
    $('#UYnotiboxWrapper').css({"left":$xPos+"px","top":$yPos+"px"});
    if(limit>3){
      $strList = '<a target="_blank" href="http://uyan.cc/index.php/youyan_main/index/noti" class="UYnotiItemWrapper readmoreNoti"  style="backgound-image:none;">查看全部</a>';				
      $('#UYnotiboxWrapper').append($strList);
    }
  }
}
/**
 * 显示用户文章提醒信息
 */
function showProfileNotiArticle(currentNode,limit){
  var $node = $(currentNode);
  var $xPos = $node.offset().left;
  var $yPos = $node.offset().top+15;

  if($("#UYnotiboxArticleWrapper").length>=1){
    $("#UYnotiboxArticleWrapper").toggle();
  }else{

    var type = 'article';
    $.ajax({
      type:"POST",
      dataType:"json",
      url:"youyan_content/getNotification",
      data:{
        user_id:user_id,type:type,limit:limit
      },
      success: function(data){
        $.each(data, function(noti_key, noti_val){
          buildNotiEntry(data[noti_key], 'noti_article');
        });
        $('#UYnotiLoading').remove();
      },
      cache:false,
      error:function(){
      }
    });		

    var $notibox = "<div id='UYnotiboxArticleWrapper'><div class='UYnotiboxTitleWrapper'><div class='UYnotiTitleLeft'>信息提醒</div><a href='http://uyan.cc/index.php/youyan_main' class='UYnotiShowAll' target='_blank' style='backgound-image:none;'>查看全部</a><div class='clear'></div></div><div id='UYnotiItemPend'></div></div>";
    $('.UYProfileWrapper').after($notibox);
    $("#UYnotiItemPend").after("<a class='UYnotiItemWrapper' id='UYnotiLoading'>loading</a>");
    $('#UYnotiboxArticleWrapper').css({"left":$xPos+"px","top":$yPos+"px"});
    if(limit>3){
      $strList = '<a target="_blank" href="http://uyan.cc/index.php/youyan_main" class="UYnotiItemWrapper readmoreNoti">查看全部</a>';					
      $('#UYnotiboxWrapper').append($strList);
    }	
  }	
}
/**
 * 点击提醒后显示详细用户提醒信息
 */
function buildNotiEntry(data, type){
  if(type=='noti'){
    var $notiStr = "<a class='UYnotiItemWrapper' href='"+data.link+"' target='_blank'>";
    $notiStr += "<img src = '"+data.profile_img+"' class='UYnotiPhoto'/>";
    $notiStr += "<div class='UYnotiName'>"+data.show_name+"</div>";
    if(data.type=='reply'){
      $notiStr += "<div class='UYnotiIntro'>回复了你的评论</div>";	
    }else{
      $notiStr += "<div class='UYnotiIntro'>喜欢你的评论</div>";	
    }
    $notiStr += "<div class='clear'></div></a>";
  }else if(type=='noti_article_detail'){
	
    var $notiStr = "<a class='UYnotiItemLevelTwo' href='"+data.page_url+"'  target='_blank'>";
    $notiStr +="<div class='UYnotiNameURLAr'>"+data.page_title+"</div>"; 
    $notiStr +="<div class='UYnotiIntroAr'>"+stringToDateTime(data.time)+"</div>";
    $notiStr +="<div class='clear'></div></a>";
	
  }else{
    var $notiStr = "<a class='UYnotiItemWrapper' onclick='moreDetailDomain(\""+data.domain+"\",\""+data.unread+"\");' >";

    /*	if(data.domain_name!=''&&data.domain_name!='undefined'){
    $notiStr += "<div class='UYnotiNameURL'>"+data.show_name+"</div>";
  }else{*/
    $notiStr += "<div class='UYnotiNameURL'>"+data.domain+"</div>";
    /*}*/
    $notiStr += "<div class='UYnotiIntro'>有"+data.unread+"篇新文章</div>";

    $notiStr += "<div class='clear'></div></a>";	
  }
  $("#UYnotiItemPend").ready(function (){
    $("#UYnotiItemPend").before($notiStr);
  });
}
/**
 * 文章提醒点击域名后显示此域名中的文章更新
 */
function moreDetailDomain(domainSelect,limit){
  $(".UYnotiTitleLeft").html(domainSelect+"<a onclick='backToAList()' class='backTolistTitle'>返回</a>");
  $(".UYnotiItemWrapper").hide();
  $("#UYnotiItemPend").after("<a class='UYnotiItemWrapper' id='UYnotiLoading'>loading</a>");
  //prepare artilcs
  $.ajax({
    type:"POST",
    dataType:"json",
    url:"youyan_content/getNotification_article",
    data:{
      user_id:user_id,domainSelect:domainSelect,limit:limit
    },
    success: function(data){
      $("#UYnotiLoading").remove();
      $.each(data, function(noti_key, noti_val){
        buildNotiEntry(data[noti_key], 'noti_article_detail');
      });
      $('#UYnotiLoading').remove();
      if(limit>3){
        $strList = '<a target="_blank" href="http://uyan.cc/index.php/youyan_main" class="UYnotiItemWrapper readmoreNoti" style="backgound-image:none;">查看全部</a>';					
        $('#UYnotiboxWrapper').append($strList);
      }

    },
    cache:false,
    error:function(){
    }
  });	
}
/**
 * 在显示用户文章提醒二级菜单后返回一级菜单
 */
function backToAList(){
  $(".UYnotiTitleLeft").html('信息提醒');
  $('.UYnotiItemLevelTwo').remove();
  $(".UYnotiItemWrapper").show();
}
/**
 * 鼠标悬停时的打分栏变化
 */
function UYChangeStar(currentState){
	$('.UYVoteStar').removeClass('UYCurrentVoteStar');
	for(var i = 0;i<=currentState;i++){
		$('#UYVoteStar'+i).addClass('UYCurrentVoteStar');
	}
}
/**
 * 打分栏初始化
 */
function UYClearStar(){
	$('.UYVoteStar').removeClass('UYCurrentVoteStar');
	if(clickVote!=-1){
		UYChangeStar(clickVote);
	}
}
/**
 * 给当前页面评分,评分将直接记录至数据库
 */
function UYVoteStar(currentStar){
	clickVote = currentStar;
	if(user_id==''||user_id==null){
		var set_user_id = 100;	
	}else{
		var set_user_id = user_id;	
	}
  $.ajax({
    type:"POST",
    dataType:"json",
    url:"youyan_content/voteStar",
    data:{
      set_user_id:set_user_id,clickVote:clickVote,page:page
    },
    success: function(data){
		$('.UYVoteItemNoti').html('评分成功');
		$('.UYVoteItemNoti').animate({
			opacity: 'toggle'

	    }, 200, function() {
		// Animation complete.
			setTimeout("$('.UYVoteItemNoti').animate({opacity: 'toggle'}, 300, function() {});",1000);
	    });
    },
    cache:false,
    error:function(){
    }
  });	
}

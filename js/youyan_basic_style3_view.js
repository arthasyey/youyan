function bindFuncToIcons(){
  $('.connectBTNSSO').click( function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/sso', SSOName,'location=yes,left=200,top=100,width=' + SSOWidth + ',height=' + SSOHeight + ',resizable=yes');
  });

  
  $('.connectBTNRENREN').click( function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/renren','人人网','location=yes,left=200,top=100,width=500,height=350,resizable=yes');
  });

  $('.connectBTNMSN').click( function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/msn','MSN','location=yes,left=200,top=100,width=500,height=350,resizable=yes');
  });

  $('.connectBTNQQ').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/qq','QQ空间','location=yes,left=200,top=100,width=600,height=460,resizable=yes');
  });

  $('.connectBTNSINA').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/sina','新浪微博','location=yes,left=200,top=100,width=600,height=400,resizable=yes');
  });

  $('.connectBTNKAIXIN').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/kaixin','开心网','location=yes,left=200,top=100,width=500,height=400,resizable=yes');
  });

  $('.connectBTNSOHU').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/sohu','搜狐微博','location=yes,left=200,top=100,width=900,height=600,resizable=yes');
  });

  $('.connectBTNNETEASY').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/neteasy','网易微博','location=yes,left=200,top=100,width=800,height=700,resizable=yes');
  });


  $('.connectBTNTENCENT').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/tencent','腾讯微薄','location=yes,left=200,top=100,width=800,height=800,resizable=yes');

  });

  $('.connectBTNDOUBAN').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/douban','豆瓣','location=yes,left=200,top=100,width=550,height=450,resizable=yes');
  });

  $('.connectBTNEMAIL').click(function() {
    boxEmailLogin.show();
    boxEmailLogin.center('x');
    var currentBindBoxX = boxEmailLogin.left;
    boxEmailLogin.moveTo(currentBindBoxX,50);
    if($('.UYShowList').height()<180){
      $('.UYEmptyBoxWrapper').css({"height":"150px"});
    }
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    $("#UYloginEmailName").val("");
    $("#UYloginEmailAD").val("");
    $("#UYloginEmailURL").val("");
    $("#alertLogin").html("");
  });

  
  $('.smallMSN').click( function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/msn','MSN','location=yes,left=200,top=100,width=500,height=350,resizable=yes');
  });
  
  $('.smallRENREN').click( function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/renren','人人网','location=yes,left=200,top=100,width=500,height=350,resizable=yes');
  });

  $('.smallQQ').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/qq','QQ空间','location=yes,left=200,top=100,width=600,height=460,resizable=yes');
  });

  $('.smallSINA').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/sina','新浪微博','location=yes,left=200,top=100,width=600,height=400,resizable=yes');
  });

  $('.smallKAIXIN').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/kaixin','开心网','location=yes,left=200,top=100,width=500,height=400,resizable=yes');
  });

  $('.smallSOHU').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/sohu','搜狐微博','location=yes,left=200,top=100,width=900,height=600,resizable=yes');
  });

  $('.smallNETEASY').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/neteasy','网易微博','location=yes,left=200,top=100,width=800,height=700,resizable=yes');
  });


  $('.smallTENCENT').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/tencent','腾讯微薄','location=yes,left=200,top=100,width=800,height=800,resizable=yes');
  });

  $('.smallDOUBAN').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    window.open('youyan/prepareLogin/douban','豆瓣','location=yes,left=200,top=100,width=550,height=450,resizable=yes');
  });

  $('.smallEMAIL').click(function() {
    boxEmailLogin.show();
    boxEmailLogin.center('x');
    var currenXPosition = boxEmailLogin.left;
    var offsetTopEmail = $(this).offset().top;
    offsetTopEmail = offsetTopEmail-180;
    if(offsetTopEmail<=70){
      offsetTopEmail = 70;
    }

    boxEmailLogin.moveTo(currenXPosition,offsetTopEmail);

    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    $("#UYloginEmailName").val("");
    $("#UYloginEmailAD").val("");
    $("#UYloginEmailURL").val("");
    $("#alertLogin").html("");
  });
}

function docReadyFunc(){
  var b_v = navigator.appVersion;
  IE6 = b_v.search(/MSIE 6/i) != -1;
  IE7 = b_v.search(/MSIE 7/i) !=-1;
  autoFixWidth = false;
  getTopLogin();
  if(width == '100%'){
    //width = $("body").width();
    width = $("body").width();
    autoFixWidth = true;
  }

  InputAmount = parseInt(numLimit);
  if(InputAmount > 0){
    $("#UYCurrentAmount").html(numLimit);
    $("#UYTotalAmount").html('/' + numLimit);
  }
  else{
    $('#UYLeftNumber').css("display", "none");
    $('#UYReplyLeftNumber').css("display", "none");
  }


  //bindedType = 'SINA,DOUBAN';
  // 获取当前页面评论数
  $.post("youyan_content/getCommentsCNT", {page: page, delStyle: delStyle}, function(data){
    $("#UYCommentAmount").html(data);
    numComments = parseInt(data);
    limitAmount = parseInt(numCommentsPerPage);
    if(numComments<limitAmount){
      $(".UYMoreItemsWrapper").css({"display":"none"});	
    }
  });

  //loadcssfile("../css/youyan_style"+styleNum+".css", "css");

  DIYWidth = width;
  // 调整宽度
  if(IE6&&autoFixWidth){
    $('.UYPane').css({"width":DIYWidth});
    $('#submitUY').css({"width":(DIYWidth-90)+"px"});
	$('.UYTitle').css({"width":(DIYWidth)+"px"});
	$('#UYInputReady').css({"width":(DIYWidth-10)+"px"});
  }else{
    $('.UYPane').css({"width":DIYWidth});
    $('#submitUY').css({"width":(DIYWidth-90)+"px"});
	$('.UYTitle').css({"width":(DIYWidth)+"px"});
	$('#UYInputReady').css({"width":(DIYWidth-10)+"px"});
  }


  //end

  $("#UYTitleTXT").html(descWord);	// 标题
  $("#submitUY").val(UYPrepareInputWord);	// 输入框中输入您的评论这几个文字
  $("#submitUY").css({"color":"#bdbbbb"});

  getRecommend();	// 获得当前页面的推荐数，有多少人喜欢
  getComments();	// 获取评论
  getWebBox();	//获得网站社区基本信息，包括网站名、用户量等，更新至打开的社区页面
}
function prepareReplyEmotion(){
	var $emotionKeyNormal = new Array("纠结","心动","生气","开心","调皮","眨眼","害羞","失落","酷","愤怒","惊讶","无语","哭泣","笑","大哭","调皮","惊讶","呆","口哨","天使","恶魔","恶魔笑","闭嘴","满意","睡觉","得意","生病","怀疑","专注","外星人","史莱克","游戏","爱心","家","地球","邮件","音乐","编辑","电话","照相");
	var $emotionKey = new Array("纠结","心动","用力","抱","鬼脸","喃喃","啪地","狂泪","忍耐","跳舞","狸猫","虫子","面条舞","喝茶","给力","思考","紧张","睡醒","离家","怒气","吃","囧","惹嫌","潜水","开心","捏脸","怒火","鬼","疑问","暴跳","不甘心","下班","失意","相拥","暖和","示爱","无语","害羞","礼物","狂笑");
	var $emotionReplySTR='<div class="emotionNavWrapper"><a class="currentEmotionTab" onclick="changeEmotionTab(\'default\')" id="defaultEmotionReply">默认表情</a><a class="unselectEmotionTab" onclick="changeEmotionTab(\'ali\')" id="aliEmotionReply">阿狸</a><div class="clear"></div></div><div class="snEmotionWrapper">';
	for(var i = 1;i<=40;i++){   
		$emotionReplySTR+="<div class='emotion' onMouseOver='changeEmotionHover(\""+i+"\",\"reply\",\"default\")' onclick='inputEmotion(\"("+$emotionKeyNormal[(i-1)]+")\",\"reply\")'><img alt='"+$emotionKeyNormal[(i-1)]+"' emotion='("+$emotionKeyNormal[(i-1)]+")'  src='/images/emotions/default/"+i+".png' class='hoverplace'/></div>";
	} 
	$emotionReplySTR +="</div><div id='LEmotionReplyNor'><img emotion='(al"+$emotionKey[0]+")'  src='/images/emotions/ali/1.gif' class='hoverplace'></div><div class='clear'></div><div class='aliEmotionWrapper'>";
	for(var i = 1;i<=40;i++){    
		$emotionReplySTR+="<div class='emotion' onMouseOver='changeEmotionHover(\""+i+"\",\"reply\",\"ali\")' onclick='inputEmotion(\"(al"+$emotionKey[(i-1)]+")\",\"reply\")'><img alt='"+$emotionKey[(i-1)]+"' emotion='(al"+$emotionKey[(i-1)]+")'  src='/images/emotions/ali/"+i+".gif' class='hoverplace'/></div>";
	}
	$emotionReplySTR+='</div><div id="LEmotionReply"><img emotion="(al'+$emotionKey[0]+')"  src="/images/emotions/ali/1.gif"/ class="hoverplace"></div><div class="clear"></div>';
	$("#UYEmotionReplyPane").html($emotionReplySTR);
}
function prepareEmotion(){
	var $emotionKeyNormal = new Array("纠结","心动","生气","开心","调皮","眨眼","害羞","失落","酷","愤怒","惊讶","无语","哭泣","笑","大哭","调皮","惊讶","呆","口哨","天使","恶魔","恶魔笑","闭嘴","满意","睡觉","得意","生病","怀疑","专注","外星人","史莱克","游戏","爱心","家","地球","邮件","音乐","编辑","电话","照相");
	var $emotionKey = new Array("纠结","心动","用力","抱","鬼脸","喃喃","啪地","狂泪","忍耐","跳舞","狸猫","虫子","面条舞","喝茶","给力","思考","紧张","睡醒","离家","怒气","吃","囧","惹嫌","潜水","开心","捏脸","怒火","鬼","疑问","暴跳","不甘心","下班","失意","相拥","暖和","示爱","无语","害羞","礼物","狂笑");	
	var $emotionSTR='<div class="emotionNavWrapper"><a class="currentEmotionTab" onclick="changeEmotionTab(\'default\')" id="defaultEmotion">默认表情</a><a class="unselectEmotionTab" onclick="changeEmotionTab(\'ali\')" id="aliEmotion">阿狸</a><div class="clear"></div></div><div class="snEmotionWrapper">';	
	for(var i = 1;i<=40;i++){
		$emotionSTR +="<div class='emotion' alt='"+$emotionKeyNormal[(i-1)]+"' onMouseOver='changeEmotionHover(\""+i+"\",\"input\",\"default\")' onclick='inputEmotion(\"("+$emotionKeyNormal[(i-1)]+")\",\"input\")'><img emotion='("+$emotionKeyNormal[(i-1)]+")'  src='/images/emotions/default/"+i+".png' class='hoverplace'  alt='"+$emotionKeyNormal[(i-1)]+"'/></div>";	
	}
	$emotionSTR +="</div><div id='LEmotionNor'><img emotion='(al"+$emotionKey[0]+")'  src='/images/emotions/ali/1.gif' class='hoverplace'></div><div class='clear'></div><div class='aliEmotionWrapper'>";
	for(var i = 1;i<=40;i++){	
		$emotionSTR +="<div class='emotion' onMouseOver='changeEmotionHover(\""+i+"\",\"input\",\"ali\")' onclick='inputEmotion(\"(al"+$emotionKey[(i-1)]+")\",\"input\")'><img alt='"+$emotionKey[(i-1)]+"' emotion='(al"+$emotionKey[(i-1)]+")'  src='/images/emotions/ali/"+i+".gif' class='hoverplace'/></div>";
    }	
	$emotionSTR+='</div><div id="LEmotion"><img emotion="(al'+$emotionKey[0]+')"  src="/images/emotions/ali/1.gif"/ class="hoverplace"></div><div class="clear"></div>';
	$('#UYEmotionPane').html($emotionSTR);
}
function buildCommentEntry(data, type){
  var isWpComment;
  if(data.user_id == 94){ // Wordpress Super User Id
    isWpComment = true;
  }
  else
    isWpComment = false;
  if(!isWpComment){
    var wrapperType;
    var infoWrapperType;
    if(type == 'comment'){
      wrapperType = 'itemWrapper';
      infoWrapperType = 'UYInfoWrapper';
    }
    else{
      wrapperType = 'itemWrapperSC';
      infoWrapperType = 'UYInfoWrapperSC';
    }

    var item = '<div class="' + wrapperType + '" id="' + data.comment_id + '">';
    if(!data.profile_img || data.user_id == 100){
      item += '<a class="UYPhoto" style="background:url(' + get_gravatar(data.comment_author_email) + ') 0 0 no-repeat"  ';
    }else{
      item += '<a class="UYPhoto" style="background:url(' + data.profile_img + ') 0 0 no-repeat" ';
    }
    item += 'onclick="openProfile(\''+data.user_id+'\',this);"></a>';

    item += buildNamePart(data, infoWrapperType);	//评论条中渲染用户信息

    item += '<span class="commentContent';
    if(data.veryfy_status != 0){
      item += ' commentDel"><br/> (该评论正在审核) </span></div>';
    }
    else{		
	  data.content = data.content.replace( "\n", "<br>");
      item += '"><br/>' + createEmotion(data.content);	// 过滤表情
      item += '</span></div>';
      item += '<div class="UYArrowHide"></div>';
      item += '<div class="UYInfoAction"> '; 
      item += '<a class="UYUpIcon" onclick="UYUp(this)"></a>';
      item += '<a class="UYUpInfo" onclick="UYUp(this)">' + digName + '<span class="UYupAmount">' + data.n_up +'</span> </a>';

      if(commentStyle == 1){	// 是否显示踩
        item += '<a class="UYDownIcon" onclick="UYDown(this)"></a>';
        item += '<a class="UYDownInfo" onclick="UYDown(this)">' + digDownName + '<span class="UYdownAmount">' + data.n_down +'</span> </a>';
      }

      item += '<a class="UYReply" onclick="UYreply(this)">回复</a>';
      item += '<a class="UYDelItem" onclick="UYdel(this)" >删除</a>';

      item += '<span class="UYCUid" style="display:none" >'+data.user_id+'</span>';
      item += '<div class="UYSendTime">';
      item += stringToDateTime(data.time);	// 距离现在多少时间
      item += '</div>';
      item += '<div class="clear"></div>';
      item += '</div>';
    }
    item += '</div><div class="clear"></div></div>';
    return item;
  }
  else{
    var wrapperType;
    var infoWrapperType;
    if(type == 'comment'){
      wrapperType = 'itemWrapper';
      infoWrapperType = 'UYInfoWrapper';
    }
    else{
      wrapperType = 'itemWrapperSC';
      infoWrapperType = 'UYInfoWrapperSC';
    }
    var item = '<div class="' + wrapperType + '" id="' + data.comment_id + '">';
    item += '<a class="UYPhoto" style="background:url(' + get_gravatar(data.comment_author_email) + ') 0 0 no-repeat" ';

    item += ' onclick="openProfile(\''+data.user_id+'\',this);"></a>';
    item += buildNamePart(data, infoWrapperType, true);

    item += '<span class="commentContent';

    if(data.veryfy_status != 0){
      item += ' commentDel"><br/> (该评论正在审核) </span></div>';
    }
    else{
      item += '"><br/>';
	  data.content = data.content.replace( "\n", "<br>");
      item += data.content + '</span></div>';
      item += '<div class="UYArrowHide"></div>';
      item += '<div class="UYInfoAction"> '; 
      item += '<a class="UYUpIcon" onclick="UYUp(this)"></a>';
      item += '<a class="UYUpInfo" onclick="UYUp(this)">' + digName + '<span class="UYupAmount">' + data.n_up +'</span> </a>';

      if(commentStyle == 1){
        item += '<a class="UYDownIcon" onclick="UYDown(this)"></a>';
        item += '<a class="UYDownInfo" onclick="UYDown(this)">' + digDownName + '<span class="UYdownAmount">' + data.n_down +'</span> </a>';
      }
      item += '<a class="UYReply" onclick="UYreply(this)">回复</a>';
      item += '<a class="UYDelItem" onclick="UYdel(this)" >删除</a>';
      item += '<span class="UYCUid" style="display:none"></span>';
      item += '<div class="UYSendTime">';
      item += stringToDateTime(data.time);
      item += '</div>';
      item += '<div class="clear"></div>';
      item += '</div>';
    }
    item += '</div><div class="clear"></div></div>';
    return item;
  }
}

function buildNamePart(data, infoWrapperType){
  var isWpComment = arguments[2] || false;
  if(!isWpComment){
    if(data.user_id!='100'){ 
		if(data.show_title!=''&&data.show_title!=null){
			if(data.show_title.length>20){
				var newShowTitle = data.show_title.substr(0,20)+'...';
			}else{
				var newShowTitle = data.show_title;
			}
		}
      var item = '<div class="' + infoWrapperType + '"><div class="UYInfo"><a onclick="openProfile(\''+data.user_id+'\',this)"';
      item += '" class="UYInfoLink">' + data.show_name + '</a>';
	  if(data.show_title!=''&&data.show_title!=null){
	  	item += '<div class="UYTitlePart" title="'+data.show_title+'">'+newShowTitle+'</div>';
	  }
      item += '<span class="dotControl"> (来自:<a class="UYSourceLink" target="_blank" href=" ' + getUserSNSHome(data)+'">'
          + SNSTypeToName[data.from_type]
          + '</a>)</span>';
	  //inser start  
	  if(data.veryfy_status!=0){
		  item += '<span class="commentVeryfyAlert">评论将在审核后显示</span>';
	  }	
	  if(showScoreItem==1){		  
		  item +='<div class="UYScoreShowWrapper">';
		  for(var i = 0;i<=4;i++){
			  if(i<data.vote_star){
		  		  item +='<img src="/images/star_small_done.png" class="UYItemStar"/>';
			  }else{
				  item +='<img src="/images/star_small_un.png" class="UYItemStar"/>';
			  }
		  }
		  item +='<div class="clear"></div></div>';
	  }
    }else{                                          // This is the anonmynous user
      var item = '<div class="' + infoWrapperType + '"><div class="UYInfo"><a onclick="openProfile(\''+data.user_id+'\',this)"';
      item += '" class="UYInfoLink" target="_blank">' + data.comment_author + '</a>';
      item += '<span class="dotControl"> (匿名评论)</span>';
	  if(data.veryfy_status!=0){
		  item += '<span class="commentVeryfyAlert">评论将在审核后显示</span>';
	  }	
	  	  //inser start
	  if(showScoreItem==1){		  
		  item +='<div class="UYScoreShowWrapper">';
		  for(var i = 0;i<=4;i++){
			  if(i<data.vote_star){
		  		  item +='<img src="/images/star_small_done.png" class="UYItemStar"/>';
			  }else{
				  item +='<img src="/images/star_small_un.png" class="UYItemStar"/>';
			  }
		  }
		  item +='<div class="clear"></div></div>';
	  }
    }
    return item;
  }else{
    var item = '<div class="' + infoWrapperType + '"><div class="UYInfo"><a onclick="openProfile(\''+data.user_id+'\',this")';

    item += ' class="UYInfoLink" >' + data.comment_author + '</a><span class="dotControl"> (wordpress原有评论) </span><br/>';
    return item;
  }
}

function UYreply(currentNode){
  var $InfoWrapperNode = $(currentNode).parent().parent();
  var $tartgetNode = $InfoWrapperNode.parent().next();
  var $replyName = $(currentNode).parent(".UYInfoAction").parent("div").children(".UYInfo").children(".UYInfoLink").html();
  if($tartgetNode.attr("id")=="UYreplySystem"){
    $("#UYreplySystem").remove();
  }
  else{
    $("#UYreplySystem").remove();
    var img_url;
    if(user_id == undefined){
      img_url = "../images/photoDefault.png";

      var $UYreplyStr = '<div id="UYreplySystem"><div class="UYReplyPhotoWrapper" style="width:50px;height:50px;float:left;margin:0 10px;_margin:0 10px 0 5px;background-image: url('
        + img_url
        + ')"></div><div class="UYreplyContentWrapper"><textarea id="UYreplyInput" name="UYreplyInput" onfocus="if(use_emotions==1){showEmoReply();}" onkeyup="$(\'#UYReplyCurrentAmount\').html(calc_rest($(\'#UYreplyInput\').val(), 1))">@'
        + $replyName
        + ': </textarea><div id="UYEmotionReplyPane"></div><div id="UYEmotionReplyBTN" onclick="showEmotionPaneReply()" style="display: none;">表情</div>';

      if(InputAmount > 0)
        $UYreplyStr +=  '<div id="UYReplyLeftNumber"><span id="UYReplyCurrentAmount">'
          + InputAmount
          + '</span><span id="UYReplyTotalAmount">/'
          + InputAmount
          + '</span></div>';


      $UYreplyStr +=  '<div class="UYreplyAction"><a id="UYSubmitReplyBTN" onclick="UYCommentButtonClick(this, \'reply\');" ><span class="replyBTNText">回复</span></a>'
        + '<div class="clear"></div></div></div><div class="clear"></div></div>';
    }else{
      img_url = profile_img_url; 
      $UYreplyStr = '<div id="UYreplySystem">'
        + '<div class="UYReplyPhotoWrapper" style="width:50px;height:50px;float:left;_margin:0 10px 0 5px;margin:0 10px;background-image: url('
        + img_url
        +')"></div>'
        + '<div class="UYreplyContentWrapper"><textarea id="UYreplyInput" name="UYreplyInput" onfocus="if(use_emotions==1){showEmoReply();}" onkeyup="$(\'#UYReplyCurrentAmount\').html(calc_rest($(\'#UYreplyInput\').val(), 1))">@'
        + $replyName
        + ': </textarea><div id="UYEmotionReplyPane"></div><div id="UYEmotionReplyBTN" onclick="showEmotionPaneReply()" style="display: none;">表情</div>';

      if(InputAmount > 0)
        $UYreplyStr += 
          '<div id="UYReplyLeftNumber"><span id="UYReplyCurrentAmount">'
          + InputAmount
          + '</span><span id="UYReplyTotalAmount">/'
          + InputAmount
          + '</span></div>';

      $UYreplyStr += '<div class="UYreplyAction"><a id="UYSubmitReplyBTNConnected" onclick="UYCommentButtonClick(this, \'reply\');" ><span class="replyBTNTextConnected">回复</span></a>'
        + '<div class="clear"></div></div></div>'
        + '<div class="clear"></div></div>';	
    }

    $InfoWrapperNode.parent().after($UYreplyStr);
    if(user_id!=100){
      $('#UYSubmitReplyBTNConnected').before('<div class="UYChooseConnect"><input type="checkbox" id="UYConnectToSNSReply" checked="checked"/><div class="UYCheckBoxIntro">同步到社交网站</div><div class="clear"></div></div>');
    }
    switch(styleNum){
      default:
        if(IE6&&autoFixWidth){
          $("#UYreplyInput").css({"width":DIYWidth-154});
          $("#UYreplySystem").css({"width":DIYWidth-63});
        }else{
          $("#UYreplyInput").css({"width":DIYWidth-154});
          $("#UYreplySystem").css({"width":DIYWidth-63});
        }
        break;
    }
    $("#UYEmotionReplyPane").html($emotionReplySTR);
  }
}
function UYShowSNS(currentNode,type){
  var $node = $(currentNode);
  var inner = "<div class='itemsListContainer'>";
  var account_menu = account_order;
  if(account_order.search(/_/)!=-1){
    var account_array = account_order.split('_');
    account_menu = account_array[1];
  }
  for(var pos = 0; pos < account_menu.length; pos++){
    var sns_id = parseInt(account_menu.substr(pos, 1));
    var snsType = SNSTypes[sns_id];
    var snsName = SNSTypeToName[snsType];
    var item = "<a class='menuItem small" + snsType + "'>" + snsName + "</a>";
    inner += item;
  }
  inner += '</div>';

  if(type=='reply'){
    $node.after("<div></div><div class='connecntReplyMenu'><a class='closeReplyMenu' onclick='hideMenu(this,\"reply\")'>回复</a>" + inner + "</div>");
  }else{
    $node.after("<div></div><div class='connecntMenu'><a class='closeMenu' onclick='hideMenu(this, \"comment\")'>发表评论</a>" + inner + "</div>");
  }
  
  if (window.MessageEvent && !document.getBoxObjectFor){	 
    var innerHeight = ($(".UYShowList").height()+ $(".UYShowList").offset().top);
    var changeToHeight = $(".connecntMenu").offset().top +$(".connecntMenu").height()- $(".UYShowList").height() ;
	var targetHeight = changeToHeight - $(".UYShowList").offset().top;
    if(innerHeight<changeToHeight){
      $(".UYShowList").css({"height":targetHeight+"px"});
    }
  }  
  
  bindFuncToIcons();
}
function changeSort(type){
  showSortMenu();
  if(type == curSort){
    return;
  }

  curSort = type;
  if(!numComments > 0)
    return;

  $(".itemWrapperSC").remove();
  $(".itemWrapper").remove();

  $("#timeSort").removeClass("currentSort");
  $("#hotSort").removeClass("currentSort");
  if(type=='hotness'){
    $("#timeSort").removeClass("currentSort");
    $("#hotSort").addClass("currentSort");
  }else{
    $("#timeSort").addClass("currentSort");	
    $("#hotSort").removeClass("currentSort");			
  }

  commentPageNum = 0;
  getComments();
  $(".UYMoreItemsWrapper").show();
}
function showSortMenu(){
  if($('#sortTypeMenu').length>=1){
    $('#sortTypeMenu').remove();
  }else{
    $(".tempCube").remove();
    $(".sortBTN").after("<div class='tempCube'><div id='sortTypeMenu'><div class='typeIntro'>排序方式:</div><a class='sortLink currentSort' onclick='changeSort(\"time\");' id='timeSort'>按时间排序</a><a class='sortLink' onclick='changeSort(\"hotness\");' id='hotSort'>按热度排序</a></div><div class='tempCube'><div class='tempCube'>");

    if(curSort=='hotness'){
      $("#timeSort").removeClass("currentSort");
      $("#hotSort").addClass("currentSort");
    }else{
      $("#timeSort").addClass("currentSort");	
      $("#hotSort").removeClass("currentSort");			
    }
  }
}

function loadMoreFunctionPane(userSNSHome){
  if(user_id == undefined){
    $(".UYLoginSerious").show();
    var content = '<div class="UYMoreFunctions">'
      + '<a id="UYSubmitInputBTN" onclick="UYCommentButtonClick(this, \'comment\')"><span class="submitBTNText">发表评论</span></a>'
      + '<div class="clear"></div></div></div>';
    $('.UYMoreFunctionsWrapper').html(content);
    submitReplyBTNConnectedChange();
  }else{
    if(login_bar_auto_hide!=1){
      $(".UYLoginSerious").hide();
    }
    var content = '<div class="UYMoreFunctions">'
      + '<div class="logoutWrapper"><div class="clear"></div></div>'
      + '<a id="UYSubmitInputBTNConnected" onclick="UYCommentButtonClick(this, \'comment\')"><span class="submitBTNTextConnected">发表评论</span></a>'
      + '<div><a id="UYLogoutBTN" onclick="logout()">(登出)</a>'
      + '<a class="currentUserNameIntro"  href="'
      + userSNSHome
      + '" target="_blank">'
      + show_name
      + '</a>'
      + '<div class="UYChooseConnect">';

    if(user_id!=100){

      content += '<input type="checkbox" id="UYConnectToSNS" checked="checked"/><div class="UYCheckBoxIntro">同步到社交网站</div>';
    }	  
    content += '<div class="clear"></div>'
      + '</div>'
      + '<div class="clear"></div></div></div>'; 
    $('.UYMoreFunctionsWrapper').html(content);
    submitReplyBTNChange();
  }
}

function dealWithPageVote(){
  if(page=='')return;
  if(user_id == undefined){
    if(GetCookie('vote_page_up')!=null&&GetCookie('vote_page_up').match(page)!=null){
      $(".pageUp").removeAttr("onclick");
      var newclick = new Function("showShareMenu('down')");
      $(".pageUp").unbind();
      $(".pageUp").attr("onclick","").click(newclick);	
      $(".pageUp").children("img").attr("src","../../images/upDigColor.png");
    }else if(GetCookie('vote_page_down')!=null&&GetCookie('vote_page_down').match(page)!=null){
      $(".pageDown").removeAttr("onclick");
      var newclick = new Function("pageVoteDowns('down')");
      $(".pageDown").unbind();
      $(".pageDown").attr("onclick","").click(newclick);
      $(".pageDown").children("img").attr("src","../../images/downDigColor.png");	
    }
  }else{
    $.ajax({
      type:"POST",
      url:"youyan_content/dealWithPageVote/",
      data:{
        user_id: user_id,
      page: page
      },
      dataType:"text",
      success: function(data){
        switch(data){
          case '':
            break;
          case 'upselect':
            $(".pageUp").removeAttr("onclick");
            $(".pageUp").attr("onclick",function(){return function(){showShareMenu('down')}});
            $(".pageUp").children("img").attr("src","../../images/upDigColor.png");
            break;
          case 'downselect':
            $(".pageDown").removeAttr("onclick");
            $(".pageDown").attr("onclick",function(){return function(){pageVoteDowns('down')}});
            $(".pageDown").children("img").attr("src","../../images/downDigColor.png");
            break;
          case 'upselectdownselect':
            //impossible infact
            $(".pageUp").removeAttr("onclick");
            $(".pageUp").attr("onclick",function(){return function(){showShareMenu('down')}});
            $(".pageUp").children("img").attr("src","../../images/upDigColor.png");				
            $(".pageDown").removeAttr("onclick");
            $(".pageDown").attr("onclick",function(){return function(){pageVoteDowns('down')}});
            $(".pageDown").children("img").attr("src","../../images/downDigColor.png");				
            break;
        }
      }
    });
  }
}
function pageVoteDowns(up_or_down){
  if(user_id == undefined){
    var user_id =100;
  }
  if(page=='')return;
  $.ajax({
    type:"POST",
    url:"youyan_content/decreasePageCnt/"+up_or_down,
    cache:false,
    data:{
      page:page,
    user_id:user_id
    },
    dataType: 'text',
    success:function(data){
      if(up_or_down=='up'){
        if($("#favPageAmount").attr("class")=='checkFav'){
          $amount = $("#favPageAmount").html();
          $amount = parseInt($amount)-1;
          $("#favPageAmount").html($amount); 
        }

        $(".pageDown").removeAttr("onclick");
        var newclick3 = new Function("pageVoteDowns('down')");
        $(".pageDown").unbind();
        $(".pageDown").attr("onclick","").click(newclick3);

        $(".pageUp").removeAttr("onclick");
        var newclick4 = new Function("showShareMenu('up')");
        $(".pageUp").unbind();
        $(".pageUp").attr("onclick","").click(newclick4);	
      }else{
        $(".pageDown").removeAttr("onclick");
        var newclick5 = new Function("pageVoteDowns('up')");
        $(".pageDown").unbind();
        $(".pageDown").attr("onclick","").click(newclick5);	
      }
      if($(".pageDown").children("img").attr("src")=="../../images/downDig.png"){
        $(".pageDown").children("img").attr("src","../../images/downDigColor.png");
      }else{
        $(".pageDown").children("img").attr("src","../../images/downDig.png");
      }
      $(".pageUp").children("img").attr("src","../../images/upDig.png");
      //set cookie
      if(up_or_down == 'up'){
        var vote_down_str = GetCookie('vote_page_down');
        if(vote_down_str!=null){
          vote_down_str = vote_down_str+page+',';
        }else{
          vote_down_str = page+',';
        }

        setCookie('vote_page_down',vote_down_str,30);
        //cancel down
        var vote_up_str = GetCookie('vote_page_up');
        var rstr =new RegExp(page+',',"g");
        vote_up_str = vote_up_str.replace(rstr,'');				
        setCookie('vote_page_up',vote_up_str,30);

      }else{
        var vote_down_str = GetCookie('vote_page_down');
        var rstr =new RegExp(page+',',"g");
        vote_down_str = vote_down_str.replace(rstr,'');				
        setCookie('vote_page_down',vote_down_str,30);
      }	
    },
      error:function(){
              alert("increase failed");
            }
  });	
}

function postComment($node){
  if($("#UYCommentCheckBoxS").val()!=''){return;}
  //loading state
  var content = $("textarea#submitUY").val();
  var postToSNS = $("#UYConnectToSNS").attr("checked");
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
    data: {
      content: content,
    page: page,
    page_url: pageURL,
    page_img: pageImg,
    domain: domain,
    title: title,
    user_id: user_id,
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
	  if(data=='short'){	//cookie判断发布是否太快
		 $("#submitUY").val("您的发布频率过快，请歇息一下哦: )");
	  }
	  if(data=='spam'){	//黑词
		location.href='http://uyan.cc/spam.html';
	  }
	  if(data!='again'&&data!='spam'&&data!='short'){
		  var new_entry = buildCommentEntry(data, 'comment');	//获取此评论的html
		  $(".UYEmptyComment").after(new_entry);	//后面渲染
		  $(".UYEmptyBoxWrapper").remove();
		  $("textarea#submitUY").val(UYPrepareInputWord);
		  numComments++;
      	  $("#UYCommentAmount").html(numComments);
		  var comment_id = data.comment_id;
	  }
	  //end		

      $("#submitUY").css({"color":"#bdbbbb"});

      $('.UYInfoWrapper').ready(function(){
        //when post
            if(IE6&&autoFixWidth){
              $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"});
			  $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
			  $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});
			  
            }else{
              $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"});
			  $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
			  $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});
            }
      });
      
      $('#UYCurrentAmount').html(InputAmount);
      $node.css({"border":"#29447E","background-color":"#5f78ab"});
      $node.children(".submitBTNTextConnected").css({"padding-left":"39px","color":"#fff"});
      $node.children(".submitBTNTextConnected").html("发表评论");
      $node.removeAttr("disabled");
      $node.removeData('executing');
      //
     if(data!='again'&&data!='spam'&&data!='short'){

      $.post("youyan_content/postCommentPostWork",	//计数的接口等以及发微薄
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
        comment_author:comment_author,
        comment_author_email:comment_author_email,
        comment_author_url:comment_author_url,
        comment_id : comment_id,
        session_name: session_name,
		vote_score:clickVote,
		veryfyCheck:veryfyCheck
          });
      }
	}
  });
}

function UYSubmitInput($node){
  if($node.data('executing'))
    return;	//判断是否是正在发

  checkState = checkInput($("#submitUY").val());
  if(checkState){
    if(user_id == undefined){
      $("#UYalertNoConnection").css({"display":"none"});
      $("#UYalertNoConnection").fadeIn("fast");
    }else{
      $node.css({"background-color":"#eeeeee","border":"1px solid #b3afaf","cursor":"normal"});
      $node.children(".submitBTNTextConnected").css({"color":"#acacac","padding-left":"45px"});
      $node.children(".submitBTNTextConnected").html("发表中");
      $node.attr("disabled", "true");
      $node.data('executing', true);
      postComment($node);
    }
  }else{
    $("#UYCurrentAmount").html("请输入内容");
  }
}
function showShareMenu(up_or_down){

  if(up_or_down=='down'){
    submitShare('down');
  }else{	  
    if($('#shareTypeMenu').length>=1){
      $('#shareTypeMenu').remove();
    }else{		
      var $item = "<div></div><div id='shareTypeMenu'>"
        +"<div class='shareIntro'>顶并分享到:</div>"
        +"<div class='shareLine'><input type='checkbox' id='sinaShareBox' class='sharecheckbox'/><div class='shareImageIntro SINAshare'>新浪微博</div><div class='clear'></div></div>"
        +"<div class='shareLine'><input type='checkbox' id='renrenShareBox' class='sharecheckbox'/><div class='shareImageIntro RENRENshare'>人人网</div><div class='clear'></div></div>"
        +"<div class='shareLine'><input type='checkbox' id='qqShareBox' class='sharecheckbox'/><div class='shareImageIntro QQshare'>QQ空间</div><div class='clear'></div></div>"
        +"<div class='actionSharePane'>"
        +"<a class='doShare' onclick='submitShare(\"up\")'>顶</a>"
        +"<a class='cancelShare' onclick='showShareMenu(\"up\")'>取消</a>"
        +"<div class='clear'></div></div>"
        +"</div>";
      $(".pageUp").after($item);			
    }
  }
}
function submitShare(up_or_down){
  if(user_id == undefined){
    var user_id =100;
  }
  if(page=='')
    return;
  $.ajax({
    type: "POST",
    url: "youyan_content/increasePageCnt/"+up_or_down,
    cache: false,
    data: {
      page:page,
    user_id:user_id
    },
    dataType: 'text',
    success: function(data){
      if(up_or_down=='up'){
        $amount = $("#favPageAmount").html();
        $amount = parseInt($amount)+1;
        $("#favPageAmount").html($amount);
        $("#favPageAmount").attr("class","checkFav");

        showShareMenu('up');
        $(".pageDown").removeAttr("onclick");
        var newclick1 = new Function("pageVoteDowns('up')");
        $(".pageDown").unbind();
        $(".pageDown").attr("onclick","").click(newclick1);	

        $(".pageUp").removeAttr("onclick");
        var newclick2 = new Function("showShareMenu('down')");
        $(".pageUp").unbind();
        $(".pageUp").attr("onclick","").click(newclick2);	
      }else{
        $("#favPageAmount").removeAttr("class");
        $amount = $("#favPageAmount").html();
        $amount = parseInt($amount)-1;
        $("#favPageAmount").html($amount);

        $(".pageUp").removeAttr("onclick");
        var newclick3 = new Function("showShareMenu('up')");
        $(".pageUp").unbind();
        $(".pageUp").attr("onclick","").click(newclick3);
      }
      if($(".pageUp").children("img").attr("src")=="../../images/upDig.png"){
        $(".pageUp").children("img").attr("src","../../images/upDigColor.png");
      }else{
        $(".pageUp").children("img").attr("src","../../images/upDig.png");
      }
      $(".pageDown").children("img").attr("src","../../images/downDig.png");
      //create Cookie

      if(up_or_down == 'up'){
        var vote_up_str = GetCookie('vote_page_up');
        if(vote_up_str!=null){
          vote_up_str = vote_up_str+page+',';
        }else{
          vote_up_str = page+',';
        }
        setCookie('vote_page_up',vote_up_str,30);
        //cancel
        var vote_down_str = GetCookie('vote_page_down');
        var rstr =new RegExp(page+',',"g");
        vote_down_str = vote_down_str.replace(rstr,'');				
        setCookie('vote_page_down',vote_down_str,30);
      }else{
        var vote_up_str = GetCookie('vote_page_up');
        var rstr =new RegExp(page+',',"g");
        vote_up_str = vote_up_str.replace(rstr,'');				
        setCookie('vote_page_up',vote_up_str,30);
      }
    },
    error:function(){
            alert("increase failed");
          }
  });

  if(up_or_down == 'up'){
    if($("#sinaShareBox").attr('checked')){
      sinaShare();
    }
    if($("#renrenShareBox").attr('checked')){
      renrenShare();
    }
    if($("#qqShareBox").attr('checked')){
      qqShare();
    }
    if($("#tencentShareBox").attr('checked')){
      tencentShare();
    }
  }
}

function anLogin(){
  var $userName = $("#UYloginEmailName").val();
  var $userEmail = $("#UYloginEmailAD").val();
  var $userURL = $("#UYloginEmailURL").val();
  $userName = $userName.replace(/<[^>]+>/g,"");
  $userEmail = $userEmail.replace(/<[^>]+>/g,"");
  $userURL = $userURL.replace(/<[^>]+>/g,"");
  if($userEmail!=''){
    var $state =  $userEmail.match(/^[\w][\w+\.\_]*@\w+(\.\w+)+$/g);
    if($state===null){
      $("#alertLogin").html("邮箱格式不正确");
      return;
    }
  }else{
    $("#alertLogin").html("请输入邮箱");
    return;
  }
  if($userName!=''){
    boxEmailLogin.hide();
    $("#alertLogin").html('');
    var str = '{"youyan":{"id":"100","user_name":"","show_name":"'+$userName+'","profile_img":"'+ get_gravatar($userEmail) +'"},"email":{"comment_author_email":"'+$userEmail+'","comment_author_url":"'+$userURL+'","comment_author":"'+$userName+'"}}';
    setCookie('uyan_login_cookie', str, 30);
    updateLoginInfo(str);
    //setCookie('uyan_login_cookie', str, 15);
    UYCommentButtonClick($('#UYSubmitInputBTNConnected'), 'comment');
  }else{
    $("#alertLogin").html("请输入昵称");	
  }
}

function updateLoginInfo(str){
  var data;
  if(str){
    data = jQuery.parseJSON(str);
  }
  var fromDataObj = {};

  if(data){
    if(data.youyan){
      user_id = data.youyan.id;
      show_name = data.youyan.show_name;
      if(data.youyan.profile_img)
        profile_img_url = data.youyan.profile_img;
    }

    if(data.renren){
      renren_session_key = data.renren.session_key;
      renren_id = data.renren.id;
      renren_access_token = data.renren.access_token;
      renren_refresh_token = data.renren.refresh_token;
      logins = 'RENREN';

      fromDataObj.from_type = 'RENREN';
      fromDataObj.renren_id = renren_id;
    }
    else if(data.sina){
      sina_access_token = data.sina.access_token;
      sina_access_secret = data.sina.access_secret;
      sina_id = data.sina.id;
      logins = 'SINA';

      fromDataObj.from_type = 'SINA';
      fromDataObj.sina_id = sina_id;
    }
    else if(data.kaixin){
      kaixin_access_token = data.kaixin.access_token;
      kaixin_access_secret = data.kaixin.access_secret;
      kaixin_id = data.kaixin.id;
      logins = 'KAIXIN';

      fromDataObj.from_type = 'KAIXIN';
      fromDataObj.kaixin_id = kaixin_id;
    }
    else if(data.neteasy){
      neteasy_access_token = data.neteasy.access_token;
      neteasy_access_secret = data.neteasy.access_secret;
      neteasy_id = data.neteasy.id;
      logins = 'NETEASY';

      fromDataObj.from_type = 'NETEASY';
      fromDataObj.neteasy_id = neteasy_id;
    }
    else if(data.tencent){
      tencent_access_token = data.tencent.access_token;
      tencent_access_secret = data.tencent.access_secret;
      tencent_id = data.tencent.id;
      logins = 'TENCENT';

      fromDataObj.from_type = 'TENCENT';
      fromDataObj.tencent_id = tencent_id;
    }
    else if(data.douban){
      douban_access_token = data.douban.access_token;
      douban_access_secret = data.douban.access_secret;
      douban_id = data.douban.id;
      logins = 'DOUBAN';

      fromDataObj.from_type = 'DOUBAN';
      fromDataObj.douban_id = douban_id;
    }
    else if(data.qq){
      qq_access_token = data.qq.access_token;
      qq_access_secret = data.qq.access_secret;
      qq_id = data.qq.id;
      logins = 'QQ';

      fromDataObj.from_type = 'QQ';
      fromDataObj.qq_id = qq_id;
    }
    else if(data.sohu){
      sohu_access_token = data.sohu.access_token;
      sohu_access_secret = data.sohu.access_secret;
      sohu_id = data.sohu.id;
      logins = 'SOHU';

      fromDataObj.from_type = 'SOHU';
      fromDataObj.sohu_id = sohu_id;
    }
    else if(data.email){
      user_id = 100;
      logins = 'EMAIL';
      fromDataObj.from_type = 'EMAIL';
      comment_author=data.email.comment_author;
      comment_author_email=data.email.comment_author_email;
      comment_author_url=data.email.comment_author_url;
      profile_img_url = get_gravatar(comment_author_email);
    }
    else if(data.msn){
      msn_id = data.msn.id;
      msn_access_token = data.msn.access_token;
      logins = 'MSN';
    }
  }
//开始渲染用户信息
  $("#UYinputPhoto").css("background", "url(" + profile_img_url + ")");
  $(".UYReplyPhotoWrapper").css("background", "url(" + profile_img_url + ")");

  var userSNSHome;
  if(fromDataObj.from_type){
    userSNSHome = getUserSNSHome(fromDataObj);	//主页地址
  }
  loadMoreFunctionPane(userSNSHome);//开始渲染

  if(profile_bar=='1'){
  	prepareProfile(profile_img_url);
  }
//  dealWithUps();
  /*if(commentStyle == 1){
    dealWithDowns();
  }
  dealWithPageVote();
  dealWithDel();*/

  if($('#UYreplyInput').length > 0)
    calc_rest($('#UYreplyInput').val(), 1);
  if($('#submitUY').length > 0)
    calc_rest($('#submitUY').val(), 0)
}

function prepareProfile(profile_img_url){
	if(user_id == undefined||user_id==100){
		$('.UYProfileWrapper').remove();
	}else{
		$.ajax({
				type:"POST",
				url:"youyan_login/userData",
				data:{
					user_id:user_id
				},
				dataType:"json",
				cache:false,
				success: function(data){
					if(data.n_comments==null||data.n_comments==''){
						var $comments = 0;
					}else{
						var $comments = data.n_comments;
					}
					if(data.n_up_received==null||data.n_up_received==''){
						var $liked = 0;
					}else{
						var $liked = data.n_up_received;
					}
					

	  var profileContent = '<div class="UYProfileWrapper"><div class="UYProfileLeft"></div><div class="UYProfileContainer"><div class="UYProfileBasicWrapper"><a class="UYProfileName" onclick="openProfile(\''+user_id+'\',this)">'+show_name+'</a>';
	  if(data.show_title==null||data.show_title==''){
	    profileContent += '<div class="UYProfileTitleWrapper"><a class="UYProfileTitle" onclick="UYChangeTitle()">编辑头衔</a></div>';
	  }else{
		  var changeTitle = data.show_title.substr(0,12);
		  if(data.show_title.length>12){
			  changeTitle = changeTitle+'...';
		  }
	    profileContent += '<div class="UYProfileTitleWrapper"><div class="UYSucessTitle">'+changeTitle+'</div><a class="UYProfileTitle" onclick="UYChangeTitle(\''+data.show_title+'\')">编辑</a></div>';
	  }
	  if(data.email==null||data.email==''){
	  	profileContent += '<div class="UYProfileReplyWrapper"><a class="UYProfileReply" onclick="UYChangeEmail();">跟踪回复</a></div>';
	  }else{
	  	profileContent += '<div class="UYProfileReplyWrapper" style="background:url(\'/images/EMAILCorrect.png\')0 0 no-repeat;"><a class="UYProfileReply UYProfileReplyDone" title="'+data.email+'" onclick="UYChangeEmail(\''+data.email+'\');">更改邮箱</a></div>';
	  }
	  profileContent += '<div class="clear"></div></div><div class="UYProfileBottomWrapper"><div class="UYProfileAmount">'+$comments+'条评论</div><div class="UYProfileAmount">'+$liked+'次被喜欢</div>';
	  
	  if(data.noti!=0){
	  profileContent += '<div class="UYProfileNotification" onclick="showProfileNoti(this,\''+data.noti+'\')">'+data.noti+'</div><div class="UYProfileNotiIntro" onclick="showProfileNoti(this,\''+data.noti+'\')">新提醒</div>';
	  }
	  if(data.noti_article!=0){
	  profileContent += '<div class="UYProfileArticle" onclick="showProfileNotiArticle(this,\''+data.noti_article+'\')">'+data.noti_article+'</div><div class="UYProfileNotiArtiIntro" onclick="showProfileNotiArticle(this,\''+data.noti_article+'\')">新文章</div>';
	  }	  
	  
	  profileContent += '<div class="clear"></div></div></div><div class="clear"></div></div>';
	  $(".UYTitle").after(profileContent);
	  //chagne width
	  var changeWidth = DIYWidth-8;
	  var changeInnerWidth = changeWidth - 8;
	  $(".UYProfileWrapper").css({"width":changeWidth+"px"});
	  $(".UYProfileContainer").css({"width":changeInnerWidth+"px"});
	  
				},
				error:function(){
						alert("由于网络不稳定,创建失败,请稍候再试。");
				}
		});		
		

	}
}
function UYChangeTitle(titleStr){
	UYCancelChangeEmail();
	$('.UYProfileTitle').hide();
	$('.UYSucessTitle').hide();
/*	if(titleStr==''||titleStr==undefinded){
		var $val = '';
	}else{*/
		var $val = titleStr;
		if($val==undefined){$val='';}
/*	}*/
	$('.UYProfileTitle').after("<div class='UYProfileInputContainer' id='UYTitleInput'><div class='UYProfileInputIntro'>头衔:</div><input type='text' id='UYProfileTitle' value='"+$val+"' class='UYProfileInput'/><a class='UYProfileInputSubmit' onclick='UYSubmitChangeTitle()'>确定</a><a class='UYProfileEmailCancel' onclick='UYCancelChangeTitle()'>取消</a><div class='clear'></div></div>");
}
function UYCancelChangeTitle(){
	$('.UYProfileInputContainer').remove();
	$('.UYProfileTitle').show();
	$('.UYSucessTitle').show();
}
function UYChangeEmail($val){
	UYCancelChangeTitle();
	$('.UYProfileReply').hide();
	if($val==undefined){$val='';}
	$('.UYProfileReply').after("<div class='UYProfileInputContainer' id='UYEmailInput'><div class='UYProfileInputIntro'>邮箱:</div><input type='text' id='UYProfileEmail' value='"+$val+"' class='UYProfileInput'/><a class='UYProfileInputSubmit' onclick='UYSubmitChangeEmail()'>确定</a><a class='UYProfileEmailCancel' onclick='UYCancelChangeEmail()'>取消</a><div class='clear'></div></div>");
}
function UYCancelChangeEmail(){
	$('.UYProfileInputContainer').remove();
	$('.UYProfileReply').show();
}
function UYSubmitChangeEmail(){
	var $email = $('#UYProfileEmail').val();
    $state =  $email.match(/^[\w][\w+\.\_]*@\w+(\.\w+)*\.[A-z]{2,}$/g);	
	if($state!==null||$email==''){
    $.post(
      "youyan_login/setEmail",
      {
        email: $email,
        user_id:user_id
      },
      function(data){
		  $('.UYProfileInputContainer').remove();
		  if($email==''){
			$('.UYProfileReply').after("<div class='UYSucessEmail'>已取消邮箱提醒</div>");
		  }else{
			$('.UYProfileReply').after("<div class='UYSucessEmail'>已添加，新回复通知将发送至邮箱中</div>");
		  }
		  
	  });
	}else{
		$('.UYProfileInputSubmit').html('格式不正确')
		setTimeout("$('.UYProfileInputSubmit').html('确定')",1000);
	}
}
function UYSubmitChangeTitle(){
	var $title = $('#UYProfileTitle').val();
	
      $.post(
      "youyan_login/setTitle",
      {
        title: $title,
		user_id:user_id
      },
      function(data){
		  $('.UYProfileInputContainer').remove();
		  $(".UYSucessTitle").remove();
		  
		  if($title.length>12){			  
			  var changeTitle = $title.substr(0,12)+'...';
		  }else{
			  var changeTitle = $title;
		  }
		  
		  $('.UYProfileTitle').before("<div class='UYSucessTitle'>"+changeTitle+"</div>");
		  $('.UYProfileTitle').show();
		  if($title==''){
			$('.UYProfileTitle').html("编辑头衔");  
		  }else{
		    $('.UYProfileTitle').html("编辑");
		  }
	  });		
	
}
function UYSubmitReply($node){
  if($node.data('executing'))
    return;
  $node.data('executing', true);

  checkState = checkInput($("#UYreplyInput").val());
  if(checkState){
    if(user_id == undefined){
      $("#UYalertNoConnection").css({"display":"none"});
      $("#UYalertNoConnection").fadeIn("fast");
    }else{
      $node.css({"background-color":"#eeeeee","border":"1px solid #b3afaf","cursor":"normal"});
      $node.children(".replyBTNTextConnected").css({"color":"#acacac","padding-left":"40px"});
      $node.children(".replyBTNTextConnected").html("发表中");
      $node.attr("disabled", "true");
      postReply($node);
    }
  }else{
    $("#UYCurrentAmount").html("请输入内容");
  }
}
function logout(){
  $.ajax({
    type:"POST",
  url:"youyan/logout"
  });

  sina_oauth_token = undefined;
  sina_oauth_token_secret = undefined;
  sina_id = undefined;

  renren_session_key = undefined;
  renren_id = undefined;
  renren_access_token = undefined;
  renren_refresh_token = undefined;

  qq_id = undefined;
  qq_access_token = undefined;
  qq_access_secret = undefined;

  douban_id = undefined;
  douban_access_token = undefined;
  douban_access_secret = undefined;

  tencent_id = undefined;
  tencent_access_token = undefined;
  tencent_access_secret = undefined;

  neteasy_id = undefined;
  neteasy_access_token = undefined;
  neteasy_access_secret = undefined;

  sohu_id = undefined;
  sohu_access_token = undefined;
  sohu_access_secret = undefined;

  user_id = undefined;
  user_name = undefined;
  email = undefined;
  profile_img_url = default_profile;

  //logins = Array();
  logins = undefined;

  updateLoginInfo();
  $(".UYChooseConnect").remove();
}
function calc_rest(text_in, typeOfNode){
  if(InputAmount < 0)
    return '';
  var now_len = text_in.length;	
  if(now_len>InputAmount){
    $("#UYTotalAmount").html('/'+InputAmount);
  }
  if(now_len<=InputAmount){
    $("#UYTotalAmount").html('/'+InputAmount);
  }

  if(typeOfNode == 0){
    if(user_id == undefined)
      $node = $("#UYSubmitInputBTN");
    else
      $node = $("#UYSubmitInputBTNConnected");
  }
  else{
    if(user_id == undefined)
      $node = $("#UYSubmitReplyBTN");
    else
      $node = $("#UYSubmitReplyBTNConnected");
  }

  if(InputAmount >= now_len){
    $node.data('disabled', false);

    if(user_id){
      $node.css({"border":"#29447E","background-color":"#5f78ab"});
      $node.children().css({"padding-left":"39px","color":"#fff"});
      $node.removeAttr("disabled");
    }
    return (InputAmount-now_len);
  }
  else{
    $node.data('disabled', true);

    if(user_id){
      $node.css({"background-color":"#eeeeee","border":"1px solid #b3afaf","cursor":"normal"});
      $node.children().css({"color":"#acacac","padding-left":"45px"});
      $node.attr("disabled", "true");
    }
    return '超过字数限制';
  }
}

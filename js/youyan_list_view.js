var IE6 = 0;
var autoFixWidth;
var InputAmount;
var $emotionReplySTR='';
var profileItemNum=0;
var profileSocialNum = 0;
var currentMoreItem = 0;

function getComments(domain){
  $.ajax({
	  type:"POST",
	  url:"youyan_hot_comment/getHotComment",
	  data:{
		domain:domain,rankType:rankType,commentHotAmount:commentHotAmount,commentTimeAmount:commentTimeAmount,periodExist:periodExist
	  },
	  dataType:"json",
	  success: function(data){
		var itemList = '';
		$.each(data, function(i,n){
		 
		  $(".UYCommentList").append(buildCommentEntry(n, 'comment'));
		  dealWithUps(n.comment_id);
		  dealWithDowns(n.comment_id);  
		});
		//trans information
		if(rankType=='time'){
			var UYTimeCommentSocket = new easyXDM.Socket({
				onMessage: function(message, origin){
					UYTimeCommentSocket.postMessage(document.body.clientHeight || document.body.offsetHeight || document.body.scrollHeight);
					messageArr = message.split('px');
					DIYWidth = messageArr[0];
					$('.UYInfoWrapper').css({"width":DIYWidth-70});
					$('.itemWrapperNo').css({"width":DIYWidth-5});
					
				}
			
			});
		}else{
			var UYHotCommentSocket = new easyXDM.Socket({
				onMessage: function(message, origin){
					UYHotCommentSocket.postMessage(document.body.clientHeight || document.body.offsetHeight || document.body.scrollHeight);
					messageArr = message.split('px');
					DIYWidth = messageArr[0];
					$('.UYInfoWrapper').css({"width":DIYWidth-70});
					$('.itemWrapperNo').css({"width":DIYWidth-5});
				}
			});
		}

		fixWidth();    
	  }
  });
}

function fixWidth(){
	$('.UYHotlistTitle').ready(function(){
		$('.UYHotlistTitle').css({"width":DIYWidth+"px"});
	});
	$('.UYCommentList').ready(function(){
		$('.UYCommentList').css({"width":DIYWidth+"px"});
	});

$('.UYInfoWrapper').ready( function(){
									  
    $('.UYInfoWrapper').css({"width":DIYWidth-70});
	$('.itemWrapperNo').css({"width":DIYWidth-5});
  });	
}

function buildCommentEntry(data, type){
  var isWpComment;
  if(data.user_id == 94){                   // Wordpress Super User Id
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
    }else{
      wrapperType = 'itemWrapperSC';
      infoWrapperType = 'UYInfoWrapperSC';
    }
	if(photoState==0){
		infoWrapperType = 'itemWrapperNo';
	}
	
    var item = '<div class="' + wrapperType + '" id="' + data.comment_id + '">';
	if(photoState!=0){
	    if(!data.profile_img || data.user_id == 100){
	      item += '<a class="UYPhoto" style="background:url(' + default_profile + ') 0 0 no-repeat" href="javascript:;"></a>';
	    }else{
	      item += '<a class="UYPhoto" target="_blank" style="background:url(' + data.profile_img + ') 0 0 no-repeat" href="';
	      item += getUserSNSHome(data) + '"></a>';
	    }
	}

    item += buildNamePart(data, infoWrapperType);

    item += '<span class="commentContent">';

    if(data.veryfy_status != '0'){
      item += '该评论正在审核';
    }
    else
	data.content = data.content.replace( "\n", "<br>");
      item += createEmotion(data.content);

    item += '</div>';
    item += '<div class="UYArrowHide"></div>';
    item += '<div class="UYInfoAction"> '; 
    item += '<a class="UYUpIcon" onclick="UYUp(this)"></a>';
    item += '<a class="UYUpInfo" onclick="UYUp(this)">' + digName + '<span class="UYupAmount">' + data.n_up +'</span> </a>';

    if(commentStyle == 1){
      item += '<a class="UYDownIcon" onclick="UYDown(this)"></a>';
      item += '<a class="UYDownInfo" onclick="UYDown(this)">' + digDownName + '<span class="UYdownAmount">' + data.n_down +'</span> </a>';
    }

    item += '<span class="UYCUid" style="display:none" >'+data.user_id+'</span>';
    item += '<div class="UYSendTime">';
    item += stringToDateTime(data.time);
    item += '</div>';
    item += '<div class="clear"></div>';
    item += '</div>';
	item += '<div class="replyFromWrapper"><div class="replyFrom"><a href="'+data.page_url+'" target="_blank" class="fromLink">'+data.page_title+'</a></div><div class="clear"></div></div>';
    item += '</div><div class="clear"></div>';
    return item;
  }else{
    var wrapperType;
    var infoWrapperType;
    if(type == 'comment'){
      wrapperType = 'itemWrapper';
      infoWrapperType = 'UYInfoWrapper';
    }else{
      wrapperType = 'itemWrapperSC';
      infoWrapperType = 'UYInfoWrapperSC';
    }
	if(photoState==0){
		infoWrapperType = 'itemWrapperNo';
	}	
    var item = '<div class="' + wrapperType + '" id="' + data.comment_id + '">';
    
	if(photoState!=0){
	item += '<a class="UYPhoto" style="background:url(../images/photoDefault.png) 0 0 no-repeat" target="_blank" href="';
    if(data.comment_author_url == ''){
      item += data.page_url;
    }
    else{
      item += data.comment_author_url;
    }
    item += '"></a>';
	}
    item += buildNamePart(data, infoWrapperType, true);

    item += '</div>';
    item += '<div class="UYArrowHide"></div>';
    item += '<div class="UYInfoAction"> '; 
    item += '<a class="UYUpIcon" onclick="UYUp(this)"></a>';
    item += '<a class="UYUpInfo" onclick="UYUp(this)">' + digName + '<span class="UYupAmount">' + data.n_up +'</span> </a>';

    if(commentStyle == 1){
      item += '<a class="UYDownIcon" onclick="UYDown(this)"></a>';
      item += '<a class="UYDownInfo" onclick="UYDown(this)">' + digDownName + '<span class="UYdownAmount">' + data.n_down +'</span> </a>';
    }

    item += '<span class="UYCUid" style="display:none"></span>';
    item += '<div class="UYSendTime">';
    item += stringToDateTime(data.time);
    item += '</div>';
    item += '<div class="clear"></div>';
    item += '</div>';
	item += '<div class="replyFromWrapper"><div class="replyFrom"><a href="'+data.page_url+'" target="_blank" class="fromLink">'+data.page_title+'</a></div><div class="clear"></div></div>';
	
    item += '</div><div class="clear"></div>';
    return item;
  }
}

function getUserSNSHome(data){
  var id_type = data.from_type.toLowerCase() + "_id";
  return SNSTypeToPrefix[data.from_type] + data[id_type];
}

function buildNamePart(data, infoWrapperType){
  var isWpComment = arguments[2] || false;
  if(!isWpComment){
	  if(data.user_id==100){
		var item = '<div class="' + infoWrapperType + '"><div class="UYInfo"><span '
		  + ' class="UYInfoLinkUN" style="cursor:default" >' + data.comment_author + '</span><span class="dotControl"> (匿名用户)</span><br/>';
		return item;
		}else{
		var item = '<div class="' + infoWrapperType + '"><div class="UYInfo"><a href="'
		  + getUserSNSHome(data) 
		  + '" class="UYInfoLink" target="_blank">' + data.show_name + '</a><span class="dotControl"> (来自:<a class="UYSourceLink" target="_blank" href=" ' + getUserSNSHome(data)
		  + '">'
		  + SNSTypeToName[data.from_type]
		  + '</a>)</span><br/>';
		return item;
	  }
  }
  else{
    var item = '<div class="' + infoWrapperType + '"><div class="UYInfo"><a target="_blank" href="';
    if(data.comment_author_url == '')
      item += data.page_url;
    else
      item += data.comment_author_url;

    item += '" class="UYInfoLink" target="_blank">' + data.comment_author + '</a><span class="dotControl"> (为wordpress原有评论) </span><br/>';
    return item;
  }
}

function createEmotion(content){
  $emotionKey = new Array("纠结","心动","用力","抱","鬼脸","喃喃","啪地","狂泪","忍耐","跳舞","狸猫","虫子","面跳舞","喝茶","给力","思考","紧张","睡醒","离家","怒气","吃","囧","惹嫌","潜水","开心","捏脸","怒火","鬼","疑问","暴跳","不甘心","下班","失意","相拥","暖和","示爱","无语","害羞","礼物","狂笑");
  var $emotionKeyNormal = new Array("纠结","心动","生气","开心","调皮","眨眼","害羞","失落","酷","愤怒","惊讶","无语","哭泣","笑","大哭","调皮","惊讶","呆","口哨","天使","恶魔","恶魔笑","闭嘴","满意","睡觉","得意","生病","怀疑","专注","外星人","史莱克","游戏","爱心","家","地球","邮件","音乐","编辑","电话","照相");  
  for(var i=1;i<=40;i++){	
    reg=new RegExp("(\\(al"+$emotionKey[(i-1)]+"\\))","g"); 
    content = content.replace(reg,'<img src="/images/emotions/ali/'+i+'.gif"/>');
    regDefault = new RegExp("(\\("+$emotionKeyNormal[(i-1)]+"\\))","g"); 
    content = content.replace(regDefault,'<img src="/images/emotions/default/'+i+'.png"/>');
  }	
  return content;
}

function UYUp(currentNode){

  var parentNode = $(currentNode).parent(".UYInfoAction");
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





function docReadyFunc(){
  var b_v = navigator.appVersion;
  IE6 = b_v.search(/MSIE 6/i) != -1;

  autoFixWidth = false;
  if(width == '100%'){
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

  DIYWidth = width;
  if(IE6&&autoFixWidth){
    $('.UYPane').css({"width":DIYWidth});
  }else{
    $('.UYPane').css({"width":DIYWidth});
  }

  //end
  $("#UYTitleTXT").html(descWord);
  $("#submitUY").val("我想说...");
  $("#submitUY").css({"color":"#bdbbbb"});
  $emotionKey = new Array("纠结","心动","用力","抱","鬼脸","喃喃","啪地","狂泪","忍耐","跳舞","狸猫","虫子","面条舞","喝茶","给力","思考","紧张","睡醒","离家","怒气","吃","囧","惹嫌","潜水","开心","捏脸","怒火","鬼","疑问","暴跳","不甘心","下班","失意","相拥","暖和","示爱","无语","害羞","礼物","狂笑");
  $emotionKeyNormal = new Array("纠结","心动","生气","开心","调皮","眨眼","害羞","失落","酷","愤怒","惊讶","无语","哭泣","笑","大哭","调皮","惊讶","呆","口哨","天使","恶魔","恶魔笑","闭嘴","满意","睡觉","得意","生病","怀疑","专注","外星人","史莱克","游戏","爱心","家","地球","邮件","音乐","编辑","电话","照相");
  $emotionSTR='<div class="emotionNavWrapper"><a class="currentEmotionTab" onclick="changeEmotionTab(\'default\')" id="defaultEmotion">默认表情</a><a class="unselectEmotionTab" onclick="changeEmotionTab(\'ali\')" id="aliEmotion">阿狸</a><div class="clear"></div></div><div class="snEmotionWrapper">';
  $emotionReplySTR='<div class="emotionNavWrapper"><a class="currentEmotionTab" onclick="changeEmotionTab(\'default\')" id="defaultEmotionReply">默认表情</a><a class="unselectEmotionTab" onclick="changeEmotionTab(\'ali\')" id="aliEmotionReply">阿狸</a><div class="clear"></div></div><div class="snEmotionWrapper">';
  for(i = 1;i<=40;i++){	
    $emotionSTR +="<div class='emotion' alt='"+$emotionKeyNormal[(i-1)]+"' onMouseOver='changeEmotionHover(\""+i+"\",\"input\",\"default\")' onclick='inputEmotion(\"("+$emotionKeyNormal[(i-1)]+")\",\"input\")'><img emotion='("+$emotionKeyNormal[(i-1)]+")'  src='/images/emotions/default/"+i+".png' class='hoverplace'  alt='"+$emotionKeyNormal[(i-1)]+"'/></div>";
    $emotionReplySTR+="<div class='emotion' onMouseOver='changeEmotionHover(\""+i+"\",\"reply\",\"default\")' onclick='inputEmotion(\"("+$emotionKeyNormal[(i-1)]+")\",\"reply\")'><img alt='"+$emotionKeyNormal[(i-1)]+"' emotion='("+$emotionKeyNormal[(i-1)]+")'  src='/images/emotions/default/"+i+".png' class='hoverplace'/></div>";
  }

  $emotionSTR +="</div><div id='LEmotionNor'><img emotion='(al"+$emotionKey[0]+")'  src='/images/emotions/ali/1.gif' class='hoverplace'></div><div class='clear'></div><div class='aliEmotionWrapper'>";
  $emotionReplySTR +="</div><div id='LEmotionReplyNor'><img emotion='(al"+$emotionKey[0]+")'  src='/images/emotions/ali/1.gif' class='hoverplace'></div><div class='clear'></div><div class='aliEmotionWrapper'>";
  for(i = 1;i<=40;i++){	
    $emotionSTR +="<div class='emotion' onMouseOver='changeEmotionHover(\""+i+"\",\"input\",\"ali\")' onclick='inputEmotion(\"(al"+$emotionKey[(i-1)]+")\",\"input\")'><img alt='"+$emotionKey[(i-1)]+"' emotion='(al"+$emotionKey[(i-1)]+")'  src='/images/emotions/ali/"+i+".gif' class='hoverplace'/></div>";
    $emotionReplySTR+="<div class='emotion' onMouseOver='changeEmotionHover(\""+i+"\",\"reply\",\"ali\")' onclick='inputEmotion(\"(al"+$emotionKey[(i-1)]+")\",\"reply\")'><img alt='"+$emotionKey[(i-1)]+"' emotion='(al"+$emotionKey[(i-1)]+")'  src='/images/emotions/ali/"+i+".gif' class='hoverplace'/></div>";
  }
  $emotionSTR+='</div><div id="LEmotion"><img emotion="(al'+$emotionKey[0]+')"  src="/images/emotions/ali/1.gif"/ class="hoverplace"></div><div class="clear"></div>';
  $emotionReplySTR+='</div><div id="LEmotionReply"><img emotion="(al'+$emotionKey[0]+')"  src="/images/emotions/ali/1.gif"/ class="hoverplace"></div><div class="clear"></div>';
  $('#UYEmotionPane').html($emotionSTR);
  getComments(domain);
}

function UYCommentButtonClick(currentNode, type){
  $node = $(currentNode);
  if($node.data('disabled'))
    return;

  if(user_id == undefined){
    UYShowSNS(currentNode, type);
  }
  else{
    if(type == 'comment')
      UYSubmitInput($node);
    else
      UYSubmitReply($node);
  }
}



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

function dealWithUps($comment_id){    
	var $str = GetCookie('vote_up');
	if($str!=null){
		if($str.match($comment_id)!=null){		
		  $("#"+$comment_id).children(".UYInfoWrapper").children(".UYInfoAction").children(".UYUpIcon").addClass("UYUpIconColor").removeClass("UYUpIcon");
		}
	}
}

function dealWithDowns($comment_id){
	var $str = GetCookie('vote_down');
	if($str!=null){
    	if($str.match($comment_id)!=null){
		$("#"+$comment_id).children(".UYInfoWrapper").children(".UYInfoAction").children(".UYDownIcon").addClass("UYDownIconColor").removeClass("UYDownIcon");
		}
	} 
}





function UYIncreaseCnt(currentNode, up_or_down){
  $comment_id = $(currentNode).parent().parent().parent().attr("id");
  $node = $(currentNode);

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
		
      idNum = $node.parent('.UYInfoAction').parent('.UYInfoWrapper').parent('.itemWrapper').attr('id');
      if(up_or_down == 'up'){
        var vote_up_str = GetCookie('vote_up');
        if(vote_up_str!=null){
          vote_up_str = vote_up_str+idNum+',';
        }else{
          vote_up_str = idNum+',';
        }
        setCookie('vote_up',vote_up_str,30);
      }else{
        var vote_down_str = GetCookie('vote_down');
        if(vote_down_str!=null){
          vote_down_str = vote_down_str+idNum+',';	
        }else{
          vote_down_str = idNum+',';
        }
        setCookie('vote_down',vote_down_str,30);
      }
    },
    error:function(){
            alert("increase failed");
          }
  });	
}

function UYDecreaseCnt(currentNode, up_or_down){
  $comment_id = $(currentNode).parent().parent().parent().attr("id");
  $node=$(currentNode);
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
      idNum = $node.parent('.UYInfoAction').parent('.UYInfoWrapper').parent('.itemWrapper').attr('id');
	  idNUmStr = idNum+',';
      if(up_or_down == 'up'){
		var vote_up_str = GetCookie('vote_up');
		if(vote_up_str!=null){
			var rstr =new RegExp(idNUmStr,"g");
			vote_up_str = vote_up_str.replace(rstr, "");		
		}
		
  		setCookie('vote_up',vote_up_str,30);
      }else{
        var vote_down_str = GetCookie('vote_down');
        if(vote_down_str!=null){
        	var rstr =new RegExp(idNUmStr,"g");
			vote_down_str = vote_down_str.replace(rstr, "");
        }
        setCookie('vote_down',vote_down_str,30);
      }
    },
    error:function(){
            alert("decrease failed");
          }
  });	
}

function setCookie(c_name,value,expiredays){
  var exdate=new Date();
  exdate.setDate(exdate.getDate()+expiredays);
  document.cookie=c_name+ "=" +escape(value)+ ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
}

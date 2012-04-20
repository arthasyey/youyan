/* 首页滚动 */

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

// 注册
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

function submitOutSignup(type, info){
  if(type == null) type = '';
  if(info == null) info = '';
  $targetURL = $("#signupOutDomain" + type).val();
  /*if(!$targetURL.match(/^(https?|ftp|mms):\/\//)){
    $targetURL = "http://" + $targetURL;  
  }*/
    if(checkOutEmail(type) !==null && checkOutPassword(type) !==null){
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
		  /*if($dataArray[3] == '2'){
		    location.href="http://uyan.cc/index.php/youyan_check_domain";	
		  }else{*/
          	location.href="http://uyan.cc/index.php/youyan_admin_edit";
		  //}
        }
      }
      );
  }
}

//重置密码
function resetPass(){
  $('.registration_box_btn').html('加载中');
  if(checkOutEmail('Main') !==null){
	  var $email = $('#signupOutEmailMain').val();
	  $('#submitbtnmsg').removeAttr('class');
	  $.ajax({
		type:"POST",
		url:"http://uyan.cc/getpwd/resetPassword",
		data:{
		  email:$email
		},
		dataType:"html",
		cache:false,
		success: function(data){					
		  if(data =='yes'){
			$(".registration_content").html("<div class='backPassTitle'>请到邮箱 "+$email+" 中接收密码重设邮件，<br />并在24小时内点击密码重设邮件中的链接完成操作。</div>");	
		  }else if(data =='no'){
			$(".registration_content_row div").remove();
			$("#submitbtnmsg").html("无此邮箱，请重试。");
		  }
		  $('.submitReset').html('重设密码');
		},
		error:function(){
				alert("由于网络不稳定,创建失败,请稍候再试。");
			  }
	  });	
	  
  }
}

function resetPassDone($email){
  var $passOne = $('#password').val();
  var $passTwo = $('#passwordc').val();
  var $reset_id = $('#reset_id').val();
  if($passOne==''||$passTwo==''||$passTwo !=$passOne){
	$("#passwordc").after('<span class="remarks"><span class="errorInput"></span><span class="remarks_img"><img src="/images/btn_left.gif"></span><span class="txt">两次密码不一致</span></span>');
	return;
  }
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/getpwd/resetPasswordDone",
    data:{
      email:$email,password:$passOne,reset_id:$reset_id
    },
    dataType:"html",
    cache:false,
    success: function(data){
	  if(data == 'nouser' || data == 'nopass'){
		  $(".registration_content").html("<div class='backPassTitle'>密码重置失败</div><div class='backActionPane'><a class='backLinkdone' href='http://uyan.cc/getpwd'>重新找回密码</a><div class='clear'></div></div>");	
	  }else{
		  $(".registration_content").html("<div class='backPassTitle'>已成功重置密码</div><div class='backActionPane'><a class='backLinkdone' href='http://uyan.cc'>返回登录</a><div class='clear'></div></div>");   
	  }
    },
    error:function(){
            alert("由于网络不稳定,访问失败,请稍候再试。");
          }
  });		
}
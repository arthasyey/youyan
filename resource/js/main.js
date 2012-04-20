//设置提示语
function setWord(id,value) {
	G(id).innerHTML = value;
}
//设置错误提示
function setError(id,value) {
	changeStyle(id,'errormsg');
	setWord(id,value);
}
//设置正确提示
function setOkmsg(id,value) {
	changeStyle(id,'okmsg');
	setWord(id,value);
}

//设置注意提示
function setWarning(id,value) {
	changeStyle(id,'promptmsg');
	setWord(id,value);
}

//设置提示
function setHintmsg(id,value) {
	changeStyle(id,'hintmsg');
	setWord(id,value);
}

function setMsgOk(fieldname){
	changeStyle(fieldname+'_info','OkMsg Naked');
	setWord(fieldname+'_info','&nbsp;');
}

function changeStyle(id,class_name){
	G(id).className = class_name;
}

//复制代码
function setcopy(id, type){
	if(isUndefined(type)) {
    	type = 'copycode';
    }
	msgid = type+'_msg';
	
	text = document.getElementById(id).value;
	document.getElementById(id).select();
	if(text == null || text == "") {
		setWord(msgid, '没有要复制的内容');
		return false;
	}
	if(is_ie) {
		clipboardData.setData('Text', text);
		
		if(type == 'copyinvitelink'){
			setWord(msgid, '复制成功,这是您的专用邀请链接，登录QQ或MSN发送给好友吧~');
		} else {
			setWord(msgid, '代码复制成功,直接可以粘贴使用');
		}
	} 
//	else if(prompt('你使用的是非IE核心浏览器，请按下 Ctrl+C 复制内容到剪贴板', text)) {
//		setWord(msgid, '你使用的是非IE核心浏览器，请按下 Ctrl+C 复制内容到剪贴板');
//		document.getElementById(msgid).style.color = 'red';
//	} 
	else {
		if(type == 'copyinvitelink'){
			setWord(msgid, '你使用的是非IE核心浏览器，请按下 Ctrl+C 复制邀请链接到剪贴板');
		} else {
			setWord(msgid, '你使用的是非IE核心浏览器，请按下 Ctrl+C 复制代码到剪贴板');
		}
		
		document.getElementById(msgid).style.color = 'red';
	}
}

function mypop(obj, sType) { 
	var oDiv = G(obj); 
	if(sType == 'show') {
		oDiv.style.display = 'block';
		if(obj == 'MoreButton') $("#getcode").attr("style", "background: none repeat scroll 0 0 #109DB6;border-radius:3px 3px 3px 3px");
	} 
	if(sType == 'hide') {
		oDiv.style.display = 'none';
		if(obj == 'MoreButton') $("#getcode").removeAttr("style");
	}
}

function divpop(obj) {
	var oDiv = G(obj);
	if(oDiv.style.display == 'block'){
		oDiv.style.display = 'none';
		document.getElementById('icon_img_' + obj).src = '/images/xjtd.jpg';
	}else{
		oDiv.style.display = 'block';
		document.getElementById('icon_img_' + obj).src = '/images/xjtd2.jpg';
	}
}

function go_install(){
	var value = $("#platform").val();
	if(value != ''){
		if(value == 'index'){
			document.location.href = SITE_URL+'/getcode';
		}else{
			document.location.href = SITE_URL+'/getcode/'+value;
		}
	}
}

function userLogout(){
	  $.ajax({
	    type:"POST",
	  url:SITE_URL+"/youyan_login/userLogout",
	  dataType:"json",
	  cache:false,
	  success: function(data){
	    location.href="http://uyan.cc";
	  },
	  error:function(){
	          alert("由于网络不稳定,登录失败,请稍候再试。");
	        }
	  });	
	}
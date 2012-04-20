/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-7-29下午10:08:28
 */
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent.indexOf('safari') != -1);


function get_browser(){
	var browser = {};
	var ua = navigator.userAgent.toLowerCase();
	var s;
	(s = ua.match(/msie ([\d.]+)/)) ? browser.ie = s[1] :
	(s = ua.match(/firefox\/([\d.]+)/)) ? browser.firefox = s[1] :
	(s = ua.match(/chrome\/([\d.]+)/)) ? browser.chrome = s[1] :
	(s = ua.match(/opera.([\d.]+)/)) ? browser.opera = s[1] :
	(s = ua.match(/version\/([\d.]+).*safari/)) ? browser.safari = s[1] : 0;
	
	if(browser.ie){
		if(window.external && window.external.max_version) {  
	        browser.maxthon = window.external.max_version.substr(0,1);  
	    }
	}
	return browser;
}


function G(objectId) {
	if(document.getElementById && document.getElementById(objectId)) {// W3C DOM
		return document.getElementById(objectId);
	} else if (document.all && document.all(objectId)) {// MSIE 4 DOM
		return document.all(objectId);
	} else if (document.layers && document.layers[objectId]) {// NN 4 DOM. note: this won't find nested layers
		return document.layers[objectId];
	} else {
		return false;
	}
}

function s(s, block) {
    if (!G(s)) return;
    if(isUndefined(block)) {
    	block = 'block'
    }
    G(s).style.display = block;
}
function h(s) {
    if (!G(s)) return;
    G(s).style.display = "none";
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function getAbsolutePos(e){
	var l=e.offsetLeft;
	var t=e.offsetTop;
	while(e=e.offsetParent){
		l+=e.offsetLeft;
		t+=e.offsetTop;
	}
	var pos=new Object();
	pos.x=l;
	pos.y=t;
	return pos;
}
function jstrim(str){
	while (str.charAt(0)==" "){
		str=str.substr(1);
	}
	while (str.charAt(str.length-1)==" "){
		str=str.substr(0,str.length-1);
	}
	return(str);
}

function $F(obj){
	return G(obj).value;
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function strlen(str) {
	return (is_ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}

function getExt(path) {
	return path.lastIndexOf('.') == -1 ? '' : path.substr(path.lastIndexOf('.') + 1, path.length).toLowerCase();
}

function doane(event) {
	e = event ? event : window.event;
	if(is_ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if(e) {
		e.stopPropagation();
		e.preventDefault();
	}
}

//删除左右两端的空格
function trim(str){
	return str.replace(/(^\s*)|(\s*$)/g, "");
}
//删除左边的空格
function ltrim(str){
	return str.replace(/(^\s*)/g,"");
}
//删除右边的空格
function rtrim(str){
	return str.replace(/(\s*$)/g,"");
}

function includejs(path){
	var sobj = document.createElement('script');
	sobj.type = "text/javascript";
	sobj.src = path;
	var headobj = document.getElementsByTagName('head')[0];
	headobj.appendChild(sobj);
}

//Ctrl+Enter 发布
function ctrlEnter(event, btnId, onlyEnter) {
	if(isUndefined(onlyEnter)) onlyEnter = 0;
	if((event.ctrlKey || onlyEnter) && event.keyCode == 13) {
		G(btnId).click();
		return false;
	}
	return true;
}

function explode(sep, string) {
	return string.split(sep);
}

function getpos(element)
{
   if (arguments.length != 1 || element == null)
   {
       return null;
   }
   var elmt = element;
   var offsetTop = elmt.offsetTop;
   var offsetLeft = elmt.offsetLeft;
   var offsetWidth = elmt.offsetWidth;
   var offsetHeight = elmt.offsetHeight;
   while (elmt = elmt.offsetParent)
   {
       if (elmt.style.position == 'absolute' || (elmt.style.overflow != 'visible' && elmt.style.overflow != ''))
       {
           break;
       }
       offsetTop += elmt.offsetTop;
       offsetLeft += elmt.offsetLeft;
   }
   return {
       top: offsetTop,
       left: offsetLeft,
       right: offsetWidth + offsetLeft,
       bottom: offsetHeight + offsetTop
   };
}

function setFocus(name,value,flag){
	if(flag != true) {
		G(name).style.backgroundColor='#ffff99';
	}
	var id = name + '_info';
	changeStyle(id,'promptmsg');
	setWord(id,value);
}

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
/*
function refreshCode(){
	var imgObject = G("seccode_img");
	
	if(isUndefined(SITE_URL)) {
		imgObject.src = '/seccode?rand='+Math.random();
	} else {
		imgObject.src = SITE_URL + '/seccode?rand='+Math.random();
	}
	imgObject.style.display="";
}
*/

function refreshCode(sessionID){
	var imgObject = G("seccode_img");
	imgObject.src = 'http://a.jiathis.com/s/seccode.php?sessionID='+sessionID+'&r='+Math.random();
	imgObject.style.display="";
}

function form_submit(){
	//changeStyle("SubmitBtn", 'button150');
	G('SubmitBtn').disabled = true;
	//G('SubmitBtn').value = '数据提交中,请稍后';
}

//复制代码
function setcopy(id, type){
	if(isUndefined(type)) {
    	type = 'copycode'
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
function set_cookie(name,value,expires){
    var date = new Date();
    date.setTime(date.getTime() + expires);
    document.cookie = name+"="+escape(value)+";expires="+date.toGMTString()+";path=/";
}
	
function get_cookie(name){
   	var cookie = document.cookie;
   	var first = cookie.indexOf(name+"=");
   	if(first != -1){
   		first += name.length+1;
   		var last = cookie.indexOf(";", first);
   		if(last == -1){
   			last = cookie.length;
   		}
   		return unescape(cookie.substring(first, last));
   	}
   	return "";
}

function del_cookie(name){
	set_cookie(name, null, -10000);
}

function checkStrLen(inputId, showId) {
	var v = G(inputId).value;
	var left = calStrText(v);
	if(left >= 0) {
		G(showId).innerHTML = '您还可以输入<span style="color: #333333;font-family: Constantia,Georgia;font-size: 30px;font-weight: bold;">' + left + '</span>字';
		G(showId).style.color = '#333333';
	} else {
		G(showId).innerHTML = '已超出<span style="color: #ff0000;font-family: Constantia,Georgia;font-size: 30px;font-weight: bold;">' + Math.abs(left) + '</span>字';
		G(showId).style.color = '#ff0000';
	}
	return left >= 0 && v;
}

function calStrText(a, e) {
	if(e === void 0) e = 140;
	var k = a.match(/[^\x00-\xff]/g);
	return Math.floor((e * 2 - a.length - (k && k.length || 0)) / 2);
}
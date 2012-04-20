/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-8-6下午4:48:28
 */

var Ajaxs = new Array();
var AjaxStacks = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
var ajaxpostHandle = 0;
var evalscripts = new Array();
var ajaxpostresult = 0;
var ajaxresulterror = 0;
var ajaxresultstring = 0;
var dialogHandle = new Class();

function AjaxRequest(recvType, waitId) {

	for(var stackId = 0; stackId < AjaxStacks.length && AjaxStacks[stackId] != 0; stackId++);
	AjaxStacks[stackId] = 1;

	var aj = new Object();

	aj.loading = 'Loading...';//public
	aj.recvType = recvType ? recvType : 'XML';//public
	aj.waitId = waitId ? G(waitId) : null;//public

	aj.resultHandle = null;//private
	aj.sendString = '';//private
	aj.targetUrl = '';//private
	aj.stackId = 0;
	aj.stackId = stackId;

	aj.setLoading = function(loading) {
		if(typeof loading !== 'undefined' && loading !== null) aj.loading = loading;
	}

	aj.setRecvType = function(recvtype) {
		aj.recvType = recvtype;
	}

	aj.setWaitId = function(waitid) {
		aj.waitId = typeof waitid == 'object' ? waitid : G(waitid);
	}

	aj.createXMLHttpRequest = function() {
		var request = false;
		if(window.XMLHttpRequest) {
			request = new XMLHttpRequest();
			if(request.overrideMimeType) {
				request.overrideMimeType('text/xml');
			}
		} else if(window.ActiveXObject) {
			var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
			for(var i=0, icount=versions.length; i<icount; i++) {
				try {
					request = new ActiveXObject(versions[i]);
					if(request) {
						return request;
					}
				} catch(e) {}
			}
		}
		return request;
	}

	aj.XMLHttpRequest = aj.createXMLHttpRequest();
	aj.showLoading = function() {
		if(aj.waitId && (aj.XMLHttpRequest.readyState != 4 || aj.XMLHttpRequest.status != 200)) {
			changedisplay(aj.waitId, '');
			aj.waitId.innerHTML = '<span><img src="'+SITE_URL+'/resource/images/common/ico_pending.gif"> ' + aj.loading + '</span>';
		}
	}

	aj.processHandle = function() {
		if(aj.XMLHttpRequest.readyState == 4 && aj.XMLHttpRequest.status == 200) {
			for(k in Ajaxs) {
				if(Ajaxs[k] == aj.targetUrl) {
					Ajaxs[k] = null;
				}
			}
			if(aj.waitId) changedisplay(aj.waitId, 'none');
			if(aj.recvType == 'HTML') {
				aj.resultHandle(aj.XMLHttpRequest.responseText, aj);
			} else if(aj.recvType == 'XML') {
				try {
					aj.resultHandle(aj.XMLHttpRequest.responseXML.lastChild.firstChild.nodeValue, aj);
				} catch(e) {
					aj.resultHandle('', aj);
				}
			}
			AjaxStacks[aj.stackId] = 0;
		}
	}

	aj.get = function(targetUrl, resultHandle) {	
		if(targetUrl.indexOf('?') != -1) {
			targetUrl = targetUrl + '&inajax=1';
		} else {
			targetUrl = targetUrl + '?inajax=1';
		}
		setTimeout(function(){aj.showLoading()}, 500);
		if(in_array(targetUrl, Ajaxs)) {
			return false;
		} else {
			Ajaxs.push(targetUrl);
		}
		aj.targetUrl = targetUrl;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		var delay = 100;
		if(window.XMLHttpRequest) {
			setTimeout(function(){
			aj.XMLHttpRequest.open('GET', aj.targetUrl);
			aj.XMLHttpRequest.send(null);}, delay);
		} else {
			setTimeout(function(){
			aj.XMLHttpRequest.open("GET", targetUrl, true);
			aj.XMLHttpRequest.send();}, delay);
		}

	}
	aj.post = function(targetUrl, sendString, resultHandle) {
		if(targetUrl.indexOf('?') != -1) {
			targetUrl = targetUrl + '&inajax=1';
		} else {
			targetUrl = targetUrl + '?inajax=1';
		}
		setTimeout(function(){aj.showLoading()}, 500);
		if(in_array(targetUrl, Ajaxs)) {
			return false;
		} else {
			Ajaxs.push(targetUrl);
		}
		aj.targetUrl = targetUrl;
		aj.sendString = sendString;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		aj.XMLHttpRequest.open('POST', targetUrl);
		aj.XMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		aj.XMLHttpRequest.send(aj.sendString);
	}
	return aj;
}

function newfunction(func){
	var args = new Array();
	for(var i=1; i<arguments.length; i++) args.push(arguments[i]);
	return function(event){
		doane(event);
		window[func].apply(window, args);
		return false;
	}
}

function changedisplay(obj, display) {
	if(display == 'auto') {
		obj.style.display = obj.style.display == '' ? 'none' : '';
	} else {
		obj.style.display = display;
	}
	return false;
}

function evalscript(s) {
	if(s.indexOf('<script') == -1) return s;
	
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	var arr = new Array();
	while(arr = p.exec(s)) {
		var p1 = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:charset=\"([\w\-]+?)\")?><\/script>/i;
		var arr1 = new Array();
		arr1 = p1.exec(arr[0]);
		
		var charset = '';
		
		if(arr1) {
			if(arr1[3]){
				charset = arr1[3];
			}
			appendscript(arr1[1], '', arr1[2], charset);
		} else {
			
			p1 = /<script(.*?)>([^\x00]+?)<\/script>/i;
			arr1 = p1.exec(arr[0]);
			
			//获取字符集
			var re = /charset=\"([\w\-]+?)\"/i;
			var charsetarr = re.exec(arr1[1]);
			if(charsetarr){
				charset = charsetarr[1];
			}
			appendscript('', arr1[2], arr1[1].indexOf('reload=') != -1, charset);
		}
	}
	return s;
}

function appendscript(src, text, reload, charset) {
	var id = hash(src + text);
	
	if(!reload && in_array(id, evalscripts)) return;
	if(reload && G(id)) {
		G(id).parentNode.removeChild(G(id));
	}

	evalscripts.push(id);
	var scriptNode = document.createElement("script");
	scriptNode.type = "text/javascript";
	scriptNode.id = id;
	
	if(charset != ''){
		scriptNode.charset = charset;
	}
	
	try {
		if(src) {
			scriptNode.src = src;
		} else if(text){
			scriptNode.text = text;
		}
		G('append_parent').appendChild(scriptNode);
	} catch(e) {}
}

function stripscript(s) {
	return s.replace(/<script.*?>.*?<\/script>/ig, '');
}

function ajaxupdateevents(obj, tagName) {
	tagName = tagName ? tagName : 'A';
	var objs = obj.getElementsByTagName(tagName);
	for(k in objs) {
		var o = objs[k];
		ajaxupdateevent(o);
	}
}

function ajaxupdateevent(o) {
	if(typeof o == 'object' && o.getAttribute) {
		if(o.getAttribute('ajaxtarget')) {
			if(!o.id) o.id = Math.random();
			var ajaxevent = o.getAttribute('ajaxevent') ? o.getAttribute('ajaxevent') : 'click';
			var ajaxurl = o.getAttribute('ajaxurl') ? o.getAttribute('ajaxurl') : o.href;
			_attachEvent(o, ajaxevent, newfunction('ajaxget', ajaxurl, o.getAttribute('ajaxtarget'), o.getAttribute('ajaxwaitid'), o.getAttribute('ajaxloading'), o.getAttribute('ajaxdisplay')));
			if(o.getAttribute('ajaxfunc')) {
				o.getAttribute('ajaxfunc').match(/(\w+)\((.+?)\)/);
				_attachEvent(o, ajaxevent, newfunction(RegExp.$1, RegExp.$2));
			}
		}
	}
}

function ajaxget(url, showid, waitid) {
	waitid = typeof waitid == 'undefined' || waitid === null ? showid : waitid;
	var x = new AjaxRequest();
	x.setLoading();
	x.setWaitId(waitid);
	x.display = '';
	x.showId = G(showid);
	if(x.showId) x.showId.orgdisplay = typeof x.showId.orgdisplay === 'undefined' ? x.showId.style.display : x.showId.orgdisplay;

	if(url.substr(strlen(url) - 1) == '#') {
		url = url.substr(0, strlen(url) - 1);
		x.autogoto = 1;
	}

	var url = url + '&inajax=1&ajaxtarget=' + showid;
	x.get(url, function(s, x) {
		evaled = false;
		if(s.indexOf('ajaxerror') != -1) {
			evalscript(s);
			evaled = true;
		}
		if(!evaled) {
			if(x.showId) {
				changedisplay(x.showId, x.showId.orgdisplay);
				changedisplay(x.showId, x.display);
				x.showId.orgdisplay = x.showId.style.display;
				ajaxinnerhtml(x.showId, s);
				ajaxupdateevents(x.showId);
				if(x.autogoto) scroll(0, x.showId.offsetTop);
			}
		}
		if(!evaled)evalscript(s);
	});
}

function ajaxpost(formid, func, timeout, optid) {
//	showloading();
	
	if(ajaxpostHandle != 0) {
		return false;
	}
	var ajaxframeid = 'ajaxframe';
	var ajaxframe = G(ajaxframeid);
	if(ajaxframe == null) {
		if (is_ie && is_ie < 9 && !is_opera) {
			ajaxframe = document.createElement("<iframe name='" + ajaxframeid + "' id='" + ajaxframeid + "'></iframe>");
		} else {
			ajaxframe = document.createElement("iframe");
			ajaxframe.name = ajaxframeid;
			ajaxframe.id = ajaxframeid;
		}
		ajaxframe.style.display = 'none';
		G('append_parent').appendChild(ajaxframe);
	}
	G(formid).target = ajaxframeid;
	if(G(formid).action.indexOf('?') != -1) {
		G(formid).action = G(formid).action + '&inajax=1';
	} else {
		G(formid).action = G(formid).action + '?inajax=1';
	}
	
	
	ajaxpostHandle = [formid, func, timeout, optid];
	
	if(ajaxframe.attachEvent) {
		ajaxframe.detachEvent ('onload', ajaxpost_load);
		ajaxframe.attachEvent('onload', ajaxpost_load);
	} else {
		document.removeEventListener('load', ajaxpost_load, true);
		ajaxframe.addEventListener('load', ajaxpost_load, false);
	}
	G(formid).submit();
	return false;
}

function ajaxpost_load() {
	
	var formid = ajaxpostHandle[0];
	var func = ajaxpostHandle[1];
	var timeout = ajaxpostHandle[2];
	var optid = ajaxpostHandle[3];
	
	var formstatus = '__' + formid;
	
//	showloading('none');
	
	if(is_ie && is_ie < 9) {
		var s = G('ajaxframe').contentWindow.document.XMLDocument.text;
	} else {
		var s = G('ajaxframe').contentWindow.document.documentElement.firstChild.nodeValue;
	}
	
	evaled = false;
	if(s.indexOf('ajaxerror') != -1) {
		evalscript(s);
		evaled = true;
	}
	if(s.indexOf('ajaxok') != -1) {
		ajaxpostresult = 1;
	} else {
		ajaxpostresult = 0;
	}
	
	if(s.indexOf('ajaxresulterror') != -1) {
		ajaxresulterror = 1;
	} else {
		ajaxresulterror = 0;
	}
	
	if(s.indexOf('ajaxresultstring') != -1) {
		ajaxresultstring = s.replace(/.*ajaxresultstring (.*)>/g, '$1');
	} else {
		ajaxresultstring = 0;
	}
	
	if(dialogExist() && !ajaxpostresult){
		var dialogTitle = dialogHandle.info.title;
	} else {
		var dialogTitle = '消息提示';
	}
	if(optid != null) {
		G(optid).innerHTML = s;
	} else {
		showdialog(dialogTitle, s);
	}
	
	//function
	if(ajaxresulterror == 0 && func) {
		setTimeout(func + '(\'' + formid + '\',\'' + ajaxpostresult + '\',\'' + ajaxresultstring + '\')', 10);
	}
	if(!evaled && G(formstatus)) {
		G(formstatus).style.display = '';
		ajaxinnerhtml(G(formstatus), s);
		evalscript(s);
	}
	
	evalscript(s);	// 主动加载JS
	
	//层消失
	if(ajaxresulterror == 0 || optid == null) {
		if(timeout && ajaxpostresult) setTimeout("hidedialog()", timeout);
	}

	formid.target = 'ajaxframe';
	ajaxpostHandle = 0;
}

function ajaxmenu(e, ctrlid, title, timeout, func) {
	
	var offset = 0;
	var duration = 3;
	
	if(isUndefined(timeout)) timeout = 0;
	if(timeout>0) duration = 0;
	
	if(isUndefined(title)) title = G(ctrlid).innerHTML;
	
	showloading();
	
	var href = !isUndefined(G(ctrlid).href) ? G(ctrlid).href : G(ctrlid).attributes['href'].value;
	
	var dialogHTML = '<DIV style="width:450px;text-align:center;font-size:14px; padding:30px 0 30px"><img src="'+SITE_URL+'/resource/images/common/ico_pending.gif" border="0" align="absmiddle" /> 正在加载中,请稍后...<br /><br /></div>';
	showdialog(title, dialogHTML);
	
	if(is_ie && is_ie < 7 && document.readyState.toLowerCase() != 'complete') {
		return;
	}

	var x = new AjaxRequest();
	

	x.etype = e.type;

	x.get(href, function(s) {
		evaled = false;
		if(s.indexOf('ajaxerror') != -1) {
			evaled = true;
		}

		if(!evaled) {
			showdialog(title, s);

			//function
			if(func) {
				setTimeout(func + '(\'' + ctrlid + '\')', 10);
			}
		}
		evalscript(s);
	});

	showloading('none');
	doane(e);
}

function urlmenu(e, url, title, timeout, func) {
	
	var offset = 0;
	var duration = 3;
	
	if(isUndefined(timeout)) timeout = 0;
	if(timeout>0) duration = 0;
	
	if(isUndefined(title)) title = G(ctrlid).innerHTML;
	
	showloading();
	
	// var href = !isUndefined(G(ctrlid).href) ? G(ctrlid).href : G(ctrlid).attributes['href'].value;
	
	var dialogHTML = '<DIV style="width:450px;text-align:center;font-size:14px; padding:30px 0 30px"><img src="'+SITE_URL+'/resource/images/common/ico_pending.gif" border="0" align="absmiddle" /> 正在加载中,请稍后...<br /><br /></div>';
	showdialog(title, dialogHTML);
	
	if(is_ie && is_ie < 7 && document.readyState.toLowerCase() != 'complete') {
		return;
	}

	var x = new AjaxRequest();
	

	x.etype = e.type;

	x.get(url, function(s) {
		evaled = false;
		if(s.indexOf('ajaxerror') != -1) {
			evaled = true;
		}

		if(!evaled) {
			showdialog(title, s);

			//function
			if(func) {
				setTimeout(func + '()', 10);
			}
		}
		evalscript(s);
	});

	showloading('none');
	doane(e);
}

function dialogExist(){
	if(typeof(dialogHandle) == 'object'){
		return true;
	} else {
		return false;
	}
}


function showdialog(title, dialogHTML){

	//在开始创建新的对话框之前，如果有旧的，先关闭
	if(dialogExist()){
		hidedialog();
	}
	
	var dialog = new Popup({
		contentType: 2,
        isHaveTitle: true,
        scrollType: 'no',
        isBackgroundCanClick: false,
        isSupportDraging: true,
        isShowShadow: true,
        isReloadOnClose: false,
        isAutoMove: true,
        width: 0,
        height: 0
	});
	
	dialogHandle = dialog;
	dialog.setContent("title",title);
	dialog.setContent("contentHtml",dialogHTML);
	dialog.build();
	dialog.show();
}

//关闭对话框
function hidedialog(){
	if(dialogExist()){
		dialogHandle.close();
		return true;
	}
	return false;
}


//得到一个定长的hash值,依赖于 stringxor()
function hash(string, length) {
	var length = length ? length : 32;
	var start = 0;
	var i = 0;
	var result = '';
	filllen = length - string.length % length;
	for(i = 0; i < filllen; i++){
		string += "0";
	}
	while(start < string.length) {
		result = stringxor(result, string.substr(start, length));
		start += length;
	}
	return result;
}

function stringxor(s1, s2) {
	var s = '';
	var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var max = Math.max(s1.length, s2.length);
	for(var i=0; i<max; i++) {
		var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
		s += hash.charAt(k % 52);
	}
	return s;
}

function showloading(display, wating) {
	var display = display ? display : 'block';
	var wating = wating ? wating : 'Loading...';
	G('ajaxwaitid').innerHTML = wating;
	G('ajaxwaitid').style.display = display;
}

function ajaxinnerhtml(showid, s) {
	if(showid.tagName != 'TBODY') {
		showid.innerHTML = s;
	} else {
		while(showid.firstChild) {
			showid.firstChild.parentNode.removeChild(showid.firstChild);
		}
		var div1 = document.createElement('DIV');
		div1.id = showid.id+'_div';
		div1.innerHTML = '<table><tbody id="'+showid.id+'_tbody">'+s+'</tbody></table>';
		G('append_parent').appendChild(div1);
		var trs = div1.getElementsByTagName('TR');
		var l = trs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(trs[0]);
		}
		var inputs = div1.getElementsByTagName('INPUT');
		var l = inputs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(inputs[0]);
		}		
		div1.parentNode.removeChild(div1);
	}
}
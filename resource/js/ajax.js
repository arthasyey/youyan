/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-7-29下午10:15:25
 */
function getXmlhttp(){
	
	var request = false;
	if(window.XMLHttpRequest) {
		request = new XMLHttpRequest();
		if(request.overrideMimeType) {
			request.overrideMimeType('text/xml');
		}
	} else if(window.ActiveXObject) {
		var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
		for(var i=0; i<versions.length && !request; i++) {

			try {
				request = new ActiveXObject(versions[i]);
				if(request) {
					return request;
				}
			} catch(e) {
				alert(e.message);
			}
		}
	}
	return request;
}

function postajax(url,requestUri,funcName,method){

	if(typeof(funcName) == "undefined"){
		var funcName = '';
	}
	if(typeof(method) == "undefined"){
		var method = true;
	}
	var xhttp=getXmlhttp();
	xhttp.open("POST",url,method);
	xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhttp.send(requestUri);
	xhttp.onreadystatechange=function(){
		if(xhttp.readyState==4 && (xhttp.status==200 || window.location.href.indexOf("http")==-1)){
			if(funcName != ''){
				eval(funcName)(xhttp.responseText);
			}
		}
	}
}

function getajax(url,funcName,method){
	
	if(typeof(funcName) == "undefined"){
		var funcName = '';
	}
	
	var func_onSuccess = funcName;
	var func_onComplete = funcName == '' ? '' : funcName+'_complete';

	if(typeof(method) == "undefined"){
		var method = true;
	}
	var xhttp=getXmlhttp();
	xhttp.open("GET",url,method);
	xhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhttp.send(null);
	if(method){
		xhttp.onreadystatechange=function(){	
			if(xhttp.readyState==4){
				if(xhttp.status==200){
					if(typeof(eval(func_onSuccess)) == 'function'){
						eval(func_onSuccess)(xhttp.responseText);
					}
				} else {
					if(typeof(eval(func_onComplete)) == 'function'){
						eval(func_onComplete)();
					}
				}
			}
		}
	} else {
		if(xhttp.readyState==4 && xhttp.status==200){
			return xhttp.responseText;
		}
	}
}
/**
 * @copyright	© 2010 JiaThis Inc
 * @author		plhwin <plhwin@plhwin.com>
 * @since		version - 2010-8-6下午5:08:28
 */

if(typeof(is_ie) == 'undefined'){
	var userAgent = navigator.userAgent.toLowerCase();
	var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
	var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
	var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
	var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent.indexOf('safari') != -1);
}

var dialogTop = 0;

if (!Array.prototype.push) {
    Array.prototype.push = function() {
        var a = this.length;
        for (var i = 0; i < arguments.length; i++) {
            this[a + i] = arguments[i]
        }
        return this.length
    }
};
function G() {
    var a = new Array();
    for (var i = 0; i < arguments.length; i++) {
        var b = arguments[i];
        if (typeof b == 'string') {
            b = document.getElementById(b)
        }
        if (arguments.length == 1) {
            return b
        }
        a.push(b)
    };
    return a
};
Function.prototype.bind = function(a) {
    var b = this;
    return function() {
        b.apply(a, arguments)
    }
};
Function.prototype.bindAsEventListener = function(b) {
    var c = this;
    return function(a) {
        c.call(b, a || window.event)
    }
};
Object.extend = function(a, b) {
    for (property in b) {
        a[property] = b[property]
    };
    return a
};
if (!window.Event) {
    var Event = new Object()
};
Object.extend(Event, {
    observers: false,
    element: function(a) {
        return a.target || a.srcElement
    },
    isLeftClick: function(a) {
        return (((a.which) && (a.which == 1)) || ((a.button) && (a.button == 1)))
    },
    pointerX: function(a) {
        return a.pageX || (a.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft))
    },
    pointerY: function(a) {
        return a.pageY || (a.clientY + (document.documentElement.scrollTop || document.body.scrollTop))
    },
    stop: function(a) {
        if (a.preventDefault) {
            a.preventDefault();
            a.stopPropagation()
        } else {
            a.returnValue = false;
            a.cancelBubble = true
        }
    },
    findElement: function(a, b) {
        var c = Event.element(a);
        while (c.parentNode && (!c.tagName || (c.tagName.toUpperCase() != b.toUpperCase()))) {
            c = c.parentNode
        }
        return c
    },
    _observeAndCache: function(a, b, c, d) {
        if (!this.observers) {
            this.observers = []
        }
        if (a.addEventListener) {
            this.observers.push([a, b, c, d]);
            a.addEventListener(b, c, d)
        } else if (a.attachEvent) {
            this.observers.push([a, b, c, d]);
            a.attachEvent('on' + b, c)
        }
    },
    unloadCache: function() {
        if (!Event.observers) {
            return
        }
        for (var i = 0; i < Event.observers.length; i++) {
            Event.stopObserving.apply(this, Event.observers[i]);
            Event.observers[i][0] = null
        };
        Event.observers = false
    },
    observe: function(a, b, c, d) {
        var a = G(a);
        d = d || false;
        if (b == 'keypress' && (navigator.appVersion.match(/Konqueror|Safari|KHTML/) || a.attachEvent)) {
            b = 'keydown'
        }
        this._observeAndCache(a, b, c, d)
    },
    stopObserving: function(a, b, c, d) {
        var a = G(a);
        d = d || false;
        if (b == 'keypress' && (navigator.appVersion.match(/Konqueror|Safari|KHTML/) || a.detachEvent)) {
            b = 'keydown'
        }
        if (a.removeEventListener) {
            a.removeEventListener(b, c, d)
        } else if (a.detachEvent) {
            a.detachEvent('on' + b, c)
        }
    }
});
Event.observe(window, 'unload', Event.unloadCache, false);
var Class = function() {
    var a = function() {
        this.initialize.apply(this, arguments)
    };
    for (i = 0; i < arguments.length; i++) {
        superClass = arguments[i];
        for (member in superClass.prototype) {
            a.prototype[member] = superClass.prototype[member]
        }
    };
    a.child = function() {
        return new Class(this)
    };
    a.extend = function(f) {
        for (property in f) {
            a.prototype[property] = f[property]
        }
    };
    return a
};
var someToHidden = [];
var someToDisabled = [];
var Popup = new Class();
Popup.prototype = {
    iframeIdName: 'ifr_popup',
    initialize: function(a) {
        this.config = Object.extend({
            contentType: 1,
            isHaveTitle: true,
            scrollType: 'no',
            isBackgroundCanClick: false,
            isSupportDraging: true,
            isShowShadow: true,
            isReloadOnClose: true,
            isAutoMove: true,
            width: 0,
            height: 0
        },
        a || {});
        this.info = {
            shadowWidth: 10,
            title: "",
            contentUrl: "",
            contentHtml: "",
            callBack: null,
            parameter: null,
            confirmCon: "",
            alertCon: "",
            someHiddenTag: "object,embed",
            someDisabledBtn: "",
            someHiddenEle: "",
            overlay: 0,
            coverOpacity: 30
        };
        this.color = {
            cColor: "#000",
            bColor: "#FFFFFF",
            tColor: "#6D84B4",
            dColor: "#A2A2A2",
            wColor: "#FFFFFF"
        };
        if (!this.config.isHaveTitle) {
            this.config.isSupportDraging = false
        }
        this.iniBuild()
    },
    setContent: function(a, b) {
        if (b != '') {
            switch (a) {
            case 'width':
                this.config.width = b;
                break;
            case 'height':
                this.config.height = b;
                break;
            case 'title':
                this.info.title = b;
                break;
            case 'contentUrl':
                this.info.contentUrl = b;
                break;
            case 'contentHtml':
                this.info.contentHtml = b;
                break;
            case 'callBack':
                this.info.callBack = b;
                break;
            case 'parameter':
                this.info.parameter = b;
                break;
            case 'confirmCon':
                this.info.confirmCon = b;
                break;
            case 'alertCon':
                this.info.alertCon = b;
                break;
            case 'someHiddenTag':
                this.info.someHiddenTag = b;
                break;
            case 'someHiddenEle':
                this.info.someHiddenEle = b;
                break;
            case 'someDisabledBtn':
                this.info.someDisabledBtn = b;
                break;
            case 'overlay':
                this.info.overlay = b
            }
        }
    },
    iniBuild: function() {
        G('dialogCase') ? G('dialogCase').parentNode.removeChild(G('dialogCase')) : function() {};
        var a = document.createElement('span');
        a.id = 'dialogCase';
        document.body.appendChild(a)
    },
    build: function() {
        var b = 10001 + this.info.overlay * 10;
        var c = b + 2;
        this.iframeIdName = 'ifr_popup' + this.info.overlay;
        var d = "/resource/default/images/";
        var f = '<a href="javascript:;"><image id="dialogBoxClose" src="' + d + 'dialogclose.gif" border="0" width="16" height="16" align="absmiddle" title="关闭" /></a>';
        var g = 'filter: alpha(opacity=' + this.info.coverOpacity + ');opacity:' + this.info.coverOpacity / 100 + ';';
        var h = '<div id="dialogBoxBG" style="position:absolute;top:0px;left:0px;width:100%;height:100%;z-index:' + b + ';' + g + 'background-color:' + this.color.cColor + ';display:none;"></div>';
        
        var dialog_width = '';
        var dialog_table_width = '';
        if(this.config.height > 0){
        	dialog_width = 'width:'+this.config.width+'px;';
        	dialog_table_width = ' width="100%"';
        }
        var i = '<div id="dialogBox" style="border:1px solid ' + this.color.dColor + ';display:none;z-index:' + c + ';position:relative;'+dialog_width+'"><table'+dialog_table_width+' border="0" cellpadding="0" cellspacing="0" bgcolor="' + this.color.bColor + '">';
        if (this.config.isHaveTitle) {
            i += '<tr height="24" bgcolor="' + this.color.tColor + '"><td><div id="dialogBoxTitle" style="height: 28px;background: url('+SITE_URL+'/resource/images/common/dlbg.jpg) repeat-x scroll 0 0 #FFFFFF;"><a id="dialogClose" style="background-color: #A12A2A; border: 3px solid #FFFFFF; border-radius: 50px 50px 50px 50px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); color: #FFFFFF;display: block;font-weight: bolder;height: 21px;  position:relative; float:right; top:-10px; right:-10px;width: 20px; z-index:10; cursor:pointer;" href="javascript:;"><span id="dialogBoxClose" style="background-position: -79px -185px;display: block; height: 10px; margin: 6px 0 0 5px; width: 10px;background:url('+SITE_URL+'/resource/images/common/close.png) no-repeat; display: inline-block; vertical-align: top;"></span></a></div></td></tr>'
        } else {
            i += '<tr height="10"><td align="right">' + f + '</td></tr>'
        };
        
        var dialog_tr_style = '';
        if(this.config.height > 0){
        	dialog_tr_style = ' style="height:'+this.config.height+'px"';
        }
        
        i += '<tr'+dialog_tr_style+' valign="top"><td id="dialogBody" style="position:relative;"></td></tr></table></div>' + '<div id="dialogBoxShadow" style="display:none;z-index:' + b + ';"></div>';
        if (!this.config.isBackgroundCanClick) {
            G('dialogCase').innerHTML = h + i;
            G('dialogBoxBG').style.height = maxHeight() + 'px'
        } else {
            G('dialogCase').innerHTML = i
        }
        // Event.observe(G('dialogBoxBG'), "click", this.reset.bindAsEventListener(this), false);
        Event.observe(G('dialogClose'), "click", this.reset.bindAsEventListener(this), false);
        Event.observe(G('dialogBoxClose'), "click", this.reset.bindAsEventListener(this), false);
        if (this.config.isSupportDraging) {
            G("dialogBoxTitle").style.cursor = "move";
            var j = this.config.isShowShadow;
            var k = this.config.isAutoMove;
            var l = this.config.height;
            var m = new Array();
            G("dialogBoxTitle").onmousedown = function(e) {
                clearTimeout(window.__DIALOGSCROLL);
                if (is_ie) {
                    document.body.onselectstart = function() {
                        return false
                    }
                }
                m = is_ie ? [event.clientX, event.clientY] : [e.clientX, e.clientY];
                m[2] = parseInt(G('dialogBox').style.left);
                m[3] = parseInt(G('dialogBox').style.top);
                document.onmousemove = function(e) {
                    clearTimeout(window.__DIALOGSCROLL);
                    if (m[0]) {
                        var a = is_ie ? [event.clientX, event.clientY] : [e.clientX, e.clientY];
                        with(G('dialogBox')) {
                            style.left = (m[2] + a[0] - m[0]) + 'px';
                            style.top = (m[3] + a[1] - m[1]) + 'px'
                        }
                        if (j) {
                            with(G('dialogBoxShadow')) {
                                style.left = (m[2] + a[0] - m[0] - 10) + 'px';
                                style.top = (m[3] + a[1] - m[1] - 10) + 'px'
                            }
                        }
                    }
                };
                document.onmouseup = function() {
                    document.onmousemove = null;
                    var a = document.body.scrollTop ? document.body.scrollTop: document.documentElement.scrollTop;
                    dialogTop = parseInt(G('dialogBox').style.top) - a;
                    if (is_ie) {
                        document.body.onselectstart = function() {
                            return true
                        }
                    }
                    m = [];
                    clearTimeout(window.__DIALOGSCROLL);
                    if (k) {
                        dialogScrolling(l)
                    }
                }
            }
        };
        this.lastBuild()
    },
    lastBuild: function() {
        var a = '<div style="width:100%;height:100%;text-align:center;"><div style="margin:20px 20px 0 20px;font-size:14px;line-height:16px;color:#000000;">' + this.info.confirmCon + '</div><div style="margin:20px;"><input id="dialogOk" type="button" value="  确定  "/>&nbsp;<input id="dialogCancel" type="button" value="  取消  "/></div></div>';
        var b = '<div style="width:100%;height:100%;text-align:center;"><div style="margin:20px 20px 0 20px;font-size:14px;line-height:16px;color:#000000;">' + this.info.alertCon + '</div><div style="margin:20px;"><input id="dialogYES" type="button" value="  确定  "/></div></div>';
        var c = 10001 + this.info.overlay * 10;
        var d = c + 4;
        if (this.config.contentType == 1) {
            var e = "<iframe width='100%' style='height:" + this.config.height + "px' name='" + this.iframeIdName + "' id='" + this.iframeIdName + "' frameborder='0' scrolling='" + this.config.scrollType + "'></iframe>";
            var f = "<div id='iframeBG' style='position:absolute;top:0px;left:0px;width:1px;height:1px;z-index:" + d + ";filter: alpha(opacity=00);opacity:0.00;background-color:#ffffff;'><div>";
            G("dialogBody").innerHTML = e + f;
            G(this.iframeIdName).src = this.info.contentUrl
        } else if (this.config.contentType == 2) {
            G("dialogBody").innerHTML = this.info.contentHtml
        } else if (this.config.contentType == 3) {
            G("dialogBody").innerHTML = a;
            Event.observe(G('dialogOk'), "click", this.forCallback.bindAsEventListener(this), false);
            Event.observe(G('dialogCancel'), "click", this.close.bindAsEventListener(this), false)
        } else if (this.config.contentType == 4) {
            G("dialogBody").innerHTML = b;
            Event.observe(G('dialogYES'), "click", this.close.bindAsEventListener(this), false)
        }
    },
    reBuild: function() {
        G('dialogBody').height = G('dialogBody').clientHeight;
        this.lastBuild()
    },
    show: function() {
        this.hiddenSome();
        this.middle();
        if (this.config.isShowShadow) {
            this.shadow()
        }
        if (this.config.isAutoMove) {
            dialogScrolling(this.config.height)
        }
    },
    forCallback: function() {
        return this.info.callBack(this.info.parameter)
    },
    shadow: function() {
        var a = G('dialogBoxShadow');
        var b = G('dialogBox');
       
        a['style']['position'] = "absolute";
        // a['style']['background'] = "#000";
        a['style']['background'] = "";
        a['style']['display'] = "";
        a['style']['opacity'] = "0.2";
        a['style']['filter'] = "alpha(opacity=30)";
        a['style']['top'] = b.offsetTop - this.info.shadowWidth + 'px';
        a['style']['left'] = b.offsetLeft - this.info.shadowWidth + 'px';
        a['style']['width'] = b.offsetWidth + 2 * this.info.shadowWidth + 'px';
        a['style']['height'] = b.offsetHeight + 2 * this.info.shadowWidth + 'px'
    },
    middle: function() {
        if (!this.config.isBackgroundCanClick) {
            G('dialogBoxBG').style.display = ''
        }
        var a = G('dialogBox');
        a['style']['position'] = "absolute";
        a['style']['display'] = '';
        var b = document.body.clientWidth ? document.body.clientWidth: document.documentElement.clientWidth;
        var c = document.body.scrollTop ? document.body.scrollTop: document.documentElement.scrollTop;
        var d = getHeight();
        
        
        if(this.config.width <= 0){
        	this.config.width = G('dialogBox').offsetWidth;
        }
        
        if(this.config.height <= 0){
        	this.config.height = G('dialogBox').offsetHeight;
        }
        
        sTop = ((d - this.config.height) / 2 + c);
        sleft = ((b - this.config.width) / 2);
        a['style']['left'] = sleft + 'px';
        a['style']['top'] = sTop + 'px';
        dialogTop = sTop - c
    },
    reset: function() {
        if (this.config.isReloadOnClose) {
            top.location.reload()
        };
        this.close()
    },
    close: function() {
        clearTimeout(window.__DIALOGSCROLL);
        G('dialogBox').style.display = 'none';
        if (!this.config.isBackgroundCanClick) {
            G('dialogBoxBG').style.display = 'none'
        }
        if (this.config.isShowShadow) {
            G('dialogBoxShadow').style.display = 'none'
        }
        G('dialogBody').innerHTML = '';
        this.showSome()
    },
    hiddenSome: function() {
        var a = this.info.someHiddenTag.split(",");
        if (a.length == 1 && a[0] == "") {
            a.length = 0
        }
        for (var i = 0; i < a.length; i++) {
            this.hiddenTag(a[i])
        };
        var b = this.info.someHiddenEle.split(",");
        if (b.length == 1 && b[0] == "") {
            b.length = 0
        }
        for (var i = 0; i < b.length; i++) {
            this.hiddenEle(b[i])
        };
        var b = this.info.someDisabledBtn.split(",");
        if (b.length == 1 && b[0] == "") {
            b.length = 0
        }
        for (var i = 0; i < b.length; i++) {
            this.disabledBtn(b[i])
        }
    },
    disabledBtn: function(a) {
        var b = document.getElementById(a);
        if (typeof(b) != "undefined" && b != null && b.disabled == false) {
            b.disabled = true;
            someToDisabled.push(b)
        }
    },
    hiddenTag: function(a) {
        var b = document.getElementsByTagName(a);
        if (b != null) {
            for (var i = 0; i < b.length; i++) {
                if (b[i].style.display != "none" && b[i].style.visibility != 'hidden') {
                    b[i].style.visibility = 'hidden';
                    someToHidden.push(b[i])
                }
            }
        }
    },
    hiddenEle: function(a) {
        var b = document.getElementById(a);
        if (typeof(b) != "undefined" && b != null) {
            b.style.visibility = 'hidden';
            someToHidden.push(b)
        }
    },
    showSome: function() {
        for (var i = 0; i < someToHidden.length; i++) {
            someToHidden[i].style.visibility = 'visible'
        };
        for (var i = 0; i < someToDisabled.length; i++) {
            someToDisabled[i].disabled = false
        }
    }
};
function getHeight() {
    var a = document.body.clientHeight ? document.body.clientHeight: document.documentElement.clientHeight;
    var b = document.body.scrollTop ? document.body.scrollTop: document.documentElement.scrollTop;
    if (document.body && document.documentElement) {
        if (document.body.clientHeight > 0 && document.documentElement.clientHeight > 0) {
            if (document.body.clientHeight < document.documentElement.clientHeight) {
                a = document.body.clientHeight
            } else {
                a = document.documentElement.clientHeight
            }
        }
    }
    return a
}
function maxHeight() {
    var a = Math.max(document.body.clientHeight, document.documentElement.clientHeight);
    var b = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
    return Math.max(a, b)
}
function dialogScrolling(a) {
    /*if(!G('dialogBox')) {
        clearTimeout(window.__DIALOGSCROLL);
        return
    }
    var b = document.body.scrollTop ? document.body.scrollTop: document.documentElement.scrollTop;
    sTop = dialogTop + b;
    if(sTop <= 150) sTop = 80;
    G('dialogBox')['style']['top'] = sTop + "px";
    if(G('dialogBoxShadow')) {
        G('dialogBoxShadow')['style']['top'] = (sTop - 10) + 'px'
    }
    window.__DIALOGSCROLL = setTimeout("dialogScrolling('" + a + "')", 10)*/
}
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
    if(!G(s)) return;
    if(isUndefined(block)) {
    	block = 'block';
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

function form_submit(){
	//changeStyle("SubmitBtn", 'button150');
	G('SubmitBtn').disabled = true;
	//G('SubmitBtn').value = '数据提交中,请稍后';
}

function explode(sep, string) {
	return string.split(sep);
}

(function(window, undefined) {
	var document = window.document,
		navigator = window.navigator,
		location = window.location;
	var jtG = function(selector, context) {
			return new jtG.fn.init(selector, context);
		},
		_jtG = window.jtG,
		_$ = window.$,
		quickExpr = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,
		rsingleTag = /^<(\w+)\s*\/?>(?:<\/\1>)?$/,
		toString = Object.prototype.toString,
		indexOf = Array.prototype.indexOf;
	jtG.variable = {};
	jtG.fn = jtG.prototype = {
		constructor : jtG,
		init : function(selector, context) {
			var match, elem;
			// Handle $(""), $(null), or $(undefined)
			if(!selector) {
				return this;
			}
			// Handle $(DOMElement)
			if(selector.nodeType) {
				this.context = this[0] = selector;
				this.length = 1;
				return this;
			}
			// The body element only exists once, optimize finding it
			if(selector === 'body' && !context && document.body) {
				this.context = document;
				this[0] = document.body;
				this.selector = selector;
				this.length = 1;
				return this;
			}
			// Handle HTML strings
			if(typeof selector === 'string') {
				// Are we dealing with HTML string or an ID?
				if(selector.charAt(0) === '<' && selector.charAt(selector.length - 1) === '>' && selector.length >= 3) {
					// Assume that strings that start and end with <> are HTML and skip the regex check
					match = [null, selector, null];
				} else {
					match = quickExpr.exec(selector);
				}
				// Verify a match, and that no context was specified for #id
				if(match && (match[1] || !context)) {
					// HANDLE: $(html) -> $(array)
					if(match[1]) {
						return alert('error_1');
					// HANDLE: $("#id")
					} else {
						elem = document.getElementById(match[2]);
						// Check parentNode to catch when Blackberry 4.6 returns
						// nodes that are no longer in the document #6963
						if(elem && elem.parentNode) {
							// Handle the case where IE and Opera return items
							// by name instead of ID
							if(elem.id !== match[2]) {
								return alert('error_2');
							}
							// Otherwise, we inject the element directly into the jtG object
							this.length = 1;
							this[0] = elem;
						}
						this.context = document;
						this.selector = selector;
						return this;
					}
				// HANDLE: $(expr, $(...))
				} else if(!context || context.jtG) {
					return alert('error_3');
				// HANDLE: $(expr, context)
				// (which is just equivalent to: $(context).find(expr)
				} else {
					return alert('error_4');
				}
			// HANDLE: $(function)
			// Shortcut for document ready
			} else {
				return alert('error_5');
			}
			return alert('error_6');
		},
		html : function(value) {
			if(value === undefined) {
				return this[0] && this[0].nodeType === 1 ? this[0].innerHTML : null;
			} else {
				this[0].innerHTML = value;
			}
			return this;
		},
		size : function() {
			return this.length;
		}
	};
	jtG.fn.init.prototype = jtG.fn;
	jtG.extend = jtG.fn.extend = function() {
		var options, name, src, copy,
			target = arguments[0] || {},
			i = 1,
			length = arguments.length,
			deep = false;
		// Handle a deep copy situation
		if(typeof target === 'boolean') {
			deep = target;
			target = arguments[1] || {};
			// skip the boolean and the target
			i = 2;
		}
		// Handle case when target is a string or something (possible in deep copy)
		if(typeof target === 'string') {
			target = {};
		}
		// extend jtG itself if only one argument is passed
		if(length === i) {
			target = this;
			--i;
		}
		for(; i < length; i++) {
			// Only deal with non-null/undefined values
			if((options = arguments[i]) != null) {
				// Extend the base object
				for(name in options) {
					src = target[name];
					copy = options[name];
					// Prevent never-ending loop
					if(target === copy) {
						continue;
					}
					// Recurse if we're merging plain objects or arrays
					if(deep && copy && typeof copy === 'object' && !copy.nodeType) {
						// Never move original objects, clone them
						target[name] = $.extend(
							deep,
							src || (copy.length != null ? [] : {}),
							copy
						);
					// Don't bring in undefined values
					} else if(copy !== undefined) {
						target[name] = copy;
					}
				}
			}
		}
		// Return the modified object
		return target;
	};
	jtG.extend({
		noConflict : function(deep) {
			if(window.$ === jtG) {
				window.$ = _$;
			}
			if(deep && window.jtG === jtG) {
				window.jtG = jtG;
			}
			return jtG;
		}
	});
	window.jtG = window.$ = jtG;
}) (window);
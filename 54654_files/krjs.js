function externalLinks() {
    if (!document.getElementsByTagName) return;
    var a = document.getElementsByTagName("a");
    for (var b = 0; b < a.length; b++) {
        var c = a[b];
        if (c.getAttribute("href") && (c.getAttribute("rel") == "external" || c.getAttribute("rel") == "external nofollow" || c.getAttribute("rel") == "nofollow external")) c.target = "_blank"
    }
}
jQuery(document).ready(function (a) {
    a("abbr.timeago").timeago();
    a(".comment-meta a:first").each(function () {
        var b = a(this).children(".timeago");
        if (b) {
            a(this).html(b)
        }
    })
});
$("a[href*='http://']:not([href*='" + location.hostname + "']),[href*='https://']:not([href*='" + location.hostname + "'])").attr("target", "_blank");
var $body = window.opera ? document.compatMode == "CSS1Compat" ? $("html") : $("body") : $("html,body");
jQuery(document).ready(function () {
    if ($("#scroll_left").length) {
        function a() {
            var a = $("#scroll_left ul li:first");
            var b = -a.outerWidth(true) + "px";
            $("#scroll_left ul").animate({
                left: b
            }, {
                duration: 800,
                complete: function () {
                    $("#scroll_left ul").append(a).css("left", "0")
                }
            })
        }
        myScroll = setInterval(a, 6e3);
        $("#z_next").click(function () {
            clearInterval(myScroll);
            var a = $("#scroll_left ul li:first");
            $("#scroll_left ul li:first").remove();
            $("#scroll_left ul li:last").after(a)
        }, function () {
            myScroll = setInterval(a, 6e3)
        });
        $("#z_prev").click(function () {
            clearInterval(myScroll);
            var a = $("#scroll_left ul li:last");
            $("#scroll_left ul li:last").remove();
            $("#scroll_left ul li:first").before(a)
        }, function () {
            myScroll = setInterval(a, 6e3)
        });
        $("#scroll_left,#z_prev,#z_next").hover(function () {
            clearInterval(myScroll)
        }, function () {
            myScroll = setInterval(a, 6e3)
        })
    }
    var b = $("#s_top, #s_bottom");
    b.click(function () {
        var a, b = $(this).attr("alt");
        if (b == "Top") {
            a = $("#header")
        } else if (b == "Bottom") {
            a = $("#footer")
        } else {
            return false
        }
        $body.animate({
            scrollTop: a.offset().top
        }, 1e3);
        return false
    });
    $("#tab_title span").mouseover(function () {
        var a = $(this).attr("id");
        $(this).parent().removeClass("tab1_title").removeClass("tab2_title").removeClass("tab3_title").removeClass("tab4_title").addClass(a + "_title");
        $("#tab_content ." + a).show().siblings().hide()
    })
});
(function (a) {
    function e() {
        var b = d(this);
        if (!isNaN(b.datetime)) {
            a(this).text(c(b.datetime))
        }
        return this
    }
    function d(b) {
        b = a(b);
        if (!b.data("timeago")) {
            b.data("timeago", {
                datetime: f.datetime(b)
            });
            var c = a.trim(b.text());
            if (c.length > 0) {
                b.attr("title", c)
            }
        }
        return b.data("timeago")
    }
    function c(a) {
        return f.inWords(b(a))
    }
    function b(a) {
        return (new Date).getTime() - a.getTime()
    }
    a.timeago = function (b) {
        if (b instanceof Date) {
            return c(b)
        } else if (typeof b === "string") {
            return c(a.timeago.parse(b))
        } else {
            return c(a.timeago.datetime(b))
        }
    };
    var f = a.timeago;
    a.extend(a.timeago, {
        settings: {
            refreshMillis: 6e4,
            allowFuture: false,
            strings: {
                prefixAgo: null,
                prefixFromNow: "从现在开始",
                suffixAgo: "前",
                suffixFromNow: null,
                seconds: "1 分钟",
                minute: "1 分钟",
                minutes: "%d 分钟",
                hour: "1 小时",
                hours: "%d 小时",
                day: "1 天",
                days: "%d 天",
                month: "1 个月",
                months: "%d 月",
                year: "1 年",
                years: "%d 年",
                numbers: []
            }
        },
        inWords: function (b) {
            function c(c, e) {
                var f = a.isFunction(c) ? c(e, b) : c;
                var g = d.numbers && d.numbers[e] || e;
                return f.replace(/%d/i, g)
            }
            var d = this.settings.strings;
            var e = d.prefixAgo;
            var f = d.suffixAgo;
            if (this.settings.allowFuture) {
                if (b < 0) {
                    e = d.prefixFromNow;
                    f = d.suffixFromNow
                }
                b = Math.abs(b)
            }
            var g = b / 1e3;
            var h = g / 60;
            var i = h / 60;
            var j = i / 24;
            var k = j / 365;
            var l = g < 45 && c(d.seconds, Math.round(g)) || g < 90 && c(d.minute, 1) || h < 45 && c(d.minutes, Math.round(h)) || h < 90 && c(d.hour, 1) || i < 24 && c(d.hours, Math.round(i)) || i < 48 && c(d.day, 1) || j < 30 && c(d.days, Math.floor(j)) || j < 60 && c(d.month, 1) || j < 365 && c(d.months, Math.floor(j / 30)) || k < 2 && c(d.year, 1) || c(d.years, Math.floor(k));
            return a.trim([e, l, f].join(" "))
        },
        parse: function (b) {
            var c = a.trim(b);
            c = c.replace(/\.\d\d\d+/, "");
            c = c.replace(/-/, "/").replace(/-/, "/");
            c = c.replace(/T/, " ").replace(/Z/, " UTC");
            c = c.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2");
            return new Date(c)
        },
        datetime: function (b) {
            var c = a(b).get(0).tagName.toLowerCase() === "time";
            var d = c ? a(b).attr("datetime") : a(b).attr("title");
            return f.parse(d)
        }
    });
    a.fn.timeago = function () {
        var a = this;
        a.each(e);
        var b = f.settings;
        if (b.refreshMillis > 0) {
            setInterval(function () {
                a.each(e)
            }, b.refreshMillis)
        }
        return a
    };
    document.createElement("abbr");
    document.createElement("time")
})(jQuery);
jQuery(document).ready(function () {
    externalLinks()
});
jQuery("document").ready(function () {
    function a(a, b, c) {
        _gat._getTrackerByName()._trackEvent(b, c)
    }
    jQuery("a").each(function () {
        var b = jQuery(this).attr("href");
        if (typeof b != "undefined" && b.indexOf("36kr.com") == -1 && b.indexOf("/") != 0) {
            jQuery(this).click(function () {
                a(jQuery(this), "Outbound Links", jQuery(this).attr("href"))
            })
        }
    })
});
jQuery(document).ready(function (a) {
    a(".tipus").hover(function () {
        a("#tipus_msg").focus()
    });
    jQuery("#contact_me").submit(function () {
        var a = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "/wp-admin/admin-ajax.php",
            data: "action=contact_form&" + a,
            success: function (a) {
                jQuery("#node").ajaxComplete(function (b, c, d) {
                    if (a == "sent") {
                        jQuery(".contact #node").hide();
                        jQuery("#contact_me").fadeOut("slow");
                        jQuery(".contact #success").fadeIn("slow");                           

                    } else {
                        result = a;
                        jQuery(".contact #node").html(result);
                        jQuery(".contact #node").fadeIn("slow")
                    }
                })
            }
        });
        return false
    })
});
(function (a) {
    a(function () {
        var b = a("#s_top");
        a(b).hide();
        a(window).scroll(function () {
            if (a(window).scrollTop() == "0") {
                a(b).fadeOut("slow")
            } else {
                a(b).fadeIn("slow")
            }
        });
        a(b).click(function () {
            a("html,body").animate({
                scrollTop: 0
            }, 700);
            return false
        })
    })
})(jQuery)
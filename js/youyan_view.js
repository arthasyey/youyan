var sina_oauth_token;
var sina_oauth_token_secret;
var sina_id;

var kaixin_id;
var kaixin_access_token;
var kaixin_access_secret;

var douban_id;
var douban_access_token;
var douban_access_secret;

var tencent_id;
var tencent_access_token;
var tencent_access_secret;

var neteasy_id;
var neteasy_access_token;
var neteasy_access_secret;

var box_has_changed = false;

var renren_session_key;
var renren_id;
var renren_access_token;
var renren_refresh_token;

var sohu_id;
var sohu_access_token;
var sohu_access_secret;

var qq_id;
var qq_access_token;
var qq_access_secret;

var msn_id;
var msn_access_token;

var SSOName;

var numComments;

var page;
var domain;
var user_id;
var show_name;
var author_url;
var author_email;
var profile_img_url;
var email;
var title;

var comment_author;
var comment_author_email;
var comment_author_url;

var commentPageNum = 0;
var numCommentsPerPage;

var width;

var anon_word;
var anon_url;
var domain_name;

var logins; //= Array();

var reply_position;

var comment_reply_pages = {};


var SNSTypes = Array(
    'EMAIL',
    'SINA',
    'TENCENT',
    'RENREN',
    'QQ',
    'NETEASY',
    'SOHU',
    'KAIXIN',
    'MSN',
    'DOUBAN'
    )


var SNSTypeToName = {
  SINA : '新浪微博',
  RENREN : '人人网',
  TENCENT : '腾讯微博',
  QQ : 'QQ空间',
  SOHU : '搜狐微博',
  NETEASY : '网易微博',
  KAIXIN : '开心网',
  DOUBAN : '豆瓣',
  MSN : 'MSN'
};

var SNSTypeToBase = {
  SINA : 'http://weibo.com',
  RENREN : 'http://renren.com',
  TENCENT : 'http://t.qq.com',
  QQ : 'http://qzone.qq.com',
  SOHU : 'http://t.sohu.com',
  NETEASY : 'http://t.163.com',
  KAIXIN : 'http://kaixin.com',
  DOUBAN : 'http://douban.com',
  MSN : 'http://www.live.cn'
};

var SNSTypeToPrefix = {
  SINA : 'http://weibo.com/',
  RENREN : 'http://www.renren.com/profile.do?id=',
  TENCENT : 'http://t.qq.com/',
  QQ : 'http://qzone.qq.com/',
  SOHU : 'http://t.sohu.com/people?uid=',
  NETEASY : 'http://t.163.com/',
  KAIXIN : 'http://www.kaixin001.com/home/?uid=',
  DOUBAN : 'http://www.douban.com/people/'
};


function stringToDateTime(postdate) { 
  var second = 1000; 
  var minutes = second*60; 
  var hours = minutes*60; 
  var days = hours*24; 
  var months = days*30; 
  var twomonths = days*365; 
  var myDate = new Date(Date.parse(postdate)); 
  if (isNaN(myDate)) { 
    myDate =new Date(postdate.replace(/-/g, "/")); 
  } 
  var nowtime = new Date(); 
  var longtime =nowtime.getTime()- myDate.getTime(); 
  var showtime = 0; 
  if( longtime > months*2 ) { 
    return postdate; 
  } 
  else if (longtime > months) { 
    return "1个月前"; 
  } 
  else if (longtime > days*7) { 
    return ("1周前"); 
  } 
  else if (longtime > days) { 
    return(Math.floor(longtime/days)+"天前"); 
  } 
  else if ( longtime > hours) { 
    return(Math.floor(longtime/hours)+"小时前"); 
  } 
  else if (longtime > minutes) { 
    return(Math.floor(longtime/minutes)+"分钟前"); 
  } 
  else if (longtime > second) { 
    return(Math.floor(longtime/second)+"秒前"); 
  }else { 
    return("0秒前"); 
  } 
}


/*function getPageDomain(){
  var url = location.href;

  var loc = url.indexOf("?");
  if(loc != -1)
    url = url.substr(0, loc);

  var loc = url.indexOf("#");
  if(loc != -1)
    url = url.substr(0, loc);

  loc = url.indexOf("www");
  if(loc != -1)
    url = url.substr(loc+3);

  loc = url.indexOf("//");
  if(loc != -1)
    page = url.substr(loc+2);
  else
    page = url;

}*/

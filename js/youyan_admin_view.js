var SINA_ACCESS_TOKEN;
var SINA_ACCESS_SECRETE;
var SINA_APP_KEY;
var SINA_APP_SECRETE;
var OP_USE_ORIG;
var OP_WIDTH;
var OP_LIMIT;
var OP_STYLE;
var OP_DIG;
var OP_DIGDOWN;
var OP_SELECTED_IDX;
var OP_MAIL_NOTIFY;
var OP_ACCOUNT_ORDER;
var OP_DEL_STYLE;
var OP_DESC_WORD;
var OP_DEFAULT_SORT;
var OP_HAS_BINDED_SINA;
var OP_DEFAULT_PROFILE;
var OP_STYLE_NUM;
var domain;


function submitSSO(){
  var sso_name = $("#sso_name").val();
}

var nCommentsToIdxMap = {
  1 : 0,
  3 : 1,
  5 : 2,
  10: 3,
  20: 4,
  50: 5
};

function bindFuncToIconsAdmin(){
  $('.connectBTNRENREN').click( function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    renrenOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/renren','人人网','location=yes,left=200,top=100,width=500,height=350,resizable=yes');

  });

  $('.connectBTNMSN').click( function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    renrenOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/msn','MSN','location=yes,left=200,top=100,width=500,height=350,resizable=yes');

  });


  $('.connectBTNQQ').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    qqOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/qq','QQ空间','location=yes,left=200,top=100,width=600,height=460,resizable=yes');
  });

  $('.connectBTNSINA').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    sinaOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/sina','新浪微博','location=yes,left=200,top=100,width=600,height=400,resizable=yes');
  });

  $('.connectBTNKAIXIN').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    kaixinOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/kaixin','开心网','location=yes,left=200,top=100,width=500,height=400,resizable=yes');
  });

  $('.connectBTNSOHU').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    sohuOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/sohu','搜狐微博','location=yes,left=200,top=100,width=900,height=600,resizable=yes');
  });

  $('.connectBTNNETEASY').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    neteasyOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/neteasy','网易微博','location=yes,left=200,top=100,width=800,height=700,resizable=yes');
  });


  $('.connectBTNTENCENT').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    tencentOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/tencent','腾讯微薄','location=yes,left=200,top=100,width=800,height=800,resizable=yes');

  });

  $('.connectBTNDOUBAN').click(function() {
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    doubanOpener = window.open('http://uyan.cc/index.php/youyan/prepareLogin/douban','豆瓣','location=yes,left=200,top=100,width=550,height=450,resizable=yes');
  });

  $('.connectBTNEMAIL').click(function() {
    boxEmailLogin.show();
    boxEmailLogin.center('x');
    $(".connecntReplyMenu").remove();
    $(".connecntMenu").remove();
    $("#UYloginEmailName").val("");
    $("#UYloginEmailAD").val("");
    $("#UYloginEmailURL").val("");
    $("#alertLogin").html("");
  });
}

function buildAccountOrder(){
  var $selectedItems = $(".loginPaneRight .connecntMenuTop .itemListWrapper");
  var ret='';
  for(var i = 0; i < $selectedItems.length; i++){
    var str =$selectedItems[i].id;
    ret += str.substr(1);
  }

  ret += '_';

  $selectedItems = $(".loginPaneRight .connecntMenu .itemListWrapper");
  for(var i = 0; i < $selectedItems.length; i++){
    var str =$selectedItems[i].id;
    ret += str.substr(1);
  }
  return ret;
}

var SNSTypeToName = {
  SINA : '新浪微博',
  TENCENT : '腾讯微博',
  RENREN : '人人网',
  QQ : 'QQ空间',
  SOHU : '搜狐微博',
  NETEASY : '网易微博',
  KAIXIN : '开心网',
  MSN : 'MSN',
  DOUBAN : '豆瓣'
};

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
    );


function changeData(timeArea,transData,type){
  if($('.onLoading').length==0)
    $('.dataLeftTitle').after('<span class="onLoading">加载中...</span>');
  $.ajax({
    type:"POST",
    url:"../../youyan_webdata/changeTable/" +timeArea,
    data:{
      transData:transData,type:type
    },
    dataType:"html",
    success: function(reply_data){
      var data_array = reply_data.split("{}");
      var reply_data_trace = data_array[1];
      var reply_data = data_array[0];
      var d = eval(reply_data);
      var d1 = eval (reply_data_trace);
      for (var i = 0; i < d.length; ++i){
        d[i][0] += 8*60 * 60 * 1000;
        d1[i][0] += 8*60 * 60 * 1000;
      }
      var options = {
        xaxis: { mode: "time" },
    series: { lines: { show: true }, points: { show: true }},
    grid: { markings: weekendAreas ,hoverable: true, clickable: true}
      };
      var plot = $.plot($("#placeholder"), [{ data: d, label:"评论数"},{data:d1,label:"用户回访数"}], options);	  
      function weekendAreas(axes) {
        var markings = [];
        var d = new Date(axes.xaxis.min);
        // go to the first Saturday
        d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
          d.setUTCSeconds(0);
        d.setUTCMinutes(0);
        d.setUTCHours(0);
        var i = d.getTime();
        do {
          markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
          i += 7 * 24 * 60 * 60 * 1000;
        } while (i < axes.xaxis.max);

        return markings;
      }		
      function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
          position: 'absolute',
          display: 'none',
          top: y + 5,
          left: x + 5,
          border: '1px solid #fdd',
          padding: '2px',
          'font-size': '12px',
          'background-color': '#fee',
          opacity: 0.80
        }).appendTo("body").fadeIn(200);
      }	


      var previousPoint = null;
      $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) {
          if (previousPoint != item.datapoint) {
            previousPoint = item.datapoint;

            $("#tooltip").remove();
            var x = item.datapoint[0].toFixed(0),
        y = item.datapoint[1].toFixed(0);                    
      showTooltip(item.pageX, item.pageY,
        getLocalTime(x/1000) + " " +item.series.label+" "+ y);
          }
        }else {
          $("#tooltip").remove();
          previousPoint = null;            
        }

      });

      $("#placeholder").bind("plotclick", function (event, pos, item) {
        if (item) { 
          plot.highlight(item.series, item.datapoint);
        }
      });

      $(".onLoading").remove();
    },
    error:function(){
            $(".onLoading").remove();
            alert("网络线路问题，暂时无法提供统计图，请稍候再试");
          }
  });    
}

function prepareData(timeArea){
  if($('.onLoading').length==0)
    $('.dataLeftTitle').after('<span class="onLoading">加载中...</span>');
  $.ajax({
    type:"POST",
    url:"../../youyan_webdata/getTable/" +timeArea,
    dataType:"html",
    success: function(reply_data){
      var data_array = reply_data.split("{}");
      var reply_data_trace = data_array[1];
      var reply_data = data_array[0];
      var d = eval(reply_data);
      var d1 = eval (reply_data_trace);
      for (var i = 0; i < d.length; ++i){
        d[i][0] += 8*60 * 60 * 1000;
        d1[i][0] += 8*60 * 60 * 1000;
      }


      var options = {
        xaxis: { mode: "time" },
    series: { lines: { show: true }, points: { show: true }},
    grid: { markings: weekendAreas ,hoverable: true, clickable: true}
      };
      var plot = $.plot($("#placeholder"), [{ data: d, label:"评论数"},{data:d1,label:"用户回访数"}], options);

      // helper for returning the weekends in a period

      function weekendAreas(axes) {
        var markings = [];
        var d = new Date(axes.xaxis.min);
        // go to the first Saturday
        d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
          d.setUTCSeconds(0);
        d.setUTCMinutes(0);
        d.setUTCHours(0);
        var i = d.getTime();
        do {
          markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
          i += 7 * 24 * 60 * 60 * 1000;
        } while (i < axes.xaxis.max);

        return markings;
      }		
      function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
          position: 'absolute',
        display: 'none',
        top: y + 5,
        left: x + 5,
        border: '1px solid #fdd',
        padding: '2px',
        'font-size': '12px',
        'background-color': '#fee',
        opacity: 0.80
        }).appendTo("body").fadeIn(200);
      }	


      var previousPoint = null;
      $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) {
          if (previousPoint != item.datapoint) {
            previousPoint = item.datapoint;

            $("#tooltip").remove();
            var x = item.datapoint[0].toFixed(0),
        y = item.datapoint[1].toFixed(0);                    
      showTooltip(item.pageX, item.pageY,
        getLocalTime(x/1000) + " " +item.series.label+" "+ y);
          }
        }else {
          $("#tooltip").remove();
          previousPoint = null;            
        }

      });

      $("#placeholder").bind("plotclick", function (event, pos, item) {
        if (item) { 
          plot.highlight(item.series, item.datapoint);
        }
      });

      $(".onLoading").remove();
    },
    error:function(){
            $(".onLoading").remove();
            alert("网络线路问题，暂时无法提供统计图，请稍候再试");
          }
  });    
}

function getLocalTime(nS) {
  dateChange = new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");  
  dateChagne = dateChange.split(' ');
  return dateChagne[0];
}

function weekendAreas(axes) {
  var markings = [];
  var d = new Date(axes.xaxis.min);
  // go to the first Saturday
  d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
    d.setUTCSeconds(0);
  d.setUTCMinutes(0);
  d.setUTCHours(0);
  var i = d.getTime();
  do {
    // when we don't set yaxis, the rectangle automatically
    // extends to infinity upwards and downwards
    markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
    i += 7 * 24 * 60 * 60 * 1000;
  } while (i < axes.xaxis.max);

  return markings;
}

function aproveReply(currentNode,commentId,selectType){
  var $aproveNode = $(currentNode);
  $aproveNode.html('...');
  $.ajax({
    type:"POST",
    url:"../../youyan_content/accessComment/"+commentId,
    dataType:"json",
    success: function(reply_data){
      $aproveNode.parent('.UYInfoAction').parent('.UYInfoWrapper').parent("").attr("class","itemWrapper normalItem");
      if(selectType=='access'){
        $aproveNode.html('已通过');
      }else{
        $aproveNode.html('已恢复');
      }
      $aproveNode.removeAttr("onclick");
      $aproveNode.css({"cursor":"default"});
      if(normalCommentToogle!=1){
        $aproveNode.parent('.UYInfoAction').parent('.UYInfoWrapper').parent("").remove();
      }
    },
    error:function(){
            alert("网络线路问题，暂时无法删除评论，请稍候再试");
          }
  });
}

function delReply(currentNode,commentId){
  var $delnode = $(currentNode);
  $delnode.html("...");
  $.ajax({
    type:"POST",
    url:"../../youyan_content/delComment/"+commentId,
    dataType:"json",
    success: function(reply_data){
      if(delCommentToogle!=1){
        $delnode.parent(".UYInfoAction").parent(".UYInfoWrapper").parent("").remove();
      }else{
        $delnode.html("已删除");
        $delnode.removeAttr("onclick");
        $delnode.css({"cursor":"default"});
        $delnode.parent('.UYInfoAction').parent('.UYInfoWrapper').parent("").attr("class","itemWrapper delItem");
      }

    },
    error:function(){
            alert("网络线路问题，暂时无法删除评论，请稍候再试");
          }
  });
}

function getAdminReplyData(ruid,comment_id,current_cid){
  if(ruid!=0&&comment_id!=0){
    $.ajax({
      type:"POST",
      url:"../../youyan_content/getReplyComment/"+ruid,
      data:{comment_id:comment_id},
      dataType:"json",
      success: function(user_data){
        $("#"+current_cid).children(".UYInfoWrapper").children(".UYInfo").children("br").after("<span class='replyInfo'>回复"+user_data[0].show_name+"</span>: ");
      },
      error:function(){
              alert("网络线路问题，暂时无法删除评论，请稍候再试");
            }
    });	
  }
}

function createEmotion(content){
  $emotionKey = new Array("纠结","心动","用力","抱","鬼脸","喃喃","啪地","狂泪","忍耐","跳舞","狸猫","虫子","面跳舞","喝茶","给力","思考","紧张","睡醒","离家","怒气","吃","囧","惹嫌","潜水","开心","捏脸","怒火","鬼","疑问","暴跳","不甘心","下班","失意","相拥","暖和","示爱","无语","害羞","礼物","狂笑");
  var $emotionKeyNormal = new Array("纠结","心动","生气","开心","调皮","眨眼","害羞","失落","酷","愤怒","惊讶","无语","哭泣","笑","大哭","调皮","惊讶","呆","口哨","天使","恶魔","恶魔笑","闭嘴","满意","睡觉","得意","生病","怀疑","专注","外星人","史莱克","游戏","爱心","家","地球","邮件","音乐","编辑","电话","照相");  
  for(var i=1;i<=40;i++){	
    reg=new RegExp("(\\(al"+$emotionKey[(i-1)]+"\\))","g"); 
    content = content.replace(reg,'<img src="../../../images/emotions/ali/'+i+'.gif"/>');
    regDefault = new RegExp("(\\("+$emotionKeyNormal[(i-1)]+"\\))","g"); 
    content = content.replace(regDefault,'<img src="../../../images/emotions/default/'+i+'.png"/>');
  }	
  return content;
}

function getAdmin(domain){
  $.ajax({
    type:"POST",
  url:"http://uyan.cc/index.php/youyan_login/userDomain",
  data:{
    domain:domain
  },
  dataType:"json",
  cache:false,
  success: function(data){
    location.href="http://uyan.cc/index.php/youyan_admin/index/";
  },
  error:function(){
          alert("由于网络不稳定,登录失败,请稍候再试。");
        }
  });	
}
function getAdminCheck(domain){
  $.ajax({
    type:"POST",
  url:"http://uyan.cc/index.php/youyan_login/userCheckDomain",
  data:{
    domain:domain
  },
  dataType:"json",
  cache:false,
  success: function(data){
    location.href="http://uyan.cc/index.php/youyan_check_domain";
  },
  error:function(){
          alert("由于网络不稳定,登录失败,请稍候再试。");
        }
  });	
}
function hideURL($currentURL,$lineId){
  $(".alertDel").html($currentURL);
  $("#currentLineID").html($lineId);
  boxDel.show();
}

function submitDEL(){
  delURL = $("#chooseToDEL").html();
  if(delURL!=''){
    $.ajax({
      type:"POST",
      url:"http://uyan.cc/index.php/youyan_login/delDomain",
      data:{
        delURL:delURL
      },
      dataType:"json",
      cache:false,
      success: function(data){			
        boxDel.hide();
        $idCard = $("#currentLineID").html();
        $("#"+$idCard).remove();
        if($(".contentTableLine").length==0){
          $(".contentTableTop").after('<div id="0" class="contentTableLine"><div class="urlContanter">您还没有添加可以管理的网站</div><div class="commentsContainer amountContainer"></div><a class="viewContainer" ></a><div class="clear"></div></div>');
        }
      },
      error:function(){
              alert("由于网络不稳定,删除失败,请稍候再试。");
            }
    });	
  }
}

function createCSS(){
  $("#saveStyle").attr("disabled","disabled");
  $("#saveStyle").html("存储中");
  var css = $("#createCSS").val();
  var type = 'box';
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/createCSS",
    data:{
      css:css,type:type
    },
    dataType:"json",
    cache:false,
    success: function(data){			
      $("#saveStyle").html("保存成功");
      $("#saveStyle").removeAttr("disabled");
      setTimeout("$('#saveStyle').html('保存');",1000);
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });
}
function createCommentCSS(){
  $("#saveCommentStyle").attr("disabled","disabled");
  $("#saveCommentStyle").html("存储中");
  var css = $("#createCommentCSS").val();
  var type = 'comment';
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/createCSS",
    data:{
      css:css,type:type
    },
    dataType:"json",
    cache:false,
    success: function(data){			
      $("#saveCommentStyle").html("保存成功");
      $("#saveCommentStyle").removeAttr("disabled");
      setTimeout("$('#saveCommentStyle').html('保存');",1000);
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });
}
function createArticleCSS(){
  $("#saveArticleStyle").attr("disabled","disabled");
  $("#saveArticleStyle").html("存储中");
  var css = $("#createArticleCSS").val();
  var type = 'article';
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/createCSS",
    data:{
      css:css,type:type
    },
    dataType:"json",
    cache:false,
    success: function(data){			
      $("#saveArticleStyle").html("保存成功");
      $("#saveArticleStyle").removeAttr("disabled");
      setTimeout("$('#saveArticleStyle').html('保存');",1000);
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });
}
function showNavi(navi){
  $(".naviBTN").each(function(){
    $(this).attr("class","naviBTN");
  });
  switch(navi){
    case 'visual':
      $("#visual").attr("class","naviBTN naviBTNCurrent");	
      $("#visualEdit").show();
      $("#installPlugin").hide();
      $("#stepTwoWrapper").hide();
      $("#installWrapper").hide();
      $("#exampleWrapper").hide();
      $("#createCSS").focus();
      $("#spamWrapper").hide();
      $("#dataBakWrapper").hide();
      break;
    case 'setting':
      $("#setting").attr("class","naviBTN naviBTNCurrent");
      $("#visualEdit").hide();
      $("#stepTwoWrapper").show();
      $("#installWrapper").hide();
      $("#exampleWrapper").hide();
      $("#installPlugin").hide();
      $("#spamWrapper").hide();
      $("#dataBakWrapper").hide();
      break;
    case 'example':
      $("#example").attr("class","naviBTN naviBTNCurrent");
      $("#visualEdit").hide();
      $("#installPlugin").hide();
      $("#stepTwoWrapper").hide();
      $("#installWrapper").hide();	
      $("#exampleWrapper").show();
      $("#spamWrapper").hide();
      $("#dataBakWrapper").hide();
      break;
    case 'plugin':
      $("#plugin").attr("class","naviBTN naviBTNCurrent");
      $("#visualEdit").hide();
      $("#installPlugin").show();
      $("#stepTwoWrapper").hide();
      $("#installWrapper").hide();	
      $("#exampleWrapper").hide();
      $("#spamWrapper").hide();
      $("#dataBakWrapper").hide();
      break;
    case 'spam':
      $("#spam").attr("class","naviBTN naviBTNCurrent");
      $("#visualEdit").hide();
      $("#installPlugin").hide();
      $("#stepTwoWrapper").hide();
      $("#installWrapper").hide();	
      $("#exampleWrapper").hide();
      $("#spamWrapper").show();
      $("#dataBakWrapper").hide();
      prapareSpam();
      break;
    case 'data':
      $("#databak").attr("class","naviBTN naviBTNCurrent");
      $("#visualEdit").hide();
      $("#installPlugin").hide();
      $("#stepTwoWrapper").hide();
      $("#installWrapper").hide();	
      $("#exampleWrapper").hide();
      $("#spamWrapper").hide();	
      $("#spamWrapper").hide();	
      $("#dataBakWrapper").show();
      break;
    default:
      $("#install").attr("class","naviBTN naviBTNCurrent");
      $("#installPlugin").hide();
      $("#visualEdit").hide();
      $("#stepTwoWrapper").hide();
      $("#installWrapper").show();
      $("#exampleWrapper").hide();
      $("#spamWrapper").hide();
      $("#dataBakWrapper").hide();
      break;
  }
}
function prapareSpam(){
  $.ajax({
    type:"POST",
  url:"http://uyan.cc/index.php/youyan_admin_edit/getSpam",
  dataType:"json",
  cache:false,
  success: function(data){
    if(data!=null){
      $(".blackListContainer").html('');
      var $inStr = createBlackList(data);			
      $(".blackListContainer").append($inStr);
      var $inWord = data.word;
      $("#spamWords").val($inWord);
    }
  },
  error:function(){            
          alert("由于网络不稳定,创建失败,请稍候再试。");
        }
  });	
}
function createBlackList(data){
  var emailList = data.email;
  var ipList = data.ip;
  var userNameList = data.user_name;
  var userIDList = data.user_id;
  var insertStr='';
  insertStr += blackListHtml(userIDList,'SNS用户');	
  insertStr += blackListHtml(emailList,'Email');	
  insertStr += blackListHtml(ipList,'IP');
  insertStr += blackListHtml(userNameList,'用户名');
  return insertStr;	
}
function blackListHtml(list,type){
  if(list!=null){
    var listArray = list.split(',');
    var $insertStr ='';	
    for(var i=0;i<listArray.length-1;i++){
      if(type=='SNS用户'){
        $insertStr += '<div class="blackListItem"><div class="blackValue">用户ID:'+listArray[i]+'</div><div class="blackType">'+type+'</div><div class="blackControl" onclick="delSpam(this)">删除</div><div class="clear"></div></div>';			
      }else{
        $insertStr += '<div class="blackListItem"><div class="blackValue">'+listArray[i]+'</div><div class="blackType">'+type+'</div><div class="blackControl" onclick="delSpam(this)">删除</div><div class="clear"></div></div>';
      }
    }
    return $insertStr;
  }else{
    return '';	
  }
}
function changeLink($url){

  if($url!=''&&$url!=null&&$url!='undefined'){
    $("#hidePageLink").html($url);
  }else{
    $("#hidePageLink").html('');
  }
}

function changeTitle($title,$page,type){
  $(".dataLeftTitleTrace").html($title);
  $("#changeDataAll").removeAttr("onclick");
  $("#changeDataYear").removeAttr("onclick");
  $("#changeDataSix").removeAttr("onclick");
  $("#changeDataThree").removeAttr("onclick");
  $("#changeDataMonth").removeAttr("onclick");
  $("#changeDataSeven").removeAttr("onclick");
  $("#changeDataAll").attr("onclick",function(){return function(){changeData('all',$page,type);}});	
  $("#changeDataYear").attr("onclick",function(){return function(){changeData(365,$page,type);}});
  $("#changeDataSix").attr("onclick",function(){return function(){changeData(180,$page,type);}});
  $("#changeDataThree").attr("onclick",function(){return function(){changeData(90,$page,type);}});
  $("#changeDataMonth").attr("onclick",function(){return function(){changeData(30,$page,type);}});
  $("#changeDataSeven").attr("onclick",function(){return function(){changeData(7,$page,type);}});
  $linkURL = $("#hidePageLink").html();
  if($linkURL!=''&&$linkURL!=null){
    $(".linkTo").show();
    $(".linkTo").attr("href",$linkURL );
  }else{
    $(".linkTo").hide();
  }
}

function clearLink(){
  $("#hidePageLink").html('');
  $(".linkTo").hide();
}

function backTitle(type){
  $("#hidePageLink").html('');
  $(".linkTo").hide();
  switch(type){
    case 'sns':
      $(".dataLeftTitleTrace").html('全部社交网站');
      break;
    case 'user':
      $(".dataLeftTitleTrace").html('全部用户');
      break;
    case 'comment':
      $(".dataLeftTitleTrace").html('全部评论');
      break;
    default:
      $(".dataLeftTitleTrace").html('全部页面');
      break;
  }

  $("#changeDataAll").removeAttr("onclick");
  $("#changeDataYear").removeAttr("onclick");
  $("#changeDataSix").removeAttr("onclick");
  $("#changeDataThree").removeAttr("onclick");
  $("#changeDataMonth").removeAttr("onclick");
  $("#changeDataSeven").removeAttr("onclick");
  $("#changeDataAll").attr("onclick",function(){return function(){prepareData('all');}});	
  $("#changeDataYear").attr("onclick",function(){return function(){prepareData(365);}});
  $("#changeDataSix").attr("onclick",function(){return function(){prepareData(180);}});
  $("#changeDataThree").attr("onclick",function(){return function(){prepareData(90);}});
  $("#changeDataMonth").attr("onclick",function(){return function(){prepareData(30);}});
  $("#changeDataSeven").attr("onclick",function(){return function(){prepareData(7);}});	
}

function changeAnalyticsType(type,node){
  $(".adminLeftMenuBTN").removeClass('currentLeftMenu');
  var $node = $(node);
  $node.addClass('currentLeftMenu');
  switch(type){
    case 'user':
      $("#userAnalytics").show();
      $("#commentAnalytics").hide();
      $("#snsAnalytics").hide();
      $("#pageAnalytics").hide();
      break;		
    case 'comment':
      $("#userAnalytics").hide();
      $("#commentAnalytics").show();
      $("#snsAnalytics").hide();
      $("#pageAnalytics").hide();		
      break;	
    case 'sns':
      $("#userAnalytics").hide();
      $("#commentAnalytics").hide();
      $("#snsAnalytics").show();
      $("#pageAnalytics").hide();			
      break;	
    default:
      $("#userAnalytics").hide();
      $("#commentAnalytics").hide();
      $("#snsAnalytics").hide();
      $("#pageAnalytics").show();			
      break;
  }
}
function buildCommentHTMLPart(key,val,type,itemTypeColor){
  var item ='<div class="itemWrapper '+itemTypeColor+'" id="'+val.comment_id+'">';
  
  if(val.profile_img==''||val.profile_img=='http://uyan.cc/images/photoDefault.png'){

    item +='<a class="UYPhoto" style="background:url(' + get_gravatar(val.comment_author_email) + ') 0 0 no-repeat" href="#" target="_blank"></a>';
  }else{
    item +='<a class="UYPhoto" style="background:url('+val.profile_img+') 0 0 no-repeat" href="#" target="_blank"></a>';		
  }
  
  item +='<div class="UYInfoWrapper">'
    +'<div class="UYInfo">';
  if(val.from_type!='wordpress'&&val.from_type!='EMAIL'){
    item+='<a href="#" class="UYInfoLink" target="_blank">'+val.show_name+'</a>';
    item+='<span class="dotControl"> (来自:<a class="UYSourceLink" href="#" target="_blank">'+val.from_type+'</a>)</span>';
    item +='<a class="UYDel" onclick="addToBlack(this,\''+val.user_id+'\',\''+val.comment_id+'\')">添加至黑名单</a>';
  }else{
    item+='<a class="UYInfoLink" style="cursor:default;color:#555;" >'+val.comment_author+'</a>';
    if(val.from_type=='EMAIL'){
      item+='<span class="dotControl"> (<a class="UYSourceLink" style="cursor:default;" >';												
          item+= val.show_name+' ';
          if(val.comment_author_email!= ''){
            item+='| Email:'+val.comment_author_email+' ';
          }
          if(val.comment_author_url != ''){
            item+='| URL:'+val.comment_author_url+' '; 
          }

          item+='</a>)</span>'; 
    }else{
      item+='<span class="dotControl"> (<a class="UYSourceLink" >'+val.from_type+'</a>)</span>';
    }
    item +='<a class="UYDel" onclick="addToBlackEmail(this,\''+val.comment_author+'\',\''+val.comment_author_email+'\',\''+val.comment_author_url+'\',\''+val.comment_id+'\')">添加至黑名单</a>';
  }
val.content = val.content.replace( "\n", "<br>");

  item+='<br/><span class="contentWrapper">'+val.content+'</span>'
    +'</div><div class="UYArrowHide"></div><div class="UYInfoAction"><a class="UYUpIcon" onclick="UYup(this)"></a> <a class="UYUpInfo" onclick="UYup(this)">顶<span class="UYupAmount">'
    +val.n_up
    +'</span> </a>'
    +'<div class="UYSendTime">'
    +val.time
    +'</div>';
  if(val.veryfy_status!='3'){
    item +='<a class="UYDel" onclick="delReply(this,\''+val.comment_id+'\')">删除</a>';
  }   
  if(val.veryfy_status=='2'||val.veryfy_status=='3'){
    item +='<a class="UYDel" onclick="aproveReply(this,\''+val.comment_id+'\',\'back\')">恢复</a>';
  }


  if(val.veryfy_status=='1'){
    item +='<a class="UYAccess" onclick="aproveReply(this,\''+val.comment_id+'\',\'access\')">审核通过</a>';
  }

  item +='<a class="UYReply" onclick="UYreplyAdmin(this)">回复</a>';
  item +='<div class="clear"></div></div>';
  if(type=='domain'&&val.page_title!=''){
    item += '<div class="replyFromWrapper"><div class="replyFrom">评论于 <a class="fromLink" target="_blank" href="'
      +val.page_url
      +'">'
      +val.page_title
      +'</a></div>'
      +'<div class="hidePage">'
      +val.page
      +'</div>'
      +'<div class="hideDomain">'
      +val.domain
      +'</div>'
      +'<div class="in_reply_to_id">'			 
      +val.user_id
      +'</div>'		 

      +'<div class="clear"></div></div>';
  }
  item += '</div><div class="clear"></div></div>';
  return item;

}
function buildCommentAdmin(key,val,type){
  switch(val.veryfy_status){
    case '1':
      var itemTypeColor = 'readyItem';
      break;
    case '2':
      var itemTypeColor = 'trashItem';
      break;
    case '3':
      var itemTypeColor = 'delItem';
      break;
    default:
      var itemTypeColor = 'normalItem';
      break;
  }

  var item = buildCommentHTMLPart(key,val,type,itemTypeColor);
  $("#afterMessage").before(item);
  //edit link
  var strPrepared = val.from_type.toLowerCase()+"_id";
  var fromTypeLink = SNSTypeToPrefix[val.from_type]+val[strPrepared];
  var snsName = SNSTypeToName[val.from_type];
  var snsLink = SNSTypeToBase[val.from_type];
  //alert(fromTypeLink);
  $("#"+val.comment_id).children('.UYPhoto').attr("href",fromTypeLink);
  if(val.from_type!='wordpress'&&val.from_type!='EMAIL'){
    $("#"+val.comment_id).children('.UYInfoWrapper').children('.UYInfo').children('.UYInfoLink').attr("href",fromTypeLink);
    $("#"+val.comment_id).children('.UYInfoWrapper').children('.UYInfo').children(".dotControl").children(".UYSourceLink").attr("href",snsLink);
  }
  $("#"+val.comment_id).children('.UYInfoWrapper').children('.UYInfo').children(".dotControl").children(".UYSourceLink").html(snsName);	

  $afterTime = stringToDateTime(val.time);
  $("#"+val.comment_id).children('.UYInfoWrapper').children('.UYInfoAction').children(".UYSendTime").html($afterTime);			
  /*if(val.ruid!=0&&val.ruid!='undefined'&&val.ruid!=''){
    getAdminReplyData(val.ruid,val.reply_to_comment_id,val.comment_id);				
    }*/
  var $emotionContent = createEmotion(val.content);	
  $("#"+val.comment_id).children('.UYInfoWrapper').children('.UYInfo').children(".contentWrapper").html($emotionContent);			 
  return true;
}

function getEmptyComment(){
  $("#afterMessage").ready(function(){
    $("#afterMessage").before('<div class="emptyCommentUnverified">[验证域名后，评论将显示在此处]</div>');
  });
}
function UYreplyAdmin(currentNode){
  //updateLoginInfo(loginInfo);
  var $InfoWrapperNode = $(currentNode).parent().parent();
  var $tartgetNode = $InfoWrapperNode.parent().next();
  var $replyName = $(currentNode).parent(".UYInfoAction").parent(".UYInfoWrapper").children(".UYInfo").children(".UYInfoLink").html();
  var use_emotions = 0;
  InputAmount = 100;
  pageImg = '';
  //url current
  var currentTitle = $(currentNode).parent('.UYInfoAction').next('.replyFromWrapper').children(".replyFrom").children(".fromLink").html();
  pageURL = $(currentNode).parent('.UYInfoAction').next('.replyFromWrapper').children(".replyFrom").children(".fromLink").attr('href');
  title = currentTitle;
  page = $(currentNode).parent('.UYInfoAction').next('.replyFromWrapper').children(".hidePage").html();
  domain = $(currentNode).parent('.UYInfoAction').next('.replyFromWrapper').children(".hideDomain").html();
  in_reply_to_id = $(currentNode).parent('.UYInfoAction').next('.replyFromWrapper').children(".in_reply_to_id").html();
  clickVote = 0;
  veryfyCheck = 0;

  if($tartgetNode.attr("id")=="UYreplySystem"){
    $("#UYreplySystem").remove();
  }
  else{
    $("#UYreplySystem").remove();
    var img_url;
    if(user_id == undefined){
      img_url = "../../../images/photoDefault.png";

      var $UYreplyStr = '<div id="UYreplySystem"><div class="UYReplyPhotoWrapper" style="width:50px;height:50px;float:left;background-image: url('
        + img_url
        + ')"></div><div class="UYreplyContentWrapper"><div class="UYreplyInputFrame"><textarea id="UYreplyInput" name="UYreplyInput" onfocus="if(use_emotions==1){showEmoReply();}" onkeyup="$(\'#UYReplyCurrentAmount\').html(calc_rest($(\'#UYreplyInput\').val(), 1))">@'
        + $replyName
        + ': </textarea></div><div id="UYEmotionReplyPane"></div><div id="UYEmotionReplyBTN" onclick="showEmotionPaneReply()" style="display: none;">表情</div>';

      if(InputAmount > 0)
        $UYreplyStr +=  '<div id="UYReplyLeftNumber"><span id="UYReplyCurrentAmount">'
          + InputAmount
          + '</span><span id="UYReplyTotalAmount">/'
          + InputAmount
          + '</span></div>';


      $UYreplyStr +=  '<div class="UYreplyAction"><a id="UYSubmitReplyBTN" onclick="UYCommentButtonClickAdmin(this, \'reply\');" ><span class="replyBTNText">回复</span></a>'
        + '<div class="clear"></div></div></div><div class="clear"></div></div><div style="height:1px;"></div>';
    }else{
      img_url = profile_img_url; 
      $UYreplyStr = '<div id="UYreplySystem">'
        + '<div class="UYReplyPhotoWrapper" style="width:50px;height:50px;float:left;background-image: url('
        + img_url
        +')"></div>'
        + '<div class="UYreplyContentWrapper"><div class="UYreplyInputFrame" ><textarea id="UYreplyInput" name="UYreplyInput" onfocus="if(use_emotions==1){showEmoReply();}" onkeyup="$(\'#UYReplyCurrentAmount\').html(calc_rest($(\'#UYreplyInput\').val(), 1))">@'
        + $replyName
        + ': </textarea></div><div id="UYEmotionReplyPane"></div><div id="UYEmotionReplyBTN" onclick="showEmotionPaneReply()" style="display: none;">表情</div>';

      if(InputAmount > 0)
        $UYreplyStr += 
          '<div id="UYReplyLeftNumber"><span id="UYReplyCurrentAmount">'
          + InputAmount
          + '</span><span id="UYReplyTotalAmount">/'
          + InputAmount
          + '</span></div>';

      $UYreplyStr += '<div class="UYreplyAction"><a id="UYSubmitReplyBTNConnected" onclick="UYCommentButtonClickAdmin(this, \'reply\');" ><span class="replyBTNTextConnected">回复</span></a>'
        + '<div class="clear"></div></div></div>'
        + '<div class="clear"></div></div><div style="height:1px;"></div>';	
    }

    $InfoWrapperNode.parent().after($UYreplyStr);
    if(user_id!=100){
      $('#UYSubmitReplyBTNConnected').before('<div class="UYChooseConnect"><input type="checkbox" id="UYConnectToSNSReply" checked="checked"/><div class="UYCheckBoxIntro">同步到社交网站</div><div class="clear"></div></div>');
    }
    /*    switch(styleNum){

          case '4':
          if(IE6){
          $("#UYreplyInput").css({"width":DIYWidth-190});
          $("#UYreplySystem").css({"width":DIYWidth-63});
          }else if(IE7){
          $("#UYreplyInput").css({"width":DIYWidth-160});
          $("#UYreplySystem").css({"width":DIYWidth-63});
          }else{
          $("#UYreplyInput").css({"width":DIYWidth-150});
          $("#UYreplySystem").css({"width":DIYWidth-63});
          }
          break;
          default:
          if(IE6&&autoFixWidth){
          $("#UYreplyInput").css({"width":DIYWidth-154});
          $("#UYreplySystem").css({"width":DIYWidth-63});
          }else{
          $("#UYreplyInput").css({"width":DIYWidth-154});
          $("#UYreplySystem").css({"width":DIYWidth-63});
          }
          break;
          }*/

  }
}
function UYCommentButtonClickAdmin(currentNode, type){

  $node = $(currentNode);
  if($node.data('disabled'))
    return;

  if(user_id == undefined){
    UYShowSNS(currentNode, type);
  }
  else{
    if(type == 'comment'){
      if(forceStar!=1){
        UYSubmitInput($node);
      }else{
        if(clickVote!=-1){
          UYSubmitInput($node);

        }else{
          $('.UYVoteItemNoti').html('请在评分后评论');
          $('.UYVoteItemNoti').animate({
            opacity: 'toggle'

          }, 200, function() {
            // Animation complete.
            setTimeout("$('.UYVoteItemNoti').animate({opacity: 'toggle'}, 300, function() {});",3000);
          });
        }
      }
    }else{
      UYSubmitReplyAdmin($node);
    }
  }
}
function UYSubmitReplyAdmin($node){
  if($node.data('executing'))
    return;
  $node.data('executing', true);

  checkState = checkInput($("#UYreplyInput").val());
  if(checkState){
    if(user_id == undefined){
      $("#UYalertNoConnection").css({"display":"none"});
      $("#UYalertNoConnection").fadeIn("fast");
    }else{
      $node.css({"background-color":"#eeeeee","border":"1px solid #b3afaf","cursor":"normal"});
      $node.children(".replyBTNTextConnected").css({"color":"#acacac"});
      $node.children(".replyBTNTextConnected").html("发布中");
      $node.attr("disabled", "true");
      postReplyAdmin($node);
    }
  }else{
    $("#UYCurrentAmount").html("请输入内容");
  }
}
function postReplyAdmin($node){
  var content = $("textarea#UYreplyInput").val();
  var parentComment = $("#UYreplySystem").prevAll(".itemWrapper").first();
  var in_reply_to_id = parentComment.attr("id");

  var postToSNS = $("#UYConnectToSNSReply").attr("checked");

  if(comment_author == undefined){
    comment_author='';
  }
  if(comment_author_email == undefined){
    comment_author_email='';
  }
  if(comment_author_url == undefined){
    comment_author_url='';
  }
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_content/postComment",
    data:{
      page_img: pageImg,
    title: title,
    page_url: pageURL,
    content: content,
    page: page,
    domain: domain,
    user_id: user_id,
    in_reply_to: in_reply_to_id,
    from_type: logins,
    postToSNS: postToSNS,
    comment_author:comment_author,
    comment_author_email:comment_author_email,
    comment_author_url:comment_author_url,
    vote_score:clickVote,
    veryfyCheck:veryfyCheck
    },
    dataType:"json",
    cache:false,
    success: function(data){
      //spam
      var comment_id;
      if(data!='again'&&data!='spam'&&data!='short'){
        var new_entry = buildCommentHTMLPart('0',data,data.from_type,'normalItem');
        $("#messagesContainer").prepend(new_entry);
        $("#UYreplySystem").remove();
        numComments++;
        $("#UYCommentAmount").html(numComments);
        comment_id = data.comment_id;
      }else{
        $node.html("<span class='replyBTNText'>回复频率过快</span>");
        setTimeout('$node.html("<span class=\'replyBTNText\'>回复</span>");$node.removeAttr("disabled");$node.data("disabled",false);$node.data("executing", false)',1000);
      }
      //end
      if(styleNum=='3'){
        $('.replyBTNTextConnected').css({"color":"#fff"});
        $('.replyBTNTextConnected').html('回复');
        $('#UYSubmitReplyBTNConnected').css({"border":"1px solid #29447e","background-color":"#5f78ab","cursor":"pointer","-moz-box-shadow":"0 1px 0 #d9d9d9","-webkit-box-shadow":"0 1px 0 #d9d9d9","box-shadow":"0 1px 0 #d9d9d9"});		  
        $node.removeData('executing');
        $("#UYSubmitReplyBTNConnected").removeAttr("onclick");
        $("#UYSubmitReplyBTNConnected").removeAttr("disabled");
        $("#UYSubmitReplyBTNConnected").attr("onclick",function(){return function(){UYCommentButtonClick(this, 'reply');}});

      }else{
        $('.replyBTNTextConnected').css({"color":"#000"});
        $('.replyBTNTextConnected').html('回复');

        $node.removeData('executing');
        $("#UYSubmitReplyBTNConnected").removeAttr("onclick");
        $("#UYSubmitReplyBTNConnected").removeAttr("disabled");
        $("#UYSubmitReplyBTNConnected").attr("onclick",function(){return function(){UYCommentButtonClick(this, 'reply');}});		  
      }


      /*      $('.UYInfoWrapper').ready( function(){
      //when post reply
      switch(styleNum){
      case '4':
      if(IE6){
      $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"});
      $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
      $('.UYInfoTopBanner').css({"width":(DIYWidth-150)+"px"});
      }else if(IE6&&autoFixWidth){
      $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"});
      $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
      }else{
      $('.UYInfoWrapper').css({"width":(DIYWidth-63)+"px"}); 
      $('.UYInfoWrapperSC').css({"width":(DIYWidth-125)+"px"});
      }
      break;
      default:
      if(IE6&&autoFixWidth){

      $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"}); 
      $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
      $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});
      $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
      }else{
      $('.UYInfoWrapper').css({"width":(DIYWidth-80)+"px"}); 
      $('.UYInfoWrapperSC').css({"width":(DIYWidth-148)+"px"});
      $('.itemWrapper').css({"width":(DIYWidth-10)+"px"});
      $('.itemWrapperSC').css({"width":(DIYWidth-75)+"px"});
      }
      break;	
      }
      }); */

      //spam 
      if(data!='again'&&data!='spam'&&data!='short'){
        //end
        $.post("http://uyan.cc/index.php/youyan_content/postCommentPostWork",
            {
              content: content,
        page: page,
        page_url: pageURL,
        page_img: pageImg,
        domain: domain,
        title: title,
        user_id: user_id,
        from_type: logins,
        postToSNS: postToSNS,
        in_reply_to: in_reply_to_id,
        comment_author:comment_author,
        comment_author_email:comment_author_email,
        comment_author_url:comment_author_url,
        comment_id: comment_id,
        session_name: session_name,
        vote_score:clickVote,
        veryfyCheck:veryfyCheck
            });
      }
    },
    error:function(){
            alert("由于网络不稳定，post 操作失败。");
          }
  });
}




function cancelCurrentReply(node){
  var $node = $(node);
  $('.replyAdminText').html('');
  $node.parent('.replyActionPane').parent('.replyAdminWrapper').remove();

}
function getMoreComment(){
  $(".noMessageState").hide();
  $(".unGetmoreCommentBTN").hide();
  $(".getmoreCommentBTN").hide();
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin/getMoreCommentsByDomain/"+currentMore,
    data:{
      currentMore:currentMore,normalCommentToogle:normalCommentToogle,readyCommentToogle:readyCommentToogle,trashCommentToogle:trashCommentToogle,delCommentToogle:delCommentToogle
    },
    dataType:"json",
    cache:false,
    success: function(data){	
      var this_item= 0;
      currentMore++;
      $.each(data, function(key, val){						
        buildCommentAdmin(key, val,'domain');
        this_item++;
      });
      $(".getmoreCommentBTN").removeAttr("onclick");
      $(".getmoreCommentBTN").attr("onclick",function(){return function(){getMoreComment();}});
      if(currentMore==1&&this_item==0){
        $(".noMessageState").show();
        $(".unGetmoreCommentBTN").hide();
        $(".getmoreCommentBTN").hide();
      }else if(this_item==20){
        $(".noMessageState").hide();
        $(".unGetmoreCommentBTN").hide();
        $(".getmoreCommentBTN").show();					 
      }else{
        $(".noMessageState").hide();
        $(".unGetmoreCommentBTN").show();
        $(".getmoreCommentBTN").hide();						 
      }

    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });
}

function getMorePageComment(page,title){
  if(page!=''){
    $(".noMessageState").hide();
    $(".unGetmoreCommentBTN").hide();
    $(".getmoreCommentBTN").hide();
    $.ajax({
      type:"POST",
      url:"http://uyan.cc/index.php/youyan_admin/getMoreCommentsByPage/"+currentMore,
      data:{
        page:page,currentMore:currentMore
      },
      dataType:"json",
      cache:false,
      success: function(data){
        var this_item= 0;
        currentMore++;
        $.each(data, function(key, val){						
          buildCommentAdmin(key, val,'page');
          this_item++;
        });
        $(".getmoreCommentBTN").removeAttr("onclick");
        $(".getmoreCommentBTN").attr("onclick",function(){return function(){getMorePageComment(page);}});
        if(currentMore==1&&this_item==0){
          $(".noMessageState").show();
          $(".unGetmoreCommentBTN").hide();
          $(".getmoreCommentBTN").hide();
        }else if(this_item==20){
          $(".noMessageState").hide();
          $(".unGetmoreCommentBTN").hide();
          $(".getmoreCommentBTN").show();					 
        }else{
          $(".noMessageState").hide();
          $(".unGetmoreCommentBTN").show();
          $(".getmoreCommentBTN").hide();						 
        }

      },
      error:function(){
              alert("由于网络不稳定,创建失败,请稍候再试。");
            }
    });
  }
}

function getRightLink(page){
  if(page!=''){
    $.ajax({
      type:"POST",
      url:"http://uyan.cc/index.php/youyan_webdata/createShareLink",
      data:{
        page:page
      },
      dataType:"html",
      cache:false,
      success: function(data){			
        boxCreateLink.show();
        $(".createLinkCode").html(data);
      },
      error:function(){
              alert("由于网络不稳定,创建失败,请稍候再试。");
            }
    });
  }
}

function changeToDomain(node){
  $("#hidePageLink").html('');
  var $node = $(node);
  timeArea = 7;
  $(".menuItem").removeClass('currentMenuItem');	
  $node.addClass('currentMenuItem');
  prepareData(timeArea);
  currentMore = 0;
  getMoreComment();
  backTitle('com');
  $('.actionPaneWrapper').hide();

}

function changeToPage(page,title,node,url){
  $("#hidePageLink").html(url);
  var $node = $(node);
  currentPage = page;
  if(page!=''){
    timeArea = 7;
    transData = page;
    type = 'allComment';
    changeData(timeArea,transData,type);
    changeTitle(title,transData,type);	
    $(".menuItem").removeClass('currentMenuItem');
    $node.addClass('currentMenuItem');
    //change comment
    currentMore =0;
    $(".itemWrapper").remove();
    getMorePageComment(page); 
    $('.actionPaneWrapper').show();
  }
}


function buildAccountOrderList(str){
  var map = {
    0: 0,
    1: 0,
    2: 0,
    3: 0,
    4: 0,
    5: 0,
    6: 0,
    7: 0,
    8: 0
  };
  var mapTop = {
    0: 0,
    1: 0,
    2: 0,
    3: 0,
    4: 0,
    5: 0,
    6: 0,
    7: 0,
    8: 0
  };
  var strArr = str.split("_");
  var strMenu = strArr[1];
  var strTop = strArr[0];
  //menu part
  var item = '';
  for(var i = 0; i < strMenu.length; i++){
    var snsId = parseInt(strMenu.substr(i, 1));
    map[snsId] = 1;
    var snsType = SNSTypes[snsId];
    var snsName = SNSTypeToName[snsType];
    item += '<div class="itemListWrapper" id="r' + snsId 
      + '"><a class="menuItem small' + snsType + '" onmouseover="getTools(this,\'menu\')">'
      + snsName + '</a><div class="clear"></div></div>';
  }
  $("#selectedItemsAdd").before(item);

  var unselected_item = '';
  for(var i = 0; i < 9; i++){
    if(map[i] == 0){
      var snsType = SNSTypes[i];
      var snsName = SNSTypeToName[snsType];
      unselected_item += '<div id="r'+ i +'" class="itemListWrapper"><a class="menuItemLeft small'+ snsType +'">'
        + snsName + '</a><div class="addToListBTN" onclick="addToListChange(\'r'+ i + '\',\'small' + snsType + '\',\''
        + snsName + '\',this,\'menu\')"></div><div class="clear"></div></div>';
    }
  }
  $("#unselectItemsAdd").after(unselected_item);
  //top part
  var item = '';
  for(var i = 0; i < strTop.length; i++){
    var snsId = parseInt(str.substr(i, 1));
    mapTop[snsId] = 1;
    var snsType = SNSTypes[snsId];
    var snsName = SNSTypeToName[snsType];
    item += '<div class="itemListWrapper" id="t' + snsId 
      + '"><a class="menuItem small' + snsType + '" onmouseover="getTools(this,\'top\')">'
      + snsName + '</a><div class="clear"></div></div>';
  }
  $("#selectedItemsTopAdd").before(item);

  var unselected_item = '';
  for(var i = 0; i < 9; i++){
    if(mapTop[i] == 0){
      var snsType = SNSTypes[i];
      var snsName = SNSTypeToName[snsType];
      unselected_item += '<div id="t'+ i +'" class="itemListWrapper"><a class="menuItemLeft small'+ snsType +'">'
        + snsName + '</a><div class="addToListBTN" onclick="addToListChange(\'t'+ i + '\',\'small' + snsType + '\',\''
        + snsName + '\',this,\'top\')"></div><div class="clear"></div></div>';
    }
  }
  $("#unselectItemsTopAdd").after(unselected_item);
}

function getTools(node,type){
  var $node = $(node);	
  $(".actionListWrapper").remove();
  $node.after('<div class="actionListWrapper"><div class="delListButton" onclick="delListButton(this,\''+type+'\')"></div><div class="downListButton" onclick="downCurrent(this)"></div><div class="upListButton" onclick="upCurrent(this)"></div><div class="clear"></div></div>');
}

function upCurrent(node){
  var $node = $(node);
  if($node.parent(".actionListWrapper").parent(".itemListWrapper").prev().attr('class')=='itemListWrapper'){
    var $insertNode = $node.parent(".actionListWrapper").parent(".itemListWrapper");
    $id = $insertNode.attr("id");
    $node.parent(".actionListWrapper").parent(".itemListWrapper").prev(".itemListWrapper").before('<div class="itemListWrapper" id="'+$id+'">'+$insertNode.html()+'<div class="clear"></div>');
    $node.parent(".actionListWrapper").parent(".itemListWrapper").remove();
  }
}

function downCurrent(node){
  var $node = $(node);
  if($node.parent(".actionListWrapper").parent(".itemListWrapper").next().attr('class')=='itemListWrapper'){
    var $insertNode = $node.parent(".actionListWrapper").parent(".itemListWrapper");
    $id = $insertNode.attr("id");
    $node.parent(".actionListWrapper").parent(".itemListWrapper").next(".itemListWrapper").after('<div class="itemListWrapper" id="'+$id+'">'+$insertNode.html()+'<div class="clear"></div></div>');
    $node.parent(".actionListWrapper").parent(".itemListWrapper").remove();
  }
}

function delListButton(node,type){
  var $node = $(node);
  var snsList = new Array(9);
  snsList['r1']=new Array("smallSINA","新浪微博");
  snsList['r2']=new Array("smallTENCENT","腾讯微博");
  snsList['r3']=new Array("smallRENREN","人人网");
  snsList['r4']=new Array("smallQQ","QQ空间");
  snsList['r5']=new Array("smallNETEASY","网易微博");
  snsList['r6']=new Array("smallSOHU","搜狐微博");
  snsList['r7']=new Array("smallKAIXIN","开心网");
  snsList['r8']=new Array("smallMSN","MSN");
  snsList['r0']=new Array("smallEMAIL", SNSTypeToName['EMAIL']);
  var snsListTop = new Array(9);
  snsListTop['t1']=new Array("smallSINA","新浪微博");
  snsListTop['t2']=new Array("smallTENCENT","腾讯微博");
  snsListTop['t3']=new Array("smallRENREN","人人网");
  snsListTop['t4']=new Array("smallQQ","QQ空间");
  snsListTop['t5']=new Array("smallNETEASY","网易微博");
  snsListTop['t6']=new Array("smallSOHU","搜狐微博");
  snsListTop['t7']=new Array("smallKAIXIN","开心网");
  snsListTop['t8']=new Array("smallMSN","MSN");
  snsListTop['t0']=new Array("smallEMAIL", SNSTypeToName['EMAIL']);

  var $id = $node.parent(".actionListWrapper").parent(".itemListWrapper").attr("id");
  if(type=='menu'){
    var $addContent = '<div id="'+$id+'" class="itemListWrapper"><a class="menuItemLeft '+snsList[$id][0]+'">'+snsList[$id][1]+'</a><div class="addToListBTN" onclick="addToListChange(\''+$id+'\',\''+snsList[$id][0]+'\',\''+snsList[$id][1]+'\',this,\'menu\')"></div><div class="clear"></div></div>';
    $("#unselectItemsAdd").after($addContent);
  }else{
    var $addContent = '<div id="'+$id+'" class="itemListWrapper"><a class="menuItemLeft '+snsListTop[$id][0]+'">'+snsListTop[$id][1]+'</a><div class="addToListBTN" onclick="addToListChange(\''+$id+'\',\''+snsListTop[$id][0]+'\',\''+snsListTop[$id][1]+'\',this,\'top\')"></div><div class="clear"></div></div>';
    $("#unselectItemsTopAdd").after($addContent);		
  }
  $node.parent(".actionListWrapper").parent(".itemListWrapper").remove();
}

function addToListChange(id,className,cnName,node,type){
  var $node = $(node);
  $node.parent(".itemListWrapper").remove();
  if(type=='menu'){
    $("#selectedItemsAdd").before('<div id="'+id+'" class="itemListWrapper"><a onmouseover="getTools(this,\''+type+'\')" class="menuItem '+className+'">'+cnName+'</a><div class="clear"></div></div>');
  }else{
    $("#selectedItemsTopAdd").before('<div id="'+id+'" class="itemListWrapper"><a onmouseover="getTools(this,\''+type+'\')" class="menuItem '+className+'">'+cnName+'</a><div class="clear"></div></div>');		
  }
}

function changeInstallNav(type,node){
  var $node =$(node);
  $(".installNavi").removeClass("installNaviSelected");
  $node.addClass("installNaviSelected");
  if(type=='plugin'){
    $("#wordpressInstallWrapper").show();
    $("#generalInstallWrapper").hide();
  }else{
    $("#wordpressInstallWrapper").hide();
    $("#generalInstallWrapper").show();	
  }
}

function changeCSSNav(type,node){
  var $node =$(node);
  $(".installNavi").removeClass("installNaviSelected");
  $node.addClass("installNaviSelected");
  if(type=='comment'){
    $("#commentCSSWrapper").show();
    $("#boxCSSWrapper").hide();
    $("#articleCSSWrapper").hide();
  }else if(type=='article'){
    $("#commentCSSWrapper").hide();
    $("#boxCSSWrapper").hide();
    $("#articleCSSWrapper").show();	
  }else{
    $("#commentCSSWrapper").hide();
    $("#boxCSSWrapper").show();
    $("#articleCSSWrapper").hide();
  }
}

function changeInstallPluginNav(type,node){
  var $node =$(node);
  switch(type){
    case 'hotArticle':
      $("#ssoInstallWrapper").hide();
      $("#hotInstallWrapper").hide();
      $("#newInstallWrapper").hide();
      $("#hotArticleInstallWrapper").show();
      $("#newArticleInstallWrapper").hide();
      $("#amountCommentWrapper").hide();
      $("#prePaneForDom").hide();
      $("#currentBreadItem").html("文章热榜");
      $(".navigationInstall").show();
      break;
    case 'newArticle':
      $("#ssoInstallWrapper").hide();
      $("#hotInstallWrapper").hide();
      $("#newInstallWrapper").hide();
      $("#hotArticleInstallWrapper").hide();
      $("#newArticleInstallWrapper").show();
      $("#amountCommentWrapper").hide();
      $("#prePaneForDom").hide();
      $("#currentBreadItem").html("最新文章");
      $(".navigationInstall").show();
      break;
    case 'new':
      $("#ssoInstallWrapper").hide();
      $("#hotInstallWrapper").hide();
      $("#newInstallWrapper").show();
      $("#hotArticleInstallWrapper").hide();
      $("#newArticleInstallWrapper").hide();
      $("#amountCommentWrapper").hide();
      $("#prePaneForDom").hide();
      $("#currentBreadItem").html("最新评论");
      $(".navigationInstall").show();
      break;
    case 'amount':
      $("#ssoInstallWrapper").hide();
      $("#hotInstallWrapper").hide();
      $("#newInstallWrapper").hide();
      $("#hotArticleInstallWrapper").hide();
      $("#newArticleInstallWrapper").hide();
      $("#amountCommentWrapper").show();
      $("#prePaneForDom").hide();
      $("#currentBreadItem").html("评论记数");
      $(".navigationInstall").show();
      break;
    case 'all':
      $("#ssoInstallWrapper").hide();
      $("#hotInstallWrapper").hide();
      $("#newInstallWrapper").hide();
      $("#hotArticleInstallWrapper").hide();
      $("#newArticleInstallWrapper").hide();
      $("#amountCommentWrapper").hide();
      $("#prePaneForDom").show();
      $("#currentBreadItem").html("");
      $(".navigationInstall").hide();
      break;
    case 'sso':
      $("#ssoInstallWrapper").show();
      $("#hotInstallWrapper").hide();
      $("#newInstallWrapper").hide();
      $("#hotArticleInstallWrapper").hide();
      $("#newArticleInstallWrapper").hide();
      $("#amountCommentWrapper").hide();
      $("#prePaneForDom").hide();
      $("#currentBreadItem").html("单点登录(SSO)");
      $(".navigationInstall").show();	
      break;
    default:
      $("#ssoInstallWrapper").hide();
      $("#hotInstallWrapper").show();
      $("#newInstallWrapper").hide();
      $("#amountCommentWrapper").hide();
      $("#hotArticleInstallWrapper").hide();
      $("#newArticleInstallWrapper").hide();
      $("#prePaneForDom").hide();
      $("#currentBreadItem").html("评论热榜");
      $(".navigationInstall").show();
      break;		
  }
}

function changeSettingBTNstate(node,name){
  var $node =$(node);
  $node.html("已保存");
  setTimeout("$('#"+name+"').html('保存设置');",1000);
}

function submitImage(upload_field){
  　var filename = upload_field.value;
  　upload_field.form.submit();
  　$('#upload_status').html("上传中...");
  　upload_field.disabled = true;
  　return true;
}

function callBackUpload(state,path){
  if(state=='sucess'){
    $(".uploadLoadImage").attr("src",path);   
    $("#upload_status").html("上传成功");	
    $("#uploadImage").removeAttr('disabled');
  }else{
    if(path=='noImage'){
      $("#upload_status").html("上传失败,仅限上传图片");	
    }else{
      $("#upload_status").html("上传失败,请检查图片格式及大小");
    }
    $("#uploadImage").removeAttr('disabled');
  }
}
function saveAmount(type){
  var $node = $("#"+type);
  if($node.val()=='')return;
  var itemAmount = $node.val();
  //getHead
  var showHeadState = $("input[name='"+type+"Radio']:checked").val();
  var showHeadNum=0;
  if(showHeadState == 1){
    showHeadNum = 1;
  }
  else
    showHeadNum = 0;
  switch(type){
    case "hotCommentSetting":
      var commentHotWidthState = $("input[name='commentHotWidthRadio']:checked").val();
      var configWidth;
      if(commentHotWidthState == 1){
        configWidth = parseInt($("#commentHotWidthRadioPixel").val());
      }
      else
        configWidth = -1;
      var changePeriod = $("#selectDateCommentLast").val();
      break;
    case "timeCommentSetting":
      var commentTimeWidthState = $("input[name='commentTimeWidthRadio']:checked").val();
      var configWidth;
      if(commentTimeWidthState == 1){
        configWidth = parseInt($("#commentTimeWidthRadioPixel").val());
      }
      else
        configWidth = -1;  
      var changePeriod;
      break;
    case "timeArticleSetting":
      var articleTimeWidthState = $("input[name='articleTimeWidthRadio']:checked").val();
      var configWidth;
      if(articleTimeWidthState == 1){
        configWidth = parseInt($("#articleTimeWidthRadioPixel").val());
      }
      else
        configWidth = -1; 
      var changePeriod;
      break;
    default:
      var articleHotWidthState = $("input[name='articleHotWidthRadio']:checked").val();
      var configWidth;
      if(articleHotWidthState == 1){
        configWidth = parseInt($("#articleHotWidthRadioPixel").val());
      }
      else
        configWidth = -1;  
      var changePeriod = $("#selectDateArticleLast").val();
      break;		
  }
  //get width for list
  var strValueA = $("#hotCommentTitleSetting").val()+"}_{"+$("#timeCommentTitleSetting").val()+"}_{"+$("#hotArticleTitleSetting").val()+"}_{"+$("#timeArticleTitleSetting").val();

  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/savePluginSetting",
    data:{
      itemAmount:itemAmount,
    type:type,
    showHeadNum:showHeadNum,
    configWidth:configWidth,
    strValueA:strValueA,
    changePeriod:changePeriod
    },
    dataType:"html",
    cache:false,
    success: function(data){	

    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });	
}
function addSpam(){
  $('.spamAlert').hide();
  spamPane.toggle();
}
function checkIp(addr){
  var reg = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
  if (reg.exec(addr) != null)
  {
    if (RegExp.$1<0 || RegExp.$1>255) return false;
    if (RegExp.$2<0 || RegExp.$2>255) return false;
    if (RegExp.$3<0 || RegExp.$3>255) return false;
    if (RegExp.$4<0 || RegExp.$4>255) return false; 
  }else{             
    return false;
  }
  return true;
}
function addBlackItem(){	
  var $value = $("#spamValue").val();
  var $type = $('#selectSpam').val();
  $('.spamAlert').hide();
  if($value==''||$type==''){
    $('.spamAlert').html('请检查Email地址格式');
    $('.spamAlert').show();
    return;
  }
  if($type=='email'){
    var $state =  $value.match(/^[\w][\w+\.\_]*@\w+(\.\w+)*\.[A-z]{2,}$/g);
    if($state == null){
      $('.spamAlert').html('请检查Email地址格式');
      $('.spamAlert').show();
      return;
    }
  }
  if($type=='ip'){
    if(!checkIp($value)){
      $('.spamAlert').html('请检查ip地址格式');
      $('.spamAlert').show();
      return;
    }
  }

  switch($type){
    case 'email':
      $showType = 'Email';
      break;
    case 'user_id':
      $showType = '用户名';
      break;
    default:
      $showType = 'IP';
      break;
  }
  $.ajax({
    type:"POST",
  url:"http://uyan.cc/index.php/youyan_admin_edit/saveBlackList",
  data:{
    type:$type,value:$value
  },
  dataType:"html",
  cache:false,
  success: function(data){

  },
  error:function(){
          alert("由于网络不稳定,创建失败,请稍候再试。");
        }
  });	
  var $insertContent = '<div class="blackListItem"><div class="blackValue">'+$value+'</div><div class="blackType">'+$showType+'</div><div class="blackControl" onclick="delSpam(this)">删除</div><div class="clear"></div></div>';
  $('.blackListContainer').append($insertContent);
  $("#spamValue").val('');
}
function delSpam(node){
  var $node = $(node);
  var $value = $node.parent('.blackListItem').children('.blackValue').html();
  var $type = $node.parent('.blackListItem').children('.blackType').html();	
  switch($type){
    case 'Email':
      $type = 'email';
      break;
    case 'IP':
      $type ='ip'
        break;
    case 'SNS用户':
      $type ='user_id'
        break;
    default:
      $type ='user_name'
        break;		
  }
  $node.html("删除中");
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/delBlackSpam",
    data:{
      value:$value,type:$type
    },
    dataType:"html",
    cache:false,
    success: function(data){	
      $node.parent('.blackListItem').remove();
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });		
}

function addToBlack(node,user_id,comment_id){
  var $node = $(node);
  $node.html('...');
  $node.removeAttr('onclick');
  $node.css({"cursor":"default"});
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/userAddToBlack",
    data:{
      user_id:user_id
    },
    dataType:"html",
    cache:false,
    success: function(data){	
      $node.html('已添加');
      delReplyBlack(node,comment_id);
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });		
}
function addToBlackEmail(node,user_name,user_email,user_domain,comment_id){
  var $node = $(node);
  $node.html('...');	
  $node.removeAttr('onclick');
  $node.css({"cursor":"default"});
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/userAddToBlack",
    data:{
      user_email:user_email,user_name:user_name,user_domain:user_domain
    },
    dataType:"html",
    cache:false,
    success: function(data){	
      $node.html('已添加');
      delReplyBlack(node,comment_id);
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });		
}
function delReplyBlack(node,comment_id){
  $delnode = $(node);
  $.ajax({
    type:"POST",
    url:"../../youyan_content/delComment/"+comment_id,
    dataType:"json",
    success: function(reply_data){
      if(delCommentToogle!=1){
        $delnode.parent(".UYInfo").parent(".UYInfoWrapper").parent("").remove();
      }else{
        $delnode.parent('.UYInfo').parent('.UYInfoWrapper').parent("").attr("class","itemWrapper delItem");
      }	  
    },
    error:function(){
            alert("网络线路问题，暂时无法删除评论，请稍候再试");
          }
  });
}
function saveSpam(){
  $value = $('#spamWords').val();	
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_admin_edit/saveBlackWords",
    data:{
      value:$value
    },
    dataType:"html",
    cache:false,
    success: function(data){	
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });
}
function changeTypeState(typeId){
  var $divpart = $('#'+typeId+'Type');
  var $checkpart = $('#'+typeId+'Check');
  var radioState = $("input[name='"+typeId+"']:checked").val();
  if(radioState == 1){
    $divpart.removeClass('defaulTypeColor');
    $divpart.addClass(typeId);
  }else{
    $divpart.removeClass(typeId);
    $divpart.addClass('defaulTypeColor');	
  }
  switch(typeId){
    case 'readyComment':
      if(radioState == 1){
        readyCommentToogle = 1;
      }else{
        readyCommentToogle = 0;
      }		
      break;
    case 'trashComment':
      if(radioState == 1){
        trashCommentToogle = 1;
      }else{
        trashCommentToogle = 0;
      }			
      break;		
    case 'delComment':
      if(radioState == 1){
        delCommentToogle = 1;
      }else{
        delCommentToogle = 0;
      }			
      break;
    default:
      if(radioState == 1){
        normalCommentToogle = 1;
      }else{
        normalCommentToogle = 0;
      }			
      break;
  }
  currentMore = 0;
  $('.itemWrapper normalItem').remove();
  $('.itemWrapper readyItem').remove();
  $('.itemWrapper delItem').remove();
  $('.itemWrapper trashItem').remove();
  $('.itemWrapper').remove();
  getMoreComment();	
}
function changeCommentNavi(type,node){
  if(type=='comment'){
    $("#trendTabContainer").hide();
    $("#commentTabContainer").show();

  }else{
    $("#trendTabContainer").show();
    $("#commentTabContainer").hide();
    prepareData(7);
  }
  var $node = $(node); 
  $('.newCommentsTab').removeClass('currentNewComments');
  $node.addClass('currentNewComments');	
}
function checkDomainVerify(curDomain,uid){
  if(curDomain==''||uid=='')return;
  $('.introducdUploadTestBTN').html("验证中");
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_login/checkDomainFile",
    data:{
      curDomain:curDomain,uid:uid
    },
    dataType:"html",
    cache:false,
    success: function(data){
      if(data=='yes'){
        $('.introducdUploadTestBTN').remove();
        $('.introduceUploadTextAfter').html("<div class='confirmVerify'>已通过验证</div>");
      }else{
        $('.introduceUploadTextAfter').html("无法找到文件，请确定已经上传文件");
        $('.introducdUploadTestBTN').html("重新验证");
      }
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });	

}
function resetPass(){
  var $email = $('#enterEmail').val();
  if($email=='')return;
  $('.submitReset').html('加载中');
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_login/resetPassword",
    data:{
      email:$email
    },
    dataType:"html",
    cache:false,
    success: function(data){					
      if(data =='yes'){
        $(".backPassContainer").html("<div class='backPassTitle'>密码重置链接已经发送至邮箱:</div><div class='backPassEmail'>"+$email+"</div>");	
      }else if(data =='no'){
        $(".backPassIntro").html("无此邮箱，请重试。");
      }
      $('.submitReset').html('重设密码');
    },
    error:function(){
            alert("由于网络不稳定,创建失败,请稍候再试。");
          }
  });		
}
function resetPassDone($email){
  var $passOne = $('#passWordA').val();
  var $passTwo = $('#passWordB').val();
  if($passOne==''||$passTwo==''||$passTwo !=$passOne)return;
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_login/resetPasswordDone",
    data:{
      email:$email,password:$passOne
    },
    dataType:"html",
    cache:false,
    success: function(data){					
      $(".backPassContainer").html("<div class='backPassTitle'>已成功重置密码</div><div class='backActionPane'><a class='backLinkdone' href='http://uyan.cc'>返回登录</a><div class='clear'></div></div>");
    },
    error:function(){
            alert("由于网络不稳定,访问失败,请稍候再试。");
          }
  });		
}
function createBakXml(){
  $('.exportDataBTN').html('生成中..');
  $('.exportDataBTN').removeAttr('onclick');
  $.ajax({
    type:"POST",
    url:"http://uyan.cc/index.php/youyan_webdata/bakupData",
    dataType:"html",
    cache:false,
    success: function(data){				
      $('.exportDataBTN').html('已完成');
      $('.bakupDataIntro').show();
    },
    error:function(){
            alert("由于网络不稳定,访问失败,请稍候再试。");
          }
  });	
}
function fclick(){
  obj = document.getElementById('t_file');	
}
function readyToUpload(upload_field){
  $('#showpath').show();
  $('.importDataBTN').hide();
  $('#startXML').show();
  var filename = upload_field.value;
  //upload_field.disabled = true;
  return 0;
}
function callBackXml($state,$error,$amount){
  if($state=='process'){
    $(".bakupDataIntroImport").show();
    $(".bakupDataIntroImport").html("导入中，依据数据量数据将在数分钟内导入完成，请稍候。");
    $("#startXML").hide();
    $("#processXML").show();
  }else if($state=='sucess'){
    $(".bakupDataIntroImport").show();
    $(".bakupDataIntroImport").html("已经成功导入数据"+$amount+"条。");
    if($error=='sameComment'){
      $(".bakupDataIntroImport").html("已经成功导入数据"+$amount+"条，部分评论重复，未导入。如遇到问题请邮件至help@uyan.cc");
    }
    if($error=='wrongDomain'){
      $(".bakupDataIntroImport").html("已经成功导入数据"+$amount+"条，部分评论于您的域名不相符，未予导入。如遇到问题请邮件至help@uyan.cc");	
    }

    $("#startXML").hide();
    $("#processXML").hide();
    $(".importDataBTN").show();
    $("#showpath").hide();
  }
}
function showXMLFormate(){
  if($(".showDataFormat").html()=="查看XML格式"){
    $(".showDataFormat").html("隐藏样例");
  }else{
    $(".showDataFormat").html("查看XML格式");
  }
  $(".formateShow").toggle();
}

function sumbitSSO(){
  var currentSSO = $(".ssoInput").val();
  if(currentSSO == OP_SSO_NAME){
    $('.ssoButton').val("没有改变");
    setTimeout("$('.ssoButton').val('提交');",2000);
  }
  else{
    $('.ssoButton').val("提交中");
    $.post("youyan_admin_edit/submitSSO", {sso_name : currentSSO, domain : domain}, function(data){
      if(data == 1){
        $('.ssoButton').val("提交成功");
        $("#inputSSOAlert").html('');
        setTimeout("$('.ssoButton').val('提交');",2000);
      }
      else{
        $("#inputSSOAlert").html("（该sso标识名不符合规范或已被占用）");
      }
    });
  }
}
function changeTopBTNState(style){
	if(style==1){
		$("#topBTNStyleContainer").show();
		$("#topBTNRankContainer").show();
	}else{
		$("#topBTNStyleContainer").hide();
		$("#topBTNRankContainer").hide();		
	}
}

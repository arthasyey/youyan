var page_a_links = document.getElementsByTagName("A");
var longStrURL = '';
var longStrId = '';

var link_id_url_map  = {};


for(i=0;i<page_a_links.length;i++){
  var attrLink = page_a_links[i].getAttribute("uyan_identify");
  var amount = 0;
  if(attrLink=='true'){
    var hrefLink = page_a_links[i].href;
    var trimURL = getTrimmedURL(hrefLink);
    var curDomain = document.domain;
    var hrefLink = curDomain+"_"+trimURL;

    link_id_url_map[i] = hrefLink;
    /*longStrURL = longStrURL+"{_}"+hrefLink;
      longStrId= longStrId+"{_}"+i;*/
  }
}

//console.log(link_id_url_map);

$.getJSON("http://uyan.cc/index.php/youyan_comment_amount?callback=?",
    {link_id_url_map : link_id_url_map}, function(data){
//                                                         console.log(data);
                                                         $.each(data, function(cur_id, cur_value){
 //                                                          console.log(cur_id);
 //                                                          console.log(cur_value);
                                                             page_a_links[cur_id].innerHTML= cur_value + "  条评论";
                                                         });
                                                       }
    );	


function getTrimmedURL(url){
  loc = url.indexOf("#");
  if(loc != -1)
    url = url.substr(0, loc);

  var length = url.length;
  loc = url.indexOf("//");

  if(loc != -1)
    url = url.substr(loc+2);
  var lastStr = url.substr(-1);
  if(lastStr=='/'){
    url = url.substr(0,url.length-1);
  }
  return url;
}

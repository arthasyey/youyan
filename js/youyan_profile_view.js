function showWebpages(){
  $("#messagesContainer").css({"display":"none"});
  $("#websitesContainer").css({"display":"block"});
}

function backToProfile(){
  $("#messagesContainer").css({"display":"block"});
  $("#websitesContainer").css({"display":"none"});		
}

function UYupProfile(currentNode){
  var parentNode = $(currentNode).parent();
  // If it's current not up'ed, 
  if(parentNode.children(".UYUpIcon").length!=0){
    parentNode.children(".UYUpIcon").removeClass('UYUpIcon').addClass('UYUpIconColor');
    var $upAmountNode = parentNode.children(".UYUpInfo").children(".UYupAmount");
    var $upAmount = parseInt($upAmountNode.html());
    $upAmountNode.html($upAmount+1);

    UYIncreaseCntProfile(currentNode, 'up');

    //down cancel
    if(parentNode.children(".UYDownIconColor").length!=0){
      parentNode.children(".UYDownIconColor").removeClass('UYDownIconColor').addClass('UYDownIcon');
      $downAmountNode = parentNode.children(".UYDownInfo").children(".UYdownAmount");
      $downAmount = $downAmountNode.html();
      $downAmountNode.html($downAmount-1);

      UYDecreaseCntProfile(currentNode, 'down');
    }
  }
  // If it's currently already up'ed, unmark the up...
  else{
    parentNode.children(".UYUpIconColor").removeClass('UYUpIconColor').addClass('UYUpIcon');
    var $amount = parseInt(parentNode.children(".UYUpInfo").children(".UYupAmount").html());
    parentNode.children(".UYUpInfo").children(".UYupAmount").html($amount-1);	

    UYDecreaseCntProfile(currentNode, 'up');
  }
}

function UYdownProfile(currentNode){
  var parentNode = $(currentNode).parent();
  // If it's current not down'ed, 
  if(parentNode.children(".UYDownIcon").length!=0){
    parentNode.children(".UYDownIcon").removeClass('UYDownIcon').addClass('UYDownIconColor');
    var $downAmountNode = parentNode.children(".UYDownInfo").children(".UYdownAmount");
    var $downAmount = parseInt($downAmountNode.html());
    $downAmountNode.html($downAmount+1);	

    UYIncreaseCntProfile(currentNode, 'down');

    //down cancel
    if(parentNode.children(".UYUpIconColor").length!=0){
      parentNode.children(".UYUpIconColor").removeClass('UYUpIconColor').addClass('UYUpIcon');
      var $upAmountNode = parentNode.children(".UYUpInfo").children(".UYupAmount");
      var $upAmount = $upAmountNode.html();
      $upAmountNode.html($upAmount-1);

      UYDecreaseCntProfile(currentNode, 'up');
    }
  }
  // If it's currently already down'ed, unmark the down...
  else{
    parentNode.children(".UYDownIconColor").removeClass('UYDownIconColor').addClass('UYDownIcon');
    var $amount = parseInt(parentNode.children(".UYDownInfo").children(".UYdownAmount").html());
    parentNode.children(".UYDownInfo").children(".UYdownAmount").html($amount-1);	

    UYDecreaseCntProfile(currentNode, 'down');
  }
}

function UYIncreaseCntProfile(currentNode, up_or_down){
  $comment_id = $(currentNode).parent().parent().parent().attr("id");
  //console.log('comment id: ' + $comment_id);
  $.ajax({
    type:"POST",
    url:"youyan_content/increaseCnt/" + up_or_down,
    data:{
      user_id: user_id,
    comment_id: $comment_id,
	domain:domain
    },
    cache:false,
    dataType: 'text',
    success:function(data){
      //console.log('increase ' + up_or_down + ' succeed');
    },
    error:function(){
            //alert("increase failed");
          }
  });	
}

function UYDecreaseCntProfile(currentNode, up_or_down){
  $comment_id = $(currentNode).parent().parent().parent().attr("id");
  //console.log('comment id: ' + $comment_id);

  $.ajax({
    type:"POST",
    url:"youyan_content/decreaseCnt/" + up_or_down,
    data:{
      user_id: user_id,
    comment_id: $comment_id,
	domain:domain
    },
    cache:false,
    dataType: 'text',
    success:function(data){
      //console.log('decrease ' + up_or_down + ' succeed');
    },
    error:function(){
            //alert("decrease failed");
          }
  });	
}

function UYreplyProfile(currentNode){
  $InfoWrapperNode = $(currentNode).parent().parent();
  $tartgetNode = $InfoWrapperNode.parent().next();
  if($tartgetNode.attr("id")=="UYreplySystem"){
    $("#UYreplySystem").remove();
  }
  else{
    $("#UYreplySystem").remove();
    $UYreplyStr = '<div id="UYreplySystem"><textarea id="UYreplyInput" name="UYreplyInput" onfocus="showEmoReply()" onkeyup="$(\'#UYReplyCurrentAmount\').html(calc_rest($(\'#UYreplyInput\').val()))"></textarea><div id="UYEmotionReplyPane"></div><div id="UYEmotionReplyBTN" onclick="showEmotionPaneReply()" style="display: none;">表情</div>'
      + '<div id="UYReplyLeftNumber"><span id="UYReplyCurrentAmount">280</span><span id="UYTotalAmount">/280</span></div>'
      + '<div class="UYreplyAction"><a id="UYSubmitReplyBTN" onclick="UYSubmitReply()" ></a>'
      + '<div class="clear"></div></div></div>';
    $name = $InfoWrapperNode.children(".UYInfo").children(".UYInfoLink").html();
    $html = $InfoWrapperNode.children(".UYInfo").html();
    $html_clean = removeTag($html);
    //$text = $InfoWrapperNode.children(".UYInfo").text();

    $InfoWrapperNode.parent().after($UYreplyStr);
    $("#UYEmotionReplyPane").html($emotionReplySTR);

    $("#UYreplyInput").html("//@"+$html_clean);
    setCursorPosition('UYreplyInput', 0);
  }
}

function UYSubmitReply(){
  checkState = checkInput($("#UYreplyInput").val());
  if(checkState){
    if(ConnectAmount==0){
      $("#UYalertNoConnection").css({"display":"none"});
      $("#UYalertNoConnection").fadeIn("fast");
    }else{
      postReply();
    }
  }else{
    $("#UYCurrentAmount").html("请输入内容");
  }
}

function postReply(){
  var content = $("textarea#UYreplyInput").val();
  in_reply_to_id = $("#UYreplySystem").prev().attr("id");
  //console.log("in reply to: " + in_reply_to_id);
  //console.log("content: " + content);

  $.ajax({
    type:"POST",
    url:"youyan_content/postReply",
    data:{
      content: content,
    page: page,
    domain: domain,
    user_id: user_id,
    in_reply_to: in_reply_to_id
    },
    dataType:"json",
    cache:false,
    success: function(data){
      var new_entry = buildCommentEntry(data);
      $(".UYEmptyComment").after(new_entry);

      $("#UYreplySystem").remove();

      $('.UYInfoWrapper').ready( function(){
        switch(styleNum){
          case 1:
            $('.UYInfoWrapper').css({"width":DIYWidth-98}); //for default style
            break;
          default:
            $('.UYInfoWrapper').css({"width":DIYWidth-65});//for style1
            break;
        }
      });
      //console.log("Post Repy Successful");
    },
    error:function(){
            alert("由于网络不稳定，post 操作失败。");
          }
  });
}

<div class="UYPane">
	<div class="UYTitle"><div></div>
     	<a class="sortBTN" onclick="showSortMenu()"><span id="UYTitleTXT"></span> (<span id="UYCommentAmount"></span>)</a>
     	<div class="recommendWrapper">
		<?php if($_SESSION[$session_name]['use_community']==1){?>
		<a class="pageSocial" onclick="UYShowCommunity();">社区</a>
		<?php }?>
		
		<a class="pageDown" onclick="pageVoteDowns('up')"><img src="../../images/downDig.png" /></a><a class="pageUp" onclick="showShareMenu('up')"><img class="pageUpImage" src="../../images/upDig.png" />顶</a><div class="clear"></div></div>
		<div class="recommendAmount">共有<span id="favPageAmount"></span>人喜欢</div>
    <div class="clear"></div></div>
    <div class="UYLoginSerious">
        <div class="clear"></div>
    </div>
	<?php if($_SESSION[$session_name]['showScoreItem']==1){?>
	<div class="UYLoginRateWrapper">
		<a class="UYVoteStar" id="UYVoteStar1" onmouseover="UYChangeStar(1)" onmouseout="UYClearStar()" onclick="UYVoteStar(1);"></a>
		<a class="UYVoteStar" id="UYVoteStar2" onmouseover="UYChangeStar(2)" onmouseout="UYClearStar()" onclick="UYVoteStar(2);"></a>
		<a class="UYVoteStar" id="UYVoteStar3" onmouseover="UYChangeStar(3)" onmouseout="UYClearStar()" onclick="UYVoteStar(3);"></a>
		<a class="UYVoteStar" id="UYVoteStar4" onmouseover="UYChangeStar(4)" onmouseout="UYClearStar()" onclick="UYVoteStar(4);"></a>
		<a class="UYVoteStar" id="UYVoteStar5" onmouseover="UYChangeStar(5)" onmouseout="UYClearStar()" onclick="UYVoteStar(5);"></a>
		<div class="UYVoteItemNoti">评分成功</div>
		<div class="clear"></div>
	</div>
	<?php }?>
	<textarea name="comment" cols="100%" rows="8" id="UYCommentCheckBoxS" style="display:block;width:0;height:0;margin:0;padding:0; resize:none;outline:none;border:none;"></textarea>
	<div class="UYInputWrapper" id="UYInputReady">
		<div id="UYinputPhoto"></div>
		<div class="UYInputAllPane">
			<div class="UYInputFrame" id="UYInputPane"  >				
				<textarea name='submitUY' id='submitUY' onblur = 'showIntro();' onfocus='hideIntro();if(use_emotions==1){showEmo();}' onkeyup="$('#UYCurrentAmount').html(calc_rest($('#submitUY').val(), 0));" onkeydown="if (event.ctrlKey && event.keyCode == 13){UYCommentButtonClick(document.getElementById('UYSubmitInputBTNConnected'), 'comment');}" >我想说...</textarea>
				<div id="UYEmotionBTN" onclick="showEmotionPane()">表情</div>
				<div id="UYEmotionPane"></div>
				<div id='UYLeftNumber'><span id="UYCurrentAmount"></span><span id="UYTotalAmount"></span></div>
			</div>
			<div class="UYMoreFunctionsWrapper"></div>
			<div class="UYLeftArrow"></div>                    	
		</div>
		<div class="clear"></div>
	</div>
	<div class="UYLiteProfileWrapper"></div>
	<div class="UYEmptyBoxWrapper"></div>
	<div style="clear:both;font-size:0;"></div>
	<div class="UYShowList">
		<div style="clear:both;font-size:0;"></div>
		<div class = "UYEmptyComment" style = "display:none"></div>
		<div class = "UYEmptyCommentEnd" style = "display:none"></div>
	</div>
	<a class="UYMoreItemsWrapper" onclick="getComments()">查看更多<img src="../images/arrowDownMore.png" class="blueArrowDown" /></a>
	<div id="Pagination" class="pagination"></div>
	<div id="UYFromPower"><a href="http://uyan.cc" target="_blank">Powered by 友言</a></div><div class="clear"></div>
</div>

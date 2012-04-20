<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../../../js/jquery.boxy.js"></script>
<script language="javascript" src="../../../js/youyan_view.js"></script>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../../../js/excanvas.min.js"></script><![endif]-->

<script language="javascript" src="../../../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="../../../js/jquery.flot.min.js"></script>
<script language="javascript" type="text/javascript" src="../../../js/jquery.flot.selection.min.js"></script>
<script language="javascript" src="../../../js/youyan_main_view.js"></script>

<link href="../../../css/global.css" rel="stylesheet" type="text/css" />
<link href="../../../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../../../css/admin.css" rel="stylesheet" type="text/css" />
<link href="../../../css/main.css" rel="stylesheet" type="text/css" />
<div class="mainWrapper">
	<div class="categoryMenuTopWrapper" style="display:none;">
    	<div class="categoryMenuTopContainer">
			<div id="siteNameContainer" class="siteNameContainer">uyan.cc </div>
            <a class="menuTopButton">设置过滤</a>
            <a class="menuTopButton">个性趋势</a>
            <a class="menuTopButton menuTopCurrent">资讯阅读</a>
            <div class="clear"></div>
        </div>
    </div>
	<div id="mainContainer" class="contentContainer">
		<div class="leftWrapper">
			<div class="nameWrapperPane">
				<img src="<?php echo $_SESSION['login']['youyan']['profile_img'];?>" class="UYPhoto" />
				<div class="nameTrueWrapper"><?php echo $_SESSION['login']['youyan']['show_name'];?></div>
				<div class="clear"></div>
			</div>

			<div class="amountWrapper">
            	<a class="amountItemWrapper">
                	<div class="amountNum "><?php echo $userData['n_comments'];?></div>
                    <div class="amountIntro">评论数</div>
                </a>
                <a class="amountItemWrapper">
                	<div class="amountNum"><?php echo $userData['n_up_received'];?></div>
                    <div class="amountIntro">被喜欢</div>
            	</a>
            </div>
			<div class="commentSites">
            	<div class="leftPaneTitle">评论最多的网站</div>
                <div class="sitesWrapper">
				<?php foreach($likeWeb as $row){?>
                	<a class="siteItem" target="_blank" href="http://<?php echo $row->domain;?>"><?php echo $row->domain;?></a>
				<?php }?>
                </div>            
            </div>
			
		</div>
		<div class="rightWrapper">
			<div class="topCommentNavi">
				<a onclick="changeMainNavi('news',this)" id="newLink" class="newCommentsTab currentNewComments">新鲜事</a>
				<a onclick="changeMainNavi('noti',this)" id="atLink" class="newCommentsTab">@我的回复</a>	
				<a onclick="changeMainNavi('like',this)" id="notiLink" class="newCommentsTab">提醒</a>				
				<div class="clear"></div>
			</div>
			<div id="newsMainContainer">
			
			
			<!-- all in on list-->
<?php /*?>				<?php foreach($notiNews as $row){?>
				<?php 	if($row->domain_name!=''&&$row->domain_name!=NULL){
							$domainName = $row->domain_name;
						}else{
							$domainName = $row->domain;
						}
						if($row->default_profile!='../images/photoDefault.png'){
							$profileImage = $row->default_profile;
						}else{
							$profileImage = 'http://uyan.cc/images/photoDefault.png';
						}						
						?>
					<div class="itemWrapper normalItem">
					
					<a target="_blank" href="http://<?php echo $row->domain;?>" style="background:url(<?php echo $profileImage;?>) 0 0 no-repeat" class="UYPhoto"></a>
					<div class="UYInfoWrapper"><div class="UYInfo"><a target="_blank" class="UYInfoLink" href="http://<?php echo $row->domain;?>"><?php echo $domainName;?></a><br><span class="contentWrapper"><a class="newArticleLink" href="<?php echo $row->page_url;?>"><?php echo $row->page_title;?></a><a href="<?php echo $row->page_url;?>" target="_blank" class="readMoreIcon">阅读更多</a><div class="clear"></div></span></div><div class="replyFromWrapper"><div class="UYSendTime"><?php echo $row->time;?></div><div class="clear"></div></div></div><div class="clear"></div></div>
				<?php }?><?php */?>
				
			</div>
			<div id="notiMainContainer">
			<?php
				$i =0;
				foreach($reply as $row){
				if($row->replyContent!=''){
					$i++;
				?>
				<div class="itemWrapper normalItem">
					<a target="_blank" href="http://<?php echo $row->link;?>" style="background:url(<?php echo $row->profile_img;?>) 0 0 no-repeat" class="UYPhoto"></a>
					<div class="UYInfoWrapper"><div class="UYInfo"><a target="_blank" class="UYInfoLink" href="http://<?php //echo $row->domain;?>"><?php echo $row->show_name;?></a><br><span class="contentWrapper"><a class="newArticleLinkUN" >回复:<?php echo $row->replyContent;?></a><a href="<?php echo $row->link;?>" target="_blank" class="readMoreIcon">查看页面</a><div class="clear"></div></span></div><div class="replyFromWrapper"><div class="UYSendTime"><?php echo $row->c_time;?></div><div class="clear"></div></div></div><div class="clear"></div></div>
			<?php }}?>
			<?php if($i==0){?>
				<div class="noReplyIntro">似乎暂时还没有人回复，多评论评论吧</div>
			<?php }?>
			</div>
			<div id="notiFavContainer">
			<?php
				$i =0;
				foreach($likeNoti as $row){				
					$i++;
			?>
				<div class="itemWrapper normalItem">
					<a target="_blank" href="http://<?php echo $row->link;?>" style="background:url(<?php echo $row->profile_img;?>) 0 0 no-repeat" class="UYPhoto"></a>
					<div class="UYInfoWrapper"><div class="UYInfo"><a target="_blank" class="UYInfoLink" href="http://<?php //echo $row->domain;?>"><?php echo $row->show_name;?></a><br><span class="contentWrapper"><img src="/images/heart.png" class="heartIcon" /><a class="newArticleLinkUN" >喜欢您的评论</a><a href="<?php echo $row->link;?>" target="_blank" class="readMoreIcon">查看页面</a><div class="clear"></div></span></div><div class="replyFromWrapper"><div class="UYSendTime"><?php echo $row->c_time;?></div><div class="clear"></div></div></div><div class="clear"></div>
				</div>				
			<?php }?>
			<?php if($i==0){?>
				<div class="noReplyIntro">似乎暂时还没有人顶您的评论，多评论评论吧</div>
			<?php }?>				
			</div>
		</div>
		<div class="clear"></div>
	</div>
	
	
</div>
<script language="javascript">
	<?php if(isset($currentSelect)&&$currentSelect=='noti'){?>
		changeMainNavi('reply');
		$('.newCommentsTab').removeClass('currentNewComments');
		$('#atLink').addClass('currentNewComments');
	<?php }?>
</script>
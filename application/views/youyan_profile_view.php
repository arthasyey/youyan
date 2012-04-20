<script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../js/jquery.boxy.js"></script>
<script language="javascript" src="../js/youyan_profile_view.js"></script>
<script language="javascript" src="../js/youyan_basic_view.js"></script>
<script language="javascript" src="../js/youyan_view.js"></script>
<script type="text/javascript">
user_id = 2;
</script>
<link href="../css/global.css" rel="stylesheet" type="text/css" />
<link href="../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../css/profile.css" rel="stylesheet" type="text/css" />

<div class="contentWrapper">
	<div class="contentContainer">
		<div class="leftWrapper">
        	<div class="amountWrapper">
            	<a class="amountItemWrapper nolineAmount" onClick="showWebpages()">
                	<div class="amountNum ">2</div>
                    <div class="amountIntro">关注网站</div>
                </a>
                <div class="amountItemWrapper">
                	<div class="amountNum">21</div>
                    <div class="amountIntro">评论数</div>
            	</div>
            </div>   
            <div class="commentSites">
            	<div class="leftPaneTitle">Vincent评论最多的网站</div>
                <div class="sitesWrapper">
                	<a class="siteItem" style="background:url(../images/googleplus.png) 0 0 no-repeat">Icon Search Engine</a>
                    <a class="siteItem" style="background:url(../images/iconfinder.png) 0 0 no-repeat">Google+</a>
                    <a class="siteItem" style="background:url(../images/googleReader.png) 0 0 no-repeat">Google reader</a>
                </div>            
            </div>
        </div>
        <div class="rightWrapper">
        	<div class="basicNameWrapper">
           		<div class="nameContent">Vincent Niu</div>
                <div class="snsWrapper">
                	<a class="SINA_profile"></a>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>                            
            </div>
            <div class="basicRelevantContent"></div>
        	<div class="leaveMessage"></div>
            
            <!-- Basic information-->
            <div id="messagesContainer">
            
            
            <!-- Generate content -->
            	<div class="UYShowList">
                    <div class = "UYEmptyComment" style = "display:none"></div>
                </div>
            <?php
			 foreach($query_result as $row){
				$arrayComments = get_object_vars($row);
  			    ?>	
  				<div class="itemWrapper" id="3">
    				<div class="UYPhoto" style="background:url('<?php echo $arrayComments['sina_profile_img'];?>') 0 0 no-repeat"></div>
                	<div class="UYInfoWrapper">
                    	<div class="UYInfo">
                        	<a href="#" class="UYInfoLink"><?php echo $arrayComments['user_name'];?></a>: <?php echo $arrayComments['content'];?>
                        </div>
    					<div class="UYInfoAction">
                        	<div class="UYSendTime"><?php echo $arrayComments['time'];?></div>
                            
    						  <?php if($arrayComments['sina_id'] != 0)
                                    echo '<a href="http://weibo.com/'.$arrayComments['sina_id'].'" class="UYFromType" id="SinaType" target="_blank"></a>';
  									if($arrayComments['renren_id'] != 0)
    								echo '<a href="http://renren.com/profile.do?id='.$arrayComments['renren_id'].'" class="UYFromType" id="RenrenType" target="_blank"></a>';
  									if($arrayComments['kaixin_id'] != 0)
    								echo '<a href="http://www.kaixin001.com/home/?uid='.$arrayComments['kaixin_id'].'" class="UYFromType" id="KaixinType" target="_blank"></a>';
 									if($arrayComments['kaixin_id'] != '')
   									echo '<a href="http://t.qq.com/'.$arrayComments['kaixin_id'].'" class="UYFromType" id="TencentType" target="_blank"></a>';?>
							<a class="UYReply" onClick="UYreplyProfile(this)">回复</a>
                            <a class="UYReplyIcon" onClick="UYreplyProfile(this)"></a>
							<a class="UYDownInfo" onClick="UYdownProfile(this)" >踩(<span class="UYdownAmount"><?php echo $arrayComments['n_down'];?></span>)</a>
                            <a class="UYDownIcon" onClick="UYdownProfile(this)"></a>
							<a class="UYUpInfo" onClick="UYupProfile(this)"><span class="UYupAmount"><?php echo $arrayComments['n_up'];?></span> 顶</a>
                            <a class="UYUpIcon" onClick="UYupProfile(this)"></a>
                            <div class="clear"></div>
						</div>
                        <!-- new -->
                        <div class="replyFromWrapper">
                            <div class="replyFrom">评论于 <a class="fromLink" href="<?php echo $arrayComments['page'];?>">问答类网站的矛盾与可行之道-月光博客</a></div>
                            <div class="hidePage"><?php print_r($arrayComments);?></div>
                            <div class="clear"></div>
                        </div>
                        
                        
                    </div>
                    <div class="clear"></div>
                </div>           
			 <?php } ?>
			 
<!--                <div id="Pagination" class="pagination">
                    <div class="pagination">
                    <span class="current prev">前一页 </span>
                    <span class="current">1</span>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <span>...</span>
                    <a class="ep" href="#">6</a>
                    <a class="next" href="#"> 后一页</a>
                    <div class="clear"></div>
                    </div>
                </div>-->
             </div>
             <!-- Websites -->
             <div id="websitesContainer">
             	<div class="backWrapper">
                	<a class="backBTN" onClick="backToProfile()">返回</a>
                    <div class="clear"></div>
                </div>
                <div class="dotLine"></div>
             	<div class="webSitesWrapper">
                	<div class="siteLinkWrapper">
                		<a class="siteLink">Icon Search Engine</a>
                        <div class="clear"></div>
                    </div>
                    <div class="siteRelavantWrapper">发布评论3条</div>
                    <div class="clear"></div>
                </div>
             </div>      
         </div>    
    	<div class="clear"></div>   
    </div>
    
</div>



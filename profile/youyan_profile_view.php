<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UYan-SNS profile</title>
<script language="javascript" src="js/jquery.boxy.js"></script>
<script language="javascript" src="js/youyan_profile_view.js"></script>
<script language="javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript">

</script>
<link href="css/global.css" rel="stylesheet" type="text/css" />
<link href="css/boxy.css" rel="stylesheet" type="text/css" />
<link href="css/profile.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topNvaigation"></div>
<div class="contentWrapper">
	<div class="contentContainer">
		<div class="leftWrapper">
        	<div class="amountWrapper">
            	<a class="amountItemWrapper nolineAmount" onclick="showWebpages()">
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
                	<a class="siteItem" style="background:url(images/googleplus.png) 0 0 no-repeat">Icon Search Engine</a>
                    <a class="siteItem" style="background:url(images/iconfinder.png) 0 0 no-repeat">Google+</a>
                    <a class="siteItem" style="background:url(images/googleReader.png) 0 0 no-repeat">Google reader</a>
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
            <?php 
			for($i=0;$i<10;$i++){
			?>	
  				<div class="itemWrapper" id="3">
    				<div class="UYPhoto" style="background:url('images/photo.png') 0 0 no-repeat"></div>
                	<div class="UYInfoWrapper">
                    	<div class="UYInfo">
                        	<a href="#" class="UYInfoLink">Vincent Niu</a>:同意！还是在前面加一句：找好人。 //@张宏江:这才是基础科研管理的要点：“给足钱、配备人、少评估、不干预”。Give me money, leave me alone. //@谢幸Xing：自然基金委政策局局长韩宇的报告中提到，王选对真正的人才建议采取12字的政策“给足钱、配备人、少评估、不干预”。
                        </div>
    					<div class="UYInfoAction"> 
                        	<div class="UYSendTime">1小时前</div>
    						<div class="UYFromType" id="SINAType">新浪微博</div>
							<a class="UYReply" onclick="UYreply(this)">回复</a>
                            <a class="UYReplyIcon" onclick="UYreply(this)"></a>
							<a class="UYDownInfo" onclick="UYdown(this)" >踩(3)</a>
                            <a class="UYDownIcon" onclick="UYdown(this)"></a>
							<a class="UYUpInfo" onclick="UYup(this)">顶(0)</a>
                            <a class="UYUpIcon" onclick="UYup(this)"></a>
                            <div class="clear"></div>
						</div>
                        <!-- new -->
                        <div class="replyFromWrapper">
                            <div class="replyFrom">评论于 <a class="fromLink">问答类网站的矛盾与可行之道-月光博客</a></div>
                            <div class="clear"></div>
                        </div>
                        
                        
                    </div>
                    <div class="clear"></div>
                </div>            
            <?php 
       		}
			?> 
                <div id="Pagination" class="pagination">
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
                </div>
             </div>
             
             <!-- Websites -->
             <div id="websitesContainer">
             	<div class="backWrapper">
                	<a class="backBTN" onclick="backToProfile()">返回</a>
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
</body>
</html>



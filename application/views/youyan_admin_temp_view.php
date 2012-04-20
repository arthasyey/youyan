<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../../../js/jquery.boxy.js"></script>
<script language="javascript" src="../../../js/youyan_view.js"></script>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../../../js/excanvas.min.js"></script><![endif]-->
<script language="javascript" src="../../../js/youyan_admin_view.js"></script>
<script language="javascript" src="../../../jquery.ui/jquery-1.4.2.min.js"></script>
<!--<script language="javascript" src="js/jquery.pagination.js"></script>-->
<script language="javascript" type="text/javascript" src="../../../js/jquery.flot.min.js"></script>
<script language="javascript" type="text/javascript" src="../../../js/jquery.flot.selection.min.js"></script>

<script language="javascript">
var domain;
var UYUserID = 25;
var currentMore = 0;
var currentPage = '<?php echo $pageInfo['page'];?>';
</script>

<link href="../../../css/global.css" rel="stylesheet" type="text/css" />
<link href="../../../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../../../css/admin.css" rel="stylesheet" type="text/css" />
<div class="contentWrapper">

	<!--menu-->
    <div class="categoryMenuTopWrapper">
    	<div class="categoryMenuTopContainer">
            <div class="siteNameContainer" id="siteNameContainer"><?php echo $_SESSION['showDomain'];?> - <span class="articleManageRight">部分页面管理权限</span></div>
            <a class="menuTopButton menuTopCurrent" >评论管理</a>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="contentContainer" id="basicContainer">
        <div class="leftWrapper">        
           <a class="menuItem currentMenuItem" title="wow">
           		<div class="articleTitle"><?php echo mb_strimwidth($pageInfo['page_title'],0,29,'..','utf-8');?></div>
                <div class="articleTime"><?php echo $pageInfo['time'];?></div>
           </a>
                      
  	    <?php  echo ($pagination);?>
        </div>

        <div class="rightWrapper">
            <div class="dataWrapper">
                <div class="dataTitle"><div class="dataLeftTitleWrapper"><span class="dataLeftTitleTrace">评论与回访统计</span><a href="#" class="linkTo" ></a><div class="clear"></div></div><a onclick="changeData(all,'<?php echo $pageInfo['page'];?>','allComment');">全部时间</a><a onclick="changeData(365,'<?php echo $pageInfo['page'];?>','allComment');">最近一年</a><a onclick="changeData(90,'<?php echo $pageInfo['page'];?>','allComment');">最近六个月</a><a onclick="changeData(90,'<?php echo $pageInfo['page'];?>','allComment');">最近三个月</a><a onclick="changeData(30,'<?php echo $pageInfo['page'];?>','allComment');">最近一个月</a><a onclick="changeData(7,'<?php echo $pageInfo['page'];?>','allComment');">最近七天</a><div class="clear"></div></div>

                <div id="placeholder" style="width:680px;height:160px;"></div>
            </div>


            <!-- Basic information-->
            <div id="messagesContainer">
            <div class="messageTitleWrapper"><div class="TitleInBox">最新评论</div><div class="alertIcon">3</div><div class="clear"></div></div>
            <!-- Generate content -->

    

<script language="javascript">
	getMorePageComment('<?php echo $pageInfo['page'];?>');
	changeData(7,'<?php echo $pageInfo['page'];?>','allComment');
</script>      
<div id="afterMessage"></div>
<div class="noMessageState" style="display:none;" >还有没来自用户的评论</div>		
<div class="unGetmoreCommentBTN"  style="display:none;" >没有更多评论了</div>	
<a class="getmoreCommentBTN" onclick="getMorePageComment('<?php echo $pageInfo['page'];?>');">查看更多</a></div></div>
<div class="clear"></div>
</div>    
</div>
<div id="createLinkPane">
	<a class="close" href="#" id="closediag"></a>
	<div class="introCreateLinkTitle">请将此链接发送给编辑，此链接具有编辑当前页面的权限。</div>
    <div class="createLinkCode" contentEditable='true'>http://www.uyan.cc/index.php/youyan_admin_temp/index/PXIEOW312IESC/</div>
</div>

<script id="source" language="javascript" type="text/javascript">
$("#createLinkPane").ready
(
  function()
  {
	boxCreateLink=new Boxy($("#createLinkPane"), {
		modal: false,
		show: false
	});	
  }
);

</script>




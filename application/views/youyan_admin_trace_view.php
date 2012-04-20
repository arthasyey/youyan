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
var UYUserID;
</script>
<link href="../../../css/global.css" rel="stylesheet" type="text/css" />
<link href="../../../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../../../css/admin.css" rel="stylesheet" type="text/css" />

<div class="contentWrapper">
	<!--menu-->
    <div class="categoryMenuTopWrapper">
    	<div class="categoryMenuTopContainer">
            <div class="siteNameContainer" id="siteNameContainer"><?php echo $_SESSION['showDomain'];?> <?php if($verify==0){echo '<span class="verifyState">[请验证域名所属，在插入评论框代码后将自动验证]</span>';				
        }else if($verify==2){echo '<a class="verifyState" href="http://uyan.cc/index.php/youyan_check_domain">[点击此处验证域名所属]</a>';}?></div>
            <a class="menuTopButton" href="/index.php/youyan_admin_edit">安装与设置</a>
            <a class="menuTopButton menuTopCurrent" >统计与分析</a>
            <a class="menuTopButton" href="/index.php/youyan_admin/index/">评论管理</a>
            <div class="clear"></div>
        </div>
    </div>    
    <div class="contentContainer" id="basicContainer">    
        <div class="leftWrapper">
			<a class="adminLeftMenuBTN currentLeftMenu">页面分析</a>
            <a class="adminLeftMenuBTN" href="/index.php/youyan_admin_trace_user/index/" >用户分析</a>
            <a class="adminLeftMenuBTN" href="/index.php/youyan_admin_trace_comment/index/" >评论分析</a>
            <a class="adminLeftMenuBTN" href="/index.php/youyan_admin_trace_sns/index/" >各社交网站回访</a>
        </div>
        <div class="rightWrapper">
        	<div id="pageAnalytics">
		     <div class="dataWrapper">
                <div class="dataTitle"><div class="dataLeftTitleTrace">全部页面</div><a id="changeDataAll" onclick="prepareData('all','<?php echo $_SESSION['showDomain'];?>')">全部时间</a><a id="changeDataYear" onclick="prepareData(365,'<?php echo $_SESSION['showDomain'];?>')">最近一年</a><a id="changeDataSix" onclick="prepareData(183,'<?php echo $_SESSION['showDomain'];?>')">最近六个月</a><a id="changeDataThree" onclick="prepareData(91,'<?php echo $_SESSION['showDomain'];?>')">最近三个月</a><a id="changeDataMonth" onclick="prepareData(30,'<?php echo $_SESSION['showDomain'];?>')">最近一个月</a><a id="changeDataSeven" onclick="prepareData(7,'<?php echo $_SESSION['showDomain'];?>')">最近七天</a><div class="clear"></div></div>

                <div id="placeholder" style="width:680px;height:160px;"></div>
            </div>
            <!--huge-->
            <div class="checkTable">
            	<div class="firstLineTable"><div class="checkNum"></div><div class="checkTitleUp">页面名称</div><div class="checkComment">评论量</div><div class="checkTrace">回访量</div><div class="clear"></div></div>
                <div class="checkItem"><div class="checkNumAll">0</div><a class="checkTitleAll" href="javascript:prepareData(7,'<?php echo $_SESSION['showDomain'];?>');backTitle('<?php echo $_SESSION['showDomain'];?>','page');">全部页面</a><div class="checkComment"><?php echo $domainTrace[0]->n_comments;?></div><div class="checkTrace"><?php echo $domainTrace[0]->n_comments_all;?></div><div class="clear"></div></div>                
                <?php 
					$numItem = 1;
				foreach($pageTrace as $row){?>
            	<div class="checkItem"><div class="checkNum"><?php echo $numItem++;?></div><a class="checkTitle" href="javascript:changeData(7,'<?php echo $row->page;?>','page');changeTitle('<?php echo $row->page_title;?>','<?php echo $row->page;?>','page');"><?php echo $row->page_title;?></a><div class="checkComment"><?php echo $row->n_comments;?></div><div class="checkTrace"><?php echo $row->traceamount;?></div><div class="clear"></div></div>
                <?php }?>         
            	<div class="clear"></div>
            </div>            
            <?php echo $pagination;?>
        </div>

        </div>
        <div class="clear"></div>
    </div>    
</div>
<script id="source" language="javascript" type="text/javascript">
	$(".dataWrapper").ready(
		function(){
			prepareData(7,'<?php echo $_SESSION['showDomain'];?>');
		});
</script>
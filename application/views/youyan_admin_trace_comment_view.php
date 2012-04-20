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
        	<div class="leftMenuWrapper">
            <a class="adminLeftMenuBTN" href="/index.php/youyan_admin_trace_user/index/" >用户分析</a>
            <a class="adminLeftMenuBTN currentLeftMenu"  >评论分析</a>
            <a class="adminLeftMenuBTN" href="/index.php/youyan_admin_trace_sns/index/" >各社交网站回访</a>
            </div>            
            <div class="leftAnalyticsWrapper">
            <div class="amountContainer">
                <a class="amountSingle" onclick="showWebpages()" title="社交影响力=评论人数*10+评论数">
                    <div class="amountNum spIntro" title="社交影响力=评论人数*10+评论数"><?php echo 10*$basic_domain[0]->n_comments+$basic_domain[0]->n_comments;?></div>
                    <div class="amountIntro" title="社交影响力=评论人数*10+评论数">社交影响力</div>
                </a>
                <a class="amountSingle" onclick="showWebpages()">
                    <div class="amountNum "><?php echo $basic_domain[0]->n_users;?></div>
                    <div class="amountIntro">评论人数</div>
                </a>
                <a class="amountSingle" onclick="showWebpages()">
                    <div class="amountNum "><?php echo $basic_domain[0]->n_pages;?></div>
                    <div class="amountIntro">评论页面数</div>
                </a>
                <a class="amountSingle" onclick="showWebpages()">
                    <div class="amountNum "><?php echo $basic_domain[0]->n_comments;?></div>
                    <div class="amountIntro">累计评论数</div>
                </a>
                <div class="clear"></div>
            </div>   
        
            
        
            <div class="kindHearted leftcube">
                <div class="leftPaneTitle">热心评论者</div>
                <?php if(isset($fav_user[0])&&$fav_user[0]!=''){?>
                <div class="heartWrapper"><a class="photoWrapper" id="heartPhoto" target="_blank" href="#" style="background:url(<?php echo $fav_user[0]->profile_img;?>) 0 0 no-repeat;"></a><div class="nameWrapper"><a class="nameHeart" target="_blank" href="#"><?php echo $fav_user[0]->show_name;?></a><div class="nameIntro">评论<?php echo $fav_user[0]->c;?>条</div></div><div class="clear"></div></div>
                <?php }else{?>
                <div class="noMessageState">网站暂时没有热心评论者</div>
                <?php }?>
            </div>
          <?php //print_r($fav_user);?>
            <?php if(!empty($fav_user)){?>

<script language="javascript" type="text/javascript">

<?php 
$sns_array=array("sina_id","renren_id","tencent_id","qq_id","kaixin_id","sohu_id","neteasy_id","douban_id");
$change_array = array("SINA","RENREN","TENCENT","QQ","KAIXIN","SOHU","NETEASY","DOUBAN");
$from_type = 'SINA';
for($i=0;$i<=7;$i++){
  if(($fav_user[0]->$sns_array[$i])!=''&&($fav_user[0]->$sns_array[$i])!=0){ 
    $from_type = $change_array[$i];
	//$from_type example SINA
    break;
  }
}
?>
$fromTypeLink = SNSTypeToPrefix['<?php echo $from_type;?>']+"<?php $userSendType = strtolower($from_type)."_id"; echo $fav_user[0]->$userSendType;?>";
$("#heartPhoto").attr("href",$fromTypeLink);
$(".nameHeart").attr("href",$fromTypeLink);
</script>
            <?PHP }?>
            <div class="kindHearted leftcube">
                <div class="leftPaneTitle">最近评论者</div>
                <div class="relavantWrapper">                
<?php $n = 0;
$strList  = ',';
foreach($visited_user as $row){
	if(!stripos($strList,$row->show_name)){
		$strList = $strList.$row->show_name.',';
	
	?>
      <div class="personWrapper" id="<?php echo 'v_'.$n;?>">
         <a class="headPhoto" target="_blank" href="#" style="background:url(<?php echo $row->profile_img;?>) 0 0 no-repeat;"></a>
          <a class="nameWrapper" target="_blank" href="#"><?php echo $row->show_name;?></a>
      </div>
      
	<script language="javascript" type="text/javascript">					
  $fromTypeLink = SNSTypeToPrefix['<?php echo $row->from_type;?>']+"<?php $userSendType = strtolower($row->from_type)."_id"; echo getTargetID($row,$userSendType);?>";
$("#v_<?php echo $n;?>").children('.headPhoto').attr("href",$fromTypeLink);									
$("#v_<?php echo $n;?>").children('.nameWrapper').attr("href",$fromTypeLink);
	</script>

<?php if($n++>6)break;}}
if($n==0){?>
                        <div class="noMessageState">还有没来自用户的评论</div>
                <?php }?>
                    <div class="clear"></div>
                </div>
            </div>
			<div class="commentSites leftcube">
                <div class="leftPaneTitle">评论最多的社交网站</div>
                <div class="sitesWrapper">
<?php $SNSArray = array("新浪微博,SINA"=>$basic_domain[0]->n_sina_comments,"人人网,RENREN"=>$basic_domain[0]->n_renren_comments,"腾讯微博,TENCENT"=>$basic_domain[0]->n_tencent_comments,"QQ空间,QQ"=>$basic_domain[0]->n_qq_comments,"搜狐微博,SOHU"=>$basic_domain[0]->n_sohu_comments,"网易微博,NETEASY"=>$basic_domain[0]->n_neteasy_comments,"开心网,KAIXIN"=>$basic_domain[0]->n_kaixin_comments);
arsort($SNSArray);
$i = 0;
foreach( $SNSArray as $key => $row){
  $key = explode(',',$key);
  echo '<div class="sitesFromWrapper"><a class="siteItem '.$key[1].'Small" >'.$key[0].'</a><div class="viewMostSite">'.$row.'</div><div class="clear"></div></div>';
  if($i++>=4)
    break;
}
?>          </div>
        </div>

        </div>
        </div>
        <div class="rightWrapper">
        	<div id="pageAnalytics">
			<?php if($verify!=1){?>
				<div class="noMessageUser">验证域名后在此处显示评论趋势</div>
			<?php }else{?>
		     <div class="dataWrapper">
             <span id="hidePageLink" style="display:none;"></span>
                <div class="dataTitle"><div class="dataLeftTitleWrapper"><span class="dataLeftTitleTrace">全部评论</span><a href="#" target="_blank" class="linkTo" ></a><div class="clear"></div></div><a id="changeDataAll" onclick="prepareData('all')">全部时间</a><a id="changeDataYear" onclick="prepareData(365)">最近一年</a><a id="changeDataSix" onclick="prepareData(183)">最近六个月</a><a id="changeDataThree" onclick="prepareData(91)">最近三个月</a><a id="changeDataMonth" onclick="prepareData(30)">最近一个月</a><a id="changeDataSeven" onclick="prepareData(7)">最近七天</a><div class="clear"></div></div>

                <div id="placeholder" style="width:680px;height:160px;"></div>
            </div>
			<?php }?>
            <!--huge-->
            <div class="checkTable">
            	<div class="firstLineTable"><div class="checkNum"></div><div class="checkTitleUp">评论内容</div><div class="checkComment">评论者</div><div class="checkTrace">回访量</div><div class="clear"></div></div>
                <div class="checkItem"><div class="checkNumAll">0</div><a class="checkTitleAll" href="javascript:prepareData(7,'<?php echo $_SESSION['showDomain'];?>');backTitle('comment');">全部评论</a><div class="checkComment"></div><div class="checkTrace"><?php if($domainTrace[0]->traceamount==NULL){echo 0;}else{echo $domainTrace[0]->traceamount;}?></div><div class="clear"></div></div>            
                <?php 
					$numItem = 1;
				foreach($commentTrace as $row){?>
            	<div class="checkItem"><div class="checkNum"><?php echo $numItem++;?></div><a class="checkTitle forCommentCheckTitle" href="javascript:changeLink('<?php echo $row->page_url;?>');changeData(7,'<?php echo $row->comment_id;?>','comment');changeTitle('<?php echo $row->content;?>','<?php echo $row->comment_id;?>','comment');"><?php echo $row->content;?></a><div class="checkComment" ><?php echo $row->show_name;?></div><div class="checkTrace"><?php if($row->traceamount==NULL){echo 0;}else{echo $row->traceamount;}?></div><div class="clear"></div></div>
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
<?php 
//fix 360
function getTargetID($row,$strforlinkb){
	switch($strforlinkb){
		case "renren_id":
			return $row->renren_id;
		break;
		case "tencent_id":
			return $row->tencent_id;
		break;
		case "qq_id":
			return $row->qq_id;
		break;
		case "kaixin_id":
			return $row->kaixin_id;
		break;
		case "sohu_id":
			return $row->sohu_id;
		break;
		case "neteasy_id":
			return $row->neteasy_id;
		break;
		case "douban_id":
			return $row->douban_id;
		break;
		default:
			return $row->sina_id;
		break;
	}
	
}?>
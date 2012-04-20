<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hot comment</title>
<link href="../../../css/youyan_style3.css" rel="stylesheet" type="text/css" />
<link href="../../../css/youyan_hot_style3.css" rel="stylesheet" type="text/css" />
<link href="../user_css/comment/<?php echo $_REQUEST['domain'];?>.css" rel="stylesheet" type="text/css" />
<style >
#UYreplySystem{margin:0;}
</style>
<script language="javascript" src="../../../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../easyXDM/easyXDM.min.js"></script>
<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../../../js/youyan_view.js"></script>
<script language="javascript" src="../../../js/youyan_list_view.js"></script>
<!-- new-->
<script type="text/javascript">
commentStyle = <?php echo $config['commentStyle'];?>;
digName = '<?php echo $config['digName'];?>';
digDownName = '<?php echo $config['digDownName'];?>';
delStyle = <?php echo $config['delStyle'];?>;
descWord = '<?php echo $config['descWord'];?>';
mailNotify = <?php echo $config['mailNotify'];?>;
defaultSort = <?php echo $config['defaultSort'];?>;
if(defaultSort == 0)
  defaultSort = 'time';
else
  defaultSort = 'hotness';


numLimit = <?php echo $config['numLimit'];?>;
styleNum = '<?php echo $config['styleNum'];?>';
account_order = '<?php echo $config['account_order'];?>';
numCommentsPerPage = <?php echo $config['numCommentsPerPage'];?>;
anon_word = '<?php echo $config['anon_word'];?>';
anon_url = '<?php echo $config['anon_url'];?>';
domain_name = '<?php echo $config['domain_name'];?>';
default_profile = '<?php echo $config['default_profile'];?>';
commentHotAmount = '<?php echo $config['commentHotAmount'];?>';
commentTimeAmount = '<?php echo $config['commentTimeAmount'];?>';
commentHotHead = '<?php echo $config['commentHotHead'];?>';
commentTimeHead = '<?php echo $config['commentTimeHead'];?>';
commentTimeWidth = '<?php echo $config['commentTimeWidth'];?>';
commentHotWidth = '<?php echo $config['commentHotWidth'];?>';
periodExist = '<?php echo $config['commentHotPeriod'];?>';
<?php 
$titleStr = $config['listTitle'];
$titleArr = explode('}_{',$titleStr);
$titleCommentHot = $titleArr[0];
$titleCommentTime = $titleArr[1];
$titleArticleHot = $titleArr[2];
$titleArticleTime = $titleArr[3];
?>
profile_img_url = default_profile;
curSort = defaultSort;
//temp data
rankType = '<?php echo $rank_type;?>';
if(rankType=='time'){
	photoState =commentTimeHead;
	width = commentTimeWidth;
	if(width == -1)
	width = '100%';
}else{
	photoState =commentHotHead;	
	width = commentHotWidth;
	if(width == -1)
	width = '100%';
}
</script>
 <?php if($config['styleNum']==''||$config['styleNum']==NULL){$config['styleNum']=3;}?>



<script type="text/javascript">
SNSTypeToName['EMAIL'] = anon_word;
SNSTypeToBase['EMAIL'] = anon_url;
domain = '<?php echo $domain;?>';
window.onload=function(){
  docReadyFunc();
};
</script>
<!--end-->
</head>
<body>
<?php if($rank_type=='time'){?>
<div class="UYHotlistTitle"><?php echo $titleCommentTime;?></div>
<?php }else{?>
<div class="UYHotlistTitle"><?php echo $titleCommentHot;?></div>
<?php }?>
<div class="UYCommentList">

</div>

</body>
</html>

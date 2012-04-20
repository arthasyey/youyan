<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../../../js/jquery.boxy.js"></script>
<script language="javascript" src="../../../js/youyan_admin_view.js"></script>
<script language="javascript" src="../../../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../js/jquery.boxy.js"></script>
<link href="../../../css/global.css" rel="stylesheet" type="text/css" />
<link href="../../../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../../../css/admin.css" rel="stylesheet" type="text/css" />
<div class="contentWrapper">
	<div class="contentContainer contentContainerOut">
		<div class="contentTitle">管理您的网站</div>
        
        <div class="contentTableTop"><div class="urlContanter">URL</div><div class="commentsContainer">评论数</div><div class="viewContainer">功能</div><div class="clear"></div></div>
<?php $noConfig = 0;$item_id = 0;
		foreach($domainContent as $row){
			if($row->domain!=''){?>
			
		<div class="contentTableLine" id="<?php echo $item_id;?>">
			<a class="urlContanter" onclick="getAdmin('<?php echo $row->domain;?>');"><?php echo $row->domain;?> (<span style="text-decoration:underline">查看</span>)</a>			<?php if($row->verified!='2'){?>
			<div class="commentsContainer amountContainer"><?php if($row->verified=='0'){echo '安装代码后自动验证';}else{echo $row->n_comments;}?></div>
			<?php }else{?>
			<a class="commentsContainer amountContainer" style="cursor:pointer;" onclick="getAdminCheck('<?php echo $row->domain;?>');">请上传验证文件到服务器</a>
			<?php }?>
			
			<a class="viewContainer" onclick="hideURL('<?php echo $row->domain;?>','<?php echo $item_id;?>');">删除</a><div class="clear"></div>
		</div>
		
 <?php $item_id++;}}
	if($item_id==0){
 	echo '<div id="0" class="contentTableLine"><div class="urlContanter">您还没有添加可以管理的网站</div><div class="commentsContainer amountContainer"></div><a class="viewContainer" ></a><div class="clear"></div></div>';
	}
 ?>
        <div class="contentTableBottom"><div class="urlContanter">合计</div><div class="commentsContainer" id="sumAmount">0</div><div class="viewContainer"></div><div class="clear"></div></div> 
        
        <div id="currentLineID"></div>
    </div>
    <script language="javascript" type="text/javascript">
		var $totalAmount = 0;
		$(".amountContainer").each(function(){
			$amount = parseInt($(this).html());
			if(!isNaN($amount)){
				$totalAmount +=$amount;
			}								   
		});
		$("#sumAmount").html($totalAmount);
	</script>
</div>

<div id="delPane">
<a class="close" href="#" id="closediag"></a>
<div class="loginTitlePane">确认删除<span class="alertDel" id="chooseToDEL"></span>？</div>
<div class="delIntroduce">如果<span class="alertDel"></span>不是您添加的域名或者您不再需要这套管理系统请选择删除</div>
<div class="loginAfterPane">
    <a class="delBTNPane" onclick="submitDEL()" id="delConfirm">删除</a><a class="delBTNPane" onclick="boxDel.hide();">取消</a><div class="clear"></div>
</div>
</div>

<script language="javascript" type="text/javascript">
$("#delPane").ready
(
  function()
  {
	boxDel=new Boxy($("#delPane"), {
		modal: false,
		show: false
	});	
  }
);
//showEditFirst();
</script>

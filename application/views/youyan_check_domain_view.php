<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../../../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../js/jquery.boxy.js"></script>
<script language="javascript" src="../../../js/youyan_admin_view.js"></script>
<link href="../../../css/global.css" rel="stylesheet" type="text/css" />
<link href="../../../css/boxy.css" rel="stylesheet" type="text/css" />
<link href="../../../css/admin.css" rel="stylesheet" type="text/css" />
<div class="contentWrapper">
	<!--menu-->
    <div class="categoryMenuTopWrapper">
    	<div class="categoryMenuTopContainer">
            <div class="siteNameContainer" id="siteNameContainer"><?php echo $_SESSION['showDomain'];
				if($verify==2){
					echo '<span class="verifyState">[请验证域名所属]</span>';
				}else if($verify==0){
					echo '<span class="verifyState">[请验证域名所属，在插入评论框代码后将自动验证]</span>';
				}				
				?>
			</div>
            <a class="menuTopButton" href="/index.php/youyan_admin_edit">安装与设置</a>
            <a class="menuTopButton" href="/index.php/youyan_admin_trace_user/index/" >统计与分析</a>
            <a class="menuTopButton" href="/index.php/youyan_admin/index/">评论管理</a>
            <div class="clear"></div>
        </div>
    </div>
	<!-- introduce-->
	<div class="introduceuploadWrapper">
		<div class="introduceUpload">请上传文件到网站根目录中，以验证管理权限。</div>
		<div class="introduceUploadText">（根目录指能可通过 http://您网站的域名/[验证文件名].html 访问到文件的位置）</div>
		<div class="introduceLink"><a href="http://uyan.cc/index.php/youyan_download_check" target="_blank">下载验证文件</a></div>
		<?php if($verify!=1){?>
		<div class="introduceUploadTextAfter">在传好文件后点击</div>
		<a class="introducdUploadTestBTN" onclick="checkDomainVerify('<?php echo $_SESSION['showDomain'];?>','<?php echo $_SESSION['uid'];?>')">验证权限</a>
		<?php }else{?>
		<div class="introduceUploadTextAfter"></div>
		<div class='confirmVerify'>已通过验证</div>
		<?php }?>
	</div>	
</div>

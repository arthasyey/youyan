<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>testPage</title>
<script language="javascript" src="../../../js/global.js"></script>
<script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript">
	masterID = 10;
	function commentEmail(){
		$.ajax({
    		type:"POST",
    		url:"youyan/commentEmail",
    		data:{
     			masterID:masterID
   			},
    		success: function(data){
				alert(data);
            },
    		cache:false,
    		error:function(){
      			alert('ajax失败');
    		}
  		});
	}
</script>
<link href="../css/global.css" rel="stylesheet" type="text/css" />
<link href="../css/boxy.css" rel="stylesheet" type="text/css" />
</head>
<body>
<a style="cursor:pointer" onClick="commentEmail()">Check email and send</a>
<?php echo $master_arr['nick'].'您好:<br/><br/>您的网站有32条新评论，请登录您的网站，或在<a href="http://www.uyan.cc/" target="_blank">友言管理页面</a>中查看。<br/><br/>祝您使用愉快！<br/>友言客服<br/><span style="color:#666;font-size:14px;">www.uyan.cc</span><br/><span style="font-size:12px;color:#aaa;">如不再需要定期报告，请在友言管理页面中设置。</span>';?>
</body>
</html>

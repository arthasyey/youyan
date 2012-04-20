<form action="/index.php/youyan_trace_master" method="post">
输入域名:
    <input type="text" name="doamin" id="doamin" />
或站长邮箱:    
	<input type="text" name="master_email" id="master_email" />
    <input type="submit" />
</form>

<?php
	if(isset($_POST['doamin'])&&$_POST['doamin']!=''){
		$doamin = $_POST['doamin'];
		$master = mysql_query("SELECT * FROM master 
							   LEFT JOIN master_domain ON master.master_id = master_domain.master_id
							   LEFT JOIN domain ON domain.domain = master_domain.domain
							   WHERE master_domain.domain = '$doamin' ");
		while($row = mysql_fetch_array($master)){
			createHTML($row);
		}
	}else if(isset($_POST['master_email'])&&$_POST['master_email']!=''){
		$master_email = $_POST['master_email'];
		$master = mysql_query("SELECT * FROM master 
							   LEFT JOIN master_domain ON master.master_id = master_domain.master_id
							   LEFT JOIN domain ON domain.domain = master_domain.domain
							   WHERE master.email = '$master_email' ");
		while($row = mysql_fetch_array($master)){
			createHTML($row);
		}
	}
	
	function createHTML($master){
		echo '站长ID: '.$master['master_id'];
		echo '<br/>';
		echo '站长Email: '.$master['email'];
		echo '<br/>';
		echo '站长昵称: '.$master['nick'];
		echo '<br/>';
		echo '注册时间: '.$master['time'];
		echo '<br/>';
		echo '网站名: '.$master['domain_name'];
		echo '<br/>';
		echo 'Domain: '.$master['domain'];
		echo '<br/>';
		echo '评论数: '.$master['n_comments'];
		echo '<br/>';
		echo '用户量: '.$master['n_users'];
		echo '<br/>';
		echo '视觉样式: '.$master['styleNum'];
		echo '<br/>';
		echo '验证情况: '.$master['verified'];
		echo '<br/><br/><br/>';
	}
?>

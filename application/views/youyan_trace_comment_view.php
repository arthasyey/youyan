<?php
	$dailyreport = mysql_query("select * from comment 
							   LEFT JOIN user ON user.user_id = comment.user_id 
							   WHERE comment.page_title!='0' ORDER BY comment.time DESC LIMIT 0,100");
	echo "最新评论：<br/>";
	while($row = mysql_fetch_array($dailyreport)){
		echo '<br/>';
		echo '<strong>'.$row['show_name'].'</strong> 在';
		echo '<a href="'.$row['page_url'].'">'.$row['domain'].'</a>评论道:';
		echo '<br/>';
		echo $row['content'];
		echo '<br/>';
		echo '<span style="font-size:13px;color:#aaa;">于'.$row['time'].'</span>';
		echo '<br/>';
    }
?>

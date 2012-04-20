<?php
date_default_timezone_set('PRC');

	$hotWebsite = mysql_query("SELECT * FROM domain WHERE domain !='' ORDER BY n_users DESC ");


	echo "优质网站评论量跟踪：<br/>";
	while($rowData = mysql_fetch_array($hotWebsite)){
		$domain = $rowData['domain'];
		$webdata = mysql_query("SELECT * FROM comment WHERE domain = '$domain' ORDER BY time desc");
		
		if(mysql_num_rows($webdata)!=0){
		$row = mysql_fetch_array($webdata);
		
		
		//get time		
		$year=((int)substr($row['time'],0,4));//取得年份		
		$month=((int)substr($row['time'],5,2));//取得月份		
		$day=((int)substr($row['time'],8,2));//取得几号
		$hour=((int)substr($row['time'],11,2));//取得几号
		$minute=((int)substr($row['time'],14,2));
		$second=((int)substr($row['time'],17,2));
		
		$timestamp =mktime($hour,$minute,$second,$month,$day,$year);
		$inner = time() - $timestamp;
		$newTime = $inner/60;
		$state =0;
		if((int)$newTime>60&&(int)$newTime<=48*60){
			$newTime =$newTime/60;
			$state =1;
		}
		if((int)$newTime>48*60){
			$newTime =$newTime/60;
			$state =2;			
		}
		$newTime =number_format($newTime,1);
		echo '<div style="font-size:14px;padding:10px;">';
		echo '<a href="'.$row['page_url'].'">'.$row['domain'].'</a>';
		if($state ==0){
		echo '<span style="padding-left:20px;padding-right:20px;">用户量'.$rowData['n_users'].'名</span><span>最后评论为 <span style="font-weight:bold;color:#3ca318;">'.$newTime.'分钟</span> 前</span>';
		}else if($state ==1){
		echo '<span style="padding-left:20px;padding-right:20px;">用户量'.$rowData['n_users'].'</span><span>最后评论为 <span style="font-weight:bold;color:#e2840b;">'.$newTime.'小时</span> 前</span>';	
		}else{
		echo '<span style="padding-left:20px;padding-right:20px;">用户量'.$rowData['n_users'].'</span><span>最后评论为 <span style="font-weight:bold;color:dd0000;">'.$newTime.'小时[dangerous]</span> 前</span>';	
		}
		echo '<br/><span style="font-size:13px;color:#aaa;line-height:20px;">最后发布内容: </span><br/><span style="font-size:13px;color:#aaa;line-height:20px;">';
		echo $row['content'];
		echo '</span><br/>';
		echo '<span style="font-size:13px;color:#aaa;">于'.$row['time'].'</span>';
		echo '</div>';
		}
    }
?>

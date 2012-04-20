<?php
	if(isset($_POST['password'])&&md5($_POST['password'])=='fd54f6da6940ba161f1bf408ac1fd601'){
		getTrace();	
	}else{
?>
<form action="http://uyan.cc/index.php/youyan_trace" method="post">
输入管理密码
<input type="password" name="password" />
<input type="submit" />
</form>
<?php		
exit();
	}
function getTrace(){
	echo "Total Comment Number: <br/>";
	$query = mysql_query("select count(*) as count from comment");
	$row = mysql_fetch_array($query);
	echo $row['count'];
	echo "<br/>"; 


	$dailyreport = mysql_query("select count(comment_id) as flow, DATE_FORMAT( time, '%Y-%m-%d' ) as s_time from comment where to_days(time) >= to_days('2011-09-02') AND comment.from_type !='wordpress' group by DATE_FORMAT( time, '%Y-%m-%d' )");	
	echo "每日新增全部评论量：<br/>";
	while($row = mysql_fetch_array($dailyreport)){
		echo "<span style='font-size:12px;color:#aaa;'>".$row['s_time']."</span> -- ";
		echo "";
		echo "<span style='font-size:15px;font-weight:bold;color:#344576;'>". (int)($row['flow']) .' </span>';
		echo "<br/>";
	}
	$dailyreport = mysql_query("select count(domain) as flow from domain ");
	echo "<br/><br/>累计注册网站量：<br/>";
	$row = mysql_fetch_array($dailyreport);
	echo $row['flow'];
	echo "<br/>";
	
	$dailyreport = mysql_query("select count(domain) as flow FROM (SELECT DISTINCT domain FROM master_domain WHERE verified = '1')a  ");
	echo "已通过验证网站量：<br/>";
	$row = mysql_fetch_array($dailyreport);
	echo $row['flow'];
	echo "<br/>";
	
	$dailyreport = mysql_query("SELECT *,DATE_FORMAT( domain.time, '%Y-%m-%d' ) as s_time
								FROM (SELECT * FROM master_domain WHERE master_domain.verified=1)a
							    LEFT JOIN domain ON domain.domain =a.domain
								LEFT JOIN master ON master.master_id=a.master_id
							    WHERE to_days(domain.time) >= to_days('2011-08-01') GROUP BY a.domain ORDER BY domain.time DESC LIMIT 0,50");
	echo "<br/><br/>最新验证Domain, Top50：<br/>";
	while($row = mysql_fetch_array($dailyreport)){
		if($row['domain']!='127.0.0.1'&&$row['domain']!='localhost'){
			echo "<span style='font-size:14px;color:#555;'>".$row['s_time']."</span> --- <strong>";
			echo $row['domain_name'].' ';
			echo $row['domain'].'</strong> | ';
			echo '站长邮箱 '.str_restore($row['email']);
			echo "<br/>";
		}
	}	
	$dailyreport = mysql_query("SELECT *,DATE_FORMAT( domain.time, '%Y-%m-%d' ) as s_time
								FROM (SELECT * FROM master_domain WHERE master_domain.verified=0)a
							    LEFT JOIN domain ON domain.domain =a.domain 
								LEFT JOIN master ON master.master_id=a.master_id
							    WHERE to_days(domain.time) >= to_days('2011-08-01') GROUP BY a.domain ORDER BY domain.time DESC LIMIT 0,50");
	echo "<br/><br/><br/>最新未验证Domain, Top50：<br/>";
	while($row = mysql_fetch_array($dailyreport)){
		if($row['domain']!='127.0.0.1'&&$row['domain']!='localhost'){
			echo "<span style='font-size:14px;color:#555;'>".$row['s_time']."</span> --- <strong>";
			echo $row['domain_name'].' ';
			echo $row['domain'].'</strong> | ';
			echo '站长邮箱 '.str_restore($row['email']);
			echo "<br/>";
		}
	}	
}

  function str_restore( $str ) {     
    if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否打开     
      $str = stripslashes($str);    // 进行过滤     
    }     
    $str = str_replace("\_", "_", $str);    // 把 '_'过滤掉     
    $str = str_replace("\%", "%", $str);    // 把 '%'过滤掉     

    return $str; 
  }
?>

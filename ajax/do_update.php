<?php 
session_start();
//microblog update
include_once( '../config.php' );
include_once( '../sdk/weibooauth.php' );
$c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
$ms  = $c->home_timeline(); // done
$me = $c->verify_credentials();
$c = new WeiboClient( WB_AKEY , 
                      WB_SKEY , 
                      $_SESSION['last_key']['oauth_token'] , 
                      $_SESSION['last_key']['oauth_token_secret']  );
//update database
function updateContentDB($user_id,$location_id,$content){
	require_once("db_con.php");
	$conn = connect_db();
	if (!$conn){die('网络繁忙');}	                                                                          
		
	$date = date('Y-m-d H:i:s');
	$updateInvite = mysql_query("INSERT INTO content (content,user_id,location_id,update_time)VALUES('$content','$user_id','$location_id','$date')");
	echo "INSERT INTO content (content,user_id,location_id,update_time)VALUES('$content','$user_id','$location_id','$date')";
	mysql_close($conn);
}

if($_POST['content']!=''){
	$rr = $c->update($_POST['content']);
	updateContentDB('100000001','1',$_POST['content']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml">
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<title>YouYan_email</title>
    	<meta name="keywords" content="YouYan" />
    	<meta name="author" content="YouYan" />
    	<meta name="description" content="YouYan SNS Talk Service" />
    	<script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
        <?php require_once("phpmailer/class.phpmailer.php");extract( $_POST );?>
        <?php 
		function smtp_mail ($sendto_email, $user_name,$content,$subject){ 
			$body = $content;
			$mail = new PHPMailer(); 
			$mail->IsSMTP(); // send via SMTP 	
			$mail->CharSet = "UTF-8";
			//$mail->Encoding = "base64";	
			$mail->Host = "127.0.0.1"; // SMTP servers 
			$mail->Port = 25; 
			$mail->SMTPAuth = false; // turn on SMTP authentication 
			$mail->Username = "root"; // SMTP username
			$mail->Password = "youyan"; // SMTP password 
			$mail->From = 'admin@uyan.cc'; // 发件人邮箱
			$mail->FromName = '友言'; // 发件人
			$mail->AddAddress($sendto_email,$user_name); // 收件人邮箱和姓名
			$mail->AddReplyTo("admin","uyan.cc");
			$mail->IsHTML(true); // send as HTML
			// 邮件主题
			$mail->Subject = htmlspecialchars($subject); 
			// 邮件内容
			$mail->Body = $body;
			$mail->AltBody ="text/html";
			if(!$mail->Send()) 
			{ 
				return 0;
			} 
			else { 
				
				return 1; 
			}
		} 
		function getAllEmail(){
			$emailList = mysql_query("SELECT * FROM master");
			while($row= mysql_fetch_array($emailList)){
				echo $row['nick'].', ';	
				echo smtp_mail($row['email'],$row['nick'],$_POST['emailContent'],$_POST['emailTitle']);
			}
			
			
		}
		
		?>
  	</head>
	<body>
    	<h2>已发送(请勿刷新)</h2>
        <h4>发送给</h4>
        <div><?php getAllEmail();?></div>
        <h4>标题为</h4>
        <div><?php echo $_POST['emailTitle'];?></div>
		<h4>内容为</h4>
        <div><?php echo $_POST['emailContent'];?></div>
        
	</body>
</html>

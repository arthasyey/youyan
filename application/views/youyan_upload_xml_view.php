<script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
<?php
set_time_limit(3600);
//require_once("checklogin.php");
define( "INROUTE" , 'xml/' );
//chage when upload
$domain_upload= $_POST['domain_upload_xml'] ;
$goodtogo = TRUE;

if ($_FILES['xmlpath']['size'] == 0 ){
	$goodtogo = FALSE;
}
if ($_FILES['xmlpath']['size'] > 5000000 ){
	$goodtogo = FALSE;
}

$allowedmimes = array("text/xml");
if (!in_array( $_FILES['xmlpath']['type'] , $allowedmimes )){
	$goodtogo = FALSE;				
}

if ( $goodtogo )
{	
	$img_type = ".xml"; 
	$store_name = date("YmHis").rand(0,1000);
    $in_path = INROUTE.date("Ymd")."/";
    if(!is_dir($in_path)){
        mkdir($in_path,0777);
    }
	$file_name = $in_path.$store_name;
	$file_name = $file_name.$img_type;

	if (!move_uploaded_file($_FILES['xmlpath']['tmp_name'],$file_name )){
		$goodtogo = FALSE;
	}
	if($goodtogo){
		$errorState = 'no';
		$itemAmount = 0;
		?>
		<script language="javascript" type="text/Javascript">
			window.parent.callBackXml('process','no','0');		
		</script>
		<?php
		
		$xml = simplexml_load_file($file_name,'SimpleXMLElement',LIBXML_NOCDATA);
		foreach($xml->post as $commentItem){
			foreach($commentItem->attributes() as $key=>$val){
   				 $comment_id = $val;
  			}
			$goodToPass = 1;
			$preStr='';
			$valStr='';

			if(isset($comment_id)&&$comment_id!=''){				
				$amount = mysql_query("SELECT comment_id FROM comment WHERE comment_id = '$comment_id'");
				$amount = mysql_num_rows($amount);				
				if($amount>=1){$goodToPass = 0;$errorState = 'sameComment';}
				$preStr = $preStr.'comment_id, ';
				$valStr = $valStr.post_check($comment_id).', ';
			}
			
			if($goodToPass==0)continue;
			
			if(isset($commentItem->content)&&$commentItem->content!=''){
				$preStr = $preStr.'content, ';
				$valStr = $valStr.'\''.post_check($commentItem->content).'\''.', ';				
			}
			  if(isset($commentItem->from_type)&&$commentItem->from_type!=''){
				$preStr = $preStr.'from_type, ';
				$valStr = $valStr.'\''.post_check($commentItem->from_type).'\''.', ';
			  }			  
			  if(isset($commentItem->time)&&$commentItem->time!=''){
				$preStr = $preStr.'time, ';
				$valStr = $valStr.'\''.post_check($commentItem->time).'\''.', ';
			  }					  
			  if(isset($commentItem->page)&&$commentItem->page!=''){
				$preStr = $preStr.'page, ';
				$valStr = $valStr.'\''.post_check($commentItem->page).'\''.', ';
			  }
			  if(isset($commentItem->page_url)&&$commentItem->page_url!=''){
				$preStr = $preStr.'page_url, ';
				$valStr = $valStr.'\''.post_check($commentItem->page_url).'\''.', ';
			  }
			  if(isset($commentItem->domain)&&$commentItem->domain!=''){
				$preStr = $preStr.'domain, ';
				$valStr = $valStr.'\''.post_check($commentItem->domain).'\''.', ';
			  }
			  if($domain_upload!=$commentItem->domain){				
				$errorState = 'wrongDomain';
				continue;
			  }
		  	  if(isset($commentItem->page_title)&&$commentItem->page_title!=''){
				$preStr = $preStr.'page_title, ';
				$valStr = $valStr.'\''.post_check($commentItem->page_title).'\''.', ';
			  }
		  	  if(isset($commentItem->user_id)&&$commentItem->user_id!=''){
				$preStr = $preStr.'user_id, ';
				$valStr = $valStr.post_check($commentItem->user_id).', ';
			  }
		  	  if(isset($commentItem->sina_url)&&$commentItem->sina_url!=''){
				$preStr = $preStr.'sina_url, ';
				$valStr = $valStr.'\''.post_check($commentItem->sina_url).'\''.', ';
			  }
			  if(isset($commentItem->tencent_t_url)&&$commentItem->tencent_t_url!=''){
				$preStr = $preStr.'tencent_t_url, ';
				$valStr = $valStr.'\''.post_check($commentItem->tencent_t_url).'\''.', ';
			  }
			  if(isset($commentItem->sohu_t_url)&&$commentItem->sohu_t_url!=''){
				$preStr = $preStr.'sohu_t_url, ';
				$valStr = $valStr.'\''.post_check($commentItem->sohu_t_url).'\''.', ';
			  }
			  if(isset($commentItem->neteasy_t_url)&&$commentItem->neteasy_t_url!=''){
				$preStr = $preStr.'neteasy_t_url, ';
				$valStr = $valStr.'\''.post_check($commentItem->neteasy_t_url).'\''.', ';
			  }
			  if(isset($commentItem->n_up)&&$commentItem->n_up!=''){
				$preStr = $preStr.'n_up, ';
				$valStr = $valStr.post_check($commentItem->n_up).', ';
			  }
			  if(isset($commentItem->n_down)&&$commentItem->n_down!=''){
				$preStr = $preStr.'n_down, ';
				$valStr = $valStr.post_check($commentItem->n_down).', ';
			  }
			  if(isset($commentItem->reply_to_comment_id)&&$commentItem->reply_to_comment_id!=''){
				$preStr = $preStr.'reply_to_comment_id, ';
				$valStr = $valStr.post_check($commentItem->reply_to_comment_id).', ';
			  }
			  if(isset($commentItem->del)&&$commentItem->del!=''){
				$preStr = $preStr.'del, ';
				$valStr = $valStr.post_check($commentItem->del).', ';
			  }
			  if(isset($commentItem->comment_author)&&$commentItem->comment_author!=''){
				$preStr = $preStr.'comment_author, ';
				$valStr = $valStr.'\''.post_check($commentItem->comment_author).'\''.', ';
			  }
			  if(isset($commentItem->comment_author_email)&&$commentItem->comment_author_email!=''){
				$preStr = $preStr.'comment_author_email, ';
				$valStr = $valStr.'\''.post_check($commentItem->comment_author_email).'\''.', ';

			  }
			  if(isset($commentItem->comment_author_url)&&$commentItem->comment_author_url!=''){
				$preStr = $preStr.'comment_author_url, ';
				$valStr = $valStr.'\''.post_check($commentItem->comment_author_url).'\''.', ';
			  }
			  if(isset($commentItem->notified)&&$commentItem->notified!=''){
				$preStr = $preStr.'notified, ';
				$valStr = $valStr.post_check($commentItem->notified).', ';
			  }
			  if(isset($commentItem->hotness)&&$commentItem->hotness!=''){
				$preStr = $preStr.'hotness, ';
				$valStr = $valStr.post_check($commentItem->hotness).', ';
			  }
			  if(isset($commentItem->IP)&&$commentItem->IP!=''){
				$preStr = $preStr.'IP, ';
				$valStr = $valStr.'\''.post_check($commentItem->IP).'\''.', ';	  
			  }
			  if(isset($commentItem->wp_import_export_id)&&$commentItem->wp_import_export_id!=''){
				$preStr = $preStr.'wp_import_export_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->wp_import_export_id).'\''.', ';
			  }
			  if(isset($commentItem->sina_trace_id)&&$commentItem->sina_trace_id!=''){
				$preStr = $preStr.'sina_trace_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->sina_trace_id).'\''.', ';		  
			  }
			  if(isset($commentItem->tencent_trace_id)&&$commentItem->tencent_trace_id!=''){
				$preStr = $preStr.'tencent_trace_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->tencent_trace_id).'\''.', ';			  }
			  if(isset($commentItem->renren_trace_id)&&$commentItem->renren_trace_id!=''){
				$preStr = $preStr.'renren_trace_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->renren_trace_id).'\''.', ';
			  }
			  if(isset($commentItem->kaixin_trace_id)&&$commentItem->kaixin_trace_id!=''){
				$preStr = $preStr.'kaixin_trace_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->kaixin_trace_id).'\''.', ';
			  }
			  if(isset($commentItem->neteasy_trace_id)&&$commentItem->neteasy_trace_id!=''){
				$preStr = $preStr.'neteasy_trace_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->neteasy_trace_id).'\''.', ';
			  }
			  if(isset($commentItem->sohu_trace_id)&&$commentItem->sohu_trace_id!=''){
				$preStr = $preStr.'sohu_trace_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->sohu_trace_id).'\''.', ';
			  }
			  if(isset($commentItem->qq_trace_id)&&$commentItem->qq_trace_id!=''){
				$preStr = $preStr.'qq_trace_id, ';
				$valStr = $valStr.'\''.post_check($commentItem->qq_trace_id).'\''.', ';		  
			  }
			  if(isset($commentItem->veryfy_status)&&$commentItem->veryfy_status!=''){
				$preStr = $preStr.'veryfy_status, ';
				$valStr = $valStr.'\''.post_check($commentItem->veryfy_status).'\''.', ';
			  }
			 $preStr = substr($preStr,0,(strlen($preStr)-2));
			 $valStr = substr($valStr,0,(strlen($valStr)-2));
			 $itemAmount++;			 
			mysql_query("INSERT INTO comment(".$preStr.")VALUE(".$valStr.")");
		}?>	
		<script language="javascript" type="text/Javascript">
			window.parent.callBackXml('sucess','<?php echo $errorState;?>','<?php echo $itemAmount;?>');		
		</script>
<?php }else{
 }	
}
  function post_check($post) {     
    if (!get_magic_quotes_gpc()) {    // 判断magic_quotes_gpc是否为打开     
      $post = addslashes($post);    // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤     
    }     
    $post = str_replace("_", "\_", $post);    // 把 '_'过滤掉     
    $post = str_replace("%", "\%", $post);    // 把 '%'过滤掉     
    $post = nl2br($post);    // 回车转换     
    $post = htmlspecialchars($post);    // html标记转换     

    return $post;     
  }

?>
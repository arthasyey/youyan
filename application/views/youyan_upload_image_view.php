<script language="javascript" src="../jquery.ui/jquery-1.4.2.min.js"></script>
<?php
//require_once("checklogin.php");
define( "INROUTE" , 'uploads/' );
define( "SPICW" , 50);
define( "SPICCLEAR" , 85 );
//chage when upload
define( "IMGROUTE" , 'http://uyan.cc/');
$domain_upload= $_POST['domain_upload'] ;
$goodtogo = TRUE;
if ($_FILES['uploadImage']['size'] == 0 ){
	$goodtogo = FALSE;
}
if ($_FILES['uploadImage']['size'] > 5000000 ){
	$goodtogo = FALSE;
}		
$allowedmimes = array("image/jpeg" , "image/jpg" , "image/pjpeg" , "image/png" , "image/gif" , "image/x-png" , "image/bmp" );
if (!in_array( $_FILES['uploadImage']['type'] , $allowedmimes )){
	$goodtogo = FALSE;				
}
//check image is legal
if(isImage($_FILES['uploadImage']['tmp_name'])!==false){
	$goodtogo = TRUE;	
}else{
	$goodtogo = FALSE;	
}
if ( $goodtogo )
{		
	$img_type = "";
	switch ( $_FILES['uploadImage']['type'] ) 
	{
		case "image/jpeg":
		case "image/jpg":
		case "image/pjpeg":
			$img_type = ".jpg";
		break;
		case "image/png":
		case "image/x-png":
			$img_type= ".png";
		break;
		case "image/gif":
			$img_type=".gif";
		break;
		case "image/bmp":
			$img_type=".bmp";
		break;
	}	
	    
	$store_name = date("YmHis").rand(0,1000);
    $in_path = INROUTE.date("Ymd")."/";
    if(!is_dir($in_path)){
        mkdir($in_path,0777);   
    }
	$file_name = $in_path.$store_name;
	$file_path = IMGROUTE.date("Ymd")."/".$store_name; 

	$file_name = $file_name.$img_type;
	if (!move_uploaded_file($_FILES['uploadImage']['tmp_name'],$file_name )){
		$goodtogo = FALSE;
	}
	$url_file = IMGROUTE.$file_name;
	if($goodtogo){
		mysql_query("UPDATE domain SET default_profile = '$url_file' WHERE domain = '$domain_upload'");
		 $_SESSION['domain_data']['default_profile'] = $url_file;
		 zip_pic($file_name, $img_type );
		?>
		<script language="javascript" type="text/Javascript">
			window.parent.callBackUpload('sucess','<?php echo $url_file;?>');		
		</script>
   <?php 
	}else{?>
		<script language="javascript" type="text/Javascript">
			window.parent.callBackUpload('false','<?php echo $url_file;?>');
		</script>	
	<?php 
    }
	
}else{?>
		<script language="javascript" type="text/Javascript">
			window.parent.callBackUpload('false','noImage');
		</script>	
	<?php 	
}
function isImage($filename){
    $types = '.gif|.jpeg|.png|.bmp';//定义检查的图片类型
    if(file_exists($filename)){
        $info = getimagesize($filename);
        $ext = image_type_to_extension($info['2']);
        return stripos($types,$ext);
    }else{
        return false;
    }
}
function zip_pic($file_name, $img_type ){
	$im_size = getimagesize($file_name);
	var_dump( $im_size );
	switch ( $img_type )
	{
		case ".jpg":
			$src_im = imagecreatefromjpeg($file_name);
			break;			
		case ".png":
			$src_im = imagecreatefrompng($file_name);
			break;			
		case ".gif":
			$src_im = imagecreatefromgif($file_name);
			break;
		case ".bmp":
			$src_im = imagecreatefrombmp( $file_name);
	}	
	// generating SPICW * SPICW pictrue for tiny images(cube)
    if($im_size[0] >= $im_size[1]){
        if($im_size[0] >= SPICW){
            $dst_sim = imagecreatetruecolor(SPICW , SPICW );
            ImageCopyResampled($dst_sim,$src_im , 0 , 0, ($im_size[0]-$im_size[1]) / 2 , 0 ,SPICW,SPICW, $im_size[1] , $im_size[1] );
        }else{
            $dst_sim = imagecreatetruecolor(SPICW , SPICW );
            ImageCopyResampled($dst_sim,$src_im , 0 , 0, ($im_size[0]-$im_size[1]) / 2 , 0 ,SPICW,SPICW, $im_size[1] , $im_size[1]);         
        }        
    }else{
        if($im_size[1] >= SPICW){
            $dst_sim = imagecreatetruecolor(SPICW , SPICW );
            ImageCopyResampled($dst_sim,$src_im , 0 , 0, 0,($im_size[1]-$im_size[0]) / 2 ,SPICW,SPICW, $im_size[0] , $im_size[0]);
        }else{
            $dst_sim = imagecreatetruecolor(SPICW , SPICW );
            ImageCopyResampled($dst_sim,$src_im , 0 , 0, 0,($im_size[1]-$im_size[0]) / 2,SPICW,SPICW, $im_size[0] , $im_size[0]);         
        }      
        
        }				
	switch ( $img_type )
		{
		case ".jpg":
			imagejpeg($dst_sim , $file_name , SPICCLEAR );
		break;			
		case ".png":
			imagepng($dst_sim , $file_name);
		break;			
		case ".gif":
			imagegif($dst_sim , $file_name);
		break;	
		case ".bmp":
			imagebmp($dst_sim , $file_name);
		break;		
		}					
	imagedestroy($dst_sim);
	imagedestroy($src_im);
			
}
?>
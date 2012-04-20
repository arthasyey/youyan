<?php 
	$the_host = $_SERVER['HTTP_HOST'];
	$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
	if($the_host !='uyan.cc'){
		header('HTTP/1.1 301 Moved Permanenty');
		header('Location:http://uyan.cc'.$request_uri);
	}
?>
<div class="header">
	<div class="header_top" id="userStatus">
	<?php if(!isset($_SESSION["uid"])){?>
    	<a href="javascript:void(0)" onclick="boxLogin.show();$('#alertLogin').html('');$('#loginForm').attr('class','outlineLogin');">登录</a><a href="/index.php/youyan_register">注册</a>
	 <?php }else{?>
		<a href="javascript:void(0)" onclick="userLogout();">( 退出 )</a><a><?php echo $_SESSION["uname"];?></a>
     <?php }?>
    </div>
</div>
<div class="radial">
    <div class="topWrapper">
        <div class="topContainer">
            <a class="logo" href="http://uyan.cc/"></a><a style="text-decoration:none;" href="http://www.jiathis.com" class="introLogoPane" target="_blank">JiaThis旗下产品</a>
            <div class="loginWrapper">
                <a id="getcode" <?php if(in_array($_SERVER["PHP_SELF"], array('/index.php/youyan_help/general','/index.php/youyan_help/wp_install','/index.php/youyan_register','/index.php/youyan_help/index/wp_install_online','/index.php/youyan_help/index/wp_install_download','/youyan_register'))){?>class="menuSelected"<?php }?> href="<?php if(isset($_SESSION["uid"])){?>/index.php/youyan_help/general<?php }else{?>/index.php/youyan_register<?php }?>" onmouseover="mypop('MoreButton', 'show');"
    onmouseout="mypop('MoreButton', 'hide');">获取代码<span class="jiao">▼</span></a>
                <a <?php if(strpos($_SERVER["PHP_SELF"],'help')!==false){?>class="menuSelected"<?php }?> href="/help">帮助中心</a> 
                <a id="admin_optid" <?php if(isset($_SESSION["uid"])){?> href="/index.php/youyan_admin_pre/index/"<?php }else{?>href="javascript:void(0);" onclick="boxLogin.show();$('#alertLogin').html('');$('#loginForm').attr('class','outlineLogin');$('#clickType').val('admin');"<?php }?> >后台管理</a>     
                <div class="clear"></div>
                <ul id="MoreButton" class="morebutton" style="display:none" onmouseover="mypop('MoreButton', 'show');"
    onmouseout="mypop('MoreButton', 'hide');">
                   <li><a href="<?php if(isset($_SESSION["uid"])){?>/index.php/youyan_help/general<?php }else{?>/index.php/youyan_register<?php }?>">通用代码</a></li>
                   <li><a href="/index.php/youyan_help/index/wp_install_online">WordPress</a></li>
                </ul>
            </div>      
            <div class="clear"></div>
        </div>  
    </div> 
</div>
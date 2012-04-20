<?php
$time = time() + 3600*24*15;
setcookie('uyan_login_cookie', $login_info, $time, '/');
?>

<script type="text/javascript">
opener.updateLoginInfo('<?php echo $login_info;?>');
  
close();

</script>


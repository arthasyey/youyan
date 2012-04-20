<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>YouYan</title>
  </head>
  <body>
<div id='sso_frame'></div>
<script type='text/javascript'>

iframeone = document.createElement("iframe");
document.body.appendChild(iframeone);
iframeone.src='<?php echo $_SESSION['SSOUrl'];?>';
iframeone.scrolling = true;
iframeone.transparent = true;
</script>

</body>
  </html>


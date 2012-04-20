<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xn="http://www.renren.com/2009/xnml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>YouYan Admin Frame</title>
    <meta name="keywords" content="YouYan" />
    <meta name="author" content="YouYan" />
    <meta name="description" content="YouYan SNS Talk Service" />
  </head>
<body>
<script language="javascript" src="../easyXDM/easyXDM.min.js"></script>
<script type="text/javascript">
var iframe;
var socket = new easyXDM.Socket({
  swf: "../easyxdm.swf",
    onReady: function(){
    },
      onMessage: function(message, origin){
        iframe = document.createElement("iframe");
        iframe.frameBorder = 0;
        iframe.id = "middle_wp_frame";
        iframe.scrolling = "yes";
        document.body.appendChild(iframe);
        iframe.src = "http://uyan.cc/index.php/youyan_admin_edit" + message;
        //console.log("remote receive message: " + message);
      }
});
</script> 
        <style type="text/css"> 
            html, body {
                overflow: hidden;
                margin: 0px;
                padding: 0px;
                width: 100%;
                height: 100%;
            }

            iframe {
                width: 100%;
                height: 100%;
                border: 0px;
            }
        </style> 
</body>
</html>


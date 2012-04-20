<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>YouYan Middle Frame</title>
<script language="javascript" src="../easyXDM/easyXDM.min.js"></script>
</head>
<body>

<script type="text/javascript">
var iframe;
var socket = new easyXDM.Socket({
  swf: "http://uyan.cc/easyXDM/easyxdm.swf",
    onReady: function(){
      //iframe.src = easyXDM.query.url;
    },
      onMessage: function(message, origin){
        iframe = document.createElement("iframe");
        iframe.frameBorder = 0;
        iframe.scrolling = 'no';
        iframe.src = message;
        document.body.appendChild(iframe);
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



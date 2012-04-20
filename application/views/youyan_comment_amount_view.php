<script language="javascript" src="../../../jquery.ui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../easyXDM/easyXDM.min.js"></script>
<script language="javascript" type="text/javascript">
	var UYAmountCommentSocket = new easyXDM.Socket({
		onMessage: function(message, origin){
			UYAmountCommentSocket.postMessage("<?php echo $amount."{_}".$linkId;?>");
		}
	});
</script>

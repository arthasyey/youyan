KindEditor.ready(function(K) {
	var jiathis_editor = K.create('textarea[name="content"]', {
		width : "600",
		height : "250",
		cssPath : '/resource/js/kindeditor/plugins/code/prettify.css',
		resizeType : 1,
		allowPreviewEmoticons : false,
		allowImageUpload : false,
		items : [
			'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
			'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
			'insertunorderedlist', '|', 'emoticons', 'image', 'link', 'code', '|', 'source']
	});
	prettyPrint();
});
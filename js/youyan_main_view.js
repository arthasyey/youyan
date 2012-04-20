function changeMainNavi(type,node){
	if(type=='news'){
		$("#notiMainContainer").hide();
		$("#newsMainContainer").show();
		$("#notiFavContainer").hide();
	}else if(type=='like'){
		$("#notiMainContainer").hide();
		$("#newsMainContainer").hide();
		$("#notiFavContainer").show();
	}else{
		$("#notiMainContainer").show();
		$("#newsMainContainer").hide();
		$("#notiFavContainer").hide();
	}
	var $node = $(node); 
	$('.newCommentsTab').removeClass('currentNewComments');
	$node.addClass('currentNewComments');	
}
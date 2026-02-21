jQuery(document).ready(function(){
	jQuery("#changepasswordform").validationEngine();
	
	$('#cancel').on('click',function(){
		document.changepasswordform.submit();
	});
});

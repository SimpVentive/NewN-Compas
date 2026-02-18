jQuery(document).ready(function(){
    
});

$('#resource_type').change(function() {
	$('#type_name').val($('#resource_type :selected').text());
});

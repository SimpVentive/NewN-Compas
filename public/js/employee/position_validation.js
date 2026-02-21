function open_comp_details(pos_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('comp_details_'+pos_id).innerHTML=xmlhttp.responseText;
			$('.section-to-scroll').on('click', function (e){

				var section = $(this).attr('data-section');
				var tabNumber = Number($(this).attr('data-tab'));
				$('.year-tab-section .nav-tabs .nav-item .nav-link').removeClass('active');
				$(this).addClass('active');

				var prevTabPane = $('#'+section).prev('div.tab-pane').outerWidth();
				$("#scrolling-section").animate({
					scrollLeft : (prevTabPane * tabNumber)
				}, 1000);

			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/position_profile_details?pos_id="+pos_id,true);
	 xmlhttp.send();    
}
$(document).ready(function(){
	$("#tab_four_sumbit").validationEngine();
	
	
});
function open_inbasket(val_id,id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('view_inbasket'+val_id).innerHTML=xmlhttp.responseText;
			if($('.custom-scroll')){
				$('.custom-scroll').scrollbar();
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/assessment_inbasket_details?val_id="+val_id+"&intray="+id,true);
	xmlhttp.send();     
}

function open_comp_details(ass_id,pos_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('comp_details_'+ass_id+'_'+pos_id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/competency_profile_details?ass_id="+ass_id+"&pos_id="+pos_id,true);
	 xmlhttp.send();    
}

$(document).ready(function() {
	$('.test-nav-panel li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	if(status!=''){
		if(status=='int'){
			$('#instruction_li').addClass('active');
			$('#read-complete-instruction').css("display", "block");
			$('#read-complete-scenerio').css("display", "none");
			$('#see-intrays').css("display", "none");
			$('#pritorize-the-intrays').css("display", "none");
			$('#actionize-intrays').css("display", "none");
		}
		else if(status=='self'){
			$('#compentencies_li').addClass('active');
			$('#read-complete-scenerio').css("display", "block");
			$('#instruction_li').addClass('active');
			$('#read-complete-instruction').css("display", "none");
			$('#see-intrays').css("display", "none");
			$('#pritorize-the-intrays').css("display", "none");
			$('#actionize-intrays').css("display", "none");
		}
		else if(status=='career'){
			$('#employees_li').addClass('active');
			$('#see-intrays').css("display", "block");
			$('#instruction_li').addClass('active');
			$('#compentencies_li').addClass('active');
			$('#strengths_li').removeClass('active');
			$('#development_li').removeClass('active');
			$('#read-complete-instruction').css("display", "none");
			$('#read-complete-scenerio').css("display", "none");
			$('#pritorize-the-intrays').css("display", "none");
			$('#actionize-intrays').css("display", "none");
		}
		else if(status=='strength'){
			$('#strengths_li').addClass('active');
			$('#pritorize-the-intrays').css("display", "block");
			$('#instruction_li').addClass('active');
			$('#compentencies_li').addClass('active');
			$('#employees_li').addClass('active');
			$('#development_li').removeClass('active');
			$('#read-complete-instruction').css("display", "none");
			$('#see-intrays').css("display", "none");
			$('#read-complete-scenerio').css("display", "none");
			$('#actionize-intrays').css("display", "none");
			
		}
		else if(status=='development'){
			$('#development_li').addClass('active');
			$('#actionize-intrays').css("display", "block");
			$('#instruction_li').addClass('active');
			$('#compentencies_li').addClass('active');
			$('#employees_li').addClass('active');
			$('#strengths_li').addClass('active');
			$('#read-complete-instruction').css("display", "none");
			$('#read-complete-scenerio').css("display", "none");
			$('#see-intrays').css("display", "none");
			$('#pritorize-the-intrays').css("display", "none");
			setInterval(function() {
		
				var formData = new FormData(document.getElementById("tab_four_sumbit"));
				var xhr = new XMLHttpRequest();
				xhr.open("POST", BASE_URL+"/employee/inbasket_four_submit_auto", true);
				xhr.send(formData);
			}, 5000); // Save form data every 5 seconds 
		}
	}
	else{
		$('#instruction_li').addClass('active');
		$('#read-complete-instruction').addClass('active');
		$("#compentencies_li").removeClass('active');
		$('#read-complete-scenerio').removeClass('active');
		$('#actionize-intrays').removeClass('active');
		$('#see-intrays').removeClass('active');
		$('#actionize-intrays').removeClass('active');
	} 
});
if(status!=''){
	if(status=='career'){
		var d =new Date();
		var curr_day = d.getDate();var
		curr_month =
		d.getMonth();var
		curr_year =
		d.getFullYear();var curr_hour = d.getHours();var
		curr_min = d.getMinutes();var
		curr_sec = d.getSeconds();

		curr_month++;// In js, first month is 0, not
		1
		year_2d =
		curr_year.toString().substring(2,4)
		var start_period=curr_year+"-"+curr_month+"-"+curr_day+" "+curr_hour+":"+curr_min+":"+curr_sec;

		$("#start_period").val(start_period);
	}
}

if(time_spend!=0){
	var countdown = time_spend;// * 60 * 1000;
	var timerId = setInterval(function(){
		countdown -= 1000;
		let min = Math.floor(countdown / (60 * 1000));
		let sec = Math.floor((countdown - (min * 60 * 1000)) / 1000);

		document.getElementById('minute').innerHTML = min;
		document.getElementById('second').innerHTML = sec;
		var period=min+":"+sec;
		$(".timespent").val(period);
	}, 1000);
}
else{
	var countdown = time * 60 * 1000;
	var timerId = setInterval(function(){
		countdown -= 1000;
		let min = Math.floor(countdown / (60 * 1000));
		let sec = Math.floor((countdown - (min * 60 * 1000)) / 1000);

		document.getElementById('minute').innerHTML = min;
		document.getElementById('second').innerHTML = sec;
		var period=min+":"+sec;
		$(".timespent").val(period);
	}, 1000);
}


	/* tolerance: "pointer",
	placeholderClass: 'list-group-item',
	pullPlaceholder:true,
	connectWith: '.connected', */
$('.list-group-sortable-connected').sortable({
	connectWith:    '.connected',
    cursor:         'move',
	placeholderClass: 'list-group-item',
    placeholder:    'sortable-placeholder',
    cursorAt:       { left: 150, top: 17 },
    tolerance:      10,
    scroll:         false,
    zIndex:         9999,
  revert: true
}).bind('sortupdate', function(e, ui) {
	var setPriority = $('#set-priority');
	var setPriorityCases = setPriority.find('li');
	
	var html = '';
	setPriorityCases.each(function (index, value){
		
		//alert(parseInt(index+1));
		html += '<div class="case-question-box responses-box p20">';
			html += '<div class="case-details">';
				html += '<label class="name">You have given Priority of '+ (index+1) +'</label>';
				html += '<span class="ans">for the Intray '+ $(value).attr('data-case') +'</span>';
				html += '<input type="hidden" name="val_id['+$(value).attr('data-value')+']" id="val_id[]" class="intray_values" value="'+$(value).attr('data-value')+'">';
				html += '</div>';
		html += '</div>';
		
		$("#intray_final_"+ ($(value).attr('data-value'))).removeAttr("data-case-order");
		$("#intray_final_"+ ($(value).attr('data-value'))).attr("data-case-order",(index+1));
		
	});

	$('#sortable-cases').html(html);
}).disableSelection();

/* $(".intray_values").click(function(){
    var link = $(this).attr('input[type="text"]').val();
    alert(link);

}); */




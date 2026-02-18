$(document).ready(function(){
	$('#employeeTest').validationEngine();
	
});

var countdown = time * 60 * 1000;
var timerId = setInterval(function(){
	countdown -= 1000;
	var min = Math.floor(countdown / (60 * 1000));
	var sec = Math.floor((countdown - (min * 60 * 1000)) / 1000);
	document.getElementById('minute').innerHTML = min;
	document.getElementById('second').innerHTML = sec;
	
}, 1000);

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

$("#start_period_1").val(start_period);

function open_case(val_id){
    var xmlhttp;
	if (window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('view_case'+val_id).innerHTML=xmlhttp.responseText;
			if($('.custom-scroll')){
				$('.custom-scroll').scrollbar();
			}
		}
	}
	xmlhttp.open("GET",BASE_URL+"/employee/assessment_case_details?val_id="+val_id,true);
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

$(".next_question").click(function(){
	var def=$('#employeeTest').validationEngine('validate');
	if(def==false){
		$('#employeeTest').validationEngine();
		return false;
	}
	else {
		
	var $pre = $( this ).attr("data-pre");
	var $post = $( this ).attr("data-post");
	var qtype=document.getElementById("qtype_"+$pre).value;
	if(qtype=='T'|| qtype=='S'){
		var question_list="#question_list"+$pre+" .radiocheck:checked";
		var ans=($(question_list).val());
	}
	else if(qtype=='F'|| qtype=='B' || qtype=='FT'){
		var ans=$("#answer_"+$pre).val();
		//alert(ans);
	}
	else if(qtype=='M'){
		var ans = [];
		var question_list="#question_list"+$pre;
		$('.check:checked').each(function() {
		   ans.push($(this).val());
		});
		//alert(ans);
	}
	//alert(ans);
	var testid=document.getElementById("testid").value;
	var assess_test_id=document.getElementById("ass_test_id").value;
	var testtype=document.getElementById("ttype").value;
	var assessment_id=document.getElementById("assid").value;
	var question=document.getElementById("question_"+$pre).value;
	var $p=parseInt($pre)+1;
		$("#start_period_"+$p).val(start_period);
		$("#question_list"+$pre).hide();
		$("#question_list"+$p).show();
		$("#question_button"+$p).show();
		$("#question_upload"+$p).show();
		$("#question_grid"+$pre).hide();
		$("#question_grid"+$p).show();
		$("#que-"+$p+"-tab").removeClass("disabled");
		$( "#que-"+$pre+"-tab" ).click(function() {
			$("#next"+$pre).show();
			$("#next"+$p).hide();
			$("#que-"+$p+"-tab").removeClass("active show");
			$("#que-"+$p+"-tab").addClass("disabled");
		});
		$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v=C",
			success: function(result){
			//alert(result);
			$("#next"+$post).show();
			$("#next"+$pre).hide();
			$("#que-"+$pre+"-tab").removeClass("show active");
			$("#que-"+$pre+"-tab").removeClass("disabled");
			$("#que-"+$post+"-tab").addClass("show active");
			$("#question-"+$pre+"-tab").removeClass("show active");
			$("#question-"+$post+"-tab").addClass("show active");
			var colors=result;
				/* var question_id=".question_color"+question;
				if(colors=='C'){
					$(question_id).addClass('badge-success');
				}
				else
				{
					$(question_id).addClass('badge-danger');
				} */
				var que_id=question;
				var question_id=".question_color"+question;
				var question_ids="#open_skip_question"+question;
				
				if(colors=='C'){
					$(question_id).removeClass('btn-danger');
					$(question_id).addClass('btn-success');
				}
				else
				{
					$(question_id).addClass('btn-danger');
				} 
			}
		});
	}
});
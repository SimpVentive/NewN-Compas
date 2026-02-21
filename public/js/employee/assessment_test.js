var totansweredquest=""

var countdown = time * 60 * 1000;
var timerId = setInterval(function(){
	countdown -= 1000;
	var min = Math.floor(countdown / (60 * 1000));
	var sec = Math.floor((countdown - (min * 60 * 1000)) / 1000);

	if (countdown <= 0) {
		clearInterval(timerId);
		var timecon=document.getElementById('timeconsume').value;
		if(timecon=='Y'){
			document.getElementById("employeeTest").submit();
		}
	} else {
		document.getElementById('minute').innerHTML = min;
		document.getElementById('second').innerHTML = sec;
	}
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

$("#start_period").val(start_period);

$(".next_question").click(function(){
	
	var def=$('#employeeTest').validationEngine('validate');
	if(def==false){
		
		$('#employeeTest').validationEngine({validateNonVisibleFields: true});
		return false;
	}
	else {
		
		var $pre = $( this ).attr("data");
		var qtype=document.getElementById("qtype_"+$pre).value;
		if(qtype=='T'|| qtype=='S'){
			var ans=$("input[name='answer_"+$pre+"[]']:checked"). val();
			//alert(ans);
		}
		else if(qtype=='F'|| qtype=='B' || qtype=='FT'){
			var ans=$("#answer_"+$pre+"_0").val();
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
		totansweredquest=document.getElementById('totansweredquest').value;
		if(totansweredquest==""){
			totansweredquest= $pre;
		}
		else{
			var res=totansweredquest.split(',');
			if(res.indexOf($pre)==-1){
				totansweredquest= totansweredquest+","+$pre;
			}
		}
		//alert(ans);
		$("#totansweredquest").val(totansweredquest);
		var testid=document.getElementById("testid").value;
		var assess_test_id=document.getElementById("ass_test_id").value;
		var testtype=document.getElementById("ttype").value;
		var assessment_id=document.getElementById("assid").value;
		var question=document.getElementById("question_"+$pre).value;
		var $p=parseInt($pre)+1;
		$("#question_list"+$pre).hide();
		$("#question_button"+$pre).hide();
		$("#question_list"+$p).show();
		$("#question_button"+$p).show();
		$("#question_grid"+$pre).hide();
		$("#question_grid"+$p).show();
		$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v=C",
			success: function(result){
			
			var colors=result;
				
				var que_id=question;
				var question_id=".question_color"+question;
				var question_ids="#open_skip_question"+question;
				
				if(colors=='C'){
					$(question_id).removeClass('red');
					$(question_id).addClass('green');
					$(question_ids).attr('onclick','openskipdiv('+$pre+')');
				}
				else
				{
					$(question_id).addClass('red');
				} 
			}
		});
		
	}
	return false;
});

$( ".pre_question").click(function() {
	var next = $( this ).attr("data");
	var p=parseInt(next)-1;
	$("#question_list"+next).hide();
	$("#question_button"+next).hide();
	$("#question_list"+p).show();
	$("#question_button"+p).show();
	$("#question_grid"+next).hide();
	$("#question_grid"+p).show();
	return false;
});

$( ".skip_question").click(function() {
	var ans="";
	var next = $( this ).attr("data");
	var qtype=document.getElementById("qtype_"+next).value;
	if(qtype=='T'|| qtype=='S'){
		ans=$("input[name='answer_"+next+"[]']:checked"). val();
	}
	var p=parseInt(next)+1;
	var ne=parseInt(next);
	$("#skipvalue"+ne).val("SKIP");
	$("#question_list"+next).hide();
	$("#question_button"+next).hide();
	$("#question_list"+p).show();
	$("#question_button"+p).show();
	$("#question_grid"+next).hide();
	$("#question_grid"+p).show();
	var testid=document.getElementById("testid").value;
	var assess_test_id=document.getElementById("ass_test_id").value;
	var testtype=document.getElementById("ttype").value;
	var assessment_id=document.getElementById("assid").value;
	var question=document.getElementById("question_"+next).value;
	var skip_value=document.getElementById("skipvalue"+ne).value;
	//var ans="";
	//var qtype="";
	$.ajax({type: "GET",url: BASE_URL+"/employee/insert_question_answers?question_id="+question+"&assess_test_id="+assess_test_id+"&type="+testtype+"&assessment_id="+assessment_id+"&testid="+testid+"&ans="+ans+"&qtype="+qtype+"&skip_v="+skip_value,
		success: function(result){
		//alert(result);
		var colors=result;
			var question_id=".question_color"+question;
			var question_ids="#open_skip_question"+question;
			var que_id=question;
			//alert("***"+ans+"***"+colors+"***");
			if(colors=="SKIP" && (ans=="" || typeof ans==="undefined")){
				$(question_id).addClass('red');
				$(question_ids).attr('onclick','openskipdiv('+ne+')');
			}
			else
			{
				$(question_id).addClass('green');
				$(question_ids).attr('onclick','openskipdiv('+ne+')');
			} 
		}
	});
	return false;
		
});	


function click_submit() {
	totansweredquest=$("#totansweredquest").val();
	var res=totansweredquest.split(",");
	var res=totansweredquest.split(",");	
	var totquestion=document.getElementById('totquest').value;
	totquestion=parseInt(totquestion)-1;
	$("#employeeTest").validationEngine({validateNonVisibleFields: true,updatePromptsPosition:true});
	//$("#employeeTest").validationEngine('detach');
	//$("#employeeTest").validationEngine('attach');
	var vv=$("#employeeTest").validationEngine('validate');
	//alert(res.length + " " + totquestion +" "+ vv);
	if(totquestion==res.length){
		document.getElementById("employeeTest").submit();
	}
	else{
		alert("Please give answers to all questions.");
		return false;
	}
}
function openskipdiv(id){
	var pre=parseInt(id)+1;
	$(".test_paper").hide();
	$(".test_footer").hide();
	$("#question_list"+id).show();
	$("#question_button"+id).show();
	
}

function alertmsg(){
   toastr.error("Test Completed");
   return false;
}



jQuery(document).ready(function(){
    $('#definition_form').validationEngine();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
	if(res_stat=='review'){
		$('#step1_li').removeClass('active');
		$('#step1_li').addClass('complete');
		$('#step2_li').removeClass('active');
		$('#step2_li').addClass('complete');
		$('#step3_li').addClass('active');
		$('#step1').removeClass('active');
		$('#step2').removeClass('active');
		$('#step3').addClass('active');
		
		/* $('#fuelux-wizard').ace_wizard({ 
			step: 2 //optional argument. wizard will jump to step "3" at first
		}); */

		var valid=$('#definition_form').validationEngine('validate');
		if(valid==false){
			$('#definition_form').validationEngine('validate');
			return false;
		}else{
			var res_id=$('#structure_id').val();
			var res_def_id=$('#resource_def_id').val();			
			$('#res_cat').html($('#structure_id :selected').text());
			var rad_but=$('#definition_form input[type=radio]:checked').val();
			//if(rad_but=='I'){
				if(rad_but=='I'){$('#res_typ').html('Internal');}else{$('#res_typ').html('External');}
				var restype=$('#retype').val();
				$.ajax({
					type: "GET",
					url: BASE_URL+"/admin/resource_lables?res_id="+res_id+"&res_def_id="+res_def_id+"&type="+rad_but+"&restype="+restype,
					success:function(data){
						$('#details_res').html(data);
						if(restype=='TRA' && rad_but=='I'){
							
							employee_details($('#column1').val());
							
						}
					}
				});
			/* }else{
				$('#res_typ').html('External');
			} */
		}
		
		
	}
	
	if(status=='venue'){
		$('#search_resource12').val(2);
		getResourcedetails();
	}
});

/* $(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#star_tdate, #end_date" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays,
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "star_tdate" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});				   
});

$(document).ready(function() {
    $("#content div").hide(); // Initially hide all content
    $("#tabs li:first").attr("id","current"); // Activate first tab
    // $("#content div:first").fadeIn(); // Show first tab content
    
    $('#tabs a').click(function(e) {
        e.preventDefault();        
        $("#content div").hide(); //Hide all content
        $("#tabs li").attr("id",""); //Reset id's
        $(this).parent().attr("id","current"); // Activate this
        $('#' + $(this).attr('title')).fadeIn(); // Show content for current tab
    });
});
jQuery(document).ready(function(){
    $('#res_def').click(function(){
        $('#serach_res_def').removeClass('active');
        $('#res_def').addClass('active');
        $('#resource_definiton').show();
        $('#search_resource').hide();
    });
    $('#serach_res_def').click(function(){
        $('#res_def').removeClass('active');
        $('#serach_res_def').addClass('active');
        $('#search_resource').show();
        $('#resource_definiton').hide();       
    });
}); 
function getResourcedetails(){	
	var res_value=document.getElementById('search_resource12').value;
	if(res_value!=''){		
		document.getElementById('loading_img').style.display='block';
		$('#search_resource12').attr('disabled',true);
		var xmlhttp;
        if (window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
        }else{
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){			
				document.getElementById("external_resource_details").innerHTML=xmlhttp.responseText;				
				document.getElementById('loading_img').style.display='none';
				$('#search_resource12').attr('disabled',false);
				$("#slider-range").slider({
					range: true,
					min:0,
					max:999999,
					step:500,
					values: [ 0, 999999 ],
					slide: function(event, ui) {
						$("#amount").val(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
					}
				});
				$("#amount").val($("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider("values", 1));
				$("#accordion").accordion({
					active: false,
					collapsible: true
				})
			
				$( "#slider-range1" ).slider({
					range: true,
					min:0,
					max:999999,
					step:500,
					values: [ 0,999999 ],
					slide: function( event, ui ) {
						$( "#basic_tariff" ).val( ui.values[ 0 ] + "-" + ui.values[ 1] );
					}
				});
				$( "#basic_tariff" ).val(  $( "#slider-range1" ).slider( "values", 0 )+ "-" + $( "#slider-range1" ).slider( "values", 1 ) );
				$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy' });

            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/webservices_trainer?res_type="+res_value,true);
        xmlhttp.send(); 
	}else{
		document.getElementById('external_resource_details').innerHTML='';
	}
}
function search_res(link){
    window.location=BASE_URL+'/admin/'+link;
}
function updt_res(link,id){
	window.location=BASE_URL+"/admin/"+link+"?res_def_id="+id;		
	}*/
/* function get_extra_info(){
    var structid=document.getElementById('structure_id').value;
    if(structid!=''){
        var xmlhttp;
        if (window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
        }else{
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
				
				var strt=xmlhttp.responseText.split("#*");
				document.getElementById('resourcedatadiv').innerHTML=strt[0];
				document.getElementById("structure_name").value=strt[1];
                /*for(var i=0;i<10;i++){
                    document.getElementById("tr_"+i).style.display='';
                    document.getElementById("add_div_"+i).style.display='block';
                    document.getElementById("add_data_div_"+i).style.display='block';
                    document.getElementById("add_div_"+i).innerHTML=strt[i];	
                }
                document.getElementById("structure_name").value=strt[10];	
                //document.getElementById("add_div_").innerHTML=strt['+i+']; 
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/resources_details?structure_id="+structid,true);
        xmlhttp.send(); 
    }
    else{
        for(var i=0;i<10;i++){
			document.getElementById("tr_"+i).style.display='none';
            document.getElementById("add_div_"+i).style.display='none';
            document.getElementById("add_data_div_"+i).style.display='none';
            document.getElementById("add_div_"+i).innerHTML='';
        }
    }
} 
jQuery(document).ready(function(){
    if(status=='search_resource'){
        $('#res_def').removeClass('active');
        $('#serach_res_def').addClass('active');
        $('#resource_definiton').hide();
        $('#search_resource').show();

        $("#tabs li:first").attr('id',' ');
        $('#resource_li').attr('id','current');

    }
});

function search_extr(){
    var valid=$('#external_search').validationEngine('validate');
    if(valid==false){
        $('#external_search').validationEngine();
    }else{
        var vale=document.getElementById('search_resource12').value;
        if(vale=='2'){
            window.location.href = BASE_URL+'/admin/webservices';
        }
        if(vale=='1'){
            window.location.href = BASE_URL+'/admin/webservices_trainer';
        }
    }
}
function search_result(){   
	var vale=document.getElementById('search_resource12').value;
	 if(vale==''){
	   window.location.href = BASE_URL+'/admin/resoures_external';
	 }
	if(vale=='2'){
		window.location.href = BASE_URL+'/admin/webservices';
	}
	if(vale=='1'){
		window.location.href = BASE_URL+'/admin/webservices_trainer';
	}    
}*/
//Resources modification functions starts
jQuery(function($) {
			
	$('[data-rel=tooltip]').tooltip();

	$(".select2").css('width','200px').select2({allowClear:true})
	.on('change', function(){
		$(this).closest('form').validate().element($(this));
	}); 


	var $validation = false;
	$('#fuelux-wizard')
	.ace_wizard({ 
		//step: 2 //optional argument. wizard will jump to step "2" at first
	})
	.on('change' , function(e, info){
		/* if(info.step == 1 && $validation) {
			if(!$('#validation-form').valid()) return false;
		} */
		if(info.step == 1){
			var resource_def_id=$('#resource_def_id').val();
			var valid=$('#definition_form').validationEngine('validate');
			if(valid==false){
				$('#definition_form').validationEngine('validate');
				return false;
			}else{
				var res_id=$('#structure_id').val();
				$('#res_cat').html($('#structure_id :selected').text());
				var rad_but=$('#definition_form input[type=radio]:checked').val();
				var restype=$('#retype').val();
				var res_def_id='';
				if(document.getElementById('resource_def_id')){
					res_def_id=$('#resource_def_id').val();
				}
				if(rad_but=='I'){
					//if(type=='TRA'){
					if(resource_def_id==""){
						$('#res_typ').html('Internal');
						$.ajax({
							type: "GET",
							url: BASE_URL+"/admin/resource_lables?res_id="+res_id+"&res_def_id="+res_def_id+"&type="+rad_but+"&restype="+restype,
							success:function(data){
								$('#details_res').html(data);
								if(document.getElementById('resource_def_id')){
									if(restype=='TRA' && rad_but=='I'){
										employee_details($('#column1').val());
									}
								}
							}
						});
					}
					//}
					
				}
				if(rad_but=='E'){
					if(restype=='TRA'){
						if(resource_def_id==""){
						$('#res_typ').html('External');
						var restype=$('#retype').val();
						
						
						var rad_but=$('#definition_form input[type=radio]:checked').val();
						if(restype=='TRA' && rad_but=='E' && resource_def_id==""){
							var str_tra = $("#search_ttrainer").val();
							if(str_tra!='' && str_tra!="undefined"){
								var res_id=$('#structure_id').val();
								$('#res_cat_3').html($('#structure_id :selected').text());
								var rad_but=$('#definition_form input[type=radio]:checked').val();
								
								$('#res_typ_3').html('External');
								$.ajax({
									type: "GET",
									url: BASE_URL+"/admin/resource_lables?res_id="+res_id+"&type="+rad_but+"&restype="+restype,
									success:function(data){
										$('#details_res').html(data);
									}
								});
								/* $.ajax({
									type: "GET",
									url: BASE_URL + "/admin/getExternalTrainer?id=" + str_tra,
									success:function(data2){
										var tra=data2.split(',');
										
									}
								}); */
							}else{
								var res_id=$('#structure_id').val();
								$('#res_cat_3').html($('#structure_id :selected').text());
								var rad_but=$('#definition_form input[type=radio]:checked').val();
								$('#res_typ_3').html('External');
								$.ajax({
									type: "GET",
									url: BASE_URL+"/admin/resource_lables?res_id="+res_id+"&type="+rad_but+"&restype="+restype,
									success:function(data){
										$('#details_res_3').html(data);
									}
								});
								//$("#definition_form").submit();
							}
						}
						/* $('#loading_img').css('display','block');
						$.ajax({
							type: "GET",
							url: BASE_URL+"/admin/external_search",
							success:function(data){
								$('#details_res').html(data);
								$('#loading_img').css('display','none');
								$("#slider-range").slider({
									range: true,
									min:0,
									max:999999,
									step:500,
									values: [ 0, 999999 ],
									slide: function(event, ui) {
										$("#amount").val(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
									}
								});
								$("#amount").val($("#slider-range").slider("values", 0) + " - " + $("#slider-range").slider("values", 1));
								$("#accordion").accordion({
									active: false,
									collapsible: true
								})
							}
						}); */
						}
						else{
							check_role();
						}
					}
					else{
						$('#res_typ').html('External');
						if(resource_def_id==""){
							$.ajax({
								type: "GET",
								url: BASE_URL+"/admin/resource_lables?res_id="+res_id+"&type="+rad_but+"&restype="+restype,
								success:function(data){
									$('#details_res').html(data);
								}
							});
						}
					}
				}
			}
		}
		if(info.step == 2){
			var resource_def_id=$('#resource_def_id').val();
			var valid=$('#definition_form').validationEngine('validate');
			if(valid==false){
				$('#definition_form').validationEngine('validate');
				return false;
			}else{				
				var restype=$('#retype').val();
				var rad_but=$('#definition_form input[type=radio]:checked').val();
				if(restype=='TRA' && rad_but=='E' && resource_def_id!=""){
					
				}
				/* if(restype=='TRA' && rad_but=='E' && resource_def_id==""){
					var str_tra = $("#search_ttrainer").val();
					if(str_tra!=''){
						var res_id=$('#structure_id').val();
						$('#res_cat_3').html($('#structure_id :selected').text());
						var rad_but=$('#definition_form input[type=radio]:checked').val();
						
						$('#res_typ_3').html('External');
						$.ajax({
							type: "GET",
							url: BASE_URL+"/admin/resource_lables?res_id="+res_id+"&type="+rad_but+"&restype="+restype,
							success:function(data){
								$('#details_res_3').html(data);
							}
						});
						$.ajax({
							type: "GET",
							url: BASE_URL + "/admin/getExternalTrainer?id=" + str_tra,
							success:function(data2){
								var tra=data2.split(',');
								
							}
						});
					}else{
						var res_id=$('#structure_id').val();
						$('#res_cat_3').html($('#structure_id :selected').text());
						var rad_but=$('#definition_form input[type=radio]:checked').val();
						$('#res_typ_3').html('External');
						$.ajax({
							type: "GET",
							url: BASE_URL+"/admin/resource_lables?res_id="+res_id+"&type="+rad_but+"&restype="+restype,
							success:function(data){
								$('#details_res_3').html(data);
							}
						});
						//$("#definition_form").submit();
					}
				}
				else */ if(restype=='TRA' && rad_but=='I'){
					$('#res_cat_3').html($('#structure_id :selected').text());
					var rad_but=$('#definition_form input[type=radio]:checked').val();
					$('#res_typ_3').html('Internal');
				}
				else{
					//$("#definition_form").submit();					
				}
			}
		}
		
	})
	.on('finished', function(e) {
		/* bootbox.dialog({
			message: "Thank you! Your information was successfully saved!", 
			buttons: {
				"success" : {
					"label" : "OK",
					"className" : "btn-sm btn-primary"
				}
			}
		}); */
		$("#definition_form").submit();
	}).on('stepclick', function(e){
		//e.preventDefault();//this will prevent clicking and selecting steps
	});


	//jump to a step
	$('#step-jump').on('click', function() {
		var wizard = $('#fuelux-wizard').data('wizard')
		wizard.currentStep = 2;
		wizard.setState();
	})
	//determine selected step
	//wizard.selectedItem().step

			
	//documentation : http://docs.jquery.com/Plugins/Validation/validate

	$('#modal-wizard .modal-header').ace_wizard();
	$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');	
	
})

/* $('input[type=radio][name=resr_type]').change(function() {
	if (this.value == 'I') {
		alert("Internal");
	}
	else if (this.value == 'E') {
		alert("Exteranl");
	}
}); */
$('#structure_id').on('change',function(){
	$.ajax({
		type: "GET",
		url: BASE_URL+"/admin/getResourceTypes?resid="+this.value,
		success:function(response){
			$('#retype').val(response);
		}
	});
});
function employee_details(empid){
	var restype=$('#retype').val();
	if(restype=='TRA'){
		$('#role_name').css('display','none');
		//$('#add_role').val('');
		//$('#Status').val('');
		var key=$('#key_val').val();var i;
		$.ajax({
			type:"GET",
			url: BASE_URL+"/admin/employeeDetails?empid="+empid,
			success:function(data){
				var resp=data.split(',');
				for(i=0; i<=key; i++){
					var j=i+1;
					if($('#column'+j).attr('type')=="text"){
						$('#column'+j).val(resp[i]);
					}
				}
			}
		});
	}
}
function check_user(){
	var restype=$('#retype').val();
	if(restype=='TRA'){
		var add=$('#add_role').val();
		if(add=='Y'){
			var empid=$('#column1').val();
			if(empid!=''){
				$.ajax({
					type:"GET",
					url: BASE_URL+"/admin/checkUser?empid="+empid,
					success:function(resp){
						var res=resp.split('#$');
						if(res[0]==0){
							$('#role_name').css('display','none');
							$('#add_role').val('');
							alertify.alert("User does not exists for the selected employee");
							return false;
						}else{
							if(res[1]){
								if(res[1]=='tra'){
									$('#add_role').val('');
									alertify.alert("Trainer Role exists for the employee");
									return false;
								}else{
									alert(res[1]);
									$('#role_name').css('display','block');
									var men=res[1].split('_');
									$('#menu_id').val(men[0]);
									
									$('#rolename').html(men[1]);									
									var resdt=res[0].split(',');
									$('#user_id').val(resdt[0]);
									$('#user_start_date').val(resdt[1]);
									$('#user_end_date').val(resdt[2]);
								}
							}
						}
						$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
					}
				});
			}else{alertify.alert("Please select Employee");return false;}
		}else{
			$('#rolename').val('');
			$('#role_name').css('display','none');
		}
	}
}
function check_role(){
	var restype=$('#retype').val();
	var add=$('#add_role').val();
	if(add=='Y'){
		$.ajax({
			type:"GET",
			url: BASE_URL+"/admin/checkRoleTra",
			success:function(resp){
				if(resp==0){
					$('#role_name').css('display','none');
					alertify.alert("Trainer Role does not exists");
					return false;
				}else{
					var data=resp.split('&*');
					$('#role_name').css('display','block');
					$('#rolename').html(data[1]);
					$('#menu_id').val(data[0]);
					$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
				}
			}
		});		
	}else{
		$('#rolename').val('');
		$('#role_name').css('display','none');
	}
}
//Code for external trainers search
function gettheme(){
	var str = $('#category_id').val();
	if (str==''){
		$("#divtheme").html("<select id='theme_id' name='theme_id' class='col-xs-12 col-sm-6' ><option value=''>Select</option></select>");
		if(document.getElementById('subcat_id')){$('#subcat_id').css('display','none');}
		$('#subcat_name').css('display','none');
		$('#Automoblie').css('display','none');
	}
	else{
		if (str == "1"){			
			$.ajax({
				type:"GET",
				url: BASE_URL+"/admin/SubCat?id=" + str,
				success:function(data){
					$("#divSubcat").html(data);
					$('#divSubcat').css('display','block');
					$('#subcat_name').css('display','block');
				}				
			});
			$("#divtheme").html("<select id='theme_id' name='theme_id' class='col-xs-12 col-sm-6' ><option value=''>Select</option></select>");
		}	
		else{
			if (document.getElementById('subcat_id')){
				$('#subcat_id').val('');
			}
			document.getElementById('subcat_ids').checked = false;
			document.getElementById('subcat_idss').checked = false;			
			$.ajax({
				type:"GET",
				url: BASE_URL+"/admin/theme1?id=" + str,
				success:function(data){
					$("#divtheme").html(data);
					$('#divSubcat').css('display','none');
					$('#subcat_name').css('display','none');
					$('#Automoblie').css('display','none');
				}				
			});
		}
	}
}

function display4(){
	if (document.getElementById('Loc_training1').checked == true){
		$("#stateclientname1").removeClass('countcss');
		$('#stateclient').css('display','block');
		$('#stateclientname').css('display','block');
		//document.getElementById('stateclientname1').style.display='block';
		$('#pani').css('display','block');
		var a = $('#state23').html("<select name='stateidclient' id='stateidclient' class='col-xs-12 col-sm-6' onchange='getcity()' ><option value=''>State</option></select>");
		$('#city23').html("<select name=\"pan[]\" id='pan' multiple='multiple' class='textin col-xs-12 col-sm-6' size='4'   ><option value='' >City</option></select>");
		$('#country_idclient').val('');
		$('#stateidclient').val('');
	}
	else if (document.getElementById('Loc_training2').checked == true)
	{
		$('#pani').css('display','none');
		var b = $('#pan').val('');
	}
	else{
		
		// To fetch states from .php page
		if(states!=''){
			var state=states.split(',');
			var stat='';
			for(var i=0;i<state.length;i++){
				stat1=state[i];
				stat2=stat1.split('*');
				if(stat==''){
					stat="<option value='"+stat2[0]+"'>"+stat2[1]+"</option>";
				}else{
					stat=stat+"<option value='"+stat2[0]+"'>"+stat2[1]+"</option>";
				}
			}
		}else{
			stat='';
		}
	
		$("#stateclientname1").addClass('countcss');
		$('#stateclient').css('display','none');
		$('#stateclientname').css('display','none');
		//document.getElementById('stateclientname1').style.display='none';
		$('#stateidclient').val('');
		$('#city23').html("<select name=\"pan[]\" id='pan' multiple='multiple' class='textin col-xs-12 col-sm-6' size='4'   ><option value='' >City</option></select>");
		var a = $('#state23').html("<select name='stateidclient' id='stateidclient' class='col-xs-12 col-sm-6' onchange='getcity()' ><option value=''>State</option>"+stat+"</select>");
		$('#pani').css('display','block');
		$('#Loc_training1').val('');
		$('#Loc_training2').val('');
	}
}
function getcity(){
	var str = $("#stateidclient").val();
	if (str == ""){
		$("#city23").html("<select multiple='multiple' size='4' name='pan[]' id='pan' class='textin col-xs-12 col-sm-6'  ><option value='' >City</option></select>");
		return false;
	}	
	$.ajax({
		type:"GET",
		url: BASE_URL+"/admin/city1?state=" + str,
		success:function(data){
			$("#city23").html(data);
		}				
	});	
}

function searchtrainr(startnext){
	var valid=$('#commentForm').validationEngine('validate');
	if(valid==false){
		$('#commentForm').validationEngine();
	}else{
		$('#loading_img').css('display','block');
		$('#external_resource_details *').prop('disabled',true);
		//$('#search_resource12').attr('disabled',true);
		var category_id=$('#category_id').val();
		var theme_id=$('#theme_id').val();
		var city=document.getElementById('pan');
		var j=0,city_arry=new Array();
		for(var i=0;i<city.options.length;i++){
			if(city.options[i].selected==true){
				city_arry[j]=city.options[i].value;
				j++;    
		   
			}
		}
		//var subtheme_id=document.getElementById('subtheme_id').value;
		var Part_level_couunt=$('#Part_level_couunt').val();
		var j=0,part_arry=new Array();
		for(var i=0;i<=Part_level_couunt;i++){
			var Part_level=document.getElementById('Part_level'+i);
			if(Part_level.checked==true){
				part_arry[j]=Part_level.value;
				j++;    
			}
		}
		var no_participants=$('#no_participants').val();
		//var ind=document.getElementById('ind').value;
		var co_host='';
		if(document.getElementById('ya1').checked==true){
		   co_host=$('#ya1').val();
		}
		if(document.getElementById('ya').checked==true){
			co_host=$('#ya').val();
		}
		var travel_type='';
		if(document.getElementById('r').checked==true){
			var travel_type=$('#r').val();
		}
		var travel_type1=$('#plane').val();
		var travel_type2=$('#train').val();
		var accod_prefer='';
		if(document.getElementById('a').checked==true){
		   accod_prefer=$('#a').val();
		}
		if(document.getElementById('c').checked==true){
		   accod_prefer=$('#c').val();
		}
		if(document.getElementById('o').checked==true){
		   accod_prefer=$('#o').val();
		}
		if(document.getElementById('d').checked==true){
		   accod_prefer=$('#d').val();
		}
		var amount=$('#amount').val();		
		
		$.ajax({
			type:'GET',
			url: BASE_URL+"/admin/searchtrainerdeatils?category_id="+category_id+"&theme_id="+theme_id+"&city="+city_arry+"&part_level="+part_arry+"&no_participants="+no_participants+"&co_host="+co_host+"&travel_type="+travel_type+"&travel_type1="+travel_type1+"&travel_type2="+travel_type2+"&accod_prefer="+accod_prefer+"&amount="+amount,
			success:function(response){
				$("#trainer_details").html(response);       		
				$('#loading_img').css('display','none');
				$('#external_resource_details *').prop('disabled',false);
				$('#search_resource12').attr('disabled',false);
				// $('#tablevenue').dataTable({ "bJQueryUI": true, "sPaginationType": "full_numbers"});
				$('#tablevenue').dataTable({ bAutoWidth: false,	"aoColumns": [{ "bSortable": false }, null, null,null, null, null]});
			}
		});
	}
}
function checkAll(){
	var tbl = document.getElementById('tablevenue');
	var lastRow = tbl.rows.length;
	if(lastRow>1){
		for(var i=1; i<lastRow; i++){
			var row = tbl.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(document.getElementById('chk_main').checked==true){
				if(chkbox.disabled==false){
					chkbox.checked = true ;
				}
			}
			else{
				if(chkbox.disabled==false){
					chkbox.checked = false ;
				}
			}
		}
	}
	checkvalu1();
}
//Function changed bcoz trainer selection has changed to radio button from checkbox
//To select single trainer at a time.
//If multiple trainers has to select than comment this function and uncomment the next function
function checkvalu1(){
	if($("input[name='check1']").is(':checked')){
		var venu=document.querySelector('input[name="check1"]:checked').value;
		$('#search_ttrainer').val(venu);
	}else{
		$('#search_ttrainer').val('');
	}
}
/* function checkvalu1(){
	var flag=0;
	var table = document.getElementById('tablevenue');
	var rowCount = table.rows.length;
	var venu=new Array();
	var j=0;
	var venu=$('#search_ttrainer').val();
	venu=venu.split(',');
	if(venu==""){
		j=0;
	}
	else{
		j=venu.length;
	}	
	if(rowCount>1){
		for(var i=1; i<rowCount; i++){
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			
			if(null!= chkbox){
				if(true== chkbox.checked){
					flag2=0;
					for(var k=0; k<venu.length; k++){
						if(venu[k]==chkbox.value){
							flag2=1;
							break;
						}
					}
					if(flag2==0){
						venu[j]=rad_val;
						flag=1;
						j++;
					}
				}
				else{
					for(var k=0; k<venu.length; k++) {
						if(venu[k]==chkbox.value){
							venu.splice(k,1);								
							j--;
							break;
						}
					}
				}
			}
		}
	}
	var a =$('#search_ttrainer').val(venu);
} */
function gettrainerdet(id){
	document.getElementById("msg_box33").innerHTML='';
	document.getElementById('loading_img').style.display='block';
	$('#commentForm *').prop('disabled',true);	
	$.ajax({
		type: "GET",
		url: BASE_URL+"/admin/quotodetails2?id="+id,
		success: function(data){
			$("#msg_box33").html(data);
			$('#loading_img').css('display','none');
			$('#commentForm *').prop('disabled',false);
			$(document).ready(function() {
				$("#content div").hide(); // Initially hide all content
				$("#tabs li:first").attr("id","current"); // Activate first tab
				$("#content div:first").fadeIn(); // Show first tab content
				
				$('#tabs a').click(function(e) {
					e.preventDefault();        
					$("#content div").hide(); //Hide all content
					$("#tabs li").attr("id",""); //Reset id's
					$(this).parent().attr("id","current"); // Activate this
					$('#' + $(this).attr('title')).fadeIn(); // Show content for current tab
				});
				$('#education').click(function(){
					$('#work-experience').removeClass('active');
					$('#education').addClass('active');
					$('#work-experience1').hide();
					$('#education1').show();
				});
				$('#work-experience').click(function(){
					$('#education').removeClass('active');
					$('#work-experience').addClass('active');
					$('#education1').hide();
					$('#work-experience1').show();
				});
    
			});
		}
	});
}
function hhh5(){
	$('#personal').addClass('active');
	$('#education1').hide();
	$('#work-experience1').hide();
	$('#consulting1').hide();
	$('#training-exp1').hide();
	$('#preference1').hide();
	$('#personal1').show();
}
function hhh(){
	$('#work-experience').removeClass('active');
	$('#education').addClass('active');
	$('#personal1').hide();
	$('#work-experience1').hide();
	$('#consulting1').hide();
	$('#training-exp1').hide();
	$('#preference1').hide();
	$('#education1').show();
}
function hhh1(){
	$('#education').removeClass('active');
	$('#work-experience').addClass('active');
	$('#personal1').hide();
	$('#education1').hide();
	$('#consulting1').hide();
	$('#training-exp1').hide();
	$('#preference1').hide();
	$('#work-experience1').show();
}
function hhh2(){
	$('#education').removeClass('active');
	$('#work-experience').addClass('active');
	$('#personal1').hide();
	$('#education1').hide();
	$('#consulting1').show();
	$('#training-exp1').hide();
	$('#preference1').hide();
	$('#work-experience1').hide();
}
function hhh3(){
	$('#education').removeClass('active');
	$('#work-experience').addClass('active');
	$('#personal1').hide();
	$('#education1').hide();
	$('#consulting1').hide();
	$('#training-exp1').show();
	$('#preference1').hide();
	$('#work-experience1').hide();
}
function hhh4(){
	$('#education').removeClass('active');
	$('#work-experience').addClass('active');
	$('#personal1').hide();
	$('#education1').hide();
	$('#consulting1').hide();
	$('#training-exp1').hide();
	$('#preference1').show();
	$('#work-experience1').hide();
}
function viewprofile(status,id){
	$("#view"+status+id).show();
	$("#knw"+status+id).hide();
}	
function collapseprofile(status,id){
	$("#view"+status+id).hide();
	$("#knw"+status+id).show();
}
function downloadpdf(){
	var str = $("#search_ttrainer").val();
	if(str==''){
		$("#popup").html('<h4>Please select the Trainer</h4>');
		return false;
	}else{		
		$.ajax({
			type: "GET",
			url: BASE_URL + "/admin/searchtrainer_generate_pdf?id=" + str,
			success:function(data){
				data=data.split("*");
				if(data[0]==1){
					window.location=BASE_URL+ "/admin/resoures?"+data[1];
					//$("#popup").html("<h4>Successfully Downloaded</h4>");
				}else{
					$("#popup").html("<h4>Not able to download</h4>");
				}
			}
		});
	}	
}
function checkUserhet(field, rules, i, options){
	var url = BASE_URL+"/index/checkusername/";
	var user_id=$("#user_id").val();
	var id=field.attr("id");
    var data = "fieldId="+field.attr("id")+"&fieldValue="+field.val()+"&user_id="+user_id;//field.attr("id") + "=" + field.val();
    var msg = undefined;
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        dataType: "json",
        data: data,
        async: false,
        success: function(json) {
            if(!json[1]) {
                msg = json[1];
            }
        }            
    });  
    if(msg != undefined) {
        return options.allrules.checkUserhet.alertText;
    }
}

function checkResourcehet(field, rules, i, options){
	var url = BASE_URL+"/index/checkresource/";
	var resource_def_id=$("#resource_def_id").val();
	var id=field.attr("id");
    var data = "fieldId="+field.attr("id")+"&fieldValue="+field.val()+"&resource_def_id="+resource_def_id;//field.attr("id") + "=" + field.val();
    var msg = undefined;
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        dataType: "json",
        data: data,
        async: false,
        success: function(json) {
            if(!json[1]) {
                msg = json[1];
            }
        }            
    });  
    if(msg != undefined) {
        return options.allrules.checkResourcehet.alertText;
    }
}
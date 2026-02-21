jQuery(document).ready(function(){
	jQuery("#reportForm").validationEngine();
	$('.scrollable_table').each(function () {
		var $this = $(this);
		$(this).ace_scroll({
			size: $this.data('height') || 400,
			//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
		});
	});
});
$(document).ready(function(){
	//    $('#starttime').timepicker();
	$('.datepicker').datepicker();
});

$(document).ready(function(){
	$('#reportDetial').modal({
		show: false,
		backdrop: 'static',
		keyboard: false  // to prevent closing with Esc button (if you want this too)
	});	
});

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
});

// function downloadexcel(){ 
     // $("#employeesTable").btechco_excelexport({
                // containerid: "#employeesTable"
               // , datatype: $datatype.Table
            // });
  
  // }

function getparameters(rep){
	//var rep=document.getElementById('report').value;
	var repname=document.getElementById('report_name'+rep).value;	 
    //alertify.alert(repname);
	 /* var repname=$('#report option:selected').text(); */
	//$('#report_detail').addClass('widget-header');
	
	 document.getElementById('reportname').value=repname; 
	 if(rep!=''){        
            var  xmlhttp2;
            if (window.XMLHttpRequest){
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp2=new XMLHttpRequest();
            }
			else{
					xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
			  }
            xmlhttp2.onreadystatechange=function(){
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
                         document.getElementById('div_params').innerHTML=xmlhttp2.responseText;
						 document.getElementById('report_detail').innerHTML ="-"+repname;
					jQuery(document).ready(function(){
					$('#startdate, #enddate').datepicker('destroy');
					var dates = $( "#startdate, #enddate" ).datepicker({dateFormat:"dd-mm-yy",
					defaultDate:"+1w" , 
					changeMonth: true,
					numberOfMonths: 1,
					onSelect: function( selectedDate ) { 
						var option = this.id === "startdate" ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
							dates.not( this ).datepicker( "option", option, date );
						}
					});	
				});
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
					$(window).on('resize.chosen', function() {
					var w = $('.chosen-select').parent().width();
					if(w<=25){w=250;}
					$('.chosen-select').next().css({'width':w});
					}).trigger('resize.chosen');
	 
                }
             }
		//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
		xmlhttp2.open("GET",BASE_URL+"/report/getparameters?rep="+rep,true);
		xmlhttp2.send();
      } 
    else {
	       document.getElementById('div_params').innerHTML="<div >Plese select Report </div>";
	     }    
 	 
      }
  
function geteventdates(){
     var eve=document.getElementById('evename').value;
	 
	    var  xmlhttp2;
            if (window.XMLHttpRequest){
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp2=new XMLHttpRequest();
             }
            else{
                    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp2.onreadystatechange=function(){
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
                         document.getElementById('datesdiv').innerHTML=xmlhttp2.responseText;
                     }
             }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/report/geteventdates?id="+eve,true);
	xmlhttp2.send();
	 

  }  
function getevents(){
   var eve=document.getElementById('evee').value;
   var prog=document.getElementById('programs').value;
   var typeid=document.getElementById('typeid').value;
    if(eve==1){
	    var  xmlhttp2;
            if (window.XMLHttpRequest){
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp2=new XMLHttpRequest();
            }
            else{
                    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp2.onreadystatechange=function(){
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
                         document.getElementById('div_events').innerHTML=xmlhttp2.responseText;
                     }
             }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/report/getalleventsbyprog?id="+prog+"&typeid="+typeid,true);
	xmlhttp2.send();
	  }
   }
   
   function get_bus(){
  
   var location=document.getElementById('proglocation').value;
   var typeid=document.getElementById('typeid').value;
    if(location!=''){
	    var  xmlhttp2;
            if (window.XMLHttpRequest){
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp2=new XMLHttpRequest();
            }
            else{
                    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp2.onreadystatechange=function(){
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
                         document.getElementById('orgs').innerHTML=xmlhttp2.responseText;
                     }
             }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/report/getallbus?id="+location+"&typeid="+typeid,true);
	xmlhttp2.send();
	  }
   }
   
   function getbudperiodnames(){
	   var budgetid=document.getElementById('budgetname').value;
	   var  xmlhttp2;
		if (window.XMLHttpRequest){
		   // code for IE7+, Firefox, Chrome, Opera, Safari
		   xmlhttp2=new XMLHttpRequest();
		}
		else{
			xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp2.onreadystatechange=function(){
			if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
				document.getElementById('budget').innerHTML=xmlhttp2.responseText;
			}
		}
		//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
		xmlhttp2.open("GET",BASE_URL+"/report/getbudgetperiods?budgetid="+budgetid,true);
		xmlhttp2.send();
	}
	
	function getsearchdata(){
		// document.getElementById('msg_box33').style.display='block';
		var val=$('#reportForm').validationEngine('validate');
		if(val==false){
			$('#reportForm').validationEngine();
		}
		else{
			var repname=document.getElementById('reportname').value;
			// $('#report_a').attr('href','#reportDetial');
			// $('#report_a').attr('data-toggle','modal');
			var reporttype=document.getElementById('type_id').value;
			var params=document.getElementById('paramscode').value;
			//  var prog='',eve='',ses='',orgname='',enrol='',enumber='',stdate='',endate='',resourcestatus='',catname='',testtype='',teststatus='',tnayear='',tnamanager='',transource='',restype='',vendororg='',vendorname='',location='';
			var param1=param2=param3=param4=param5=param6=param7='';
			if(params!=''){
				var s=params.split("***");
				for(var i=0;i<s.length;i++){
					if(reporttype==1){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){  param2=document.getElementById('evename').value;   }
						if(s[i]=='SYSTEM_ENROLLMENT_STATUS'){ param3=document.getElementById('enronlstatus').value; }
						if(s[i]=='PROG_LOCATION'){ param4=document.getElementById('proglocation').value;}
						if(s[i]=='ORG_NAME'){ param5=document.getElementById('org_name').value;}
						if(s[i]=='EMP_NUM'){ param6=document.getElementById('empnumber').value;  }
					}
					else if(reporttype==2){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){  param2=document.getElementById('evename').value;   }
					}
					else if(reporttype==3){ 
						if(s[i]=='CAT_NAME'){ param1=document.getElementById('cat_name').value; }
						if(s[i]=='RESOURCE_BOOKING_STATUS'){ param2=document.getElementById('resourcestatus').value; }
					}
					else if(reporttype==4){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){  param2=document.getElementById('evename').value;   }
						if(s[i]=='SESS_NAME'){  param3=document.getElementById('session_name').value;   }
						if(s[i]=='EVALU_TYPE'){  param4=document.getElementById('evaluation_type').value;   }
					}
					else if(reporttype==5){
						if(s[i]=='EVE_NAME'){  param1=document.getElementById('evename').value;   }
					}
					else if(reporttype==7){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){  param2=document.getElementById('evename').value;   }
						if(s[i]=='SESS_NAME'){  param3=document.getElementById('session_name').value;   }
						if(s[i]=='EMP_NUM'){ param4=document.getElementById('empnumber').value;  }
						if(s[i]=='EVAL_TYPE'){ param5=document.getElementById('test_type').value;   }
						if(s[i]=='TEST_STATUS'){ param6=document.getElementById('test_status').value;   }
					}
					else if(reporttype==8){
						if(s[i]=='CAT_NAME'){ param1=document.getElementById('cat_name').value; }
						if(s[i]=='PROG_NAME'){ param2=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){  param3=document.getElementById('evename').value;   }
					}		  
					else if(reporttype==9){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){  param2=document.getElementById('evename').value;   }
					}
					else if(reporttype==10){
						if(s[i]=='TNA_YEAR'){ param1=document.getElementById('tnayear').value;  }
						if(s[i]=='ORG_NAME'){ param2=document.getElementById('org_name').value;}
						if(s[i]=='DEPT'){ param3=document.getElementById('department').value;}
						if(s[i]=='PROG_LOCATION'){ param4=document.getElementById('proglocation').value; }
						if(s[i]=='LEVEL'){ param5=document.getElementById('level').value; }
						if(s[i]=='CAT_NAME'){ param6=document.getElementById('cat_name').value; }
						if(s[i]=='MNGR'){ param7=document.getElementById('tnamanager').value;   }	
						/* if(s[i]=='TNA_YEAR'){ param1=document.getElementById('tnayear').value;  }
						if(s[i]=='ORG_NAME'){ param2=document.getElementById('org_name').value;}
						if(s[i]=='DEPT'){ param5=document.getElementById('department').value;}
						if(s[i]=='PROG_LOCATION'){ param6=document.getElementById('proglocation').value; }
						if(s[i]=='LEVEL'){ param7=document.getElementById('level').value; }
						if(s[i]=='CAT_NAME'){ param4=document.getElementById('cat_name').value; }
						if(s[i]=='MNGR'){ param3=document.getElementById('tnamanager').value;   } */
						//if(s[i]=='PROG_NAME'){ param5=document.getElementById('programs').value; }
						//if(s[i]=='TRAINING_SRC'){ param6=document.getElementById('transource').value;   }
					}
					else if(reporttype==11){	
						//if(s[i]=='VENDOR_ORG'){ param1=document.getElementById('vendororg').value;   }
						if(s[i]=='RES_CAT'){ param1=document.getElementById('resourcecategory').value;   }
						if(s[i]=='VENDOR_NAME'){ param2=document.getElementById('vendorname').value;   }
						if(s[i]=='RES_TYPE'){ param3=document.getElementById('res_type').value;   }
						if(s[i]=='PROG_NAME'){ param4=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){  param5=document.getElementById('evename').value;   }
					} 
					else if(reporttype==12){
						// if(s[i]=='ORG_NAME'){ param1=document.getElementById('org_name').value; }
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='PROG_LOCATION'){ param2=document.getElementById('proglocation').value; }
					}
					else if(reporttype==13){
						if(s[i]=='PROG_LOCATION'){ param1=document.getElementById('proglocation').value; }
						if(s[i]=='LEVEL'){ param2=document.getElementById('level').value; }
						if(s[i]=='CAT_NAME'){ param3=document.getElementById('cat_name').value; }
						if(s[i]=='ORG_NAME'){ param4=document.getElementById('org_name').value; }
						if(s[i]=='DEPT'){ param5=document.getElementById('department').value; }
					}
					else if(reporttype==14){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){ param2=document.getElementById('evename').value; }
						if(s[i]=='FEEDBACK_TEMP'){ param3=document.getElementById('feedback').value; }
					}
					else if(reporttype==15){
						if(s[i]=='BUDGET_NAME'){ param1=document.getElementById('budgetname').value; }
						if(s[i]=='BUDGET_PERIOD'){ param2=document.getElementById('budget').value; }
						//if(s[i]=='ORG_NAME'){ param2=document.getElementById('org_name').value; }
						if(s[i]=='PROG_LOCATION'){ param3=document.getElementById('proglocation').value; }
					}
					else if(reporttype==16){
						if(s[i]=='YEAR'){ param1=document.getElementById('year_id').value; }
						if(s[i]=='MONTH'){ param2=document.getElementById('month_id').value; }
					}
					else if(reporttype==17){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){ param2=document.getElementById('evename').value; }
						if(s[i]=='TRAINER_NAME'){ param3=document.getElementById('tra_name').value; }
					}
					else if(reporttype==18){
						if(s[i]=='MONTH'){ param1=document.getElementById('month_id').value; }
						if(s[i]=='YEAR'){ param2=document.getElementById('year_id').value; }
					}
					else if(reporttype==19){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){ param2=document.getElementById('evename').value; }
					}
					else if(reporttype==20){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){ param2=document.getElementById('evename').value; }
						if(s[i]=='TEST_NAME'){ param3=document.getElementById('test_name').value; }
						if(s[i]=='TRAINER_NAME'){ param4=document.getElementById('tra_name').value; }
					}
					else if(reporttype==21){
						if(s[i]=='PROG_NAME'){ param1=document.getElementById('programs').value; }
						if(s[i]=='EVE_NAME'){ param2=document.getElementById('evename').value; }
						if(s[i]=='PROG_LOCATION'){ param3=document.getElementById('proglocation').value; }
					}
					else if(reporttype==22){
						if(s[i]=='CAL_NAME'){ param1=document.getElementById('calendar_id').value; }
						if(s[i]=='LOCATION_ZONES'){ param2=document.getElementById('zone_id').value; }
						if(s[i]=='MONTH'){ param3=document.getElementById('month_id').value; }
					}
					else if(reporttype==23){
						if(s[i]=='Bul_NAME'){ param1=document.getElementById('bul_name').value;  }
						if(s[i]=='ORG_NAME'){ param2=document.getElementById('org_name').value;}
						if(s[i]=='BUL_ZONE'){ param3=document.getElementById('zone_id').value;}
						if(s[i]=='BUL_LOCATION'){ param4=document.getElementById('proglocation').value; }
						if(s[i]=='DEPT'){ param5=document.getElementById('department').value; }
						if(s[i]=='LEVEL'){ param6=document.getElementById('level').value; }
					}
					else if(reporttype==24){
						if(s[i]=='ASSESS_NAME'){ param1=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param2=document.getElementById('pos_name').value;}
					}
					else if(reporttype==25){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
						if(s[i]=='EMP_NAME'){ param4=document.getElementById('emp_name').value;}
					}
					else if(reporttype==26){
						if(s[i]=='POS_NAME'){ param1=document.getElementById('pos_name').value;  }
						if(s[i]=='CRI_POS'){ param2=document.getElementById('cri_position').value;}
						if(s[i]=='CAT_POS'){ param3=document.getElementById('cat_position').value;}
						if(s[i]=='INT_TYPE'){ param4=document.getElementById('int_type').value;}
						if(s[i]=='TOT_QUESTION'){ param5=document.getElementById('total_question').value;}						
						
					}
					else if(reporttype==27){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='POS_TYPE'){ param2=document.getElementById('pos_type').value;  }
						if(s[i]=='ASSESS_NAME'){ param3=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param4=document.getElementById('pos_name').value;}
					}
					/* else if(reporttype==28){
						if(s[i]=='ASSESS_NAME'){ param1=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param2=document.getElementById('pos_name').value;}
					}
					else if(reporttype==29){
						if(s[i]=='ASSESS_NAME'){ param1=document.getElementById('assess_name').value;  }
						if(s[i]=='ASS_TYPE'){ param2=document.getElementById('ass_type').value;}
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
					} */
					else if(reporttype==29){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
						if(s[i]=='EMP_NAME'){ param4=document.getElementById('emp_name').value;}
					}
					else if(reporttype==28){
						if(s[i]=='ASSESS_NAME'){ param1=document.getElementById('assess_name').value;  }
						if(s[i]=='ASS_TYPE'){ param2=document.getElementById('ass_type').value;}
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
					}
					else if(reporttype==31){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
					}
					else if(reporttype==32){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
					}
					else if(reporttype==33){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
					}
					else if(reporttype==30){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='ASSESSOR_NAME'){ param3=document.getElementById('assessor_id').value;}
					}
					else if(reporttype==34){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
						if(s[i]=='EMP_NAME'){ param4=document.getElementById('emp_name').value;}
					}
					else if(reporttype==35){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
						if(s[i]=='EMP_NAME'){ param4=document.getElementById('emp_name').value;}
					}
					/* else if(reporttype==35){
						if(s[i]=='TRA_LOC_NAME'){ param1=document.getElementById('tra_loc_name').value;}
						if(s[i]=='TRA_DEP_NAME'){ param2=document.getElementById('tra_org_name').value;  }
						if(s[i]=='TRA_EMP_NAME'){ param2=document.getElementById('tra_emp_name').value;  }
					}
					else if(reporttype==36){
						if(s[i]=='ASS_TYPE'){ param1=document.getElementById('ass_type').value;}
						if(s[i]=='ASSESS_NAME'){ param2=document.getElementById('assess_name').value;  }
						if(s[i]=='POS_NAME'){ param3=document.getElementById('pos_name').value;}
						if(s[i]=='EMP_NAME'){ param4=document.getElementById('emp_name').value;}
					} */
				}
			}
			 
			var stdate=endate="";
			if(document.getElementById('startdate')){
				stdate=document.getElementById('startdate').value;
			}
			if(document.getElementById('enddate')){
				endate=document.getElementById('enddate').value;
			}
			window.open(BASE_URL+"/report/getsearchresults?typeid="+reporttype+"&report_name="+repname+"&param1="+param1+"&param2="+param2+"&param3="+param3+"&param4="+param4+"&param5="+param5+"&param6="+param6+"&param7="+param7+"&fromdate="+stdate+"&todate="+endate,"_blank");
		}
	}
	
	
	
  
// function htmltopdf() {
     // var repname=document.getElementById('reportname').value;
	// var pdf = new jsPDF('l', 'pt', 'letter') //('l', 'pt', 'fr'); 
	// //var pdf=new jsPDF('landscape');
	// pdf.setFontSize(10);
	// source = $('#idexceltable')[0];
	// specialElementHandlers = {
		// '#bypassme': function (element, renderer) {
			// return true
		// }
	// };
	// margins = {
		// top: 80,
		// bottom: 30,
		// left: 40,
		// width: 622
	// };
	// pdf.fromHTML(
	// source, 
	// margins.left,
	// margins.top, { 
	// 'width': margins.width, 
	// 'elementHandlers': specialElementHandlers
	// },

	// function (dispose) {
	// pdf.save(repname+'.pdf');
	// }, margins);
// }
  
  
function deleterows1(id,row){
	var con=window.confirm("Are you sure want to Delete the record.");
	if(con==true){
		document.getElementById(row).style.display='none';
		if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{ 
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				//for(var j=0 j<table.length; j++){
					//alertify.alert(dd);
					//if(document.getElementById(dd).checked==true){  //alertify.alert(len);
					//spli.splice(row,1);
					/*alertify.alert(row);
					table.deleteRow(row);*/
					//ble.deleteRow();
					//len=spli.length;
					// alertify.alert(len);
					// break;
					//  }
			}
		}
		// ?id="+sel+"&id1="+comp_ten
		xmlhttp.open("GET",BASE_URL+"/admin/group_deletion?group="+id,true);
		xmlhttp.send();
	}
	else { return false;   }
}
	
  function getteststatus(){ 
    var testtype=document.getElementById('test_type').value;
	     
			  if (window.XMLHttpRequest)                
				 {// code for IE7+, Firefox, Chrome, Opera, Safari
				 xmlhttp=new XMLHttpRequest();
				 }		
			 else{// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				 }
		xmlhttp.onreadystatechange=function(){                                         
		if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 	
			  document.getElementById("test_status").innerHTML=xmlhttp.responseText;
                       	
				 }
		
		} 
	 // ?id="+sel+"&id1="+comp_ten
	  xmlhttp.open("GET",BASE_URL+"/report/getteststatus?id="+testtype,true);
	  xmlhttp.send();
		 
	    }
		
  function getsessions(){ 
	   var eveid=document.getElementById('evename').value; 
	   		  if (window.XMLHttpRequest)                
				 {// code for IE7+, Firefox, Chrome, Opera, Safari
				 xmlhttp=new XMLHttpRequest();
				 }		
			 else{// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				 }
		xmlhttp.onreadystatechange=function(){                                         
		if (xmlhttp.readyState==4 && xmlhttp.status==200)           
			{ 	
			  document.getElementById("session_name").innerHTML=xmlhttp.responseText;
                       	
				 }
	    }	
		  xmlhttp.open("GET",BASE_URL+"/report/getevesessions?id="+eveid,true);
	  xmlhttp.send();
	}
	  
	  
function open_ass_type(){
	var ass_type=document.getElementById('ass_type').value;
	var pos_type=document.getElementById('pos_type').value;
	var  xmlhttp2;
	if (window.XMLHttpRequest){
	   // code for IE7+, Firefox, Chrome, Opera, Safari
	   xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById('assess_name').innerHTML=xmlhttp2.responseText;
		}
	}
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/report/get_assessment_type?ass_type="+ass_type+"&pos_type="+pos_type,true);
	xmlhttp2.send();
}	
function open_ass_position(){
	var assid=document.getElementById('assess_name').value;
	var  xmlhttp2;
	if (window.XMLHttpRequest){
	   // code for IE7+, Firefox, Chrome, Opera, Safari
	   xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById('pos_name').innerHTML=xmlhttp2.responseText;
		}
	}
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/report/get_assessment_position?assid="+assid,true);
	xmlhttp2.send();
} 

function open_ass_assessor(){
	var assid=document.getElementById('assess_name').value;
	var  xmlhttp2;
	if (window.XMLHttpRequest){
	   // code for IE7+, Firefox, Chrome, Opera, Safari
	   xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById('assessor_id').innerHTML=xmlhttp2.responseText;
		}
	}
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/report/get_assessment_asessor?assid="+assid,true);
	xmlhttp2.send();
} 

function open_ass_position_emp(){
	var assid=document.getElementById('assess_name').value;
	var posid=document.getElementById('pos_name').value;
	var ass_type=document.getElementById('ass_type').value;
	var  xmlhttp2;
	if (window.XMLHttpRequest){
	   // code for IE7+, Firefox, Chrome, Opera, Safari
	   xmlhttp2=new XMLHttpRequest();
	}
	else{
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function(){
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById('emp_name').innerHTML=xmlhttp2.responseText;
		}
	}
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/report/get_assessment_position_emp?assid="+assid+"&posid="+posid+"&ass_type="+ass_type,true);
	xmlhttp2.send();
} 
   

function menus(id,menu){
    var ids=id;
    window.location=BASE_URL+"/admin/layoutmenus?id="+ids+"&menu="+menu;
}
function link(link){
    window.location=BASE_URL+link;
}
function create_link(link){
    window.location=BASE_URL+"/admin/"+link;
}
function create_link_ass(link){
    window.location=BASE_URL+"/assessor/"+link;
}
function create_link_ven(link){
    window.location=BASE_URL+"/vendor/"+link;
}
function createreport_like(link){
    
     window.location=BASE_URL+"/report/"+link;
}
function createmp_link(link){
    window.location=BASE_URL+"/employee/"+link;
}
function back(){
 window.history.back()
  }
  
  // added by sravathi For Report generating
  //Function for exporting data to excel
function downloadexcel(id,reportname){ 
	var browser="";			
	if (/MSIE 10/i.test(navigator.userAgent)) {
	   // this is internet explorer 10
	   browser="IE10";
	}
	if(/MSIE 6/i.test(navigator.userAgent)){
		// this is internet explorer 9 and 11
		browser="IE6";
	}
	if(/MSIE 7/i.test(navigator.userAgent)){
		// this is internet explorer 9 and 11
		browser="IE7";
	}
	if(/MSIE 8/i.test(navigator.userAgent)){
		// this is internet explorer 9 and 11
		browser="IE8";
	}

	if(/MSIE 9/i.test(navigator.userAgent) || /rv:11.0/i.test(navigator.userAgent)){
		// this is internet explorer 9 and 11
		browser="IE9";
	}

	if (/Edge\/12./i.test(navigator.userAgent)){
	   // this is Microsoft Edge
	  browser="IE12";
	}
	//alert(browser);
	if(browser!=""){
		if(browser!="IE12"){
		var table = $("#" + id);
		var strCopy = $('<div></div>').html(table.clone()).html();
		//alert(strCopy);
		window.clipboardData.setData("Text", strCopy);
		var objExcel = new ActiveXObject("Excel.Application");
		objExcel.visible = false; 
		var objWorkbook = objExcel.Workbooks.Add; 
		var objWorksheet = objWorkbook.Worksheets(1); 
		objWorksheet.Paste; 
		objExcel.visible = true;
		}
		else{
			alert("Browser Not Supports Download to excel");
		}
	}
	else{
		/* var table = $("#" + id);
		window.open('data:application/vnd.ms-excel,' + $(table).html()); */
		$( "#"+id ).btechco_excelexport({
		 containerid: id
		, datatype: $datatype.Table
		, filename: reportname
	  
		});
	}
	/*  */
}

//Function for exporting data to pdf
function htmltopdf(divid,reportname) {
    
	var size_s=$("#employeesTable").width();
	var size=(size_s*0.5);
	//alert(size);
	var image_a=600;
	var image_b=780;
	if(size<=595){
		var pdf = new jsPDF('l', 'pt', 'a4');
		var image_a=600;
		var image_b=780;
	}
	else if(size>=595 && size<=841){
		var pdf = new jsPDF('l', 'pt', 'a3');
		var image_a=1080;
		var image_b=1160;
	}
	else if(size>=841 && size<=1190){
		var pdf = new jsPDF('l', 'pt', 'a2');
		var image_a=1520;
		var image_b=1600;
	}
	else if(size>=1190 && size<=1683){ 
		var pdf = new jsPDF('l', 'pt', 'a1');
		var image_a=2180;
		var image_b=2250;
	}
	else if(size>=1683 && size<=2383){
		var pdf = new jsPDF('l', 'pt', 'a0');
		var image_a=3090;
		var image_b=3170;
	}
	else if(size>=2383 && size<=3370){
		var pdf = new jsPDF('l', 'pt', '2a0');
		var image_a=4390;
		var image_b=4470;
	}
	else if(size>=3370 && size<=4767){
		var pdf = new jsPDF('l', 'pt', '4a0');
		var image_a=6200;
		var image_b=6280;
	}
	else{
		var pdf = new jsPDF('l', 'pt', '4a0');
		var image_a=6200;
		var image_b=6280;
	}	
	pdf.setFontSize(10);
	source = $('#'+divid)[0];
	specialElementHandlers = {
		'#bypassme': function (element, renderer) {
			return true
		}
	};
	margins = {
		top: 80,
		bottom: 30,
		left: 40,
		width: 622
	};
	
	pdf.fromHTML(
	source, 
	margins.left,
	margins.top, { 
	'width': margins.width, 
	'elementHandlers': specialElementHandlers
	},

	function (dispose) {
	pdf.save(reportname+'.pdf');
	}, margins);
}

//Datepicker code common for all
function date_funct(id){
	$(function(){
		var date1 = new Date();
		var date2 = new Date(2039,0,19);
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		
		var dates = $( "#"+id+"" ).datepicker({
			dateFormat:"dd-mm-yy",
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			minDate:"",
			maxDate:difDays
		});				   
	});
     // $(function() {
         // var dates = $( "#"+id+"" ).datepicker({dateFormat:"dd-mm-yy",
             // defaultDate: "+1w",
             // changeMonth: true,
             // changeYear: true,
             // numberOfMonths: 1,
             // minDate:"",
             // //showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg",
             // //buttonImageOnly: true
         // });
         // $( ".ui-datepicker" ).css('z-index','123123123123123');
     // });
 }
 
 // Timepicker code
 function time_funct(id){
	$('#'+id+'').timepicker({
		minuteStep: 1,
		showSeconds: true,
		showMeridian: false
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	
     // $(function(){
         // $( "#"+id+"" ).timepicker();
     // });
 }
 //Delete function according to new UI
  function deletefunction(curr){
	var id=curr.id;
	var funct=curr.name;
	var rowid=curr.rel;
	//e.preventDefault();
	swal({
		title: "Are you sure?",
		text: "Do you want to delete the row!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: BASE_URL+"/admin/"+funct,
					global: false,
					type: "POST",
					data: ({val : id}),
					dataType: "html",
					async:false,
					success: function(msg){
						if(msg==1){
							document.getElementById(rowid).style.display='none';
							swal("Deleted!", "Your row has been deleted.", "success");
						}
						else{
							swal("Cancelled", msg, "warning");
						}
					}
				}).responseText;
			}
			else {
				swal("Cancelled", "Your row is safe :)", "error");
			}
		}
	);
	/* $( "#dialog-confirm" ).removeClass('hide').dialog({
		resizable: false,
		modal: true,
		buttons: [{
			html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete ",
			"class" : "btn btn-danger btn-xs",
			click: function() {
				$( this ).dialog( "close" );
			}
		},{
			html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
			"class" : "btn btn-xs",
			click: function() {
				$( this ).dialog( "close" );
			}
		}]
	}); */
} 

 //Publish function according to new UI
function publishfunction(curr){
	var id=curr.id;
	var funct=curr.name;
	var rowid=curr.rel;
	//e.preventDefault();
	swal({
		title: "Are you sure?",
		text: "Do you want to Publish position validation!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: BASE_URL+"/admin/"+funct,
					global: false,
					type: "POST",
					data: ({val : id}),
					dataType: "html",
					async:false,
					success: function(msg){
						if(msg==1){
							$(".confirm").click(function(){
								location.reload(true);
							});
							swal("Publish!", "Your position validation has been Published.", "success");
							
						}
						else{
							swal("Cancelled", msg, "warning");
						}
					}
				}).responseText;
			}
			else {
				swal("Cancelled", "Your position validation is safe :)", "error");
			}
		}
	);
	
} 

function assessmentfunction(curr){
	var id=curr.id;
	var funct=curr.name;
	var rowid=curr.rel;
	//e.preventDefault();
	swal({
		title: "Are you sure?",
		text: "Do you want to Publish Assessment!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: BASE_URL+"/admin/"+funct,
					global: false,
					type: "POST",
					data: ({val : id}),
					dataType: "html",
					async:false,
					success: function(msg){
						if(msg==1){
							$(".confirm").click(function(){
								location.reload(true);
							});
							swal("Publish!", "Your Assessmsnt has been Published.", "success");
							
						}
						else{
							swal("Cancelled", msg, "warning");
						}
					}
				}).responseText;
			}
			else {
				swal("Cancelled", "Your Assessmsnt is safe :)", "error");
			}
		}
	);
	
}

function deletefunctionrep(curr){
	var id=curr.id;
	var funct=curr.name;
	var rowid=curr.rel;
	//e.preventDefault();
	swal({
		title: "Are you sure?",
		text: "Do you want to delete the row!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: BASE_URL+"/report/"+funct,
					global: false,
					type: "POST",
					data: ({val : id}),
					dataType: "html",
					async:false,
					success: function(msg){
						if(msg==1){
							document.getElementById(rowid).style.display='none';
							swal("Deleted!", "Your row has been deleted.", "success");
						}
						else{
							swal("Cancelled", "You cannot delete is row :(", "warning");
						}
					}
				}).responseText;
			}
			else {
				swal("Cancelled", "Your row is safe :)", "error");
			}
		}
	);
}
 
 //Delete function according to new UI for Reports
  /* function deletefunctionrep(curr){
	var id=curr.id;
	var funct=curr.name;
	var rowid=curr.rel;
	//e.preventDefault();	
	$( "#dialog-confirm" ).removeClass('hide').dialog({
		resizable: false,
		modal: true,
		buttons: [
			{
				html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; Delete ",
				"class" : "btn btn-danger btn-xs",
				click: function() {
					$( this ).dialog( "close" );
						$.ajax({ 
						url: BASE_URL+"/report/"+funct,
						global: false,
						type: "POST",
						data: ({val : id}),
						dataType: "html",
						async:false,            
						success: function(msg){
							if(msg==1){     //alertify.alert(rowid);                 
								document.getElementById(rowid).style.display='none';
							}
							else{
								$( "#dialog-confirm-delete" ).removeClass('hide').dialog({
									resizable: false,
									modal: true,
									buttons: [
											{
												html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Ok ",
												"class" : "btn btn-xs",
												click: function() {
													$( this ).dialog( "close" );
												}
											}
										]
								});
							
								return false;                    
							}                
						}
					}).responseText;
					
				}
			},
			{
				html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
				"class" : "btn btn-xs",
				click: function() {
					$( this ).dialog( "close" );
				}
			}
		]
	});
 }  */
 
 //Delete function common for Report Controller
function delete_funct1(id,funct,rowid){
    if(id!=""){
        $.ajax({
            url: BASE_URL+"/report/"+funct,
            global: false,
            type: "POST",
            data: ({val : id}),
            dataType: "html",
            async:false,            
            success: function(msg){
                 
                if(msg==1){                     
                    document.getElementById(rowid).style.display='none';
                }
                else{
                    alertify.alert(msg);
                    return false;                    
                }                
            }
        }).responseText;
    }
}
 
//Delete function common for all
function delete_funct(id,funct,rowid){
    if(id!=""){              
        $.ajax({ 
            url: BASE_URL+"/admin/"+funct,
            global: false,
            type: "POST",
            data: ({val : id}),
            dataType: "html",
            async:false,            
            success: function(msg){
                if(msg==1){                   
                    document.getElementById(rowid).style.display='none';
                }
				else if(msg==2){
					location.reload();
				}
                else{  
                    alertify.alert(msg);
                    return false;                    
                }                
            }
        }).responseText;
    }
}
/* $(document).ready(function(){
	var config = {
      '.chosen-select'           : {}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
}); */
$(document).ready(function(){
	var lbg = $("<div class='lightbox_bg'></div>");
	$('body').append(lbg);
	$('.lightboxopen').click(function(e){
		var myval = $(this).attr("rel");
		var id ="#" + myval;	
		
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
		hh=winH/2-$(id).height()/2;
		
		//Set the popup window to center
		$(id).css('top',0);
		$(id).css('left', winW/2-$(id).width()/2);
		$(id).css('position','fixed');
		$('.lightbox_bg').show();
		$("#" + myval).css('opacity', 0.5);
		$("#" + myval).animate({top:hh}).animate({opacity: 1}, 350);
	});
	
	$('a.lightbox_close').click(function(){
		var myval2 =$(this).parent().attr('id');
		$("#" + myval2).css('opacity', 0.5);
		$("#" + myval2).animate({top:0});
		$("#" + myval2).animate({ opacity: 0, top: "-1200px", },0,function(){$('.lightbox_bg').hide();});		
	});
});


// JavaScript Document
/*
 * CSS UI Lightbox v1 (Aug 29 2011)
 * http://css-ui.com
 *
 * Copyright 2011, http://codeeverywhere.ca
 * Licensed under the MIT license.
 *
 */
(function($){ 	
	$.uilightbox = function(options){
		var settings = {
			'title'	: 'CSS UI Lightbox',
			'body'	: '<p>This is the CSS UI Lightbox, for help visit <a href="http://css-ui.com">css-ui.com</a></p>',
			'footer'	: '<a href="#">Close</a>',
			'triggerClose' : 'a',
		};
		if(options){ $.extend(settings, options); } 
		
		$('body').append('<div id="ui-lightbox"><div> \
		<div class="ui-lightbox-head">' + settings.title + '</div> \
		<div class="ui-lightbox-mid">' + settings.body + '</div> \
		<div class="ui-lightbox-foot"> ' + settings.footer + '</div> \
		</div></div>');
		
		$('#ui-lightbox').fadeIn(300, function(){
			$('div', this).fadeIn(200);
			return false;
		});
	
		$(settings.triggerClose).click(function(){
			$('#ui-lightbox div').fadeOut(250, function(){
				$(this).parent().fadeOut(1000, function(){
					$(this).remove();
					return false;
				});
			});
		});
	};
})(jQuery);

function notEqual(field, rules, i, options){
	
 var a=rules[i+2];
 if(parseFloat(field.val()) < parseFloat( jQuery("#"+a).val() ) ){
   return "Value is smaller than a, and should be greater than or equal to it."
 }
}


(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText": "* This field is required",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required",
                    "alertTextDateRange": "* Both date range fields are required"
                },
				
                "requiredInFunction": { 
                    "func": function(field, rules, i, options){
                        return (field.val() == "test") ? true : false;
                    },
                    "alertText": "* Field must equal test"
                },
                "dateRange": {
                    "regex": "none",
                    "alertText": "* Invalid ",
                    "alertText2": "Date Range"
                },
                "dateTimeRange": {
                    "regex": "none",
                    "alertText": "* Invalid ",
                    "alertText2": "Date Time Range"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* You must enter valid data with minimum  ",
                    "alertText2": " characters "
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* You can allowed to enter maximum ",
                    "alertText2": " characters "
                },
                "groupRequired": {
                    "regex": "none",
                    "alertText": "* You must fill one of the following fields"
                },
                "min": {
                    "regex": "none",
                    "alertText": "* Minimum value is "
                },
                "max": {
                    "regex": "none",
                    "alertText": "* You can allowed to enter maximum value  "
                },
                "past": {
                    "regex": "none",
                    "alertText": "* You must enter Date before to "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* You must enter Date After "
                },	
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Maximum ",
                    "alertText2": " options allowed"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Please select ",
                    "alertText2": " options"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* Fields do not match"
                },
				"notEqual":  {
					"func": function(field, rules, i, options){
						return (field.val() == $('#oldpassword').val()) ? false : true;
					},
					"alertText": "* Old password and New password must be different"
				},
                "creditCard": {
                    "regex": "none",
                    "alertText": "* Invalid credit card number"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}([ \.\-])?)?([\(][0-9]{1,6}[\)])?([0-9\.\-]{1,32})(([A-Za-z \:]{1,11})?[0-9]{1,4}?)$/,
                    "alertText": "* You must enter valid phone number"
                },
                "email": {
                    // HTML5 compatible email regex ( http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#    e-mail-state-%28type=email%29 )
                    "regex": /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                    "alertText": "*  You must enter valid email address"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* You must enter valid integer value"
                },
                 "alphabets": {
                    "regex": /^[a-z A-Z]+$/,
                    "alertText": "* You must enter only alphabets"
                },
				"alphabetSpace": {
                    //"regex": /^[a-z A-Z _ 0-9]+$/,
					 "regex": /^[a-z A-Z]+$/,
                    "alertText": "* Only Alphabets are Allowed"
                },				
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,
                    "alertText": "* You must enter valid floating decimal number"
                },
                "date": {                    
                    //	Check if date is valid by leap year
			"func": function (field) {
					var pattern = new RegExp(/^(\d{4})[\/\-\.](0?[1-9]|1[012])[\/\-\.](0?[1-9]|[12][0-9]|3[01])$/);
					var match = pattern.exec(field.val());
					if (match == null)
					   return false;
	
					var year = match[1];
					var month = match[2]*1;
					var day = match[3]*1;					
					var date = new Date(year, month - 1, day); // because months starts from 0.
	
					return (date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day);
				},                		
			 "alertText": "* Invalid date, must be in YYYY-MM-DD format"
                },
                "date2": {                    
                    //	Check if date is valid by leap year
			"func": function (field) {
					var pattern = new RegExp(/^(0?[1-9]|[12][0-9]|3[01])[\/\-\.](0?[1-9]|1[012])[\/\-\.](\d{4})$/);
					var match = pattern.exec(field.val());
					if (match == null)
					   return false;
	
					var year = match[3];
					var month = match[2]*1;
					var day = match[1]*1;					
					var date = new Date(year, month - 1, day); // because months starts from 0.
	
					return (date.getFullYear() == year && date.getMonth() == (month - 1) && date.getDate() == day);
				},                		
			 "alertText": "* Invalid Date format.You must enter a valid date format (DD-MM-YYYY)"
                },
                "ipv4": {
                    "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Invalid IP address"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "alertText": "* Invalid URL"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* you must enter Numbers only"
                },
                "amount": {
                    "regex": /^\d{0,11}(\.\d{1,2})?$/,
                    "alertText": "* Invalid format.You must eneter Amount Format only"
                },
                "picture": {
                    "regex": /(?:gif|jpg|png|bmp)$/,
                    "alertText": "*Invalid format.you must Upload gif, jpg, png and bmp only"
                },
                "file": {
                    "regex": /(?:pdf|ppt|pptx)$/,
                    "alertText": "* You are allowed to Upload either pdf or ppt files only"
                },
				"files": {
                    "regex": /(?:pdf|ppt|pptx|doc|docx)$/,
                    "alertText": "* You are allowed to Upload either pdf or ppt or doc files only"
                },
				"allfiles": {
                    "regex": /(?:pdf|ppt|pptx|doc|docx|xls|xlsx)$/,
                    "alertText": "* You are allowed to Upload either pdf or ppt or doc or excel files only"
                },
				"uploadfiles": {
                    "regex": /(?:xls|xlsx|csv)$/,
                    "alertText": "* You are allowed to Upload either csv or excel files only"
                },
				"uploadcsv": {
                    "regex": /(?:csv)$/,
                    "alertText": "* You are allowed to Upload CSV files only"
                },
                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Letters only"
                },
                "onlyLetterSomeSp": {
                    "regex": /^[a-zA-Z]+(([\'\,\_\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/,
                    //"alertText": "* Letters and . , '"
					"alertText": "* you can allowed to enter Letters and . , '"
                },
                 "alphanumericSp": {
                    "regex": /^[a-zA-Z0-9]+(([\_\\\/\-\ ][0-9a-zA-Z& ])?[0-9a-zA-Z]*)*$/,
                    "alertText": "You must enter alphanumeric characters in the range A to z or 0-9.A name should contain no special characters such as ? * & space etc.,"
                },
                "alphanumeric": {
                    "regex": /^[-a-zA-Z0-9_.  ]+$/,
                    "alertText": "you can enter only letters, Numbers & Space/underscore ."
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* No special characters allowed"
                },
                // --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertText": "* This user is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxUserCallPhp": {
                    "url": "phpajax/ajaxValidateFieldUser.php",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This username is available",
                    "alertText": "* This user is already taken",
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "* This name is already taken",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* This name is available",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxNameCallPhp": {
                    // remote json service location
                    "url": "phpajax/ajaxValidateFieldName.php",
                    // error
                    "alertText": "* This name is already taken",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxPassword": {
                    // remote json service location
                    "url": BASE_URL+"/admin/ajaxpassword",
                    // error
                    "alertText": "* Enter Old Password Correctly",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxMenuName": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkmenuname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#menu_creation_id",
                    // error
                    "alertText": "* Menu name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxRoleName": {                               
                    // remote json service location
                    "url": BASE_URL+"/index/checkrolename",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#Role_Id",
                    // error
                    "alertText": "* Role name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxRoleCode": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkrolecode",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#Role_Id",
                    // error
                    "alertText": "* Role code already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"roleempexist":{
				  "url": BASE_URL+"/index/empexitsforrole",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#porg,#roles",
                    // error
                    "alertText": "* Role code already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"				
				 },
                "ajaxbudgetsetupName": {                               
                    // remote json service location
                    "url": BASE_URL+"/index/checkbudgetnamename",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#budget_id",
                    // error
                    "alertText": "* Budget name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxcalendarName": {                               
                    // remote json service location
                    "url": BASE_URL+"/index/checkcalendarname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#calendar_id",
                    // error
                    "alertText": "* Calendar name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxLocation":	{
                    // remote json service location
                    "url": BASE_URL+"/index/checklocation_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#city,#location_id",
                    // error
                    "alertText": "* Location already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxZone":	{
                    // remote json service location
                    "url": BASE_URL+"/index/checkzone_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#zone_id",
                    // error
                    "alertText": "* Zone already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxEventrestrict": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkeventrestrict_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#program_id,#restriction_id",
                    // error
                    "alertText": "* Event Restriction already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxGrade": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkgrade_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#grade_id",
                    // error
                    "alertText": "* Grade already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxSubgrade": {
                    // remote json service location
                    "url": BASE_URL+"/index/checksubgrade_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#subgrade_id",
                    // error
                    "alertText": "* Sub Grade already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxEmptype": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkemptype_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#emp_type_id",
                    // error
                    "alertText": "* Employee Type already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxEmpcat": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkempcategory_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#emp_cat_id",
                    // error
                    "alertText": "* Employee Category already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxLevel": {
                    // remote json service location
                    "url": BASE_URL+"/index/checklevel_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#level_id",
                    // error
                    "alertText": "* level already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxPosition": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkposition_exist",
                    // you may want to pass extra data on the ajax call#position_org_id,
                    "extraDataDynamic": "#pos_id",
                    // error
                    "alertText": "* Positon Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Position, please wait"
                }, 
				"ajaxcasestudy": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkcasestudy_exist",
                    // you may want to pass extra data on the ajax call#position_org_id,
                    "extraDataDynamic": "#casestudy_id",
                    // error
                    "alertText": "* Case Study Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Position, please wait"
                }, 
                "ajaxIndicator": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkindicator_exist",
                    // you may want to pass extra data on the ajax call#position_org_id,
                    "extraDataDynamic": "#ind_master_id",
                    // error
                    "alertText": "* Indicator Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Indicator, please wait"
                }, 
                "ajaxWorkProcessNames":{
                    "url": BASE_URL+"/index/wfprocessname_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#system_proc_name,#process_id",
                    // error
                    "alertText": "* Process Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Master Code, please wait"
                },
                
                 
                "ajaxUserProcessNames":{
                    "url": BASE_URL+"/index/wfuserprocessname_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#user_proc_name,#process_id",
                    // error
                    "alertText": "* User Process Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Master Code, please wait"
                },
               "ajaxWfRoleName":{
                    "url": BASE_URL+"/index/wfrolename_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#role_name,#wf_role_id",
                    // error
                    "alertText": "* Role Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Master Code, please wait"
                },
                
                 "ajaxWfGroupName":{
                    "url": BASE_URL+"/index/wf_groupname_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#approver_group_id,#group_name',
                    // error
                    "alertText": "* Group name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait" 
                },
                 "ajaxReportGroupName":{
                    "url": BASE_URL+"/index/report_groupname_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#report_group_id,#report_group_name',
                    // error
                    "alertText": "* Report Group Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait" 
                    
                    
                },
                
                 "ajaxReportName":{
                    "url": BASE_URL+"/index/report_name_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#report_id,#report_name',
                    // error
                    "alertText": "* Report Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"                   
                    
                }, 
				"ajaxMaterCode": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkmastercode",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#master_id",
                    // error
                    "alertText": "* Master Code Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Master Code, Please Wait"
                },
                "ajaxMaterTitle": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkmastertitle",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#master_id",
                    // error
                    "alertText": "* Master Title Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Master Title, Please Wait"
                },
                "ajaxEmpNumber": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkempnumber",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#employee_id",
                    // error
                    "alertText": "* Employee Number Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Employee Number, Please Wait"
                },
				"ajaxlanguage": {
                    // remote json service location
                    "url": BASE_URL+"/index/checklanguage",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#lang_id",
                    // error
                    "alertText": "* Language name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Language name, Please Wait"
                },
				"ajaxVenNumber": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkvennumber",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#vendor_id",
                    // error
                    "alertText": "* Vendor Number Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Employee Number, Please Wait"
                },
				"checkvenmobile": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkvenmobilenumber",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#vendor_id",
                    // error
                    "alertText": "* Vendor Mobile Number Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Employee Number, Please Wait"
                },
				"ajaxMenNumber": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkmennumber",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#mason_id",
                    // error
                    "alertText": "* Mason Number Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating mason Number, Please Wait"
                },
                "ajaxEmpNumberAdmin": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkempnumberadmin",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#org_id",
                    // error
                    "alertText": "* Employee Number Don't match the Database",
                    // speaks by itself
                    "alertTextLoad": "* Validating Employee Number, Please Wait"
                },
                "ajaxEmpMail": {
                    // remote json service location
                    "url": BASE_URL+"/index/empmail",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#employee_id",
                    // error
                    "alertText": "* Employee Email Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Employee Email, Please Wait"
                },
                "ajaxOrgName": {
                    // remote json service location
                    "url": BASE_URL+"/index/orgname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#org_id,#parent_org_id",
                    // error
                    "alertText": "* Organization Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Organization Name, Please Wait"
                },
				"ajaxOrgNameType": {
                    // remote json service location
                    "url": BASE_URL+"/index/orgnametype",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#org_id,#parent_org_id,#org_name",
                    // error
                    "alertText": "* Organization Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Organization Name, Please Wait"
                },
                "ajaxEventName": {
                    // remote json service location
                    "url": BASE_URL+"/index/eventname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#event_id",
                    // error
                    "alertText": "* Event Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Event Name, Please Wait"
                },
				"ajaxHierarchyName": {
                    // remote json service location
                    "url": BASE_URL+"/index/hierarchyname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#hierarchy_id",
                    // error
                    "alertText": "* Hierarchy Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Hierarchy Name, Please Wait"
                },
				"ajaxEventSessName": {
                    // remote json service location
                    "url": BASE_URL+"/index/eventsessname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#event_sess_id,#event_id",
                    // error
                    "alertText": "* Session Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Session Name, Please Wait"
                },
				"ajaxTNAName": {
                    // remote json service location
                    "url": BASE_URL+"/index/tna_name",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#tna_id",
                    // error
                    "alertText": "* TNA Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating TNA Name, Please Wait"
                },
				"checktnadetails": {
                    // remote json service location
                    "url": BASE_URL+"/index/check_tna",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#tna_admin_id",
                    // error
                    "alertText": "* TNA Details Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating TNA Details, Please Wait"
                },
				"ajaxEventOrgName": {
                    // remote json service location
                    "url": BASE_URL+"/index/learnerorgname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#learner_id,#lnr_eventid",
                    // error
                    "alertText": "* Organization Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Organization Name, Please Wait"
                },
				"ajaxProgOrgName": {
                    // remote json service location
                    "url": BASE_URL+"/index/learnerorgname_prog",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#learner_id,#lnr_prg_id",
                    // error
                    "alertText": "* Organization Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Organization Name, Please Wait"
                },
				"ajaxEventLocation": {
                    // remote json service location
                    "url": BASE_URL+"/index/learnerlocation",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#learner_id,#lnr_eventid",
                    // error
                    "alertText": "* Location Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating location Name, Please Wait"
                },
				"ajaxProgLocation": {
                    // remote json service location
                    "url": BASE_URL+"/index/learnerlocation_prog",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#learner_id,#lnr_prg_id",
                    // error
                    "alertText": "* Location Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating location Name, Please Wait"
                },
				"ajaxevechatname": {
                    // remote json service location
                    "url": BASE_URL+"/index/eventchatname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#chat_id,#chat_eventid",
                    // error
                    "alertText": "* Chat Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Chat Name, Please Wait"
                },
				"ajaxeveforumname": {
                    // remote json service location
                    "url": BASE_URL+"/index/eventforumname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#forum_id,#gen_event_id",
                    // error
                    "alertText": "* Forum Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Forum Name, Please Wait"
                },
				"ajaxevetopicname": {
                    // remote json service location
                    "url": BASE_URL+"/index/eventtopicname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#expert_topic_id,#expert_eventid",
                    // error
                    "alertText": "* Topic Name Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Topic Name, Please Wait"
                },
				"ajaxEventlearnergroup": {
                    // remote json service location
                    "url": BASE_URL+"/index/learnergroupname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#learner_id,#lnr_eventid",
                    // error
                    "alertText": "* Learner Group Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Learner Group, Please Wait"
                },
				"ajaxProglearnergroup": {
                    // remote json service location
                    "url": BASE_URL+"/index/learnergroupname_prog",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#learner_id,#lnr_prg_id",
                    // error
                    "alertText": "* Learner Group Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Learner Group, Please Wait"
                },
                "ajaxResourceName": {
                    // remote json service location
                    "url": BASE_URL+"/index/resourcename",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#resource_booking_id,#event_id",
                    // error
                    "alertText": "* Resource Already Booked for this Event",
                    // speaks by itself
                    "alertTextLoad": "* Validating Resource Name, Please Wait"
                },
				"ajaxSessResource": {
                    // remote json service location
                    "url": BASE_URL+"/index/sessresourcename",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#resource_booking_id,#event_id,#res_event_sess_id",
                    // error
                    "alertText": "* Resource Already Booked for this Session",
                    // speaks by itself
                    "alertTextLoad": "* Validating Resource Name, Please Wait"
                },
				"ajaxReferenceName": {
                    // remote json service location
                    "url": BASE_URL+"/index/referencename",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#reference_id,#event_id",
                    // error
                    "alertText": "* Reference Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Reference Name, Please Wait"
                },				
				"ajaxEventEvaluation": {
                    // remote json service location
                    "url": BASE_URL+"/index/evaluationname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#evaluation_id,#eval_eventid,#evaluation_type",
                    // error
                    "alertText": "* Test Name and Test Type Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Test Name and Type, Please Wait"
                },
				"ajaxEventSessEvaluation": {
                    // remote json service location
                    "url": BASE_URL+"/index/sessevaluationname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#sess_evaluation_id,#event_sess_id,#sess_evaluation_type",
                    // error
                    "alertText": "* Test Name and Test Type Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Test Name and Type, Please Wait"
                },
                "ajaxEnrlEmp": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkempenroll",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#enroll_id,#evntid",
                    // error
                    "alertText": "* Employee Number Already Enrolled",
                    // speaks by itself
                    "alertTextLoad": "* Validating Employee Number, Please Wait"
                },
				"ajaxAssessorEmp": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkassenroll",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#assessment_id_assessor_id,#position_id_assessor_id",
                    // error
                    "alertText": "* Assessor Already Enrolled",
                    // speaks by itself
                    "alertTextLoad": "* Validating Assessor Name, Please Wait"
                },
				"ajaxAssessorEmpsp": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkassenrollsp",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#assessment_id_assessor,#position_id_assessor",
                    // error
                    "alertText": "* Assessor Already Enrolled",
                    // speaks by itself
                    "alertTextLoad": "* Validating Assessor Name, Please Wait"
                },
				"ajaxAnnouncementOrg": {
                    // remote json service location
                    "url": BASE_URL+"/index/announcementorg",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#id,#announce_inclu_id",
                    // error
                    "alertText": "* Organization Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Organization, Please Wait"
                },
				"ajaxAnnouncementLearnerGroup": {
                    // remote json service location
                    "url": BASE_URL+"/index/announcementlearnergroup",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#id,#announce_inclu_id",
                    // error
                    "alertText": "* Learner Group Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Organization, Please Wait"
                },
                "ajaxUsername": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkusername",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#user_id",
                    // error
                    "alertText": "* Username already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Username, please wait"
                },
				"ajaxUsernameOrgid": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkusername",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#user_id,#parent_org_id",
                    // error
                    "alertText": "* Username already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Username, please wait"
                },
                "ajaxCompetency":{
                    // remote json service location
                    "url": BASE_URL+"/index/checkcomname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#competency_type,#competency_id",
                    // error
                    "alertText": "* Competency Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxprogram":{
                    // remote json service location
                    "url": BASE_URL+"/index/checkprogram_name_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#pro_id,#category",
                    // error
                    "alertText": "* Program Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Program Name, please wait"
                },
                "proglearnercomp":{
                    // remote json service location
                    "url": BASE_URL+"/index/checkprogram_learner_comp",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#program_id,#competency_id,#prg_learner_id",
                    // error
                    "alertText": "* Level Name for the same Competency already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Level Name for the Competency, please wait"
                },
                "ajaxUseremail": {
                    // remote json service location
                    "url": BASE_URL+"/index/checkuseremail",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#user_id",
                    // error
                    "alertText": "* email already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating email, please wait"
                },             
                "ajaxCategoryName": {
                    // remote json service location
                    "url": BASE_URL+"/index/catname",
                    "extraDataDynamic": "#ids",
                    "alertText": "* Category name already exists",
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxgroupName":{
                    // remote json service location
                    "url": BASE_URL+"/index/learner_group_exist",
                    // you may want to pass extra data on the ajax call
                    //"extraData": "name="+$('#lgroup').val(),
                    // error
                    "alertText": "* Group Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxgroupNameedit":{
                    // remote json service location
                    "url": BASE_URL+"/index/learner_groupedit_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#gid',
                    // error
                    "alertText": "* Group Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxQuestionbankNameEdit":{
                    // remote json service location
                    "url": BASE_URL+"/index/questionbank_nameedit_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#questionbank_id',
                    // error
                    "alertText": "* Question bank name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                }, 
			/* 	"ajaxQuestionbankName":{
                    // remote json service location
                    "url": BASE_URL+"/index/questionbank_name_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#gid',
                    // error
                    "alertText": "* Question bank name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },                */ 
                "ajaxQuestionbankQuestionExist":{
                   // remote json service location
                    "url": BASE_URL+"/index/questionbankquestion_exist",
                    // you may want to pass extra data on the ajax call
                     "extraDataDynamic": "#question_bank_id,#question_id",
                    // error
                    "alertText": "* Question Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxQuestion_QuestionExist":{
                   // remote json service location
                    "url": BASE_URL+"/index/question_name_edit_exist",
                    // you may want to pass extra data on the ajax call
                     "extraDataDynamic": "#question_id",
                    // error
                    "alertText": "* Question Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                 "ajaxQuestionbankQuestionEditExist":{
                   // remote json service location
                    "url": BASE_URL+"/index/questionbankquestion_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#question_bank_id,#question_id",
                    // error
                    "alertText": "* Question Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				    "ajaxTestCode":{
                    // remote json service location
                    "url": BASE_URL+"/index/test_code_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#test_id',
                    // error
                    "alertText": "* Test Code already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                   "ajaxTestName":{
                    // remote json service location
                    "url": BASE_URL+"/index/test_name_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#test_id',
                    // error
                    "alertText": "* Test name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxTestNameEdit":{
                    // remote json service location
                    "url": BASE_URL+"/index/test_nameedit_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#test_id',
                    // error
                    "alertText": "* Test name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
              "ajaxNotificationName":{
                    // remote json service location
                    "url": BASE_URL+"/index/notification_name_exist",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#notification_id',
                    // error
                    "alertText": "* Notification Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },				
				"ajaxNotifictionMasterCode":{
                    // remote json service location
                    "url": BASE_URL+"/index/checknotifiction_mastercode",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#master_id',
                    // error
                    "alertText": "* Master Code is already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
			 "ajaxNotifictionMaterTitle": {
                    // remote json service location
                    "url": BASE_URL+"/index/checknotification_mastertitle",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": "#master_id",
                    // error
                    "alertText": "* Master Title Already Exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating Master Title, Please Wait"
                },
				
                   "ajaxNotificationType":{
                    // remote json service location
                    "url": BASE_URL+"/index/notification_name_exist_parent",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#notification_id,#porg',
                    // error
                    "alertText": "* Notification Type already exists for this Organization",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxLevelcode":{
                    // remote json service location
                    "url": BASE_URL+"/index/checklevelcode",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#comp_level_id,#competency_type,#competency_name',
                    // error
                    "alertText": "* Level Code already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
                "ajaxLevelname":{
                    // remote json service location
                    "url": BASE_URL+"/index/checklevelname",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#comp_level_id,#competency_type,#competency_name',
                    // error
                    "alertText": "* Level Name already exists",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxDircheck":{
                    // remote json service location
                    "url": BASE_URL+"/index/checkuploaddir",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#learning_material_id',
                    // error
                    "alertText": "* Material Name already exists or you cannot edit the material name",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxDirchecknon":{
                    
                    "url": BASE_URL+"/index/checkuploaddirnon",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#learning_material_id,#material_type',
                    // error
                    "alertText": "* Material Name already exists for non edit material so try other name",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"
                },
				"ajaxZoneCheck":{
                    "url": BASE_URL+"/index/check_zone_map",
                    // you may want to pass extra data on the ajax call
                    "extraDataDynamic": '#zone_id,#state_id',
                    // error
                    "alertText": "* Zone has already Mapped to the state",
                    // speaks by itself
                    "alertTextLoad": "* Validating, please wait"                   
                    
                }, 
				"validatenotint":{
					"alertText": "* You must enter alphanumeric not numeric"
				},
				"validatenotsp":{
					//"alertText": "* Please enter alphanumeric and symbol -_.&"
					"alertText": "* You must enter alphanumeric values"
				},
				"validatesp":{
					"alertText": "* You must enter alphanumeric characters in the range A to Z or 0 to 9 and should contain no special characters such as ? * & space etc.,"
				},
				"validatenospace":{
					"alertText": "* Please enter alphanumeric and -_.  and no space"
				},
                "validate2fields": {
                    "alertText": "* Please input HELLO"
                },
				"materialformat": {
                    "alertText": "* Please Upload zip file"
                },
				"materialformat2": {
                    "alertText": "* Please Upload PDF file for Material Type PDF or PPT <br>* Please Upload MP4 file for Material Type VIDEO"
                },
                "checklevelcodename": {
                    "alertText": "* Please enter check level code check name"
                },
                "checklevelcode": {
                    "alertText": "* Please check level code"
                },
                "checklevelname": {
                    "alertText": "* Please check level name"
                },
                "checklevelcodeunique": {
                    "alertText": "* Please check level code unique"
                },
                "checklevelnameunique": {
                    "alertText": "* Please check level name unique"
                },
                "checkbalancebudget": {
                    "alertText": "* Balance Budget less than the Amount"
                },
                "checkbudgetamount": {
                    "alertText": "* Budget Amount less than the Amount"
                },
                 "checkdeptamount": {
                    "alertText": "* Budget amount greater than the total organization amount"
                },
                "checkitemsamount": {
                    "alertText": "* Check Organization Amount should be greater than the Budget Item details."
                }, 
				"checkUserhet": {
                    "alertText": "*User Name Already Exists."
                },
				"checkResourcehet": {
                    "alertText": "*Resource Name Already Exists."
                },             
				"checkUnisess": {
                    "alertText": "*Session Name Already Exists."
                },
				"checkUnieve": {
                    "alertText": "*Event Name Already Exists."
                },
				"checkUnipro": {
                    "alertText": "*Program Name Already Exists."
                }, 
                "floating": {
                    //"regex": /^[0-9]*\.[0-9][0-9]$/,
                    "regex": /^([0-9,]+[\.]?[0-9]?[0-9]?|[0-9]+)$/,
                    "alertText": "* You must enter Numbers only."
                },
	        //tls warning:homegrown not fielded 
                "dateFormat":{
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/,
                    "alertText": "* Invalid Date"
                },
                //tls warning:homegrown not fielded 
				"dateTimeFormat": {
	                "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/,
                    "alertText": "* Invalid Date or Date Format",
                    "alertText2": "Expected Format: ",
                    "alertText3": "mm/dd/yyyy hh:mm:ss AM|PM or ", 
                    "alertText4": "yyyy-mm-dd hh:mm:ss AM|PM"
	            },
				
                    "TimeFormat":{
                        "regex":/^([0-1]?[0-9]|[2][0-3]):([0-5][0-9])$/,
                        "alertText": "* Invalid Time or Time Format"
                    }
                
            };
            
        }
    };

    $.validationEngineLanguage.newLang();
    
})(jQuery);

function checknotinteger(field, rules, i, options){
	var numbers = /^[-+]?[0-9]+$/;
	var inputtxt=field.val();
	inputtxt=inputtxt.trim();
	field.val(inputtxt);
	if(inputtxt.match(numbers))  {
		return options.allrules.validatenotint.alertText;
	}
	var str = /^[&& ._-]+$/;
	if(inputtxt.match(str))  {
		return options.allrules.validatenotsp.alertText;
	}
	else{
		var str = /^[a-zA-Z0-9 &&._-]+$/;
		if(!inputtxt.match(str))  {
			return options.allrules.validatenotsp.alertText;
		}
	}
}

function checknospace(field, rules, i, options){
	var numbers = /^[-+]?[0-9]+$/;
	var inputtxt=field.val();
	inputtxt=inputtxt.trim();
	field.val(inputtxt);
	if(inputtxt.match(numbers))  {
		return options.allrules.validatenotint.alertText;
	}
	var str = /^[&&._-]+$/;
	if(inputtxt.match(str))  {
		return options.allrules.validatenospace.alertText;
	}
	else{
		var str = /^[a-zA-Z0-9&&._-]+$/;
		if(!inputtxt.match(str))  {
			return options.allrules.validatenospace.alertText;
		}
	}
  }

function checknotint(field, rules, i, options){
	var numbers = /^[-+]?[0-9]+$/;
	var inputtxt=field.val();
	inputtxt=inputtxt.trim();
	field.val(inputtxt);
	if(inputtxt.match(numbers))  {
		return options.allrules.validatenotint.alertText;
	}
	var str = /^[a-zA-Z0-9]+$/;
	if(!inputtxt.match(str))  {
		return options.allrules.validatesp.alertText;
	}
}

/* jQuery(function($) {
				$('.chosen-select').chosen({allow_single_deselect:true}); 
				//resize the chosen on window resize
				$(window).on('resize.chosen', function() {
					var w = $('.chosen-select').parent().width();
					$('.chosen-select').next().css({'width':w});
				}).trigger('resize.chosen');
}); */

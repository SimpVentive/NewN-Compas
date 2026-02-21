jQuery(document).ready(function(){
	jQuery("#notificationForm").validationEngine();
});
jQuery(document).ready(function(){
	jQuery("#NotificationsearchForm").validationEngine();
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

 jQuery(document).ready(function() {
        $('#maildiv').click(function(){
            $('#maildiv').addClass('active');
            $('#querydiv').removeClass('active');
			$('#MilContent').removeClass('active');
			$('#MilContent').show();
            $('#recipients').hide();
            $('#querymap').hide();           
        });
     $('#recpdiv').click(function(){
            $('#recpdiv').addClass('active');
            $('#querydiv').removeClass('active');
			$('#MilContent').removeClass('active');
            $('#recipients').show();
            $('#querymap').hide();
			$('#MilContent').hide();
           
        });
      $('#querydiv').click(function(){
            $('#querydiv').addClass('active');
            $('#recpdiv').removeClass('active');
			$('#MilContent').removeClass('active');
            $('#querymap').show();
            $('#recipients').hide();
            $('#MilContent').hide();
        });
        });

function gettimedetails(){
   var tt=document.getElementById('type').value; 
   if(tt=='P'){
      document.getElementById('daysdiv').style.display="block";
     // document.getElementById('hours').style.display="block";
     }else {
         
           document.getElementById('daysdiv').style.display="none";
     // document.getElementById('hours').style.display="none";
     }
}
function getempsdetails(){
    var parent=document.getElementById('porg').value;
     if(parent!=''){
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
                      var data = xmlhttp2.responseText;
                        var result =data.split('*');
                        var user=$.trim(result[0]);
                        var manag=$.trim(result[1]);
                     
			document.getElementById("users").value=user;
			document.getElementById('manager').value=manag;
			
		 }
	}
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/admin/getempdata?group="+group+"&loc="+loc+"&org="+org+"&hierar="+hierar+"&grad="+grad+"&emptype="+emptype+"&post="+post,true);
	xmlhttp2.send();
    }
  }
function onlydegits(t){
            var patt1 = /(\d{3}).*(\d{3}).*(\d{4})/;
            var patt2 = /^\((\d{3})\).(\d{3})-(\d{4})$/;
            var str = t.value;
            var result;
        if (!str.match(patt2)){
                result = str.match(patt1);
                        if (result!= null){
                        //alertify.alert(result);
                        //t.value = t.value.replace(/[^\d]/gi,'');
                        //str = '(' + result[1] + ') ' + result[2] + '-' + result[3];
                        //t.value = str;
                        }
                    else{
                            if (t.value.match(/[^\d]/gi)){
                            t.value = t.value.replace(/[^\d]/gi,'');
                            }
                     }
          }
  }
  
   function getemps(){
             var query=document.getElementById('query').value;
            if(query!=''){
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
                                document.getElementById("empmails").innerHTML=xmlhttp2.responseText;
                               // document.getElementById('manager').value=manag;

                         }
                }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/admin/getemp_mails?query="+query,true);
	xmlhttp2.send();
         
              }
         }
         
//      function getenable(){
//         var not=document.getElementById('notification_name').value;  
//         if(not==''){
//             document.getElementById('status').disabled='disabled'; 
//              document.getElementById('porg').disabled='disabled';
//               document.getElementById('history').disabled='disabled';
//                document.getElementById('type').disabled='disabled';
//                 document.getElementById('comments').disabled='disabled';
//                  document.getElementById('users').disabled='disabled';
//                   document.getElementById('manager').disabled='disabled';
//                  //  document.getElementById('subject').disabled='disabled'; 
//                    document.getElementById('event_type').disabled='disabled';  
//         }
//         else {
//               document.getElementById('status').disabled=''; 
//              document.getElementById('porg').disabled='';
//               document.getElementById('history').disabled='';
//                document.getElementById('type').disabled='';
//                 document.getElementById('comments').disabled='';
//                  document.getElementById('users').disabled='';
//                   document.getElementById('manager').disabled='';
//                  //  document.getElementById('subject').disabled=''; 
//                      document.getElementById('event_type').disabled='';  
//         }
//          
//      }

/*  function getnotificationtype(){
   var  pid=document.getElementById('porg').value;
   if(pid==''){
       document.getElementById('ntype').style.display="none"
   }else {
       document.getElementById('ntype').style.display="block"
   }
 }
  */
 function getdata(){
     var data=document.getElementById('notification123').value;
    // var type=document.getElementById('type').value;
      var status=document.getElementById('status').value;
      var type="";
//     if(data=='' && type=='' && status==''){ 
//        alertify.alert("Please select atleast One Option");
//         return false;
//       }
//    else {   
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
                            
                                document.getElementById("notificationdiv").innerHTML=xmlhttp2.responseText;
                         }
                }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/admin/getnotificationusers?nid="+data+"&type="+type+"&status="+status,true);
	xmlhttp2.send();
     }
 //}
  function createnotification(){
     window.location=BASE_URL+"/admin/notification";
     }
     
     function getmailsdata(time,nid){
         //var empid=document.getElementById('').value;
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
                                document.getElementById("mailscontent").innerHTML=xmlhttp2.responseText;
                         }
                }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/admin/getmailcontent?nid="+nid+"&time="+time,true);
	xmlhttp2.send();  
         
     }

$(document).ready(function (){ 
		   $( ".deleteclass" ).on('click', function(e) {
		     var id=$(this).attr('id');
		     var funct=$(this).attr('name');
			 var rowid=$(this).attr('rel');
			  e.preventDefault();
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
										url: BASE_URL+"/admin/"+funct,
										global: false,
										type: "POST",
										data: ({val : id}),
										dataType: "html",
										async:false,            
										success: function(msg){
											if(msg==1){     //alertify.alert(rowid);                 
												document.getElementById(rowid).style.display='none';
											}
											else{  $( "#dialog-confirm-delete" ).removeClass('hide').dialog({
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
							}
							,
							{
								html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
								"class" : "btn btn-xs",
								click: function() {
									$( this ).dialog( "close" );
								}
							}
						]
					});
				  });
			})
			
			
  function getparameters(){
                var  xmlhttp2;
				var ntcod=document.getElementById('notification_type').value;
				ntcoddata=ntcod.split("-");
				ntid=ntcoddata[0];
				//alertify.alert(ntid);
				ntcode=ntcoddata[1];
				document.getElementById("system_notification").value=ntcode
                if (window.XMLHttpRequest){
                        xmlhttp2=new XMLHttpRequest();
                }
                else{  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                xmlhttp2.onreadystatechange=function(){
                        if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
						      // alertify.alert(xmlhttp2.responseText);
						      params=xmlhttp2.responseText;
						       s=params.split("####");
							    //dd=s[1].trim();
								//alertify.alert(s[1]);
                                document.getElementById("parameters").innerHTML=s[0];
								//var aaaaa=CKEDITOR.instances['editor1'].getData();
								CKEDITOR.instances['editor1'].setData(s[1]);
								//alertify.alert(aaaaa);
								//CKEDITOR.instances.editor1.setData('');
								//CKEDITOR.instances['editor1'].insertHtml("");
								//CKEDITOR.instances['editor1'].html(s[1]);
								//alertify.alert(s[1]);
								//alertify.alert(dd);
								//jQuery("#editor1").html(dd);
								// document.getElementById("editor1").innerHTML=dd;
								// document.getElementById("textareadiv").innerHTML=s[1];
								//  document.getElementById("data12").value=dd; 
								/*document.getElementById("div12").innerHTML=dd; */
								// $('#editor1').html(s[1]);
                         }
                }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post=
	xmlhttp2.open("GET",BASE_URL+"/admin/getparameters?ntid="+ntid,true);
	xmlhttp2.send();
   }
   function doGetCaretPosition(ctrl) {
	var CaretPos = 0;	// IE Support
		if (document.selection) { 
			ctrl.focus ();
			//alertify.alert("Value Length-"+ctrl.value.length);
			var Sel = document.selection.createRange ();
			Sel.moveStart ('character', -ctrl.value.length);
			CaretPos = Sel.text.length;
		}
	// Firefox support
	else if (ctrl.selectionStart || ctrl.selectionStart == '0')
	  {  //alertify.alert(ctrl.value);
		CaretPos = ctrl.selectionStart;
		 alertify.alert(ctrl.selectionStart);
		// alertify.alert(ctrl.selectionEnd);
		}
	return (CaretPos);
 }

function setCaretPosition(ctrl, pos){
	if(ctrl.setSelectionRange)
	{
		ctrl.focus();
		ctrl.setSelectionRange(pos,pos);
	}
	else if (ctrl.createTextRange) {
		var range = ctrl.createTextRange();
		range.collapse(true);
		range.moveEnd('character', pos);
		range.moveStart('character', pos);
		range.select();
	}
} 

function getperioddiv(){
 var s=document.getElementById("notifictaion_type").value;
  if(s=='P'){
   //document.getElementById('periodicdiv').style.display="block";
   $("#periodicdiv").css("display", "block");
   }
   else {
     // document.getElementById('periodicdiv').style.display="none";
       $("#periodicdiv").css("display", "none"); 
    }

 }			
      
    
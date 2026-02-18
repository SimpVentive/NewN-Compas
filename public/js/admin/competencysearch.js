//$(document).ready(function(){
//	$('#thetable').tableScroll({height:150});
//});

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
											if(msg==1){     //alert(rowid);                 
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

  
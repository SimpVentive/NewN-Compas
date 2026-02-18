   
        function testcreation(){
            var qq=document.getElementById('questions').value;
           if(qq==''){
              alertify.alert("Plese Create Question Bank.");
              document.getElementById('questiondiv').style.display="block";
            return false;
          }
        window.location= BASE_URL+"/admin/test_creation"; 
        }
        function gotoquestionbank(){
           window.location=BASE_URL+"/admin/questionbank_home";  
            }
        
        function viewfun(id){
           
            window.location= BASE_URL +"/admin/test_view?id="+id;
    }
    
   function test(id){ 
      window.location=BASE_URL +"/admin/test_creation?id="+id;       
     }
        function managetest(id){ 
           
      window.location=BASE_URL+"/admin/addquestions_test?id="+id;             
     }
     
    function  updatefun(id){
    window.location=BASE_URL +"/admin/update_test?id="+id;       
        
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

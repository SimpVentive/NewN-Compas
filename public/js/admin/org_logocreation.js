$(document).ready(function(){
    $('#org_master_logo').validationEngine()
});


function Create_new(link){
    window.location=BASE_URL+'/admin/'+link;
}

function Update_org(link,id,hash){
    window.location=BASE_URL+'/admin/'+link+'?orgid='+id+'&hash='+hash;
}

$(document).ready(function(){
	$('#logo_img').change(  
            function () {   var iSize =($("#logo_img")[0].files[0].size / 1024); 
			  if(iSize<5 || iSize>=10){ 
                    // alertify.alert("Only '.jpeg','.jpg' formats are allowed.");
                    $('#save').attr("disabled", true);
                    $('#myfile1').html("Logo size between 5 to 10 kbps only.");
               
			} else {    $('#save').attr("disabled", false);
                         $('#myfile1').html(" "); }; 
			     
            });  
	//$('input').on('ifChecked', function(event){});	
  
});

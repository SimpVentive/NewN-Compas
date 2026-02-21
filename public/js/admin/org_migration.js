$(document).ready(function(){
    $('#migrate_data').validationEngine();    
});
 $(function(){
        // Variable to store your files
	var files;
	// Add events
	$('input[type=file]').on('change', prepareUpload);
	$('#migrate').on('click', uploadFiles);

	// Grab the files and set them to our variable
	function prepareUpload(event){
            files = event.target.files;
        }
	// Catch the form submit and upload the files
	function uploadFiles(event){	
	if($("#migrate_data").validationEngine('validate')){
		var parent_org=document.getElementById('parent_org').value;
		// if(browse==''){
			// alert("Please Select File");
			// return false;
		// }
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening
            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value){
                data.append(key, value);
            });   
            
            $.ajax({
                url: BASE_URL+"/admin/org_data_migrate?files&parent_org_id="+parent_org,
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                
                success: function(data, textStatus, jqXHR){
                    if(typeof data.error === 'undefined'){
                        // Success so call function to process the form
                        //alert(data);
                        document.getElementById('org_migrate_data').innerHTML=data;
						//document.getElementById('enrol_emp_no').value='';
            		//submitForm(event, data);
                    }
                    else{
                        // Handle errors here
            		console.log('ERRORS: ' + data.error);
                        //alert(data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                    toastr.error('ERRORS: ' + textStatus);
                    // STOP LOADING SPINNER
                }
            });
        }
	}
        
        function submitForm(event, data){
            // Create a jQuery object from the form
            $form = $(event.target);

            // Serialize the form data
            var formData = $form.serialize();

            // You should sterilise the file names
            /*$.each(data.files, function(key, value){
                formData = formData + '&filenames[]=' + value;
            });*/
            formData=data;
            $.ajax({
                url: BASE_URL+"/admin/org_data_migrate",
                type: 'POST',
                data: formData,
                cache: false,
                dataType: 'json',
                success: function(data, textStatus, jqXHR){
                    if(typeof data.error === 'undefined'){
                        //alert(data);
                        // Success so call function to process the form
                        console.log('SUCCESS: ' + data.success);
                    }
                    else{
                        // Handle errors here                                
                        console.log('ERRORS: ' + data.error);
                   }
               },
               error: function(jqXHR, textStatus, errorThrown){
                   // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                },
                complete: function(){
                    // STOP LOADING SPINNER
                }
            });
        }
    });
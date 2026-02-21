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
		var questionbank=document.getElementById('questionbank').value;
		var comp_def_id=document.getElementById('comp_def_id').value;
		var scale_id=document.getElementById('scale_id').value;
		var element=document.getElementById('element').value;
		var browse=document.getElementById('test').value;
		if(parent_org==''){
			alert("Please Select Parent Organization");
			return false;
		}
		if(browse==''){
			alert("Please Select File");
			return false;
		}
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening
            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value){
                data.append(key, value);
            });   
            
            $.ajax({
                url: BASE_URL+"/admin/test_data_migrate_comp_lang?files&parent_org_id="+parent_org+"&question_bank="+questionbank+"&comp_def_id="+comp_def_id+"&element="+element+"&scale_id="+scale_id,
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
                        document.getElementById('emppersonal_migrate_data').innerHTML=data;
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
                    alert(data);
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
                url: BASE_URL+"/admin/test_data_migrate_comp_lang",
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

function getQuestionbanks(){
	var parentid=document.getElementById('parent_org').value;
	var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('questionbank').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/test_data_questionbanks_comp?parentid="+parentid,true);
    xmlhttp.send();
}

function getCompetencyElements(){
	var qbid=document.getElementById('questionbank').value;
	var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('competency-elements').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/test_comp_elements?qbid="+qbid,true);
    xmlhttp.send();
}

function getlevelCompetencyElements(){
	var comp_id=document.getElementById('comp_def_id').value;
	var scale_id=document.getElementById('scale_id').value;
	var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('competency-level-elements').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/test_comp_level_elements?compid="+comp_id+"&scaleid="+scale_id,true);
    xmlhttp.send();
}
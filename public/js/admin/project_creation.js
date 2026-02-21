$(document).ready(function(){
	$("#project_creation").validationEngine();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeYear: true, changeMonth: true });
	$('#mentor_id').ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
});

function get_subtheme(){
    var themes=document.getElementById('theme').value;
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
            document.getElementById('sub_theme').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/ebook_sub_theme?themes="+themes,true);
    xmlhttp.send(); 
}

function create_ebook(){
    window.location=BASE_URL+"/admin/ebook";
}

function cancel_ebook(){
    window.location=BASE_URL+"/admin/ebook_search";
}

function ebook_dlete(id){
	var xmlhttp;
        if (window.XMLHttpRequest){
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
        }
        else{
                // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }		
        xmlhttp.onreadystatechange=function(){ 
                if (xmlhttp.readyState==4 && xmlhttp.status==200){//alertify.alert(xmlhttp.responseText);
                    document.getElementById('ebook_'+id).style.display='none';
                }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/ebook_details_delete?id="+id,true);
        xmlhttp.send();	
}


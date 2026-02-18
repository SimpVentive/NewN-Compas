 jQuery(function($) {
	var oTable1 = 
		$('#newtableid').dataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null, null,
					  { "bSortable": false }
		]});
	})

jQuery(function($) {
	var oTable1 = 
		$('#newtableids').dataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null,
					  { "bSortable": false }
		]});
	})	
$(document).ready(function(){
        $('#org_master').validationEngine();
		$('#sales_validation').validationEngine();
		$('#product_validation').validationEngine();
        //$('#workinfo_form').validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
		$('.datepicker').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});	
 });
/* $("input[type=submit]").click(function(){
	var def=$('#org_master').validationEngine('validate');
	if(def==false){
		$('#org_master').validationEngine();
	}else{
		$("input[type=submit]").attr('disabled','disabled');
	}
}); */
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));	
	var dates = $( "#dob" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	minDate:"",
	maxDate:difDays
	});				   
}); 
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#date_of_joining, #date_of_exit" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		minDate:org_start_date,
		maxDate:difDays,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id === "date_of_joining" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
			instance.settings.dateFormat ||
			$.datepicker._defaults.dateFormat,
			selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});				   
});
 function readURL(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
             $('#blah').attr('src', e.target.result);
         }
         reader.readAsDataURL(input.files[0]);
     }
 }
 $(document).ready(function(){
     $("#imgInp").change(function(){
         readURL(this);
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
		 
		$(window).on('resize.chosen', function() {
			var w = $('.chosen-select').parent().width();
			if(w<=25){w=250;}
			$('.chosen-select').next().css({'width':w});
		}).trigger('resize.chosen');
     });
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
 });
 
 $(document).ready(function() {
	$('.nav-tabs li').click(function(event){
		if ($(this).hasClass('disabled')) {
			return false;
		}
	});
	if(status!=''){
		if(status=='personal'){
			
			$('#empwork_li').addClass('active');
			$('#emppersonal-info').removeClass('active');
			$('#empwork-info').addClass('active');
			$('#empreportees').removeClass('active');
			$('#empsales').removeClass('active');
		}
		else if(status=='product'){
			
			$('#empwork_li').addClass('active');
			$('#emppersonal-info').removeClass('active');
			$('#empwork-info').addClass('active');
			$('#empreportees').removeClass('active');
			$('#empsales').removeClass('active');
		}
		else if(status=='reportees'){
			$('#empreportees_li').addClass('active');
			$('#emppersonal-info').removeClass('active');
			$('#empwork-info').removeClass('active');
			$('#empreportees').addClass('active');
			$('#empsales').removeClass('active');
		}
		else if(status=='sales'){
			$('#empsales_li').addClass('active');
			$('#emppersonal-info').removeClass('active');
			$('#empwork-info').removeClass('active');
			$('#empreportees').removeClass('active');
			$('#empsales').addClass('active');
		}
	}
	else{
		$("#emppersonal_li").addClass('active');
		$('#emppersonal-info').addClass('active');
		$('#empwork-info').removeClass('active');
		$('#empreportees').removeClass('active');
		$('#empsales').removeClass('active');
	} 
});
 
 
//function validate_pic(){
////jQuery(document).ready(function(){
//    //$('input#submit').click(function(){alertify.alert('asgdsgd');
//    var val = $("#imgInp").val();
//     if (!val.match(/(?:gif|jpg|png|bmp)$/)) {
//         // inputted file path is not an image of one of the above types
//        alertify.alert("Uploaded file is not an Image!");
//        return false;
//     }
// //});
////});
//}
 function change_gendar(){
    var title=document.getElementById('title').value;
    //alertify.alert("in function");
    if(title=='MR' || title=='MRS' || title=='MS'){
        var xmlhttp;
        if (window.XMLHttpRequest)
        { // code for IE7+, Firefox, Chrome, Opera, Safari
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
                document.getElementById("Gendar").innerHTML=xmlhttp.responseText;
                //alertify.alert(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/ChangeGendar?title="+title,true);
        xmlhttp.send();
    }
    else if(title=='DR'){
        document.getElementById("Gendar").innerHTML="<option value='' >Select</option><option value='M'>Male</option><option value='F'>Female</option>";
    }
}

function open_cite(){
    var state_id=document.getElementById('state').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
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
			document.getElementById("cities").innerHTML=xmlhttp.responseText;
			//alertify.alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/city_list?state_id="+state_id,true);
	xmlhttp.send();
    
}
function change_title(){
    var gendar=document.getElementById('Gendar').value;
	var title=document.getElementById('title').value;
    
	if(gendar!=''){
        var xmlhttp;
        if (window.XMLHttpRequest)
        { // code for IE7+, Firefox, Chrome, Opera, Safari
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
                document.getElementById("title").innerHTML=xmlhttp.responseText;
                //alertify.alert(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/ChangeTitle?gendar="+gendar+"&title="+title,true);
        xmlhttp.send();
    }    
}
function move_back(){
    window.location=BASE_URL+'/admin/employee_search';
}
/* function view_age(){
    var db=document.getElementById('dob').value;
    var dob_yr=Array();
    dob_yr=db.split('-');
    var cur_year=new Date().getFullYear();
    var age=cur_year-dob_yr[2];
    document.getElementById('emp_age').value=age+' '+'Years';
   
} */
function check_org(id){
    var org_id=document.getElementById('department['+id+']').value;
    if(org_id==''){
        alertify.alert("Please Select Organization");
        return false;
    }
}
function get_pos(id){
    var orgid=document.getElementById('department['+id+']').value;
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
            //alertify.alert(xmlhttp.responseText);
            document.getElementById("position["+id+"]").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/ChangePosition?org_id="+orgid,true);
    xmlhttp.send();
}
function orgname_valid(){
    var hiddtab="inner_hidden_id";
    var ins=document.getElementById(hiddtab).value;
    if(ins!=''){
        var ins1=ins.split(",");
        var temp=0;
        for( var j=0;j<ins1.length;j++){
            if(parseInt(ins1[j])>parseInt(temp)){
                temp=ins1[j];
            }
        }
        //var maxa=Math.max(ins1);
        sub_iteration=parseInt(temp)+1;
        for( var j=0;j<ins1.length;j++){
            var i=ins1[j];
            var product_name=document.getElementById("product_name["+i+"]").value;
			var product_type=document.getElementById("product_type["+i+"]").value;
			var product_status=document.getElementById("status["+i+"]").value;
            if(product_name==''){
                alertify.alert("Please enter product name");
                return false;
            }
			if(product_type==''){
                alertify.alert("Please Select product type");
                return false;
            }
			if(product_status==''){
                alertify.alert("Please select product status");
                return false;
            }
        }
    }
}
function status_change(){    
    var hiddtab="inner_hidden_id";
    var ins=document.getElementById(hiddtab).value;
    if(ins!=''){
        var ins1=ins.split(",");
        var temp=0;
        for( var j=0;j<ins1.length;j++){
            if(parseInt(ins1[j])>parseInt(temp)){
                temp=ins1[j];
            }
        }
        //var maxa=Math.max(ins1);
        sub_iteration=parseInt(temp)+1;
        for( var j=0;j<ins1.length;j++){
            var i=ins1[j];
            var chars=/^[-a-zA-Z0-9_ ]+$/i;
            var status_val=document.getElementById('status['+i+']').value;
            if(status_val=='A'){               
                for( var k=0;k<ins1.length;k++){
                    l=ins1[k];
                    var status_val2=document.getElementById('status['+l+']').value;
                    if(k!=j){
                        if(status_val==status_val2){
                            alertify.alert("Only one status can be Active");
                            document.getElementById('status['+l+']').value='I';
                            return false;
                        }
                    }
                }
            }
        }
    }
}
function AddInfo(){
    var tbl = document.getElementById("workinfo_tab");
    var lastRow = tbl.rows.length;
    var lastrow1= lastRow+1;
    var hiddtab="inner_hidden_id";
    var ins=document.getElementById(hiddtab).value;
    if(ins!=''){
        var ins1=ins.split(",");
        var temp=0;
        for( var j=0;j<ins1.length;j++){
            if(parseInt(ins1[j])>parseInt(temp)){
                temp=ins1[j];
            }
        }
        //var maxa=Math.max(ins1);
        sub_iteration=parseInt(temp)+1;
        for( var j=0;j<ins1.length;j++){
            var i=ins1[j];
            var product_name=document.getElementById("product_name["+i+"]").value;
			var product_type=document.getElementById("product_type["+i+"]").value;
			var product_status=document.getElementById("status["+i+"]").value;
            if(product_name==''){
                alertify.alert("Please enter product name");
                return false;
            }
			if(product_type==''){
                alertify.alert("Please Select product type");
                return false;
            }
			if(product_status==''){
                alertify.alert("Please select product status");
                return false;
            }
        }
    }
    else{
        sub_iteration=1;
        ins1=1;
        var ins1=Array(1);
    }
	if(org_status!=''){
        var orgst=org_status.split(',');
        var orgnztn_status='';
		orgnztn_status="<option value=''>Select</option>";
        for(var i=0;i<orgst.length;i++){
            orgst2=orgst[i].split('*');
            if(orgnztn_status==''){
                orgnztn_status="<option value='"+orgst2[0]+"'>"+orgst2[1]+"</option>";
            }else{
                if(orgst2[0]=='I'){var sel="selected='selected'";}else{var sel='';}
                orgnztn_status=orgnztn_status+"<option value='"+orgst2[0]+"' "+sel+">"+orgst2[1]+"</option>";
            }
        }
    }else{
        orgnztn_status='';
    }
    var super_sub_iteration=sub_iteration-1;
    $("#workinfo_tab").append("<tr id='worktab"+sub_iteration+"'><td style='padding-left:15px;'><input type='hidden' name='product_id[]' id='product_id["+sub_iteration+"]' value=''><input type='checkbox' name='select_chk' id='select_chk["+sub_iteration+"]' value="+sub_iteration+"></td><td><input class='validate[required]' type='text' name='product_name[]' id='product_name["+sub_iteration+"]' value='' style='width:400px'></td><td><select class='validate[required]' name='product_type[]' id='product_type["+sub_iteration+"]' style='width:300px'><option value=''>Select</option><option value='Screeds'>Screeds</option><option value='Waterproofing'>Waterproofing</option><option value='Adhesives'>Adhesives</option><option value='Grouts'>Grouts</option></select></td><td><input type='hidden' name='stat_hidden' id='stat_hidden["+sub_iteration+"]'><select name='status[]' id='status["+sub_iteration+"]' style='width:200px'>"+orgnztn_status+"</select></td></tr>");
    var config = {
        '.chosen-select': {}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
	
	if(to_date!=''){
		var moddate=to_date.replace(/[/]/g,'-');
		startdate=moddate.split("-");
		var currentDate = new Date(startdate[2],startdate[1]-1,startdate[0]);
		currentDate.setTime(currentDate.getTime() + 1*86400000);
		incre_todate=currentDate.getDate()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getFullYear();
		document.getElementById("from_date"+sub_iteration+"").value=incre_todate; 
	}
	$("#supervisor_"+sub_iteration).ajaxChosen({
		dataType: 'json',
		type: 'POST',
		url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});

	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		if(w<=25){w=250;}
		$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen');
}
function setfromdate(key){
	var to_date=document.getElementById('to_date'+key+'').value;
	if(to_date!=''){
		//var rep="/,-";
		var moddate=to_date.replace(/[/]/g,"-");
		//alertify.alert(moddate);
		startdate=moddate.split("-");
		//alertify.alert(startdate);
		var currentDate = new Date(startdate[2],startdate[1]-1,startdate[0]);
		currentDate.setTime(currentDate.getTime() + 1*86400000);
		incre_todate=currentDate.getDate()+"-"+(currentDate.getMonth()+1)+"-"+currentDate.getFullYear();
		
		var hiddtab="inner_hidden_id";
		var ins=document.getElementById(hiddtab).value;
		if(ins!=''){
			var ins1=ins.split(",");
			for(var j=0;j<ins1.length;j++){
				if(parseInt(ins1[j])==key){
					var ins2=j+1;
					if(document.getElementById('from_date'+ins1[ins2]+'')){
						document.getElementById('from_date'+ins1[ins2]+'').value=incre_todate;
					}
				}
			}        
		}
	}
	else{
		var hiddtab="inner_hidden_id";
		var ins=document.getElementById(hiddtab).value;
		if(ins!=''){
			var ins1=ins.split(",");
			for(var j=0;j<ins1.length;j++){
				if(parseInt(ins1[j])==key){
					var ins2=j+1;
					if(document.getElementById('from_date'+ins1[ins2]+'')){
						document.getElementById('from_date'+ins1[ins2]+'').value='';
					}
				}
			}        
		}		
	}
}
function DelInfo(){
    var ins=document.getElementById('inner_hidden_id').value;
    //alert(ins);
	var arr1=ins.split(",");
    var flag=0;
    var tbl = document.getElementById('workinfo_tab');
    var lastRow = tbl.rows.length;
    for(var i=(arr1.length-1); i>=0; i--){
        var bb=arr1[i];
        var a="select_chk["+bb+"]";	
        	
		if(document.getElementById(a).checked){
			var stat=document.getElementById("stat_hidden["+bb+"]").value;
			if(stat=='A'){
				alertify.alert('You cannot delete an employee work information record, which is active');
				return false;
			}else{
				var del_confirm=window.confirm("Do you want to delete this record?");
				if(del_confirm==true){
					var b=document.getElementById(a).value;
					var c="worktab"+b+"";
					var wrkid=document.getElementById("work_id["+b+"]").value;
					if(wrkid!=""){
						$.ajax({
							url: BASE_URL+"/admin/DeleteEmpInfo",
							global: false,
							type: "POST",
							data: ({val : wrkid}),
							dataType: "html",
							async:false,
							success: function(msg){
							}
						}).responseText;
					}
					for(var j=(arr1.length-1); j>=0; j--) {
						if(arr1[j]==b) {
							arr1.splice(j, 1);
							break;
						}
					}
					flag++;
					$("#"+c).remove();
				}else{
					return false;
				}
			}
		}
    }
    if(flag==0){
        alertify.alert("Please select the Value to Delete");
        return false;
    }
    document.getElementById('inner_hidden_id').value=arr1;
    
}
//Functions for User Creation
function role_creationid(id){
	var role_id=document.getElementById('role_id'+id).value;
	if(document.getElementById('rollid_'+id).checked){
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
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				$('#startdate_'+id).removeAttr('disabled');
				$('#enddate_'+id).removeAttr('disabled');
				$('#menuids_'+id).removeAttr('disabled');
				$('#exclusion'+id).removeAttr('disabled');
				$('#description'+id).removeAttr('disabled');
				$('#role_id'+id).removeAttr('disabled');
				$('#exclusion'+id).addClass('bigbutton');
				$('#user_role_id'+id).removeAttr('disabled');
				document.getElementById('menu_execlusions'+id).style.display='block';
				document.getElementById('menu_execlusions'+id).innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/menu_execlusion?id="+id+"&role_id="+role_id,true);
		xmlhttp.send();
	}
	else{
		$('#msg'+role_id).css('display','none');
		$('#exclusion'+id).removeClass('bigbutton');
		$('#startdate_'+id).attr('disabled','disabled');
		$('#enddate_'+id).attr('disabled','disabled');
		$('#menuids_'+id).val('');
		$('#user_role_id'+id).attr('disabled','disabled');
		$('#menuids_'+id).attr('disabled','disabled');
		$('#exclusion'+id).attr('disabled','disabled');
		$('#description'+id).attr('disabled','disabled');
		$('#role_id'+id).attr('disabled','disabled');
	}
}
function exclusion(type,key){
	var id=type;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState===4 && xmlhttp.status===200){
			document.getElementById("msg"+id).style.display='block';
			document.getElementById("msg"+id).innerHTML=xmlhttp.responseText;
		}
	};
	xmlhttp.open("GET",BASE_URL+"/admin/execlusion?id="+id+"&key="+key,true);
	xmlhttp.send();
}
function cancelmenu(id){
	document.getElementById("msg"+id).style.display='none';
}



$(window).on('resize.chosen', function() {
	var w = $('.chosen-select').parent().width();
	if(w<=25){w=250;}
	$('.chosen-select').next().css({'width':w});
}).trigger('resize.chosen');


function fetch_empdata(){
    var empno=document.getElementById('emp_no').value;
	
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
            $response=xmlhttp.responseText.split('@');
			if($response[0]==0){
				alertify.alert($response[1]);
				//document.getElementById('emp_no').value='';
				$("#emp_no option[value='N/A']").attr("selected", true);
				return false;
			}else{
				if($response[0]!=""){//alertify.alert($response[4]);
					document.getElementById('emp_name').value=$response[1];
					document.getElementById('department').value=$response[2];
					
				}
				else{
					alertify.alert("Employee details does not found with this Employee Number");
					document.getElementById('emp_no').value='';
					document.getElementById('emp_name').value='';
					document.getElementById('department').value='';
					
					return false;
				}
			}
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_details?empnum="+empno,true);
    xmlhttp.send(); 
}

function open_sales_sheet(id){
    var sales_year=document.getElementById('sales_year_'+id).value;
	var sales_id=document.getElementById('sales_id_'+id).value;
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
			var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
			var sheet="";
			if(xmlhttp.responseText!=='null'){
				var myArr = JSON.parse(xmlhttp.responseText);
				for (var i in myArr) {
					
					sheet+="<tr><td><input type='hidden'  name='bud_detail_id[]' id='bud_detail_id' class='col-xs-12 col-sm-12' value='"+ myArr[i].bud_detail_id + "'><input type='hidden'  name='month_id[]' id='month_id' class='col-xs-12 col-sm-12' value='"+ myArr[i].month + "'><input type='text' class='col-xs-12 col-sm-12' value='"+months[myArr[i].month-1] + "' readonly></td><td><input type='text'  name='sales_target[]' id='sales_target' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120' value='"+ myArr[i].sales_target + "'></td><td><input type='text'  name='actual_sales[]' id='actual_sales' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120' value='"+ myArr[i].actual_sales + "'></td></tr>";
				}
			}
			else{
				
				for (var i in months) {
					var aa=i+1;
					sheet+="<tr><td><input type='hidden'  name='bud_detail_id[]' id='bud_detail_id' class='col-xs-12 col-sm-12' value=''><input type='hidden'  name='month_id[]' id='month_id' class='col-xs-12 col-sm-12' value='"+aa+ "'><input type='text' class='col-xs-12 col-sm-12' value='"+months[i]+ "' readonly></td><td><input type='text'  name='sales_target[]' id='sales_target' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120'></td><td><input type='text'  name='actual_sales[]' id='actual_sales' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120'></td></tr>";
				}
			}
			//alert(sheet);
			$("#sales_sheet"+id).html(sheet);
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_sales_data_details?sales_year="+sales_year+"&sales_id="+sales_id,true);
    xmlhttp.send(); 
}


function Enroll_data_Delete(){
	var ins=document.getElementById('hidden_val').value;	
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('newtableid');
	var lastRow = tbl.rows.length;
	
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chck["+bb+"]";
		
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="innerdata["+b+"]";
			var sales_id=document.getElementById("sales_id["+b+"]").value;
			if(sales_id!=""){
				$.ajax({
					url: BASE_URL+"/admin/delete_sales_data",
					global: false,
					type: "POST",
					data: ({sales_id: sales_id}),
					dataType: "html",
					async:false,
					success: function(msg){
					}
				}).responseText;
			}
			for(var j=(arr1.length-1); j>=0; j--) {
				if(arr1[j]==b) {
					arr1.splice(j, 1);
					break;
				}
			}
			flag++;
			//alertify.alert("#"+c);
			document.getElementById(c).style.display='none';
			document.getElementById('enrollment_div').innerHTML='';
		   // $("#"+c).remove();                
		}
	}
	if(flag==0){
		alertify.alert("Please select the data to Delete");
		return false;
	}
	document.getElementById('hidden_val').value=arr1;
	if(lastRow<5){
		$('#enrolldivtab').css('height','auto');
	}
}


function open_dealer_sales_sheet(id){
    var sales_year=document.getElementById('sales_year_n_'+id).value;
	var product_id=document.getElementById('product_id_'+id).value;
    var xmlhttp;
	if(sal_val!=''){
        var salid=sal_val.split(',');
        var saldata='';
        for(var i=0;i<salid.length;i++){
            sal1=salid[i];
            sal2=sal1.split('*');
			
            if(saldata==''){
                saldata="<option value='"+sal2[0]+"' >"+sal2[1]+"</option>";
            }else{
                saldata=saldata+"<option value='"+sal2[0]+"'>"+sal2[1]+"</option>";
            }
        }
    }else{
        saldata='';
    }
	
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
			var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
			var sheet="";
			if(xmlhttp.responseText!=='null'){
				var myArr = JSON.parse(xmlhttp.responseText);
				for (var i in myArr) {
					sheet+="<tr><td><input type='hidden'  name='dealer_detail_id[]' id='dealer_detail_id' class='col-xs-12 col-sm-12' value='"+ myArr[i].dealer_detail_id + "'><input type='hidden'  name='month_id[]' id='month_id' class='col-xs-12 col-sm-12' value='"+ myArr[i].month + "'><input type='text' class='col-xs-12 col-sm-12' value='"+months[myArr[i].month-1] + "' readonly></td><td><select name='sales_id[]' id='sales_id'  class='col-xs-12 col-sm-12' style='width:200px;'><option value=''>Select</option>"+saldata+"</select></td><td><input type='text'  name='sales_target[]' id='sales_target' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120' value='"+ myArr[i].sales_target + "'></td><td><input type='text'  name='actual_sales[]' id='actual_sales' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120' value='"+ myArr[i].actual_sales + "'></td></tr>";
				}
			}
			else{
				for (var i in months) {
					var aa=i+1;
					sheet+="<tr><td><input type='hidden'  name='dealer_detail_id[]' id='dealer_detail_id' class='col-xs-12 col-sm-12' value=''><input type='hidden'  name='month_id[]' id='month_id' class='col-xs-12 col-sm-12' value='"+aa+ "'><input type='text' class='col-xs-12 col-sm-12' value='"+months[i]+ "' readonly></td><td><select name='sales_id[]' id='sales_id'  class='col-xs-12 col-sm-12' style='width:200px;'><option value=''>Select</option>"+saldata+"</select></td><td><input type='text'  name='sales_target[]' id='sales_target' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120'></td><td><input type='text'  name='actual_sales[]' id='actual_sales' class='validate[minSize[2], maxSize[150]] col-xs-12 col-sm-12' size='35px;' maxlength='120'></td></tr>";
				}
			}
			//alert(sheet);
			$("#sales_n_sheet"+id).html(sheet);
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_dealer_sales_data_details?sales_year="+sales_year+"&product_id="+product_id,true);
    xmlhttp.send(); 
}
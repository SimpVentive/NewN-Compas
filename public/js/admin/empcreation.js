$(document).ready(function(){
        $('#org_master').validationEngine();
		 $('#work_info').validationEngine();
        //$('#workinfo_form').validationEngine({validateNonVisibleFields: true, updatePromptsPosition:true});
		$('.datepicker').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#datepicker_from').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#datepicker_to').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#datepicker_start0').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#datepicker_end0').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#datepicker_new').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
		$('#to_date').datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
			
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
			$('#emppersonal_li').removeClass('active');
			$('#empwork-info').addClass('active');
			$('#empreportees').removeClass('active');
		}else if(status=='reportees'){
			$('#empreportees_li').addClass('active');
			$('#emppersonal-info').removeClass('active');
			$('#empwork-info').removeClass('active');
			$('#empreportees').addClass('active');
		}
	}
	else{
		$("#emppersonal_li").addClass('active');
		$('#emppersonal-info').addClass('active');
		$('#empwork-info').removeClass('active');
		$('#empreportees').removeClass('active');
	} 
});
 
 
//function validate_pic(){
////jQuery(document).ready(function(){
//    //$('input#submit').click(function(){toastr.error('asgdsgd');
//    var val = $("#imgInp").val();
//     if (!val.match(/(?:gif|jpg|png|bmp)$/)) {
//         // inputted file path is not an image of one of the above types
//        toastr.error("Uploaded file is not an Image!");
//        return false;
//     }
// //});
////});
//}
 function change_gendar(){
    var title=document.getElementById('title').value;
    //toastr.error("in function");
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
                //toastr.error(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/ChangeGendar?title="+title,true);
        xmlhttp.send();
    }
    else if(title=='DR'){
        document.getElementById("Gendar").innerHTML="<option value='' >Select</option><option value='M'>Male</option><option value='F'>Female</option>";
    }
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
                //toastr.error(xmlhttp.responseText);
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
        toastr.error("Please Select Organization");
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
            //toastr.error(xmlhttp.responseText);
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
            var from_date=document.getElementById("from_date"+i+"").value; 
			var to_date=document.getElementById("to_date"+i+"").value; 
			if(from_date=='' && to_date==''){
				toastr.error("From Date and To Date Both can not be empty");
				return false;
			}
			if(from_date=='' && to_date!=''){
				toastr.error("You can not give To Date without giving From Date");
				return false;
			}
            var org=document.getElementById("department["+i+"]").value;
			var pos=document.getElementById("position["+i+"]").value;	
			var grade=document.getElementById("grade["+i+"]").value;
			var payroll=document.getElementById("payroll["+i+"]").value;
			var loc=document.getElementById("location["+i+"]").value;
			var sup=document.getElementById("supervisor_"+i).value;
			var gross=document.getElementById("gross["+i+"]").value;
			var net=document.getElementById("net["+i+"]").value;
			var tot_ctc=document.getElementById("ctc["+i+"]").value;
            if(org==''){
                toastr.error("Please Select Organization Name");
                return false;
            }
            else{
                for( var k=0;k<ins1.length;k++){
                    l=ins1[k];
                    var org2=document.getElementById("department["+l+"]").value; 
					var pos2=document.getElementById("position["+l+"]").value;	
					var grade2=document.getElementById("grade["+l+"]").value;
					var payroll2=document.getElementById("payroll["+l+"]").value;
					var loc2=document.getElementById("location["+l+"]").value;
					var sup2=document.getElementById("supervisor_"+l).value;
					var gross2=document.getElementById("gross["+l+"]").value;
					var net2=document.getElementById("net["+l+"]").value;
					var tot_ctc2=document.getElementById("ctc["+l+"]").value;
					
                    if(k!=j){
                        if(org==org2 && pos==pos2 && grade==grade2 && payroll==payroll2 && loc==loc2 && sup==sup2 && gross==gross2 && net==net2 && tot_ctc==tot_ctc2){
                            toastr.error("All the details are matching with one of the previous records");
                            return false;
                        }
                    }
                }
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
                            toastr.error("Only one status can be Active");
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
            var from_date=document.getElementById("from_date"+i+"").value; 
			var to_date=document.getElementById("to_date"+i+"").value; 
			if(from_date=='' && to_date==''){
				toastr.error("From Date and To Date Both can not be empty");
				return false;
			}
			if(from_date=='' && to_date!=''){
				toastr.error("You can not give To Date without giving From Date");
				return false;
			}
			if(to_date==''){
				toastr.error("You can not Add new Organization without giving To Date to the current Organization");
				return false;
			}
			
            var org=document.getElementById("department["+i+"]").value;
			var pos=document.getElementById("position["+i+"]").value;	
			var grade=document.getElementById("grade["+i+"]").value;
			var payroll=document.getElementById("payroll["+i+"]").value;
			var loc=document.getElementById("location["+i+"]").value;
			var sup=document.getElementById("supervisor_"+i).value;
			var gross=document.getElementById("gross["+i+"]").value;
			var net=document.getElementById("net["+i+"]").value;
			var tot_ctc=document.getElementById("ctc["+i+"]").value;
            if(org==''){
                toastr.error("Please Select Organization Name");
                return false;
            }
            else{
                for( var k=0;k<ins1.length;k++){
                    l=ins1[k];
                    var org2=document.getElementById("department["+l+"]").value; 
					var pos2=document.getElementById("position["+l+"]").value;	
					var grade2=document.getElementById("grade["+l+"]").value;
					var payroll2=document.getElementById("payroll["+l+"]").value;
					var loc2=document.getElementById("location["+l+"]").value;
					var sup2=document.getElementById("supervisor_"+l).value;
					var gross2=document.getElementById("gross["+l+"]").value;
					var net2=document.getElementById("net["+l+"]").value;
					var tot_ctc2=document.getElementById("ctc["+l+"]").value;
					
                    if(k!=j){
                        if(org==org2 && pos==pos2 && grade==grade2 && payroll==payroll2 && loc==loc2 && sup==sup2 && gross==gross2 && net==net2 && tot_ctc==tot_ctc2){
                            toastr.error("All the details are matching with one of the previous records");
                            return false;
                        }
                    }
                }
            }
        }
    }
    else{
        sub_iteration=1;
        ins1=1;
        var ins1=Array(1);
    }
	 // To fetch Organization Details from lms_admin_emp_creation.php page
    if(org_val!=''){
        var orgid=org_val.split(',');
        var orgdata='';
        for(var i=0;i<orgid.length;i++){
            org1=orgid[i];
            org2=org1.split('*');
            if(orgdata==''){
                orgdata="<option value='"+org2[0]+"'>"+org2[1]+"</option>";
            }else{
                orgdata=orgdata+"<option value='"+org2[0]+"'>"+org2[1]+"</option>";
            }
        }
    }else{
        orgdata='';
    }
    // To fetch business units Details from lms_admin_emp_creation.php page
    if(bus_org_val!=''){
        var orgid=bus_org_val.split(',');
        var borgdata='';
        for(var i=0;i<orgid.length;i++){
            org1=orgid[i];
            org2=org1.split('*');
            if(borgdata==''){
                borgdata="<option value='"+org2[0]+"'>"+org2[1]+"</option>";
            }else{
                borgdata=borgdata+"<option value='"+org2[0]+"'>"+org2[1]+"</option>";
            }
        }
    }else{
        borgdata='';
    }
	 //To fetch Positions from php page 
	if(pos_val!=''){
	    var posid=pos_val.split(',');
		var position='';
		for(var i=0;i<posid.length;i++){
		    pos1=posid[i];
			pos2=pos1.split('*');
			if(position==''){
			    position="<option value='"+pos2[0]+"'>"+pos2[1]+"</option>";
			}
			else{
			    position=position+"<option value='"+pos2[0]+"'>"+pos2[1]+"</option>";
			}
		}
	}
	else{
	    position='';
	}
   
    // To fetch Grades Details from lms_admin_emp_creation.php page
    if(grade_val!=''){
        var grdid=grade_val.split(',');
        var grades='';
        for(var i=0;i<grdid.length;i++){
            grd1=grdid[i];
            grd2=grd1.split('*');
            if(grades==''){
                grades="<option value='"+grd2[0]+"'>"+grd2[1]+"</option>";
            }else{
                grades=grades+"<option value='"+grd2[0]+"'>"+grd2[1]+"</option>";
            }
        }
    }
    else{
      grades='';  
    }
	
	// To fetch SubGrades Details from lms_admin_emp_creation.php page
    if(sub_grade_val!=''){
        var sgrdid=sub_grade_val.split(',');
        var sgrades='';
        for(var i=0;i<sgrdid.length;i++){
            sgrd1=sgrdid[i];
            sgrd2=sgrd1.split('*');
            if(sgrades==''){
                sgrades="<option value='"+sgrd2[0]+"'>"+sgrd2[1]+"</option>";
            }else{
                sgrades=sgrades+"<option value='"+sgrd2[0]+"'>"+sgrd2[1]+"</option>";
            }
        }
    }
    else{
      sgrades='';  
    }
	
    // To fetch Location Details from lms_admin_emp_creation.php page
    if(loc_val!=''){
        var locid=loc_val.split(',');
        var locations='';
        for(var i=0;i<locid.length;i++){
            loc1=locid[i];
            loc2=loc1.split('*');
            if(locations==''){
                locations="<option value='"+loc2[0]+"'>"+loc2[1]+"</option>";
            }else{
                locations=locations+"<option value='"+loc2[0]+"'>"+loc2[1]+"</option>";
            }
        }
    }
    else{
        locations='';
    }
    // To fetch Grades Details from lms_admin_emp_creation.php page
    if(super_val!=''){
        var superid=super_val.split(',');
        var supervisors='';
        for(var i=0;i<superid.length;i++){
            sup1=superid[i];
            sup2=sup1.split('*');
            if(supervisors==''){
                supervisors="<option value='"+sup2[0]+"'>"+sup2[1]+"</option>";
            }else{
                supervisors=supervisors+"<option value='"+sup2[0]+"'>"+sup2[1]+"</option>";
            }
        }
    }
    else{
        supervisors='';
    }
    // To fetch status Details from lms_admin_emp_creation.php page
    if(org_status!=''){
        var orgst=org_status.split(',');
        var orgnztn_status='';
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
    $("#workinfo_tab").append("<tr id='worktab"+sub_iteration+"'><td style='padding-left:15px;'><input type='checkbox' name='select_chk' id='select_chk["+sub_iteration+"]' value="+sub_iteration+"></td><td><input type='hidden' name='work_id[]' id='work_id["+sub_iteration+"]' value=''><input type='text' style='width:90px' class='validate[custom[date2],future[#to_date"+super_sub_iteration+"], past[#date_of_exit]] datepicker mediumtext' name='from_date[]' id='from_date"+sub_iteration+"' value='' readonly></td><td><input type='text' style='width:90px' class='validate[custom[date2],future[#from_date"+sub_iteration+"],past[#date_of_exit]] datepicker mediumtext' name='to_date[]' id='to_date"+sub_iteration+"' value='' onfocus='date_funct(this.id)'  onchange='setfromdate("+sub_iteration+")'></td><td><select name='department[]' id='department["+sub_iteration+"]' class='validate[required] mediumselect'><option value=''>Select</option>"+orgdata+"</select></td><td><select name='business_unit[]' id='business_unit["+sub_iteration+"]' class='validate[required] mediumselect'><option value=''>Select</option>"+borgdata+"</select></td><td><select class='mediumselect' name='position[]' id='position["+sub_iteration+"]'><option value=''>Select</option>"+position+"</select></td><td><select class='mediumselect' name='grade[]' id='grade["+sub_iteration+"]' onclick='check_org("+sub_iteration+")'><option value=''>Select</option>"+grades+"</select></td><td><select class='mediumselect' name='sub_grade[]' id='sub_grade["+sub_iteration+"]' onclick='check_org("+sub_iteration+")'><option value=''>Select</option>"+sgrades+"</select></td><td><select class='mediumselect' name='payroll[]' id='payroll["+sub_iteration+"]' onclick='check_org("+sub_iteration+")'><option value=''>Select</option></select></td><td><select class='mediumselect' name='location[]' id='location["+sub_iteration+"]' onclick='check_org("+sub_iteration+")'><option value=''>Select</option>"+locations+"</select></td><td><select class='supervisor mediumselect chosen-select' name='supervisor[]' id='supervisor_"+sub_iteration+"' onclick='check_org("+sub_iteration+")'><option value=''>Select</option>"+supervisors+"</select></td><td><select class='mediumselect' name='manager[]' id='manager["+sub_iteration+"]' onclick='check_org("+sub_iteration+")'><option value=''>Select</option></select></td><td><input class='mediumtext' type='text' style='width:75px;' name='gross[]' id='gross["+sub_iteration+"]' value=''></td><td><input type='text' class='mediumtext' style='width:75px;' name='net[]' id='net["+sub_iteration+"]' value=''></td><td><input type='text' class='mediumtext' style='width:75px;' name='ctc[]' id='ctc["+sub_iteration+"]' value=''></td><td><input type='hidden' name='stat_hidden' id='stat_hidden["+sub_iteration+"]'><select class='mediumselect' name='status[]' id='status["+sub_iteration+"]' onchange='status_change()'>"+orgnztn_status+"</select></td></tr>");
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
		//toastr.error(moddate);
		startdate=moddate.split("-");
		//toastr.error(startdate);
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
				toastr.error('You cannot delete an employee work information record, which is active');
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
        toastr.error("Please select the Value to Delete");
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

$("#supervisor_0").ajaxChosen({
	   dataType: 'json',
	   type: 'POST',
	   url:BASE_URL+'/admin/autoemployee'
},{
	   loadingImg: 'loading.gif'
});
function on_loads(){
	$(window).on('resize.chosen', function() {
		var w = $('.chosen-select').parent().width();
		//alert(w);
		if(w<=66.6666){
			w=195;}
		$('#department_chosen,#supervisor_0_chosen').css({'width':w}); 
	}).trigger('resize.chosen');
}
function getRole(val,key) {
	$.ajax({
	type: "POST",
	url: BASE_URL+'/admin/menu_view?role_id='+val+'&key='+key,
	success: function(data){
		$("#menu_execlusions"+key).html(data);
	}
	});
}

function AddExpenses_validation(){
	var hiddtab="exp_hidden_id";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=ins1[j];
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];
			var item_id=document.getElementById('rollid_'+i+'').checked;
			if(item_id==''){
				toastr.error("Please Check the checkbox");
				return false;
			}
			var item_type=document.getElementById('role_id'+i+'').value;
			if(item_type==''){
				toastr.error("Please Select Role name");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('role_id'+l+'').value;
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Role name already selected");
							return false;
						}
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
}

function AddExpenses(){
	var hiddtab="exp_hidden_id";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=parseInt(ins1[j]);
			}
		}
		
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];
			var item_id=document.getElementById('rollid_'+i+'').checked;
			
			if(item_id==''){
				toastr.error("Please Check the checkbox");
				return false;
			}
			var item_type=document.getElementById('role_id'+i+'').value;
			
			if(item_type==''){
				toastr.error("Please Select Role name");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					//alert(l);
					var item_type2=document.getElementById('role_id'+l+'').value;
					
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Role name already selected");
							return false;
						}
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}
	// To fetch Expenses type from .php page
   if(exptype!=''){
        var expt=exptype.split(',');
        var item_type='';
        for(var i=0;i<expt.length;i++){
            emp1=expt[i];
            emp2=emp1.split('*');
            if(item_type==''){
                item_type="<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }else{
                item_type=item_type+"<option value='"+emp2[0]+"'>"+emp2[1]+"</option>";
            }
        }
    }else{
        item_type='';
    }
	
	$("#expense_details").append("<tr id='expenses"+sub_iteration+"'><td><input type='checkbox'  id='rollid_"+sub_iteration+"' name='rolename[]' class='validate[] checkbox'  value='"+sub_iteration+"'/></td><td><input id='user_role_id"+sub_iteration+"' type='hidden' name='user_role_id["+sub_iteration+"]' value='' ><select name='role_id["+sub_iteration+"]' id='role_id"+sub_iteration+"' class='form-control m-b' onchange='getRole(this.value,"+sub_iteration+");' ><option value=''>Select</option>"+item_type+"</select></td><td><input type='text' name='description["+sub_iteration+"]'  id='description"+sub_iteration+"'  class='form-control'></td><td><div class='input-group date' id='datepicker_start"+sub_iteration+"'><input type='text' name='startdate["+sub_iteration+"]' id='startdate_"+sub_iteration+"' class='validate[required,custom[date2],future[#start_date]] form-control'><span class='input-group-addon'><span class='fa fa-calendar'></span></span></div></td><td><div class='input-group date' id='datepicker_end"+sub_iteration+"'><input type='text' name='enddate["+sub_iteration+"]'  id='enddate_"+sub_iteration+"' class='validate[custom[date2],future[#startdate_"+sub_iteration+"]] form-control'><span class='input-group-addon'><span class='fa fa-calendar'></span></span></div></td><td><div id='menu_execlusions"+sub_iteration+"'><input type='button' name='exclusion' id='exclusion"+sub_iteration+"' value='Menu'></div></td></tr>");
	$('#datepicker_start'+sub_iteration).datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
	$('#datepicker_end'+sub_iteration).datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
	$('#startdate_'+sub_iteration).datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
	$('#enddate_'+sub_iteration).datepicker({format: 'dd-mm-yyyy',orientation: "top",autoclose: true,todayHighlight: true});
	$(document).ready(function(){
		var date1 = new Date();
		var date2 = new Date(2039,0,19);
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		var dates = $( "#startdate_"+sub_iteration+", #enddate_"+sub_iteration+"" ).datepicker({
			dateFormat:"dd-mm-yy",
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 1,
			/*minDate:0,
			maxDate:difDays,*/
			onSelect: function( selectedDate ) {
				var option = this.id === "startdate_"+sub_iteration+"" ? "minDate" : "maxDate", instance = $( this ).data( "datepicker" ),date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat,selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
		if($("#enddate_"+sub_iteration+"").val()!=""){
			$( "#startdate_"+sub_iteration+"" ).datepicker("option", "maxDate", $("#enddate_"+sub_iteration+"").val());
		}
		if($("#startdate_"+sub_iteration+"").val()!=""){
			$( "#enddate_"+sub_iteration+"" ).datepicker("option", "minDate", $("#startdate_"+sub_iteration+"").val());
		}
	});
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}

function DelExpenses(){
	var ins=document.getElementById('exp_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('expense_details');
	var lastRow = tbl.rows.length;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=parseInt(arr1[i]);
		if(bb!=0){
		var a="rollid_"+bb+"";
		
		if(document.getElementById(a).checked){
			if($("#"+a).attr('disabled') === undefined){
			var b=document.getElementById(a).value;
			
			var c="expenses"+b+"";
			var user_role_id=document.getElementById("user_role_id"+b+"").value;
			
			/* if(user_role_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_emp_role",
					global: false,
					type: "POST",
					data: ({val : user_role_id}),
					dataType: "html",
					async:false,
					success: function(msg){
					}
				}).responseText;
			}  */
			
			for(var j=(arr1.length-1); j>=0; j--) {
				if((arr1[j])==b) {
					arr1.splice(j, 1);
					break;
				}  
			}
			flag++;
			$("#"+c).remove();
			}
		}
		}
	}
	if(flag==0){
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById('exp_hidden_id').value=arr1;
}

function work_info_view(id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		 //code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		 //code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('workinfodetails'+id).innerHTML="loading..."
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById('workinfodetails'+id).innerHTML=xmlhttp.responseText;
		$("#supervisor_1").ajaxChosen({
				   dataType: 'json',
				   type: 'POST',
				   url:BASE_URL+'/admin/autoemployee'
			},{
				   loadingImg: 'loading.gif'
			});
			$(window).on('resize.chosen', function() {
				var w = $('.chosen-select').parent().width();
				if(w<=244){
					w=180;}
				$('#supervisor_1_chosen').css({'width':w}); 
			}).trigger('resize.chosen');
			
		}
		}
	
	xmlhttp.open("GET",BASE_URL+"/admin/work_info_details?work_info_id="+id,true);
	xmlhttp.send();
}

function grade_change(id){    
     var grade_id=document.getElementById('grade['+id+']').value;
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
             $('#subgradediv'+id).html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/grade_sub_emp_creation?grade_id="+grade_id+"&key="+id,true);
     xmlhttp.send();
}

function zones_change(id){    
     var zone_id=document.getElementById('zones_name['+id+']').value;
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
             $('#statenames'+id).html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/zone_states_emp_creation?zone_id="+zone_id+"&key="+id,true);
     xmlhttp.send();
}

function open_location_state(id){    
    var state_id=document.getElementById('state_id['+id+']').value;
	var zone_id=document.getElementById('zones_name['+id+']').value;
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
             $('#locationnames'+id).html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/states_emp_creation?zone_id="+zone_id+"&state_id="+state_id+"&key="+id,true);
     xmlhttp.send();
}

function check_org(){}
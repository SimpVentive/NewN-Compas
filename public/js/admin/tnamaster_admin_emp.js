//Start of Script for TNA Setup

$(document).ready(function(){
	
	$('#tna').validationEngine();
	$('#tna_form').validationEngine();
	$('#usercreationform').validationEngine();
	
	
});
$(document).ready(function(){
$('#emp_no').ajaxChosen({
		
		   dataType: 'json',
		   type: 'POST',
		   url:BASE_URL+'/admin/autoemployee'
	},{
		   loadingImg: 'loading.gif'
	});
	
});


$(document).ready(function(){
	$("#contentcat").ace_scroll({
	size:230,
	mouseWheelLock: true,
	alwaysVisible : true
	});
	
	$('.scrollable_emp').each(function () {
		var $this = $(this);
		$(this).ace_scroll({
			size: $this.data('height') || 300,
			//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
		});
	});
	
	$('.scrollable').each(function () {
		var $this = $(this);
		$(this).ace_scroll({
			size: $this.data('height') || 700,
			//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
		});
	});

	
});
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});
function on_loads_expenses(id,exp_id){
    var tna_id=document.getElementById('tna_id').value;
	var tna_admin_id=document.getElementById('tna_admin_id').value;
	var emp_num=document.getElementById('emp_num').value;
	var status_n=document.getElementById('status').value;
	var key_id=id;

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
                document.getElementById("expences_details"+id).innerHTML=xmlhttp.responseText;
                $('#expenses_data').validationEngine();
            }
        }
        xmlhttp.open("GET",BASE_URL+"/admin/manager_emp_programs?tna_id="+tna_id+"&tna_admin_id="+tna_admin_id+"&key_value="+id+"&expid="+exp_id+"&emp_num="+emp_num+"&status_n="+status_n,true);
        xmlhttp.send();

}
function search_program(){
	var cat_ids=document.getElementById('default_cat').value;
	var cat_id="";
	var program_name=document.getElementById('program_name').value;
	var emp_num=document.getElementById('emp_num').value;
	var tna_id=document.getElementById('tna_id').value;
	var status_n=document.getElementById('status').value;
	var tna_admin_id=document.getElementById('tna_admin_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('program_search').innerHTML="<img style='padding-left:350px;' src='"+BASE_URL+"/public/images/outsell_loading.gif'/>";
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("program_search").innerHTML=xmlhttp.responseText;
			$('.scrollable').each(function () {
				var $this = $(this);
				$(this).ace_scroll({
					size: $this.data('height') || 500,
					//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
				});
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/admin_emp_programs_view?cat_id="+cat_id+"&program_name="+program_name+"&status="+status_n+"&tna_id="+tna_id+"&tna_admin_id="+tna_admin_id+"&emp_num="+emp_num+"&cat_ids="+cat_ids,true);
	xmlhttp.send();

}
function open_cat_programs(id){
	var emp_num=document.getElementById('emp_num').value;
	var tna_id=document.getElementById('tna_id').value;
	var program_name="";
	var cat_ids="";
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
			document.getElementById("program_search").innerHTML=xmlhttp.responseText;
			$('.scrollable').each(function () {
		var $this = $(this);
		$(this).ace_scroll({
			size: $this.data('height') || 500,
			//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
		});
	});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/admin_emp_programs_view?cat_id="+id+"&program_name="+program_name+"&emp_num="+emp_num+"&tna_id="+tna_id+"&cat_ids="+cat_ids,true);
	xmlhttp.send();

}

function open_cat_programs_search(id){
	var tna_admin_id=document.getElementById('tna_admin_id').value;
	var tna_id=document.getElementById('tna_id').value;
	var status_n=document.getElementById('status').value;
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
			document.getElementById("program_search_one").innerHTML=xmlhttp.responseText;
			$('.scrollable').each(function () {
		var $this = $(this);
		$(this).ace_scroll({
			size: $this.data('height') || 500,
			//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
		});
	});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/manager_programs_emp_add?cat_id="+id+"&status="+status_n+"&tna_id="+tna_id+"&tna_admin_id="+tna_admin_id,true);
	xmlhttp.send();

}


function open_program_info(id){
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
			document.getElementById("program_info").innerHTML=xmlhttp.responseText;
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/manager_program_info?pro_id="+id,true);
	xmlhttp.send();

}

function click_submit(id){
	var a="pro_id"+id;
	if(document.getElementById(a).checked){
		var program_id=document.getElementById("program_id"+id).value;
		var employee_id=document.getElementById("employee_id").value;
		var tna_id=document.getElementById("tna_id").value;
		var catid=document.getElementById("cat_id").value;
		if(program_id!=' '){
			$.ajax({
				url: BASE_URL+"/admin/admin_add_programs",
				global: false,
				type: "POST",
				data: ({val : program_id,emp_id : employee_id,tnaid : tna_id,cat_ids : catid}),
				dataType: "html",
				async:false,
				success: function(msg){
					open_cat_programs(catid);
					document.getElementById('emp_program').innerHTML=msg;
				}
			}).responseText;
		} 
		
	}
	
}

function open_program_info_emp(id){
	document.getElementById("program_info_emp").innerHTML="";
	var tna_admin_id=document.getElementById('tna_admin_id').value;
	var tna_id=document.getElementById('tna_id').value;
	var status_n=document.getElementById('status').value;
	var cat_id=document.getElementById('cat_id').value;
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
			document.getElementById("program_info_emp").innerHTML=xmlhttp.responseText;
			$('.scrollable').each(function () {
				var $this = $(this);
				$(this).ace_scroll({
					size: $this.data('height') || 300,
					//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
				});
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/manager_program_addemp?pro_id="+id+"&status="+status_n+"&tna_id="+tna_id+"&tna_admin_id="+tna_admin_id+"&cat_id="+cat_id,true);
	xmlhttp.send();

}

function selectAll(source) {
	checkboxes = document.getElementsByName('emp_id[]');
	for(var i in checkboxes)
	checkboxes[i].checked = source.checked;
}

function open_other_program(id){
	var emp_id=document.getElementById('employee_id').value;
	var emp_num=document.getElementById('emp_num').value;
	var tna_id=document.getElementById('tna_id').value;
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
			document.getElementById("program_other_info").innerHTML=xmlhttp.responseText;
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/admin_cat_other_programs?cat_id="+id+"&emp_num="+emp_num+"&tna_id="+tna_id+"&emp_id="+emp_id,true);
	xmlhttp.send();

}




function addcompetency(){
	var tbl = document.getElementById("other_progamTab");
	var lastRow = tbl.rows.length;
	var lastrow1= lastRow+1;
	var hiddtab="addgroup";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(parseInt(ins1[j])>parseInt(temp)){
				temp=ins1[j];
			}
		}
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j];		
			var name=document.getElementById('level_name_'+i).value;
			if(name==''){
				alertify.alert("Please Enter program name");
				return false;
			}
			else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var name1=document.getElementById('level_name_'+l).value;
					if(k!=j){
						if(name==name1){
							alertify.alert("Program Name Already Exists");
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

	
	$("#other_progamTab").append("<tr id='tna_org_row"+sub_iteration+"'><td style='padding-left: 15px;'><input type='checkbox' name='chkbox' id='chkbox_"+sub_iteration+"' value="+sub_iteration+" /></td><td><input type='text' name='level_name[]' id='level_name_"+sub_iteration+"' value=''  style='width:300px;'/></td></tr>");
	
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}

/* function fetch_empdata(){
    var empno=document.getElementById('emp_number').value;
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
				}
				else{
					alertify.alert("Employee details does not found with this Employee Number");
					document.getElementById('emp_no').value='';
					document.getElementById('emp_name').value='';
					document.getElementById('department').value='';
					document.getElementById('emp_org_id').value='';
					return false;
				}
			}
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/fetch_emp_data_id_tna?empnum="+empno,true);
    xmlhttp.send(); 
} */

/* $(window).on('resize.chosen', function() {
	var w = $('.chosen-select').parent().width();
	w=326;
	$('.chosen-select').next().css({'width':w});
	}).trigger('resize.chosen'); */
	
	


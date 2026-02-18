$(document).ready(function(){
	$('#comp_master').validationEngine();
});

function open_subcategory(){
	var cat_id=document.getElementById('comp_def_category').value;
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
			document.getElementById('comp_def_sub_category').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/change_subcat?id="+cat_id,true);
	xmlhttp.send();	
}

function open_indicator(id){
	var hiddtab="addgroup"+id;
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
			var ind_type=document.getElementById('comp_def_level_ind_type_'+i+'_'+id).value;
			var ind_name=document.getElementById('comp_def_level_ind_name_'+i+'_'+id).value;
			if(ind_type==''){
				toastr.error("Please select Indicator type.");
				return false;
			}
			if(ind_name==''){
				toastr.error("Please enter indicators.");
				return false;
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
    
	if(ind_detail!=''){
        var ind_details=ind_detail.split(',');
        var ind_ids='';
        for(var i=0;i<ind_details.length;i++){
            ind1=ind_details[i];
            ind2=ind1.split('*');
            if(ind_ids==''){
                ind_ids="<option value='"+ind2[0]+"'>"+ind2[1]+"</option>";
            }else{
                ind_ids=ind_ids+"<option value='"+ind2[0]+"'>"+ind2[1]+"</option>";
            }
        }
    }else{
        ind_ids='';
    }
	
	$("#source_table"+id).append("<tr id='subgrd"+sub_iteration+"_"+id+"'><td><input  type='checkbox' name='chkbox[]' id='chkbox"+sub_iteration+"_"+id+"'  value='"+sub_iteration+"' /><input type='hidden' id='comp_def_level_ind_id"+sub_iteration+"' name='comp_def_level_ind_id["+id+"][]' value=''></td><td><select  class='form-control m-b' name='comp_def_level_ind_type["+id+"][]' id='comp_def_level_ind_type_"+sub_iteration+"_"+id+"'><option value=''>Select</option>"+ind_ids+"</select></td><td><input type='text' name='comp_def_level_ind_name["+id+"][]' id='comp_def_level_ind_name_"+sub_iteration+"_"+id+"' class='form-control'></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}

function delete_indiactor(id){
	var hiddtab="addgroup"+id;
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('source_table'+id);
	var lastRow = tbl.rows.length;
	
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chkbox"+bb+"_"+id;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd"+bb+"_"+id;
			//alert(b);
			var ind_id=document.getElementById("comp_def_level_ind_id"+b+"").value;
			if(ind_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_indicator",
					global: false,
					type: "POST",
					data: ({val : ind_id}),
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
		}
	}
	if(flag==0){
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById(hiddtab).value=arr1;
}

function open_method(id){
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
			document.getElementById('sub_assessment_'+id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/change_ass_sub?id="+id,true);
	xmlhttp.send();	
}

function open_migration_maps(id){
	var hiddtab="addgroup_migration"+id;
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
			var migration_others=document.getElementById('comp_def_level_migrate_oth_'+i+'_'+id).value;
			if(migration_others==''){
				toastr.error("Please select source type.");
				return false;
			}
		}	
		sub_iteration=parseInt(temp)+1; 
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
    
	$("#table_migration_map"+id).append("<tr id='subgrd_migration"+sub_iteration+"_"+id+"'><td><input  type='checkbox' name='chkbox_migration[]' id='chkbox_migration"+sub_iteration+"_"+id+"'  value='"+sub_iteration+"' /><input type='hidden' id='comp_def_level_migrate_id"+sub_iteration+"' name='comp_def_level_migrate_ids["+id+"][]' value=''></td><td><input type='text' name='comp_def_level_migrate_oth["+id+"][]' id='comp_def_level_migrate_oth_"+sub_iteration+"_"+id+"' class='form-control'></td></tr>");
	if(document.getElementById(hiddtab).value!=''){
		var ins=document.getElementById(hiddtab).value;
		document.getElementById(hiddtab).value=ins+","+sub_iteration;
	}
	else{
		document.getElementById(hiddtab).value=sub_iteration;
	}
}

function delete_migration_maps(id){
	var hiddtab="addgroup_migration"+id;
	var ins=document.getElementById(hiddtab).value;
	var arr1=ins.split(",");
	var flag=0;
	var tbl = document.getElementById('table_migration_map'+id);
	var lastRow = tbl.rows.length;
	
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="chkbox_migration"+bb+"_"+id;
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="subgrd_migration"+bb+"_"+id;
			//alert(b);
			var check_id=document.getElementById("chkbox_migration"+bb+"_"+id).value;
			var migration_id=document.getElementById("comp_def_level_migrate_id"+bb+"").value;
			if(migration_id!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_migration_map",
					global: false,
					type: "POST",
					data: ({val : migration_id,val1 : check_id}),
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
		}
	}
	if(flag==0){
		toastr.error("Please select the Value to Delete");
		return false;
	}
	document.getElementById(hiddtab).value=arr1;
}

function open_intray_indiator(qus_id,level_id,comp_id){
	document.getElementById("txtHint_indicator"+level_id).innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint_indicator"+level_id).innerHTML = this.responseText;
			$('#intray_val').validationEngine();
			
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/insert_question_indicator?qus_id="+qus_id+"&level_id="+level_id+"&comp_id="+comp_id, true);
	xmlhttp.send();
}

function open_element(level_id,comp_id,id=""){
	document.getElementById("txtHint_element"+level_id).innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint_element"+level_id).innerHTML = this.responseText;
			$('#element_val').validationEngine();
			
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/element_details?level_id="+level_id+"&comp_id="+comp_id+"&id=" + id, true);
	xmlhttp.send();
}

function open_element_edit(level_id,comp_id,id){
	
	document.getElementById("txtHint_element"+level_id+"_"+id).innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint_element"+level_id+"_"+id).innerHTML = this.responseText;
			$('#element_val').validationEngine();
			
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/element_details?level_id="+level_id+"&comp_id="+comp_id+"&id=" + id, true);
	xmlhttp.send();
}

function open_interview_edit(level_id,comp_id,id){
	
	document.getElementById("txtHint_interview"+level_id+"_"+id).innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint_interview"+level_id+"_"+id).innerHTML = this.responseText;
			$('#interview_val').validationEngine();
			
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/interview_question_details?level_id="+level_id+"&comp_id="+comp_id+"&id=" + id, true);
	xmlhttp.send();
}

function open_interview(level_id,comp_id,id=""){
	document.getElementById("txtHint_interview"+level_id).innerHTML ="";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("txtHint_interview"+level_id).innerHTML = this.responseText;
			$('#interview_val').validationEngine();
			
		}
	};
	xmlhttp.open("GET", BASE_URL+"/admin/interview_question_details?level_id="+level_id+"&comp_id="+comp_id+"&id=" + id, true);
	xmlhttp.send();
}


function addcompetencyposition(){
    var table = document.getElementById('competencyposTab');
    var rowCount = table.rows.length;
	var dd="addgroup_position";
	var s=document.getElementById(dd).value;
	//toastr.error(s);
	if(s!=''){ 
		s=s.split(",");
		// toastr.error(s.length);
		for(var i=0;i<s.length;i++){var b=s[i];
			var comp_qtype=document.getElementById('comp_qtype_'+b).value;
			var comp_question_name=document.getElementById('comp_question_name_'+b).value;
			var comp_question_answer=document.getElementById('comp_question_answer_'+b).value;
			if(comp_qtype==''){
				toastr.error("Please select Question type.");
				return false;
			}
			if(comp_question_name==''){
				toastr.error("Please enter question.");
				return false;
			}
			if(comp_question_answer==''){
				toastr.error("Please enter question answer.");
				return false;
			}
            
			for(var j=0;j<s.length;j++){
				var bb=s[j];
				if(j!=i){
					var comp_question_name1=document.getElementById('comp_question_name_'+bb).value;
					if(comp_question_name1==comp_question_name){
						toastr.error("Question should be Unique.");
						document.getElementById('comp_question_name_'+bb).value='';
						document.getElementById('comp_question_name_'+bb).focus();
						return false;
					}
                }
            }
        }
    }
	var temp2=0;	
	var employeecount=document.getElementById(dd).value;
	employeecount=employeecount.split(",");
	var asdf=employeecount.length-1;
	for(var k=0; k<employeecount.length; k++){	
		if(parseInt(temp2)<parseInt(employeecount[k])){
			temp2=employeecount[k];
		}
	}
	var p=parseInt(temp2)+1;
	if(document.getElementById(dd).value==""){
		employeecount=1;
		p=1;
	}
	else{employeecount.push(p);}
	document.getElementById(dd).value=employeecount;
	// var rowcou=parseInt(iteration)+1;
	// To fetch method type option from .php page
	if(qtypename!=''){
        var expt=qtypename.split(',');
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
	
	
	
	
	var row = table.insertRow(rowCount);
	var cell1 = row.insertCell(0);
	cell1.style.valign="middle";
	//cell1.style.textAlign="center";
	cell1.innerHTML="<div style='padding-left:18px;'><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' /><input type='hidden' id='comp_int_qid_"+p+"' name='comp_int_qid[]' value=''></div>";
	var cell2 = row.insertCell(1);
	cell2.style.valign="middle";
	cell2.style.textAlign="center";
	cell2.innerHTML="<select name='comp_qtype[]' id='comp_qtype_"+p+"' style='width:100%;' class='form-control m-b'><option value=''>Select</option>"+item_type+"</select>";
	var cell3 = row.insertCell(2);
	cell3.style.valign="middle";
	//cell2.style.textAlign="center";
	cell3.innerHTML="<textarea rows='4' class='form-control' name='comp_question_name[]' id='comp_question_name_"+p+"'></textarea>  ";
	
	var cell4=row.insertCell(3);
	cell4.style.valign="middle";
	//cell3.style.textAlign="center";
	cell4.innerHTML="<textarea rows='4' class='form-control validate[required]' name='comp_question_answer[]' id='comp_question_answer_"+p+"'></textarea>   ";
	
}

function deletecompetencyposition(){
	var table = document.getElementById('competencyposTab');
	var s=document.getElementById("addgroup_position").value;
	var spli=s.split(",");
	var flag=0; //toastr.error(spli);
	var len=spli.length;
	// toastr.error(len);
	for(var m=len;m >0; m--){
		var kk=m-1;
		//  toastr.error(m);
		var fd=spli[kk]
		//  toastr.error(fd);
		var ddd="chkbox_"+fd;
		// toastr.error(ddd);
		//alert(ddd);
		if(document.getElementById(ddd).checked==true){
			flag++;
		}
	}
	if(flag>0){
		// toastr.error(len);
		var jinit=parseInt(len);
		// toastr.error(jinit);
		for(var j=jinit; j>0; j--){
			var k=j-1;
			var dd="chkbox_"+spli[k];
			//toastr.error(dd);
			if(document.getElementById(dd).checked==true){ // toastr.error(j);
				var cc=document.getElementById(dd).value; 
				// toastr.error(cc);
				if(cc!==""){
					$.ajax({      //  toastr.error(gid);
						url: BASE_URL+"/admin/deleteteinterviewcompetencylevels",
						global: false,
						type: "POST",
						data: ({id : cc}),
						dataType: "html",
						async:false,
						success: function(msg){         // toastr.error(msg);
						}
					}).responseText;
				}
				var hh=j-1;
				spli.splice(hh,1);
				table.deleteRow(j);
				len=spli.length;
				// toastr.error(len);
				// break;
			}
		}
	}
	else if(flag==0){
		toastr.error("Please select the record");
		return false;
	}
	//  toastr.error(spli);
	document.getElementById("addgroup_position").value=spli;
}



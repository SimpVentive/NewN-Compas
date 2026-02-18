$(document).ready(function(){
	$('#sec_profile').validationEngine();
});
function secure_type(){
	var pid=document.getElementById('parent_org_id').value;
	if(pid==''){
		toastr.error("Please Select Parent Organization ");
		$('#sec_type').val('');
		return false;
	}else{
		var typ=$('#sec_type').val();
		if(typ=='no' || typ==''){
			$('#secorg').css('display','none');
			document.getElementById('hier_name').innerHTML='';
			document.getElementById('top_org').innerHTML='';
			document.getElementById('orgname[0]').innerHTML='';
		}else{
			$('#secorg').css('display','block');
			$.ajax({
				type: "GET",
				url: BASE_URL+"/admin/fetch_hierarchies?orgid="+pid,
				success: function(data){
					var resp=data.split('#@');
					document.getElementById('hier_name').innerHTML=resp[0];
					document.getElementById('top_org').innerHTML=resp[1];
					document.getElementById('orgname[0]').innerHTML=resp[1];
				}
			});
		}
	}	
}
function orgtypes(key){
	var oid=document.getElementById('orgname['+key+']').value;
	if(oid!=''){
		$.ajax({
			type: "GET",
			url: BASE_URL+"/admin/org_type?orgid="+oid,
			success: function(data){
				document.getElementById('orgtype['+key+']').innerHTML=data;
			}
		});
	}else{
		document.getElementById('orgtype['+key+']').innerHTML='';
	}
}
function AddOrgs(){
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
			var item_type=document.getElementById('orgname['+i+']').value;
			if(item_type==''){
				toastr.error("Please select organization");
				return false;
			}else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('orgname['+l+']').value;
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Organization already selected");
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
	// To fetch Expenses Status from .php page
    /* if(secure_orgs!=''){
        var expst=secure_orgs.split(',');
        var orgname='';
        for(var i=0;i<expst.length;i++){
            expst1=expst[i];
            expst2=expst1.split('*');
            if(orgname==''){
                orgname="<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }else{
                orgname=orgname+"<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }
        }
    }else{
        orgname='';
    } 
	var orgname=$("#orgname["+sub_iteration+"]").html();
	alert(orgname);*/
	var pid=document.getElementById('parent_org_id').value;
	$.ajax({
		type: "GET",
		url: BASE_URL+"/admin/fetch_hierarchies?orgid="+pid,
		success: function(data){
			var resp=data.split('#@');
			$("#org_details").append("<tr id='orgs"+sub_iteration+"'><td style='padding-left:20px;' class='hidden-480'><input type='hidden' name='secure_org_id[]' id='secure_org_id["+sub_iteration+"]' value=''><input type='checkbox' name='orgs_chk[]' id='orgs_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><select class='form-control m-b' style='width:50%;' name='orgname[]' id='orgname["+sub_iteration+"]' onchange='orgtypes("+sub_iteration+")'>"+resp[1]+"</select></td><td><div id='orgtype["+sub_iteration+"]'></div></td></tr>");
			if(document.getElementById(hiddtab).value!=''){
				var ins=document.getElementById(hiddtab).value;
				document.getElementById(hiddtab).value=ins+","+sub_iteration;
			}
			else{
				document.getElementById(hiddtab).value=sub_iteration;
			}
		}
	});
	
}
function DelOrgs(){
	var ins=document.getElementById('exp_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="orgs_chk_"+bb+"";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="orgs"+b+"";
			var secorgid=document.getElementById("secure_org_id["+b+"]").value;
			if(secorgid!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_secure_org",
					global: false,
					type: "POST",
					data: ({val : secorgid}),
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
	document.getElementById('exp_hidden_id').value=arr1;
}
function getLocations(){
	var pid=document.getElementById('parent_org_id').value;
	if(pid==''){
		toastr.error("Please Select Parent Organization ");
		$('#sec_type').val('');
		return false;
	}else{		
		$.ajax({
			type: "GET",
			url: BASE_URL+"/admin/fetch_locations?porg_id="+pid,
			success: function(data){
				document.getElementById('location[0]').innerHTML=data;
			}
		});
	}
}
function AddLocs(){
	var hiddtab="loc_hidden_id";
	var ins='';
	if(document.getElementById(hiddtab)){
	var ins=document.getElementById(hiddtab).value;
	}
	var pid=document.getElementById('parent_org_id').value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		for( var j=0;j<ins1.length;j++){
			if(parseInt(ins1[j])>parseInt(temp)){
				temp=parseInt(ins1[j]);
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var item_type=document.getElementById('location['+i+']').value;
			if(item_type==''){
				toastr.error("Please select location");
				return false;
			}else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('location['+l+']').value;
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Location already selected");
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
	// To fetch Expenses Status from .php page
    /* if(secure_locs!=''){
        var expst=secure_orgs.split(',');
        var locname='';
        for(var i=0;i<expst.length;i++){
            expst1=expst[i];
            expst2=expst1.split('*');
            if(locname==''){
                locname="<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }else{
                locname=locname+"<option value='"+expst2[0]+"'>"+expst2[1]+"</option>";
            }
        }
    }else{
        locname='';
    } */
	$.ajax({
		type: "GET",
		url: BASE_URL+"/admin/fetch_locations?porg_id="+pid,
		success: function(data){
			$("#loc_details").append("<tr id='locs"+sub_iteration+"'><td style='padding-left:20px;' class='hidden-480'><input type='hidden' name='secure_location_id[]' id='secure_location_id["+sub_iteration+"]' value=''><input type='checkbox' name='locs_chk[]' id='locs_chk_"+sub_iteration+"' value='"+sub_iteration+"' /></td><td><select class='form-control m-b' style='width:50%;' name='location[]' id='location["+sub_iteration+"]' >"+data+"</select></td></tr>");
			if(document.getElementById(hiddtab).value!=''){
				var ins=document.getElementById(hiddtab).value;
				document.getElementById(hiddtab).value=ins+","+sub_iteration;
			}
			else{
				document.getElementById(hiddtab).value=sub_iteration;
			}
		}
	});	
}
function DelLocs(){
	var ins=document.getElementById('loc_hidden_id').value;
	var arr1=ins.split(",");
	var flag=0;
	for(var i=(arr1.length-1); i>=0; i--){
		var bb=arr1[i];
		var a="locs_chk_"+bb+"";
		if(document.getElementById(a).checked){
			var b=document.getElementById(a).value;
			var c="locs"+b+"";
			var seclocid=document.getElementById("secure_location_id["+b+"]").value;
			if(seclocid!=' '){
				$.ajax({
					url: BASE_URL+"/admin/delete_secure_location",
					global: false,
					type: "POST",
					data: ({val : seclocid}),
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
	document.getElementById('loc_hidden_id').value=arr1;
}
function org_validate(){
	var hier=$('#hier_name').val();
	var top_org=$('#top_org').val();
	if(hier!=''){
		$('#man_org').css('display','block');
		if(top_org==''){
			toastr.error("Please select top organization for the hierarchy");
			return false;
		}
	}else{
		$('#man_org').css('display','none');
		if(top_org!=''){
			toastr.error("Top Organization can not be selected without Hierarchy");
			return false;
		}
	}
	var hiddtab="exp_hidden_id";
	var ins=document.getElementById(hiddtab).value;
	if(ins!=''){
		var ins1=ins.split(",");
		var temp=0;
		if(ins1.length>1){
		for( var j=0;j<ins1.length;j++){
			if(ins1[j]>temp){
				temp=ins1[j];
			}
		}
		var maxa=Math.max(ins1);
		sub_iteration=parseInt(temp)+1;
		for( var j=0;j<ins1.length;j++){
			var i=ins1[j]; 
			var item_type=document.getElementById('orgname['+i+']').value;
			if(item_type==''){
				toastr.error("Please select organization");
				return false;
			}else{
				for( var k=0;k<ins1.length;k++){
					l=ins1[k];
					var item_type2=document.getElementById('orgname['+l+']').value;
					if(k!=j){
						if(item_type==item_type2){
							toastr.error("Organization already selected");
							return false;
						}
					}
				}
			}
		}	
		sub_iteration=parseInt(temp)+1; 
		}
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}	
	
}

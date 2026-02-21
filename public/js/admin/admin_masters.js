$(document).ready(function(){
    $('#lms_masters').validationEngine();
	$('#datepicker_start').datepicker({
	format: 'dd-mm-yyyy',
	orientation: "top",
	autoclose: true,
	todayHighlight: true});
	$('#datepicker_end').datepicker({
	format: 'dd-mm-yyyy',
	orientation: "top",
	autoclose: true,
	todayHighlight: true});
});
function Create_new(funct){
	window.location=BASE_URL+"/admin/"+funct;
}
function validate_masters(){
    var tbl = document.getElementById("material_upload");
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
            var chars=/^[-a-zA-Z0-9_ ]+$/i;
            var code1="code["+i+"]";
            var code=document.getElementById(code1).value;
            if(code!=''){
                for( var k=0;k<ins1.length;k++){
                    l=ins1[k];
                    n=i+1;
                    var code2='code['+l+']';
                    if(k!=j){
                        var ss1=document.getElementById(code1).value;
                        var ss3=ss1.toUpperCase();
                        var ss2=document.getElementById(code2).value;
                        var ss4=ss2.toUpperCase();
                        if(ss3.trim()==ss4.trim()){
                            alertify.alert("Code '"+ss2+"' Already Exists");
                            return false;
                        }
                    }
                }    
            }
            var stdate=document.getElementById('stdate'+i+'').value;
            var enddate=document.getElementById('enddate'+i+'').value;
            if(stdate==''){
                if(enddate!=''){
                    toastr.error("You can not give end date with out giving start date");
                    return false;
                }
            }
        }
    }
}
function AddMore(){
    var tbl = document.getElementById("material_upload");
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
            var chars=/^[-a-zA-Z0-9_ ]+$/i;
            var code1="code["+i+"]";
            var code=document.getElementById(code1).value;
            if(code==''){
                toastr.error("Please Add Value Code");
				document.getElementById(code1).focus();
                return false;
            }
            else {
                if(chars.test(document.getElementById('code['+i+']').value)==false){
                toastr.error("Only Alpha Numerics are Allowed for Code");
                return false;
            }
            else{
                for( var k=0;k<ins1.length;k++){
                    l=ins1[k];
                    var code2='code['+l+']';
                    if(k!=j){
                        var ss1=document.getElementById(code1).value;
                        var ss3=ss1.toUpperCase();
                        var ss2=document.getElementById(code2).value;
                        var ss4=ss2.toUpperCase();
                        if(ss3.trim()==ss4.trim()){
                            toastr.error("Code '"+ss2+"' Already Exists");
							document.getElementById(code2).value='';
							document.getElementById(code2).focus();
                            return false;
                        }
                    }
                }
            }
        }
        var stdate=document.getElementById('stdate'+i+'').value;
        var enddate=document.getElementById('enddate'+i+'').value;
        if(stdate==''){
            if(enddate!=''){
                toastr.error("You can not give end date with out giving start date");
				document.getElementById('enddate'+i+'').value='';
				document.getElementById('stdate'+i+'').focus();
                return false;
            }
        }
    }
}
else{
    sub_iteration=1;
    ins1=1;
    var ins1=Array(1);
}
$("#material_upload").append("<tr id='innertable"+sub_iteration+"'><td align='center' style='padding-left:10px; width:40px;'><input type='checkbox' name='select_chk[]' id='select_chk["+sub_iteration+"]' value='"+sub_iteration+"' /></td><td style='width:52px;'><input type='hidden' name='value_id[]' id='value_id["+sub_iteration+"]' value=''><input type='text' class='validate[required,minSize[1],maxSize[30], custom[alphanumericSp]] form-control' name='code[]' id='code["+sub_iteration+"]' value='' maxlength='30' size='10px' style='width:90%;'/></td><td style='width:155px;'><input type='text' class='validate[required,minSize[2],maxSize[80], custom[alphanumericSp]] form-control' name='value[]' id='value["+sub_iteration+"]' value='' size='50px' style='width:95%;' /></td><td style='width:55px;'><div class='input-group date' id='datepicker_start'><input type='text' class='validate[custom[date2]] form-control' name='stdate[]' id='stdate"+sub_iteration+"' value='' size='17px' style='width:100%;' onfocus='date_funct(this.id)' /><span class='input-group-addon'><span class='fa fa-calendar'></span></span></div></td><td style='width:55px;'><div class='input-group date' id='datepicker_start'><input type='text' class='validate[custom[date2],future[#stdate"+sub_iteration+"]] form-control' name='enddate[]' id='enddate"+sub_iteration+"' value='' size='16px' style='width:100%;' onfocus='date_funct(this.id)'/><span class='input-group-addon'><span class='fa fa-calendar'></span></span></div><input type='hidden' id='hide_values["+sub_iteration+"]' name='hide_values[]' value='' /></td></tr>");
$('#stdate'+sub_iteration).datepicker({
	format: 'dd-mm-yyyy',
	orientation: "top",
	autoclose: true,
	todayHighlight: true});
$('#enddate'+sub_iteration).datepicker({
	format: 'dd-mm-yyyy',
	orientation: "top",
	autoclose: true,
	todayHighlight: true});
document.getElementById("code["+sub_iteration+"]").focus();

   if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
}
function Material_Delete(){
    var ins=document.getElementById('inner_hidden_id').value;
    var arr1=ins.split(",");
    var flag=0;
    var tbl = document.getElementById('material_upload');
    var lastRow = tbl.rows.length;
    for(var i=(arr1.length-1); i>=0; i--){
        var bb=arr1[i];
        var a="select_chk["+bb+"]";
        if(document.getElementById(a).checked){
            var b=document.getElementById(a).value;
            var c="innertable"+b+"";
            var code=document.getElementById("code["+b+"]").value;
            if(code!=""){
                $.ajax({
                    url: BASE_URL+"/admin/deletemastervalue",
                    global: false,
                    type: "POST",
                    data: ({val : code}),
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
    document.getElementById('inner_hidden_id').value=arr1;
    
}
function change_masters(funct,id,hash){
    window.location=BASE_URL+"/admin/"+funct+"?master_id="+id+"&hash="+hash;
}
function Cancel_data(){
    window.location=BASE_URL+"/admin/master_home";
}
$(document).ready(function(){
    $('#lms_masters').validationEngine();
	$('.datepicker').datepicker({ dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true });
});
function Create_new(funct){
	window.location=BASE_URL+"/admin/"+funct;
}
function validate_masters(){
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
            var code1="scale_code["+i+"]";
            var code=document.getElementById(code1).value;
            if(code!=''){
                for( var k=0;k<ins1.length;k++){
                    l=ins1[k];
                    n=i+1;
                    var code2='scale_code['+l+']';
                    if(k!=j){
                        var ss1=document.getElementById(code1).value;
                        var ss3=ss1.toUpperCase();
                        var ss2=document.getElementById(code2).value;
                        var ss4=ss2.toUpperCase();
                        if(ss3.trim()==ss4.trim()){
                            alertify.alert("Scale Code '"+ss2+"' Already Exists");
                            return false;
                        }
                    }
                }    
            }            
        }
    }
}
function AddMore(){
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
            var code1="scale_code["+i+"]";
			var code2="scale_value["+i+"]";
            var code=document.getElementById(code1).value;
            if(code==''){
                alertify.alert("Please Add Scale Code");
				document.getElementById(code1).focus();
                return false;
            } 
			var value=document.getElementById(code2).value;
            if(value==''){
                alertify.alert("Please Add Scale Value");
				document.getElementById(code1).focus();
                return false;
            } 
		}
	}
	else{
		sub_iteration=1;
		ins1=1;
		var ins1=Array(1);
	}
	$("#scale_detail").append("<tr id='innertable"+sub_iteration+"'><td align='center' style='padding-left:10px;'><input type='checkbox' name='select_chk[]' id='select_chk["+sub_iteration+"]' value='"+sub_iteration+"' /></td><td><input type='hidden' name='scale_value_id[]' id='scale_value_id["+sub_iteration+"]' value=''><input type='text' class='validate[required,minSize[1],maxSize[30], custom[alphanumericSp]] mediumtext' name='scale_code[]' id='scale_code["+sub_iteration+"]' value='' maxlength='30' size='10px' style='width:90%;'/></td><td><input type='text' class='validate[required,minSize[2],maxSize[80], custom[alphanumericSp]] mediumtext' name='scale_value[]' id='scale_value["+sub_iteration+"]' value='' size='50px' style='width:50%;' /></td></tr>");

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
    for(var i=(arr1.length-1); i>=0; i--){
        var bb=arr1[i];
        var a="select_chk["+bb+"]";
        if(document.getElementById(a).checked){
            var b=document.getElementById(a).value;
            var c="innertable"+b+"";
            var code=document.getElementById("scale_code["+b+"]").value;
            if(code!=""){
                $.ajax({
                    url: BASE_URL+"/admin/deletescalevalue",
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
        alertify.alert("Please select the Value to Delete");
        return false;
    }
    document.getElementById('inner_hidden_id').value=arr1;
    
}
function change_masters(funct,id,hash){
    window.location=BASE_URL+"/admin/"+funct+"?master_id="+id+"&hash="+hash;
}
function Cancel_data(){
    window.location=BASE_URL+"/admin/ratingscale_search";
}
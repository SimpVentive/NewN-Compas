jQuery(document).ready(function(){
	jQuery("#org_master").validationEngine();
	
	
});
jQuery(document).ready(function(){
	jQuery("#org_master2").validationEngine();
	
	
});
jQuery(document).ready(function(){
	jQuery("#org_master1").validationEngine();
	
	
});
$(document).ready(function(){
    var dates = $( "#start_date, #end_date" ).datepicker({
        dateFormat:"dd-mm-yy",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
        buttonImageOnly: true,
        onSelect: function( selectedDate ) { 
            var option = this.id == "start_date" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
            instance.settings.dateFormat ||
            $.datepicker._defaults.dateFormat,
            selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
});

$(document).ready(function(){
    var dates = $( "#stdate_edit, #enddate_edit" ).datepicker({
        dateFormat:"dd-mm-yy",
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        minDate:"<?php //echo date('d-m-Y');?>",
        /*maxDate:"<?php //echo $futureDate;?>",*/
        showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
        buttonImageOnly: true,
        onSelect: function( selectedDate ) { 
            var option = this.id == "stdate_edit" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
            instance.settings.dateFormat ||
            $.datepicker._defaults.dateFormat,
            selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });

});

$(document).ready(function(){
    var dates = $( "#stdate1, #enddate1" ).datepicker({
        dateFormat:"dd-mm-yy",
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        minDate:"<?php //echo date('d-m-Y');?>",
        /*maxDate:"<?php //echo $futureDate;?>",*/
        showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
        buttonImageOnly: true,
        onSelect: function( selectedDate ) { 
            var option = this.id == "stdate1" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(
            instance.settings.dateFormat ||
            $.datepicker._defaults.dateFormat,
            selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
});

function back_edit(){
    window.location=BASE_URL+"/admin/competency_search";
}

function mandatory(){
    var table = document.getElementById('tablelen');
    var rowCount = table.rows.length;
    for(var i=1;i<rowCount;i++){
        var txt1="#level_code_"+i;
        var txt2="#level_name_"+i;
        var txt3="#comp_"+i;
        var val1=$(txt1).val();
        var val2=$(txt2).val();
        var val3=$(txt3).val();
        val1=$.trim(val1);
        val2=$.trim(val2);
        val3=$.trim(val3);
        //alertify.alert(i+" "+val1+" "+val2+" "+val3);
        if(val1!='' || val2!=''){
            var xx=$("#codevalue").val();
            var yy=$("#namevalue").val();
            xx=$.trim(xx);
            yy=$.trim(yy);
            if(xx=="" && yy==""){
                document.getElementById('codevalue').value=val1;
                document.getElementById('namevalue').value=val2;
            }
            else{
                var str1=document.getElementById('namevalue').value;
                var res1 = str1.split(",");
                var str=document.getElementById('codevalue').value;
                var res = str.split(",");
                for(var j=0;j<rowCount;j++){
                    if((res[j]==val1 && res[j]!="") || (val1=="" && val2!="")){
                        alertify.alert('Please Check The Level Code,It Should be Unique');
                        document.getElementById('codevalue').value='';
                        document.getElementById('namevalue').value='';
                        val1='';
                        return false;
                    }
                    if((res1[j]==val2 && res1[j]!="") || (val1!="" && val2=="")){
                        alertify.alert('Please Check The Level Name,It Should be Unique');
                        document.getElementById('codevalue').value='';
                        document.getElementById('namevalue').value='';
                        return false;
                    }
                }
                document.getElementById('codevalue').value=document.getElementById('codevalue').value+','+val1;
                document.getElementById('namevalue').value=document.getElementById('namevalue').value+','+val2;
            }
        }
        else if(val3!='' && (val1=='' || val2=='')){
            //alertify.alert(val3);
            if(val1==''){
                alertify.alert("Please Enter Level Code");
            }
            if(val2==''){
                alertify.alert("Please Enter Level Name");
            }
            document.getElementById('codevalue').value='';
            document.getElementById('namevalue').value='';
            return false;
        }
    }
    document.getElementById('codevalue').value='';
    document.getElementById('namevalue').value='';
}

function checkHELLO(field, rules, i, options){
        if (field.val() != "HELLO") {
                // this allows to use i18 for the error msgs
                return options.allrules.validate2fields.alertText;
        }
}
                
function checkLevelcode(field, rules, i, options){
    var table = document.getElementById('tablelen');
    var rowCount = table.rows.length;
    for(var i=1;i<rowCount;i++){
        var txt1="#level_value_"+i;
        var txt2="#level_name_"+i;
        var txt3="#comp_"+i;
        var val1=$(txt1).val();
        var val2=$(txt2).val();
        var val3=$(txt3).val();
        val1=$.trim(val1);
        val2=$.trim(val2);
        val3=$.trim(val3);
        if(val1!='' || val2!=''){
            var xx=$("#codevalue").val();
            var yy=$("#namevalue").val();
            xx=$.trim(xx);
            yy=$.trim(yy);
            if(xx=="" && yy==""){
                document.getElementById('codevalue').value=val1;
                document.getElementById('namevalue').value=val2;
            }
            else{
                var str1=document.getElementById('namevalue').value;
                var res1 = str1.split(",");
                var str=document.getElementById('codevalue').value;
                var res = str.split(",");
                for(var j=0;j<rowCount;j++){
                    if((res[j]==val1 && res[j]!="") || (val1=="" && val2!="")){
                        //alertify.alert('Please Check The Level Code,It Should be Unique');
                        document.getElementById('codevalue').value='';
                        document.getElementById('namevalue').value='';
                        val1='';
                        return options.allrules.checklevelcodeunique.alertText;
                    }
                }
                document.getElementById('codevalue').value=document.getElementById('codevalue').value+','+val1;
                document.getElementById('namevalue').value=document.getElementById('namevalue').value+','+val2;
            }
        }
    }
    document.getElementById('codevalue').value='';
    document.getElementById('namevalue').value='';
}

function checkLevelname(field, rules, i, options){
    var table = document.getElementById('tablelen');
    var rowCount = table.rows.length;
    for(var i=1;i<rowCount;i++){
        var txt1="#level_value_"+i;
        var txt2="#level_name_"+i;
        var txt3="#comp_"+i;
        var val1=$(txt1).val();
        var val2=$(txt2).val();
        var val3=$(txt3).val();
        val1=$.trim(val1);
        val2=$.trim(val2);
        val3=$.trim(val3);
        if(val1!='' || val2!=''){
            var xx=$("#codevalue").val();
            var yy=$("#namevalue").val();
            xx=$.trim(xx);
            yy=$.trim(yy);
            if(xx=="" && yy==""){
                document.getElementById('codevalue').value=val1;
                document.getElementById('namevalue').value=val2;
            }
            else{
                var str1=document.getElementById('namevalue').value;
                var res1 = str1.split(",");
                var str=document.getElementById('codevalue').value;
                var res = str.split(",");
                for(var j=0;j<rowCount;j++){
                    if((res1[j]==val2 && res1[j]!="") || (val1!="" && val2=="")){                        
                        //alertify.alert('Please Check The Level Name,It Should be Unique');
                        document.getElementById('codevalue').value='';
                        document.getElementById('namevalue').value='';
                        return options.allrules.checklevelnameunique.alertText;
                    }
                }
                document.getElementById('codevalue').value=document.getElementById('codevalue').value+','+val1;
                document.getElementById('namevalue').value=document.getElementById('namevalue').value+','+val2;
            }
        }
    }
    document.getElementById('codevalue').value='';
    document.getElementById('namevalue').value='';
}


function mandatory1(){
    var fromdate=document.getElementById('stdate1').value;
    var todate=document.getElementById('enddate1').value;
    if(document.getElementById('enddate1').value!=''){
        var dt2= fromdate;
        var arrDt2 = dt2.split('/');
        var date2=arrDt2[2] + "/" + arrDt2[1] + "/" + arrDt2[0];
        var dt= todate;
        var arrDt = dt.split('/');
        var date1=arrDt[2] + "/" + arrDt[1] + "/" + arrDt[0];
        if(date2>=date1){
            alertify.alert('End Date should be greater than Start date');
            return false;
        }
        //return false;
    }
    for(i=0;i<=4;i++){
        var txt1="comp_edit_"+i;
        var txt2="level_name_"+i;
        var txt3="level_code_"+i;
        if(document.getElementById(txt1).value!=''){
            if(document.getElementById(txt3).value==''){
                alertify.alert('Please Enter Leval Code');
                return false;
            }
            if(document.getElementById(txt2).value==''){
                alertify.alert('Please Enter Leval Name');
                return false;
            }
        }
    }
}

function mandatory2(){
    for(i=0;i<=4;i++){
        var txt1="comp_edit_"+i;
        var txt2="level_name_"+i;
        var txt3="level_code_"+i;
        if(document.getElementById(txt1).value!=''){
            if(document.getElementById(txt3).value==''){
                alertify.alert('Please Enter Leval Code');
                return false;
            }
            if(document.getElementById(txt2).value==''){
                alertify.alert('Please Enter Leval Name');
                return false;
            }
        }
    }
    
    var fromdate=document.getElementById('stdate_edit').value;
    var todate=document.getElementById('enddate_edit').value;
    if(document.getElementById('enddate_edit').value!=''){
        var dt2= fromdate;
        var arrDt2 = dt2.split('/');
        var date2=arrDt2[2] + "/" + arrDt2[1] + "/" + arrDt2[0];
        var dt= todate;
        var arrDt = dt.split('/');
        var date1=arrDt[2] + "/" + arrDt[1] + "/" + arrDt[0];
        if(date2>=date1){
            alertify.alert('End Date should be greater than Start date');
            return false;
        }
        //return false;
    }
}

function popup_datac(id){
    var vars=id;
    var str=document.getElementById('competency').value;
    var x=document.getElementById("comp_"+id).value;
    document.getElementById("comp_"+id).innerHTML=str;
    //document.getElementById("hid1_"+id).innerHTML=x;
    //alertify.alert(str);
    //popup_data(id);
    $('.lightbox_bg').hide();
    document.getElementById('msg_box33').style.display='none';
}

function popup_data_edit1(id){
    var vars=id;
    var str=document.getElementById('competency1').value;
    var x=document.getElementById("comp_edit_"+id).value;
    document.getElementById("comp_edit_"+id).innerHTML=str;
    $('.lightbox_bg').hide();
    document.getElementById('msg_box33').style.display='none';
}

function popup_data_edit2(id){
    var vars=id;
    var str=document.getElementById('competency2').value;
    var x=document.getElementById("comp_edit_"+id).value;
    document.getElementById("comp_edit_"+id).innerHTML=str;
    $('.lightbox_bg').hide();
    document.getElementById('msg_box33').style.display='none';
}


 function popup_data(id){
    var x=document.getElementById("comp_"+id).value;
    //alertify.alert(x);
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
            //var n=xmlhttp.responseText.split(","); 
           //document.getElementById("listofvalues").innerHTML=n[0];
           //if(n[1]==1){

            document.getElementById('msg_box33').style.display='block';
            document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
            var x=document.getElementById("comp_"+id).value;

            //alertify.alert(x);
            //alertify.alert(xmlhttp.responseText);
            new nicEditor().panelInstance('competency');

            popup_text();
            $('.button').click(function() {
                var data = $('#peter').find('.nicEdit-main').text();
                document.getElementById('comp_'+id).value=data;
            });
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/competency_details_popup?id="+id+"&x="+x,true);
    xmlhttp.send();	
 }

 function popup_data_edit(id){
    var xmlhttp;
     var x=document.getElementById("comp_edit_"+id).value;
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
            //var n=xmlhttp.responseText.split(","); 
            //document.getElementById("listofvalues").innerHTML=n[0];
            //if(n[1]==1){
            document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
            document.getElementById('msg_box33').style.display='block';
            new nicEditor().panelInstance('competency1');
            popup_text();

            $('.button1').click(function() {
                var data = $('#peter1').find('.nicEdit-main').text();
                document.getElementById('comp_edit_'+id).value=data;
            });
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/competency_details_popup_edit?id="+id+"&x="+x,true);
    xmlhttp.send(); 	
}
 
function popup_data_edit_view(id){
    var xmlhttp;
    var x=document.getElementById("comp_edit_"+id).value;
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
            //var n=xmlhttp.responseText.split(","); 
            //document.getElementById("listofvalues").innerHTML=n[0];
            //if(n[1]==1){
            document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
            document.getElementById('msg_box33').style.display='block';
            new nicEditor().panelInstance('competency2');
            popup_text();
            $('.button1').click(function() {
                var data = $('#peter1').find('.nicEdit-main').text();
                document.getElementById('comp_edit_'+id).value=data;
            });
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/competency_details_popup_edit_view?id="+id+"&x="+x,true);
    xmlhttp.send();
 }


function popup_text(){
    $(document).ready(function(){
        var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
        $('#msg_box33').append(lclose);
        var myval = "msg_box33";
        var moniter_wdith = screen.width;
        var moniter_height = screen.height;
        var lightboxinfo_wdith = $("#" + myval).width();	
        var lightboxinfo_height= $("#" + myval).height();
        var remain_wdith =  moniter_wdith - lightboxinfo_wdith;		
        var remain_height =  moniter_height - lightboxinfo_height;		
        var byremain_wdith = remain_wdith/2;
        var byremain_height = remain_height/2;
        var byremain_height2 = byremain_height-10;
        $("#" + myval).css({left:byremain_wdith});
        $("#" + myval).css({top:byremain_height2});
        $('.lightbox_bg').show();
        $("#" + myval+' .lightbox_close_rel').add();
        $("#" + myval).animate({opacity: 1,left: "420px",top: "180px"}, 10);
    });
    $('a.lightbox_close_rel').click(function(){
        var myval2 =$(this).parent().attr('id');
        $("#" + myval2).animate({opacity: 0,top: "-1200px"},0,function(){$('.lightbox_bg').hide()});
    });
}

function cretae_new(){
    window.location=BASE_URL+"/admin/competency";
}
jQuery(document).ready(function(){
	jQuery("#calender_edit").validationEngine();
	
	
});

 function tab_fun(id,counts,year){
    var fromdate=document.getElementById('from_date').value;
	var todate=document.getElementById('to_date').value;
	fromdate=fromdate.split("-");todate=todate.split("-");
	
	var id=id;
	//alert(id);
	//alert(year);
	var counts=counts;
	for(j=fromdate[2];j<=todate[2];j++){
		for(var i=1;i<=12;i++){ 
			if(i<=9){
				var y="0"+i;
			}
			else{
				var y=i;
			}
			if(y==id && j==year){
			  //alert('link_'+y+'_'+j);
				document.getElementById('link_'+y+'_'+j).style.display='block';
			}
			else{
				//alert('link_'+y+'_'+j);
				if(document.getElementById('link_'+y+'_'+j)){
				document.getElementById('link_'+y+'_'+j).style.display='none';}
			}
		}
	}
	
}


      function validation(id,year){
        var tb2 = document.getElementById('calendar_table_'+id+'_'+year);
            var lastRow1 = tb2.rows.length;
            var lastRow=lastRow1-1;
            //var id=lastRow1+1;
            var temp=0;
            var s=document.getElementById("addusers_"+id+'_'+year).value;
            var spli=s.split(",");
            var len=spli.length;
            for(var i=0; i<len; i++){
                if(Number(temp)<Number(spli[i])){
                    temp=spli[i]; 
                }
            }
            q=Number(temp);
            p=Number(temp)+1;
            if(document.getElementById("addusers_"+id+'_'+year).value==''){
                s=0;
                p=0;
            }
            else{
                spli.push(p);
            } 
            var prg_name=document.getElementById('program_id_'+id+'_'+year+'_'+q).value;            
            if(prg_name==''){ 
                alertify.alert("Please Select Program Name"+id);
                return false;
            }
//            for(var j=0; j<=Number(temp); j++){ 
//                 var prg=document.getElementById('program_name_'+id+'_'+spli[j]).value;
//                 for(var k=0; k<=Number(temp); k++){                   
//                     var prg1=document.getElementById('program_name_'+id+'_'+spli[k]).value;
//                     if(j!=k){
//                     if(prg.trim()===prg1.trim()){
//                         alertify.alert("Please change Program name");
//                         return false;
//                     }
//                     }
//                 }
//             }            
             document.getElementById("addusers_"+id+'_'+year).value=spli; 
         }
    function add_delete(id,year){
	    //alert(year);
        var tab = document.getElementById('calendar_table_'+id+'_'+year);
        var lastRow1 = tab.rows.length;
        var lastRow=lastRow1-1;
        var s=document.getElementById("addusers_"+id+'_'+year).value;
        if(s==0){
            for(var i=1; i<lastRow; i++){
                s=s+','+i;
            }
        }
        document.getElementById("addusers_"+id+'_'+year).value=s;
        var spli=s.split(",");
        flag=0;
        var len=spli.length;
        for(var i=0; i<len; i++){  //alertify.alert(spli[i]);
            var ddd="chk_"+id+"_"+year+"_"+spli[i];
            if(document.getElementById(ddd).checked==true){
                flag++;
            }
        }
        if(flag>0){
            var jinit=Number(len)-1;
            for(var j=jinit; j>=0; j--){
                k=j+1;
                var p=j-2;
                var dd="chk_"+id+"_"+year+"_"+spli[j];
                if(document.getElementById(dd).checked===true){
                    var cc=document.getElementById(dd).value; 
					//alert(cc);
                    if(cc!=""){
                        $.ajax({
                            url: BASE_URL+"/admin/delete_calender",
                            global: false,
                            type: "POST",
                            data: ({val : cc}),
                            dataType: "html",
                            async:false,
                            success: function(msg){
                                
                            }
                        }).responseText;
                    }
                    spli.splice(j,1);
                    tab.deleteRow(j+1);
                    len=spli.length;
                }
            }
        }
        else if(flag==0){
            alertify.alert("Please select Atleast one Checkbox");
            return false;
        }
        document.getElementById("addusers_"+id+'_'+year).value=spli;
    }
    
    function search_calender(){
        window.location=BASE_URL+"/admin/calender_search";
    }
    
//function add_rowempty(id,month_id){
//     // To fetch program details from .php page
//     var program=progm.split(',');
//     var prg='';
//     for(var i=0;i<program.length;i++){     
//         program1=program[i];
//         program2=program1.split('*');
//         if(prg==''){
//         prg="<option value='"+program2[0]+"'>"+program2[1]+"</option>";
//     }
//     else{
//         prg=prg+"<option value='"+program2[0]+"'>"+program2[1]+"</option>";
//     }
//     }
//     
//     // To fetch status details from .php page
//     var status=publis.split(',');
//     var pub='';
//     for(var i=0;i<status.length;i++){     
//         status1=status[i];
//         status2=status1.split('*');
//         if(pub==''){
//         pub="<option value='"+status2[0]+"'>"+status2[1]+"</option>";
//     }
//     else{
//         pub=pub+"<option value='"+status2[0]+"'>"+status2[1]+"</option>";
//     }
//     }
//     
//    var tb2 = document.getElementById('calendar_table_'+id);
//    var lastRow1 = tb2.rows.length;
//    var lastRow=lastRow1-1;
//    //var id=lastRow1+1;
//    var temp=0;
//    var s=document.getElementById("addusers_"+id).value;
//    var spli=s.split(",");
//    var len=spli.length;
//    for(var i=0; i<len; i++){
//        if(Number(temp)<Number(spli[i])){
//            temp=spli[i]; 
//        }
//    }
//    q=Number(temp);
//    p=Number(temp)+1;
//    if(document.getElementById("addusers_"+id).value==''){
//        s=0;
//        p=0;
//    }
//    else{
//        spli.push(p);
//    }
//    var prg_name=document.getElementById('program_id_'+id+'_'+q).value;            
//    if(prg_name==''){
//        alertify.alert("Please Select Program Name"+id);
//        return false;
//    }
//    //            for(var j=0; j<=Number(temp); j++){ 
//    //                 var prg=document.getElementById('program_id_'+id+'_'+spli[j]).value;
//    //                 for(var k=0; k<=Number(temp); k++){                   
//    //                     var prg1=document.getElementById('program_id_'+id+'_'+spli[k]).value;
//    //                     if(j!=k){
//    //                     if(prg.trim()===prg1.trim()){
//    //                         alertify.alert("Please change Program name");
//    //                         return false;
//    //                     }
//    //                     }
//    //                 }
//    //             }
//    var row = tb2.insertRow(lastRow1);
//    var cell1= row.insertCell(0);
//    cell1.innerHTML="<input type='hidden' name='claen_id[]_"+id+"' id='claen_id_"+id+"_"+p+"' value='' ><input type='checkbox' style='width: 46px;' name='chk_"+id+"_"+p+"' id='chk_"+id+"_"+p+"' value=''/>";
//    var cell2= row.insertCell(1);
//    cell2.innerHTML="<select name='program_id_"+id+"[]' id='program_id_"+id+"_"+p+"' class='validate[required] mediumselect'><option value=''>Select</option>"+prg+"</select>";
//    var cell3= row.insertCell(2);
//    cell3.innerHTML="<input type='text' name='location_"+id+"[]' id='location_"+id+"_"+p+"' value='' class='smalltext'>";
//    var cell4= row.insertCell(3);
//    cell4.innerHTML="<input type='text' name='start_date_"+id+"[]' id='start_date_"+id+"_"+p+"' value='' class='smalltext'>";
//    var cell5= row.insertCell(4);
//    cell5.innerHTML="<input type='text' name='end_date_"+id+"[]' id='end_date_"+id+"_"+p+"' value='' class='smalltext'>";
//    var cell6= row.insertCell(5);
//    cell6.innerHTML="<select name='program_visible_"+id+"[]' id='program_visible_"+id+"_"+p+"' class='smallselect'><option value=''>Select</option>"+pub+"</select>";
//    var cell7= row.insertCell(6);
//    cell7.innerHTML="<input type='text' name='faculty_"+id+"[]' id='faculty_"+id+"_"+p+"' value='' class='smalltext'>";
//    document.getElementById("addusers_"+id).value=spli;    
//}
//    function add_row(id,month_id){
//         // To fetch program details from .php page
//     var program=progm.split(',');
//     var prg='';
//     for(var i=0;i<program.length;i++){     
//         program1=program[i];
//         program2=program1.split('*');
//         if(prg==''){
//         prg="<option value='"+program2[0]+"'>"+program2[1]+"</option>";
//     }
//     else{
//         prg=prg+"<option value='"+program2[0]+"'>"+program2[1]+"</option>";
//     }
//     }
//     
//     // To fetch status details from .php page
//     var status=publis.split(',');
//     var pub='';
//     for(var i=0;i<status.length;i++){     
//         status1=status[i];
//         status2=status1.split('*');
//         if(pub==''){
//         pub="<option value='"+status2[0]+"'>"+status2[1]+"</option>";
//     }
//     else{
//         pub=pub+"<option value='"+status2[0]+"'>"+status2[1]+"</option>";
//     }
//     }
//    var tb2 = document.getElementById('calendar_table_'+id);
//     var lastRow = tb2.rows.length;
//     var lastRow1=lastRow-2;
//     var temp=0;
//     var s=0;
//     if(document.getElementById("addusers_"+id).value==0){
//         for(var i=1; i<=lastRow1; i++){
//             s=s+','+i;
//         }
//     document.getElementById("addusers_"+id).value=s;
//     }
//     else{
//         s=document.getElementById("addusers_"+id).value;
//     }
//     var spli=s.split(",");
//     var len=spli.length;
//     for(var i=0; i<len; i++){
//         if(Number(temp)<Number(spli[i])){
//             temp=spli[i]; 
//         }
//     }
//
//     q=Number(temp);
//     p=Number(temp)+1;
//     if(document.getElementById("addusers_"+id).value==''){
//         s=0;
//         p=0;
//     }
//     else{
//        spli.push(p);
//     } 
//     var prg_name=document.getElementById('program_id_'+id+'_'+q).value; 
//     if(prg_name==''){
//         alertify.alert("Please Select Program Name");
//         return false;
//     }
//    //            for(var j=0; j<Number(temp); j++){ 
//    //                 var prg=document.getElementById('program_id_'+id+'_'+spli[j]).value;
//    //                 for(var k=0; k<Number(temp); k++){                   
//    //                     var prg1=document.getElementById('program_id_'+id+'_'+spli[k]).value;
//    //                     if(j!=k){
//    //                     if(prg.trim()===prg1.trim()){
//    //                         alertify.alert("Please change Program name");
//    //                         return false;
//    //                     }
//    //                     }
//    //                 }
//    //             }
//     var row = tb2.insertRow(lastRow);
//     var cell1= row.insertCell(0);
//     cell1.innerHTML="<input type='hidden' name='claen_id_"+id+"[]' id='claen_id_"+id+"_"+p+"' value='' ><input type='checkbox' style='width: 46px;' name='chk_"+p+"' id='chk_"+id+"_"+p+"' value=''/>";
//     var cell2= row.insertCell(1);
//     cell2.innerHTML="<select name='program_id_"+id+"[]' id='program_id_"+id+"_"+p+"' class='validate[required] mediumselect'><option value=''>Select</option>"+prg+"</select>";
//     var cell3= row.insertCell(2);
//     cell3.innerHTML="<input type='text' name='location_"+id+"[]' id='location_"+id+"_"+p+"' value='' class='smalltext'>";
//     var cell4= row.insertCell(3);
//     cell4.innerHTML="<input type='text' name='start_date_"+id+"[]' id='start_date_"+id+"_"+p+"' value='' class='smalltext'>";
//     var cell5= row.insertCell(4);
//     cell5.innerHTML="<input type='text' name='end_date_"+id+"[]' id='end_date_"+id+"_"+p+"' value='' class='smalltext'>";
//     var cell6= row.insertCell(5);
//     cell6.innerHTML="<select name='program_visible_"+id+"[]' id='program_visible_"+id+"_"+p+"' class='smallselect'><option value=''>Select</option>"+pub+"</select>";
//     var cell7= row.insertCell(6);
//     cell7.innerHTML="<input type='text' name='faculty_"+id+"[]' id='faculty_"+id+"_"+p+"' value='' class='smalltext'>";
//     document.getElementById("addusers_"+id).value=spli;    
//}
// 

$(document).ready(function(){
for(var j=0; j<=12; j++){
    if(j<=9){
	    i="0"+j;
	}
	else{
	    i=j;
	}
	var y=document.getElementById('year').value;
    var dates = $( "#start_date_"+i+"_"+y+"_0, #end_date_"+i+"_"+y+"_0" ).datepicker({dateFormat:"dd-mm-yy",
    defaultDate: "+1w",
    changeMonth: true,
    changeYear: true,
    numberOfMonths: 1,
    //minDate:" //date('d-m-Y');",
    /*maxDate:"<?php //echo $futureDate;?>",*/
//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
    //buttonImageOnly: true,
    onSelect: function( selectedDate ) { 
            var option = this.id == "start_date_"+i+"_"+y+"_0" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                                    dates.not( this ).datepicker( "option", option, date );
                                                                            }
                                                            });
                                                            }

});

function add_row(id,month_id,year){
    var tb2 = document.getElementById('calendar_table_'+id+'_'+year);
    var lastRow = tb2.rows.length;
	//alertify.alert("lastrow"+lastRow);
    var lastRow1=lastRow-2;
    var temp=0;
	var temp_j=0;
    var s=0; 
	var r=0;
    var adu=document.getElementById("addusers_"+id+'_'+year).value
    // alertify.alert("adu"+adu);	
	if(adu!=''){
		if(adu==0){
			for(var i=1; i<=lastRow1; i++){
				s=s+','+i;
			} 
		  document.getElementById("addusers_"+id+'_'+year).value=s;
		}
		else{
			s=document.getElementById("addusers_"+id+'_'+year).value;
		}
	
    if(Number(s)!=0){ 
			var spli=s.split(",");
			var len=spli.length; 
				for(var i=0; i<len; i++){
					if(Number(temp)<Number(spli[i])){
						temp=spli[i]; 
					}
				}				
				q=Number(temp);
				p=Number(temp)+1;
				
				for(var j=0; j<len; j++){
					if(Number(temp)<Number(spli[j])){
						temp_j=spli[j]; 
					}
				}
				r=Number(temp_j);
			  if(document.getElementById("addusers_"+id+'_'+year).value==''){
					s=0;
					p=0;
				}
				else{ 
				   spli.push(p);
				}
       }
	  else{
				q=0;
				p=1;
				spli=0;
			}
		//alert('program_id_'+id+'_'+year+'_'+q);
    var prg_name=document.getElementById('program_id_'+id+'_'+year+'_'+q).value; 
	var prg_name2=document.getElementById('program_id_'+id+'_'+year+'_'+r).value; 
    if(prg_name==''){
        alertify.alert("Please Select Program Name");
        return false;
    }
    document.getElementById("addusers_"+id+'_'+year).value=spli;
	} else {
	    document.getElementById("addusers_"+id+'_'+year).value=0;
		p=0;
	
	  }
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
                    $("#calendar_table_"+id+'_'+year).append(xmlhttp.responseText);                   
                }
            }
	xmlhttp.open("GET",BASE_URL+"/admin/add_cal_row?id="+id+"&month_id="+month_id+"&year="+year+"&last_row="+p,true);
	xmlhttp.send(); 
}

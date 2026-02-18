
jQuery(document).ready(function(){
    // toastr.error('hello');
	jQuery("#manageTestForm").validationEngine();
	
});


        
      function getquestionbank(){
          var qid=document.getElementById('qbank').value;
          if(qid===''){
              toastr.error("Please Select Question Bank Name ");
              return false;
          }
		 else {  	$('#search_a').attr('href','#modalquestionbank');
					$('#search_a').attr('data-toggle','modal');
				// document.getElementById('msg_box33').style.display='block';
				var addgrp=document.getElementById('addgroup').value;
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
								document.getElementById("test_questions").innerHTML=xmlhttp.responseText;
								//$(".modal-header").click(function() {$(this).parent().draggable(); });
								$(".modal-header").click(function() {$(this).parent().draggable(); });
								$( ".test_questions" ).draggable( "option", "disabled", true );
						}
				}
				xmlhttp.open("GET",BASE_URL+"/admin/questionbank_questions?id="+qid+"&selquest="+addgrp,true);
				xmlhttp.send(); 
			}
		}

	 
 Array.prototype.remove = function(value) {
      this.splice(this.indexOf(value), 1);
      return true;
   };


function deletefun(){ 
	var tab = document.getElementById('data_emp'); 
        var s=tab.rows.length;
       var tid=document.getElementById('testid').value;
         len=parseInt(s)-1;
		 var bs=0;
		   for(var i=s; i>=1; i--){ 
			   var dd="check1["+i+"]";
			   var chkbox=document.getElementById(dd);
              if(null !== chkbox && true === chkbox.checked) { 
                      bs++;
  						} 
					}
   if(bs>0){
	 var con=window.confirm("Are you sure want to Delete the record.");
	   if(con===true){
             //var   addgroup=document.getElementById('addgroup').value;
			  // toastr.error(addgroup);
                for(var i=s; i>=1; i--){ 
                       var dd="check1["+i+"]";
                       var chkbox=document.getElementById(dd);
                  
                        if(null !== chkbox && true === chkbox.checked) {
							var   addgroup=document.getElementById('addgroup').value;
                                var cc=chkbox.value; 
							   var t_spli=addgroup.split(","); // toastr.error(cc);
                                if(cc!==""){
								//t_spli.remove(cc);
								 
                                $.ajax({                       //  toastr.error(gid);
										url: BASE_URL+"/admin/deletetestquestins",
										global: false,
										type: "POST",
										data: ({id : cc ,tid:tid }),
										dataType: "html",
										async:false,
										success: function(msg){
											if(msg==1){
												t_spli.remove(cc);
												var j=parseInt(i)-1;
												document.getElementById('data_emp').deleteRow(j);
											}else{
												toastr.error(msg);
											}
											//document.getElementById('addgroup').value=t_spli;	
											//location.reload();
										}
                                 }).responseText;
								 //toastr.error(t_spli);
								//var myStr = t_spli.join(','); //toastr.error(myStr);
								document.getElementById('addgroup').value=t_spli;		
                         }
                      
                         /* var j=parseInt(i)-1;
						// toastr.error(j);
				  
                   document.getElementById('data_emp').deleteRow(j); */
				   
							}
					 }  
			   } 
          else {   return false;	}
		  }
		  else {   /* $( "#dialog-confirm-delete1" ).removeClass('hide').dialog({
															resizable: false,
															modal: true,
															buttons: [
																{
																	html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Ok ",
																	"class" : "btn btn-xs",
																	click: function() {
																		$( this ).dialog( "close" );
																	}
																}
																]
															});
											
												return false;  */ toastr.error('Please select Question.');  return false; 
							}
    
    }
	
       function goback(){
           window.location= BASE_URL+"/admin/test_home";
       }
        
       function validation(){
           var table=document.getElementById('inner_data_emp');
           var  len=table.rows.length;
                var che=0;
//               for( var i=1; i<=len; i++){
//                       var ss=document.getElementById('check1['+i+']');
//                  if(ss.checked===true){
//                      che=che+1;
//                  }
//               }
//               if(che===0){
//                   toastr.error("Please select Questions.");
//                   return false;
//               }

       }
        
   function questionsids(ids){
		var emp='';
              //  var selids=document.
             //  toastr.error(ids);
		for(var i=1;i<=ids;i++){
			var checkid=document.getElementById('check['+i+']');
			if(checkid.checked==true){
				var empid=checkid.value;
				if(emp===''){
					emp=empid;
				}
				else{
					emp=emp+","+empid;
				}			
			}
		}
       var ddd=emp.trim();
		if(ddd==''){
					toastr.error("Please Select Questions.");
					 $('#go').attr('data-dismiss','');					
					 return false;
		          }
              //  toastr.error("checked questions"+emp);
                var selques=document.getElementById('addgroup').value;
              //   toastr.error("Selected queseions"+selques);
                if(selques!=''){
                 emp=emp+','+selques;
               }
		 $('#go').attr('data-dismiss','modal');
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
				document.getElementById('buttonsdiv').style.display='block';
				 document.getElementById("serachdata").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET",BASE_URL+"/admin/group_selected_questionslist?qids="+emp,true);
		xmlhttp.send();
    }

   function checkAll(){ 
	var tbl = document.getElementById('inner_data_emp');
	var lastRow = tbl.rows.length;
	alert(lastRow);
	if(lastRow>1){
		for(var i=0; i<=lastRow; i++){
			var row = tbl.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(document.getElementById('maincheck').checked==true){
				if(chkbox.disabled==false){
					chkbox.checked = true ;
				}
			}
			else{
				if(chkbox.disabled==false){
					chkbox.checked = false ;
				}
			}
		}
	}
	//checkvalu();
  }

   
    function getpassscore(){
            var ss=document.getElementById('scoring').value;
     if(ss=='N'){
             // document.getElementById('passper').style.display='none';
              document.getElementById('totalscore').value='0';
             
              document.getElementById('totalscore').disabled="disbled";
            }
            else { 
                    document.getElementById('totalscore').disabled="";
         
            }
        }
   
jQuery(document).ready(function(){
	jQuery("#learnergroupForm").validationEngine();
}); 

 function questcreation(id){
          
      window.location= BASE_URL+"/admin/question_creation?id="+id;    
       
        }
 function updatefun(id){
       window.location=BASE_URL+"/admin/question_update?id="+id;      
            
      }
 
        
        
  function deletefun(){ 
	var tab = document.getElementById('questionTable'); 
       var s=tab.rows.length;
      // alertify.alert(s);
        len=parseInt(s)-1;
       //alertify.alert(len);
	 var con=window.confirm("Are you sure want to Delete the record.");
	   if(con===true){
              
               for(var i=len; i>=1; i--){ 
                      var dd="chk_"+i;
                      var chkbox=document.getElementById(dd);
//                       var chkbox1=document.getElementById(dd).value;
//                       alertify.alert(chkbox1);
                     // alertify.alert(chkbox);
                       // var row = tab.rows[k]; 
                        // alertify.alert(row);
                        
//                        var chkbox = row.cells[0].childNodes[0];
//                            if(chkbox.checked===true){
//                                      alertify.alert("haii");
//                                   } 
                       if(null !== chkbox && true === chkbox.checked) { 
                               var cc=chkbox.value; 
                              // alertify.alert(cc);
                               if(cc!==""){
                               $.ajax({
                                                                //  alertify.alert(gid);
                                    url: BASE_URL+"/admin/deletequestions",
                                    global: false,
                                    type: "POST",
                                    data: ({id : cc }),
                                    dataType: "html",
                                    async:false,
                                    success: function(msg){
                                                                       // alertify.alert(msg);
                                    }
                                }).responseText;
                        }
                       
                       // alertify.alert(i);
                        var j=parseInt(i);
                  document.getElementById('questionTable').deleteRow(j);
                     //  tab.deleteRow(i); 
                      //tab.ro
                          // len=spli.length;
                   }
                 }        
            //  document.getElementById("addgroup").value=spli;
                }
	    else {
	      return false;
		}
   }

jQuery(document).ready(function(){
	
	$('.summernote').summernote({
			height: 230,
			minHeight: null,
			maxHeight: null,
			focus: true,
			callbacks: {
				onImageUpload: function(files, editor, welEditable) {
					for (var i = files.length - 1; i >= 0; i--) {
						sendFile(files[i], this);
					}
				},
			},
			dialogsFade: true,
			fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
			toolbar: [
			/* ['fontname', ['fontname']],
			['fontsize', ['fontsize']], */
			/* ['font', ['style','bold', 'italic', 'underline', 'clear']], */
			/* ['color', ['color']], */
			/* ['para', ['ul', 'ol', 'paragraph']]'fullscreen', ,
			['height', ['height']], 
			['table', ['table']],*/
			['insert', ['picture','link']],
			['view', ['codeview']],
			['misc', ['undo','redo']]
			]
		});
	jQuery("#questionForm").validationEngine({
       //   ignore: ':hidden:not(.summernote),.note-editable.card-block'
	    validateNonVisibleFields: true
	});
	jQuery("#questionvaluesForm").validationEngine();
	
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("class");
    var words = target.split(" ");
	//	$(this).removeClass("btn-success");
	if(target.match(/c1/)) { 
		$('.c1').addClass('btn-success btn-primary');
		if($(this).hasClass( "btn-primary" )){
		$(this).removeClass("btn-success");	
		}
	}
	/*if(words.length>=2){
	if($(e.target).hasClass( "c" )){
		$(e.target).addClass('btn-success');
		
	}
			
	}*/
});
}); 



 function jm_phonemask(t){
			var patt1 = /(\d{3}).*(\d{3}).*(\d{4})/;
			var patt2 = /^\((\d{3})\).(\d{3})-(\d{4})$/;
			var str = t.value;
			var result;
			if (!str.match(patt2)){
			    result = str.match(patt1);
					if (result!= null){
					//toastr.error(result);
					//t.value = t.value.replace(/[^\d]/gi,'');
					//str = '(' + result[1] + ') ' + result[2] + '-' + result[3];
					//t.value = str;
					}
			else{
				if (t.value.match(/[^\d]/gi))
				t.value = t.value.replace(/[^\d]/gi,'');
				}
			}
	}
 

    function deletemultiple_single(){
	var table = document.getElementById('radio4Tab');
	var s=document.getElementById("addgroup_single").value;
    var comp_lang_id=document.getElementById('comp_lang_id').value;
	var question_id=document.getElementById('question_id_l').value;
	var spli=s.split(",");
	var flag=0; //toastr.error(spli);
	var len=spli.length;
	// toastr.error(len);
	for(var m=len;m >0; m--){
		var kk=m-1;
		//  toastr.error(m);
		var fd=spli[kk];
		//  toastr.error(fd);
		var ddd="qar"+fd;
		// toastr.error(ddd);
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
			var dd="qar"+spli[k];
			var ddddd="value_id_"+spli[k];
			//toastr.error(dd);
			if(document.getElementById(dd).checked==true){ // toastr.error(j);
				var cc=document.getElementById(dd).value;
				// toastr.error(cc);
				if(cc!==""){
					if(document.getElementById(ddddd)){
				var question_id=document.getElementById(ddddd).value;
					$.ajax({      
						url: BASE_URL+"/admin/deletete_multi_single",
						global: false,
						type: "POST",
						data: ({id : cc ,qid:question_id}),
						dataType: "html",
						async:false,
						success: function(msg){
						}
					}).responseText;
					}
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
	document.getElementById("addgroup_single").value=spli;
       }

    function deletemultiple_multple(id){
	var table = document.getElementById('radio5Tab');
	var s=document.getElementById("addgroup_multiple").value;
	var spli=s.split(",");
            len=spli.length;
                for(var i=0;i<len; i++){
                   // toastr.error("splice value -"+spli[i]+"row value-"+id);
                    var vs=Number(spli[i]);
                   if(vs===id){
                    spli.splice(i,1);
                  document.getElementById('radio5Tab').deleteRow(i);
                   }
                }
        document.getElementById("addgroup_multiple").value=spli;
       }

   function multiple_multple_choice(){
        table=document.getElementById('radio5Tab');
        len=table.rows.length;
		
		if(Number(len)==Number(5)){ toastr.error("You cannot add more than 5 options."); return false;  }
		
          var dd="addgroup_multiple";
	var s=document.getElementById(dd).value;
        var temp2=0;	
	var employeecount=document.getElementById(dd).value;
	employeecount=employeecount.split(",");
	var asdf=employeecount.length-1;
	for(var k=0; k<employeecount.length; k++){	
		if(parseInt(temp2)<parseInt(employeecount[k])){
			temp2=employeecount[k];
		}
	}
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value===""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
			}
	 document.getElementById(dd).value=employeecount;
        //toastr.error(document.getElementById(dd).value)
       //  toastr.error(len);
         var rowcou=len;
        if(rowcou<Number(5)){
	var row = table.insertRow(rowcou);
	var cell1 = row.insertCell(0);
	   cell1.style.styleFloat = 'right';
       cell1.style.cssFloat = 'right';
			   
	cell1.innerHTML="<input type='checkbox' value='"+p+"' name='chkbox_"+p+"' id='qma"+p+"'><input type='hidden' name='value_id_"+p+"' value='' />Correct Answer";	
	
	var cell2 = row.insertCell(1);
	   $(cell2).addClass("ae_answerDefinition");
	    cell2.innerHTML="<table style='padding-left: 30px;'><tbody><tr style='line-height:60px;'><td>Answer Text <sup><font color='#FF0000' style='height:32px'>*</font></sup>:</td><td><input type='text' name='answer_chk_"+p+"' id='q6a"+p+"' class='ae_answerText mediumtext add_textbox_multipe"+p+"' title='Type your answer text here' value=''></td></tr><tr style='line-height:40px;'><td>Explanation Text:</td><td><input type='text' name='expla_chk_"+p+"'id='q6a"+p+"' class='ae_answerText  mediumtext text-label add_textbox_multipe"+p+"' title='Type your explanation text here' value=''></td></tr></tbody></table>";
	var cell3 = row.insertCell(2);
        cell3.innerHTML="<input id='multiple_single"+p+"' class='btn btn-sm btn-danger' type='button' value='Delete' name='multiple_single' onclick='deletemultiple_multple("+p+")'>";
      $(".add_textbox_multipe"+p).each(function(){
    // toastr.error(this.id);
     this.value = $(this).attr('title');
        $(this).addClass('text-label');
            $(this).focus(function(){
                if(this.value === $(this).attr('title')) {
                    this.value = '';
                    $(this).css('color', '#000');
                }
            });
            $(this).blur(function(){
                if(this.value === '') {
                    this.value = $(this).attr('title');
                }
            });
        });
    } 
    }
    
    function questioncancel(id){           
           window.location= BASE_URL+"/admin/questions?id="+id;
        }
   /* function gettypedata(id){
            var dd=document.getElementById("questtype_"+id).value;
           // toastr.error(dd);
          //  var lab=document.getElementById("label_"+id).innerText;
         var lab=$("#label_"+id).text();
		
          document.getElementById('selectedtype').innerHTML=lab; 
         if(id!==6){
             document.getElementById('pointsTab').style.display="block";
         } 
         else {
          document.getElementById('pointsTab').style.display="none";
         
        }
          for(var i=1;i<7;i++){
              if(i===id){
        document.getElementById('radio'+id).style.display="block";
              if(id===4 || id===5){
       document.getElementById('series').style.display="block";     
              } 
              else {
         document.getElementById('series').style.display="none";      
              }
            }
          else {
         document.getElementById('radio'+i).style.display="none";  
          }
         }
        document.getElementById('question_name').disabled=""; 
        /* document.getElementById('startdate').disabled="";  
        document.getElementById('enddate').disabled="";  
        document.getElementById('pstatus').disabled="";  
        document.getElementById('order').disabled="";  
     } */  
	 
	function gettypedata_new(){
            var eid=document.getElementById("questtype");
			var id1 = eid.options[eid.selectedIndex].value;
			var option_array=id1.split(",");
			var id=option_array[0];
			//alert(id);
			var daytxt = eid.options[eid.selectedIndex].text; 
			
          document.getElementById('selectedtype').innerHTML=daytxt; 
         if(id!=6){
             document.getElementById('pointsTab').style.display="block";
         } 
         else { 
          document.getElementById('pointsTab').style.display="none";
         
        }
          /* for(var i=1;i<7;i++){
              if(i==id){
        document.getElementById('radio'+id).style.display="block";
              if(id==4 || id==5){
       document.getElementById('series').style.display="block";     
              } 
              else {
         document.getElementById('series').style.display="none";      
              }
            }
          else {
         document.getElementById('radio'+i).style.display="none";  
          }
         }
        document.getElementById('question_name').disabled=""; 
        /* document.getElementById('startdate').disabled="";  
        document.getElementById('enddate').disabled="";  
        document.getElementById('pstatus').disabled="";  
        document.getElementById('order').disabled=""; */  
    }
     
     function validation(){
                 //var stdate=document.getElementById('startdate').value;	
                 //var enddate=document.getElementById('enddate').value;	
		 var quest=document.getElementById('question_name').value;	
		 var publish=document.getElementById('pstatus').value;
                 var points=document.getElementById('points').value;
                 var isChecked = jQuery("input[name=questtype]:checked").val();
//                 if($('input[name=questtype]:checked').length<=0)
//                   {
//                    toastr.error("Please select Question type.")
//                     return false;
//                   }
//		 if(quest===''){
//			  toastr.error("please enter Question Text");
//			  return false;
//			  } 
//		 if(stdate===''){
//			  toastr.error("please Enter Start Date");
//			  return false;
//			  }
//               if(publish===''){
//                        toastr.error("Please select Publishing options. "); 
//                          return false;
//                 }
            if(isChecked==='F'){
                  var q=document.getElementById('qa1').value;
                  if(q==='Type your answer text here'){
                   toastr.error("Please enter Answer text.");
                   return false;
                 }
             }
             /*  if(isChecked==='FT'){
                  var q=document.getElementById('freetext').value;
                  if(q===''){
                   toastr.error("Please enter Free text.");
                   return false;
                 }
             } */
             if(isChecked==='B'){
                  var n=document.getElementById('qan1').value;
                   //toastr.error("hellol");
                  if(n==='Type your answer text here'){
                   toastr.error("Please enter Answer text.");
                   return false;
                 }
             } 
            if(isChecked==='T'){
                  var t=document.getElementById('qat1').value;
                  var f=document.getElementById('qat2').value;
                  if(t==='Type your answer text here'){
                   toastr.error("Please enter Answer text.");
                   return false;
                  }
               if(f==='Type your answer text here'){
                   toastr.error("Please enter Answer text.");
                   return false;
                 }
               //  toastr.error("first val"+t+"second val"+f);
                  var aa=t.trim();var bb=f.trim();
                 if((t!=='Type your answer text here') && (aa===bb)) {
                     toastr.error("Your Trying to enter a duplicate Answer for an question please change Answer details or update existing answer");
                     document.getElementById('qat2').focus();
                     return false;
                     
                 }  
                 
             } 
              if(isChecked==='S'){
                 var len=$('input[name=rad_multiple]').length
                 
                  for(var i=1; i<=len;i++){
                  var dd=document.getElementById('qart'+i).value;
                    if(dd==='Type your answer text here'){
                          toastr.error("Please enter Answer text");
                         return false;
                        }
                       for(var j=1; j<=len; j++){
                         var ddd=document.getElementById('qart'+j).value; 
                          if(j!=i){
                              var ss=dd.trim(); var sss=ddd.trim();
                              if(ss===sss){
                                  toastr.error("Your Trying to enter a duplicate Answer for an question please change Answer details or update existing answer.");
                                  return false;
                              }
                          }
                         
                       } 
                   }
                    if(len<2){
                      toastr.error("Two answers are mandatory. You must add one more answer");
                      return false;
                    }
                 }
			if(isChecked==='M'){
				var ord=document.getElementById('order').value;
                var tab=document.getElementById('radio5Tab');
                len=tab.rows.length;
                 if(len<2){
                      toastr.error("Two answers are mandatory. You must add one more answer");
                      return false;
                  }
                  var chec=0;
              for(var i=1; i<=len;i++){
                  var dd=document.getElementById('q6a'+i).value;
                  var ss=document.getElementById('qma'+i);
                 // toastr.error(ss.value);
                        if(ss.checked===true){
                            chec=Number(chec)+1;
                        }
                        if(dd==='Type your answer text here'){
                            toastr.error("Please enter Answer text");
                             return false;
                            }
                    for(var j=1; j<=len; j++){
                         var ddd=document.getElementById('q6a'+j).value;
                          if(j!=i){
                              var sm=dd.trim(); var ssm=ddd.trim();
                              if(sm===ssm){
                                  toastr.error("Your Trying to enter a duplicate Answer for an question please change Answer details or update existing answer.");
                                  return false;
                              }
                          }                         
                       }                            
                  } // toastr.error(chec); toastr.error(len);
                    if(Number(chec)==0){ toastr.error("Please select Correct options."); return false; }
                    if(Number(chec)===Number(len)){
                         toastr.error("Please Add another Unchecked Answer");
                          return false;
                     }
                 }
		
	 }
  
   $(document).ready(function(){
	var dates = $( "#startdate, #enddate" ).datepicker({
		dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "startdate" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
  
 $('input:text.ae_answerText').each(function(){
 
    this.value = $(this).attr('title');
    $(this).addClass('text-label');
    
    $(this).focus(function(){
        if(this.value === $(this).attr('title')) {
            this.value = '';
            $(this).removeClass('text-label');
        }
    });
    
    $(this).blur(function(){
        if(this.value === '') {
            this.value = $(this).attr('title');
            $(this).addClass('text-label');
        }
    });
});



function AddQuestionnaire(){
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
            var code1="question_name["+i+"]";
			var code2="question_name["+i+"]";
            var code=document.getElementById(code1).value;
            if(code==''){
                toastr.error("Please Add Questionnaire");
				document.getElementById(code1).focus();
                return false;
            } 
			var value=document.getElementById(code2).value;
            if(value==''){
                toastr.error("Please Add Questionnaire");
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
	$("#scale_detail").append("<tr id='innertable"+sub_iteration+"'><td align='center' style='padding-left:10px;'><input type='hidden' name='question_id[]' id='question_id' value='' /><input type='checkbox' name='select_chk[]' id='select_chk["+sub_iteration+"]' value='"+sub_iteration+"' /></td><td><input type='text' class='validate[required,minSize[2],maxSize[80], custom[alphanumericSp]] mediumtext' name='question_name[]' id='question_name["+sub_iteration+"]' value='' size='50px' style='width:100%;' /></td></tr>");

   if(document.getElementById(hiddtab).value!=''){
        var ins=document.getElementById(hiddtab).value;
        document.getElementById(hiddtab).value=ins+","+sub_iteration;
    }
    else{
        document.getElementById(hiddtab).value=sub_iteration;
    }
}
function questionnaire_delete(){
    var ins=document.getElementById('inner_hidden_id').value;
    var arr1=ins.split(",");
    var flag=0;
    for(var i=(arr1.length-1); i>=0; i--){
        var bb=arr1[i];
        var a="select_chk["+bb+"]";
        if(document.getElementById(a).checked){
            var b=document.getElementById(a).value;
            var c="innertable"+b+"";
            /* var code=document.getElementById("question_id["+b+"]").value;
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
            } */
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
function questionnaire_validate(){
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
            var code1="question_name["+i+"]";
			var code2="question_name["+i+"]";
            var code=document.getElementById(code1).value;
            if(code==''){
                toastr.error("Please Add Questionnaire");
				document.getElementById(code1).focus();
                return false;
            } 
			var value=document.getElementById(code2).value;
            if(value==''){
                toastr.error("Please Add Questionnaire");
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
}


function addcompetency(){
	
    var table = document.getElementById('competencyTab');
    var rowCount = table.rows.length;
    var dd="addgroup";
	var s=document.getElementById(dd).value;
	if(s!=''){  
		s=s.split(",");
		// toastr.error(s.length);
		for(var i=0;i<s.length;i++){var b=s[i];
			var name=document.getElementById('comp_lang_id_'+b).value;
			var des=document.getElementById('lang_question_name_'+b).value;
			var regex= /^[0-9]+$/;
			
			if(name==''){
				toastr.error("Please Select language .");
				return false;
			}
			if(des==''){
				toastr.error("Please enter question .");
				return false;
			}
			
			for(var j=0;j<s.length;j++){
				var bb=s[j];
				if(j!=i){
					var name1=document.getElementById('comp_lang_id_'+bb).value;
					if(name==name1){ 
						toastr.error("language should be Unique.");
						document.getElementById('comp_lang_id_'+bb).value;
						document.getElementById('comp_lang_id_'+bb).focus();
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
	
	if(language_detail_new!=''){
        var language_d=language_detail_new.split(',');
        var language_status='';
        for(var i=0;i<language_d.length;i++){
            level1=language_d[i];
            level2=level1.split('*');
            if(language_status==''){
                language_status="<option value='"+level2[0]+"'>"+level2[1]+"</option>";
            }else{
                language_status=language_status+"<option value='"+level2[0]+"'>"+level2[1]+"</option>";
            }
        }
    }else{
        language_status='';
    }
	 
	document.getElementById(dd).value=employeecount;
	// var rowcou=parseInt(iteration)+1;
	var row = table.insertRow(rowCount);
	var cell1 = row.insertCell(0); 
	cell1.style.valign="middle";
	//cell1.style.textAlign="center";
	cell1.innerHTML="<div style='padding-left:18px;'><input type='hidden' name='question_id_"+p+"' id='question_id_"+p+"' value='' /><input type='hidden' id='comp_lang_id' name='comp_lang_id[]' value=''><input  type='checkbox' name='chkbox[]' id='chkbox_"+p+"'  value='' /></div>";
	
	var cell2 = row.insertCell(1);
	cell2.style.valign="middle";
	//cell2.style.textAlign="center";
	cell2.innerHTML="<select name='lang_id[]' id='comp_lang_id_"+p+"'  style='width:85%;' class='form-control m-b'><option value=''>Select</option>"+language_status+"</select>";  
       
    var cell3=row.insertCell(2);
	cell3.style.valign="middle";
	//cell3.style.textAlign="center";	<input type='text' class='mediumtext' name='comp_level_name[]' id='level_name_"+p+"' maxlength='20'  value='' style='width:85%;' />	
	cell3.innerHTML="<textarea style='resize:none; width: 90%;' id='lang_question_name_"+p+"' maxlength='200' class='largetexta' name='lang_question_name[]' class='form-control'></textarea>";
    
}

function deletecompetency(){
	var table = document.getElementById('competencyTab');
	var s=document.getElementById("addgroup").value;
    var comp_lang_id=document.getElementById('comp_lang_id').value;
	var question_id=document.getElementById('question_id_l').value;
	var spli=s.split(",");
	var flag=0; //toastr.error(spli);
	var len=spli.length;
	// toastr.error(len);
	for(var m=len;m >0; m--){
		var kk=m-1;
		//  toastr.error(m);
		var fd=spli[kk];
		//  toastr.error(fd);
		var ddd="chkbox_"+fd;
		// toastr.error(ddd);
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
						url: BASE_URL+"/admin/deletetelanguagequestion",
						global: false,
						type: "POST",
						data: ({id : cc ,qid:question_id}),
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
	document.getElementById("addgroup").value=spli;
}

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="yes"){
            $("#multi_lang").show();
        }
        if($(this).attr("value")=="no"){
            $("#multi_lang").hide();
        }
		if($(this).attr("value")==""){
            $("#multi_lang").hide();
        }
        
    });
});

function open_scale(){
	var level_id=document.getElementById('level_id').value;
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
			document.getElementById('scale_id').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/change_level?id="+level_id,true);
	xmlhttp.send();	
}

function validate_data(){
	var question_name=document.getElementById('question_name').value;
	if(question_name==''){
		toastr.error("Please enter Question Text.");
		return false;
	}
	if(document.getElementById('inlineCheckbox1').checked==true){
    var table = document.getElementById('competencyTab');
    var rowCount = table.rows.length;
    var dd="addgroup";
	var s=document.getElementById(dd).value;
	if(s!=''){  
		s=s.split(",");
		// toastr.error(s.length);
		for(var i=0;i<s.length;i++){var b=s[i];
			var name=document.getElementById('comp_lang_id_'+b).value;
			var des=document.getElementById('lang_question_name_'+b).value;
			var regex= /^[0-9]+$/;
			
			if(name==''){
				toastr.error("Please Select language .");
				return false;
			}
			if(des==''){
				toastr.error("Please enter question .");
				return false;
			}
			
			for(var j=0;j<s.length;j++){
				var bb=s[j];
				if(j!=i){
					var name1=document.getElementById('comp_lang_id_'+bb).value;
					if(name==name1){ 
						toastr.error("language should be Unique.");
						document.getElementById('comp_lang_id_'+bb).value;
						document.getElementById('comp_lang_id_'+bb).focus();
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
	}
}
  function deletemultiple_multple_new(){
	var table = document.getElementById('radio6Tab');
	var s=document.getElementById("addgroup_multiple").value;
    var comp_lang_id=document.getElementById('comp_lang_id').value;
	var question_id=document.getElementById('question_id_l').value;
	var spli=s.split(",");
	var flag=0; //toastr.error(spli);
	var len=spli.length;
	// toastr.error(len);
	for(var m=len;m >0; m--){
		var kk=m-1;
		//  toastr.error(m);
		var fd=spli[kk];
		//  toastr.error(fd);
		var ddd="qma"+fd;
		// toastr.error(ddd);
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
			var dd="qma"+spli[k];
			var ddddd="value_id_"+spli[k];
			//toastr.error(dd);
			if(document.getElementById(dd).checked==true){ // toastr.error(j);
				var cc=document.getElementById(dd).value;
				// toastr.error(cc);
				if(cc!==""){
					if(document.getElementById(ddddd)){
				var question_id=document.getElementById(ddddd).value;
					$.ajax({      
						url: BASE_URL+"/admin/deletete_multi_single",
						global: false,
						type: "POST",
						data: ({id : cc ,qid:question_id}),
						dataType: "html",
						async:false,
						success: function(msg){
						}
					}).responseText;
					}
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
	document.getElementById("addgroup_multiple").value=spli;
       }

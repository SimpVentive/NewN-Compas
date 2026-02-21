
<script>    
<?php
foreach($_REQUEST as $key=>$val){
    echo "var ".$key."='".$val."';";
}

//To send language  name to .js file
$language_name='';
foreach($language as $languages){
    if($language_name==''){
		if($languages['lang_id']!=2){
        $language_name=$languages['lang_id']."*".$languages['lang_name'];
		}
    }
    else{
		if($languages['lang_id']!=2){
        $language_name=$language_name.",".$languages['lang_id']."*".$languages['lang_name'];
		}
    }
}
echo "var language_detail_new='".$language_name."';"; 
?>
function multiple_single_choice(){
	//jQuery("#questionvaluesForm").validationEngine();
	table=document.getElementById('radio4Tab');
	len=table.rows.length;
	
	if(Number(len)==Number(8)){ toastr.error('You cannot add more than 8 options'); return false}; 
	var dd="addgroup_single";
	var s=document.getElementById(dd).value;
	if(s!=''){
		s=s.split(",");
		for(var i=0;i<s.length;i++){
			var b=s[i];
			var code=document.getElementById('qart'+b).value;
			if(code==''){
                toastr.error("Please enter Answer value for English.");
				return false;
			}
			<?php 
			if(!empty($ques_lang_n)){
			foreach($ques_lang_n as $key=>$ques_langs){
			?>
				var language_<?php echo $key; ?> =document.getElementById('qart_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_'+b).value;
				if(language_<?php echo $key; ?>==''){
					toastr.error("Please enter Answer value for <?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>.");
					return false;
				}
			<?php
			}
			}?>
			for(var j=0;j<s.length;j++){
				var bb=s[j];
				if(j!=i){
					var code1=document.getElementById('qart'+bb).value;
					if(code==code1){ 
						toastr.error("Questiuon Values should be Unique.");
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
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value===""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
	}
	var gg=document.getElementById(dd).value=employeecount;
	var rowcou=len;
	// toastr.error(rowcou);
	if(rowcou < Number(8)){
		var row = table.insertRow(rowcou);
		var cell1 = row.insertCell(0);
		/* cell1.style.styleFloat = 'right';*/
		cell1.style.css = 'center'; 
		cell1.innerHTML="<label class='position-relative'><input type='radio' name='rad_multiple' value='answer_rad_"+p+"' id='qar"+p+"'><span class='lbl'></span></label>";
		
		var cell2 = row.insertCell(1);
		$(cell2).addClass("ae_answerDefinition");
		cell2.innerHTML="<div style='overflow-x:auto; width:'<?php //echo $c5=(!empty($ques_lang_n))?(count($ques_lang_n>0)?"220px":""):""; ?>'><textarea class='summernote' name='answer_rad_"+p+"' id='qart"+p+"' /></textarea></div>";
		<?php 
		if(!empty($ques_lang_n)){
		foreach($ques_lang_n as $key=>$ques_langs){
		$key1=($key+2);
		$key2=($key+3);
		?>
		var cell<?php echo $key2;?> = row.insertCell(<?php echo $key1;?>);
		$(cell<?php echo $key2;?>).addClass("ae_answerDefinition");
		cell<?php echo $key2;?>.innerHTML="<input type='hidden' name='que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>'><input type='hidden' name='comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>'><input type='hidden' name='lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>'><div style='overflow-x:auto; width:'><textarea class='summernote' name='answer_rad_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='qart_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"'/></textarea></div>";
		<?php }
		}
		?>

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
		}
}

function multiple_multple_choice_new(){
	//jQuery("#questionvaluesForm").validationEngine();
	table=document.getElementById('radio6Tab');
	len=table.rows.length;
	
	if(Number(len)==Number(8)){ toastr.error('You cannot add more than 8 options'); return false; }
	var dd="addgroup_multiple";
	var s=document.getElementById(dd).value;
	if(s!=''){
		s=s.split(",");
		for(var i=0;i<s.length;i++){
			var b=s[i];
			var code=document.getElementById('q6a'+b).value;
			if(code==''){
                toastr.error("Please enter Answer value for English.");
				return false;
			}
			<?php 
			if(!empty($ques_lang_n)){
			foreach($ques_lang_n as $key=>$ques_langs){
			?>
				var language_<?php echo $key; ?> =document.getElementById('q6a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_'+b).value;
				if(language_<?php echo $key; ?>==''){
					toastr.error("Please enter Answer value for <?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>.");
					return false;
				}
			<?php
			}
			}?>
			for(var j=0;j<s.length;j++){
				var bb=s[j];
				if(j!=i){
					var code1=document.getElementById('q6a'+bb).value;
					if(code==code1){ 
						toastr.error("Question values should be Unique.");
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
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value===""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
	}
	var gg=document.getElementById(dd).value=employeecount;
	var rowcou=len;
	// toastr.error(rowcou);
	if(rowcou < Number(8)){
		var row = table.insertRow(rowcou);
		var cell1 = row.insertCell(0);
		/* cell1.style.styleFloat = 'right';*/
		cell1.style.css = 'center'; 
		cell1.innerHTML="<label class='position-relative'><input type='checkbox' name='chkbox_"+p+"' value='"+p+"' id='qma"+p+"'><span class='lbl'></span></label>";
		var cell2 = row.insertCell(1);
		$(cell2).addClass("ae_answerDefinition");
		cell2.innerHTML="<div style='overflow-x:auto;'><textarea class='summernote' name='answer_chk_"+p+"' id='q6a"+p+"' /></textarea></div>";
		<?php 
		if(!empty($ques_lang_n)){
		foreach($ques_lang_n as $key=>$ques_langs){
		$key1=($key+2);
		$key2=($key+3);
		?>
		var cell<?php echo $key2;?> = row.insertCell(<?php echo $key1;?>);
		$(cell<?php echo $key2;?>).addClass("ae_answerDefinition");
		cell<?php echo $key2;?>.innerHTML="<input type='hidden' name='que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>'><input type='hidden' name='comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>'><input type='hidden' name='lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>'><div style='overflow-x:auto;'><textarea class='summernote' name='answer_chk_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='q6a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"'/></textarea></div>";
		<?php }
		}
		?>
		
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
	
		}
}


function multiple_multple_priority_new(){
	//jQuery("#questionvaluesForm").validationEngine();
	table=document.getElementById('radio7Tab');
	len=table.rows.length;
	//alert(len);
	if(Number(len)==Number(25)){ toastr.error('You cannot add more than 25 options'); return false; }
	var dd="addgroup_priority";
	var s=document.getElementById(dd).value;
	if(s!=''){
		s=s.split(",");
		for(var i=0;i<s.length;i++){
			var b=s[i];
			var code=document.getElementById('q7a'+b).value;
			if(code==''){
                toastr.error("Please enter Answer value for English.");
				return false;
			}
			<?php 
			if(!empty($ques_lang_n)){
			foreach($ques_lang_n as $key=>$ques_langs){
			?>
				var language_<?php echo $key; ?> =document.getElementById('q7a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_'+b).value;
				if(language_<?php echo $key; ?>==''){
					toastr.error("Please enter Answer value for <?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>.");
					return false;
				}
			<?php
			}
			}?>
			for(var j=0;j<s.length;j++){
				var bb=s[j];
				if(j!=i){
					var code1=document.getElementById('q7a'+bb).value;
					
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
	p=parseInt(temp2)+1;
	if(document.getElementById(dd).value===""){
		employeecount=1;
		p=1;
	}
	else{
		employeecount.push(p);		
	}
	var gg=document.getElementById(dd).value=employeecount;
	var rowcou=len;
	// toastr.error(rowcou);
	if(rowcou < Number(25)){
		var row = table.insertRow(rowcou);
		var cell1 = row.insertCell(0);
		/* cell1.style.styleFloat = 'right';*/
		cell1.style.css = 'center'; 
		cell1.innerHTML="<label class='position-relative'><input type='checkbox' checked='checked' name='chkbox_"+p+"' value='"+p+"' id='qma"+p+"'><span class='lbl'></span></label>";
		var cell2 = row.insertCell(1);
		$(cell2).addClass("ae_answerDefinition");
		cell2.innerHTML="<div style='overflow-x:auto; '><textarea class='summernote' name='answer_chk_"+p+"' id='q7a"+p+"' /></textarea></div>";
		<?php 
		if(!empty($ques_lang_n)){
		foreach($ques_lang_n as $key=>$ques_langs){
		$key1=($key+2);
		$key2=($key+3);
		?>
		var cell<?php echo $key2;?> = row.insertCell(<?php echo $key1;?>);
		$(cell<?php echo $key2;?>).addClass("ae_answerDefinition");
		cell<?php echo $key2;?>.innerHTML="<input type='hidden' name='que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>'><input type='hidden' name='comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>'><input type='hidden' name='lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' value='<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>'><div style='overflow-x:auto;'><textarea  class='summernote' name='answer_chk_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"' id='q7a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_"+p+"'/></textarea></div>";
		<?php }
		}
		?>
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
	
		}
}

</script>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<?php
					if(isset($_REQUEST['qid'])){
					$step1=isset($_REQUEST['step1'])?"btn-primary c1":"btn-success c1";
					}else{
						$step1=isset($_REQUEST['step1'])?"btn-primary ":"btn-success";
					}
					
					if(isset($_REQUEST['qid'])){
						if(count($ques_lang_n)>0 || count($questions)>0){
					$step2=isset($_REQUEST['step2'])?"btn-primary c1":"btn-success c1";
						if(count($questions)>0){
					$step3=isset($_REQUEST['step3'])?"btn-primary c1":"btn-success c1";
						}else{
					$step3=isset($_REQUEST['step3'])?"btn-primary":"btn-default disabled";
						}
						}else{
					$step2=isset($_REQUEST['step2'])?"btn-primary":"btn-default disabled";
					$step3=isset($_REQUEST['step3'])?"btn-primary":"btn-default disabled";
						}
					}else{
					$step2=isset($_REQUEST['step2'])?"btn-primary":"btn-default disabled";
					$step3=isset($_REQUEST['step3'])?"btn-primary":"btn-default disabled";
					}
					?>
					<div class="m-b-md" id="wizardControl">

						<a class="btn <?php echo $step1; ?>" href="#step1" data-toggle="tab">Step 1 - Question</a>
						<a class="btn <?php echo $step2; ?> " href="#step2" data-toggle="tab" >Step 2 - Question Value</a>
						<a class="btn <?php echo $step3; ?> " href="#step3" data-toggle="tab">Step 3 - Review/Publish</a>
					</div>

					<div class="tab-content">
						<?php
						$step1_a=isset($_REQUEST['step1'])?"active":"";
						?>
						<div id="step1" class="p-m tab-pane <?php echo $step1_a; ?>">
							<form id="questionForm" name="questionForm" method="post" action="<?php echo BASE_URL?>/admin/comp_question_insert_step_one" >
							<input type="hidden" name="question_bank_id" id="question_bank_id" value="<?php echo $_REQUEST['id']; ?>" />
							<input type="hidden" name="question_id" id="question_id" value="<?php echo isset($_REQUEST['qid'])?$_REQUEST['qid']:""; ?>" />
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-default card-view hblue">
										<div class="panel-heading hbuilt">
											<h6 class="txt-dark capitalize-font">Enter the following details</h6>
										</div>
										<div class="panel-body">
											<div class="form-group col-lg-6">
												<label class="control-label mb-10 text-left">Question Category<sup><font color="#FF0000">*</font></sup>:</label>
												<select name='question_category' id='question_category' class='validate[required] form-control m-b'>
												<option value="">Select</option>
													<?php 	
													foreach($quest_cat as $quest_cats){
														$sel=isset($question['quest_cat'])?($question['quest_cat']==$quest_cats['code'])?'selected="selected"':'':'';
														echo "<option value=".$quest_cats['code']." ".$sel.">".$quest_cats['name']."</option>";
													}?>
												</select>
											</div>
											<div class="form-group col-lg-6">
												<label class="control-label mb-10 text-left">Question Type<sup><font color="#FF0000">*</font></sup>:</label>
												<select class="validate[required] form-control m-b" name='questtype' id="questtype" onchange="gettypedata_new(this.value)"  data-prompt-position="topLeft:100" >
													<option value="">Select</option>
													<?php	
													foreach($questiontype as $questiontypes){
														if($questiontypes->flag!='FB'){
															$sel=isset($question['type'])?($question['type']==$questiontypes->flag)?'selected="selected"':'':'';?>
															<option <?php echo $sel; ?> value="<?php echo $questiontypes->id; ?>,<?php echo $questiontypes->flag; ?>"><?php echo $questiontypes['name']; ?></option>
														<?php 	        	
														}
													} ?>
												</select>
											</div>
										</div>
										<input type="hidden" name="qbankid" id="qbankid" value="<?php echo $_REQUEST['id']; ?>" />
										<input type="hidden" name="comp_def_id" id="comp_def_id" value="<?php echo $ques_bank['comp_def_id']; ?>" />
										<div class="panel-heading hbuilt">
											<h6 class="txt-dark capitalize-font">Question Creation</h6>
										</div>
										<div class="panel-body">
											<div class="form-group col-lg-6">
												<label class="control-label mb-10 text-left">Question Type:</label>
												<label id="selectedtype"><?php echo isset($question['qtype'])?$question['qtype']:""; ?></label>
												
											</div>
											<div class="form-group col-lg-6">
												<label class="col-sm-12 control-label">Multi Language<sup><font color="#FF0000">*</font></sup>:</label>
												<?php 
												$yes=isset($question['multi_language'])?($question['multi_language']=="yes")?'checked="checked"':'':'';
												$no=isset($question['multi_language'])?($question['multi_language']=="no")?'checked="checked"':'':"checked='checked'";
												?>
												<div class="col-sm-6">
													<label class="checkbox-inline"> <input name="multi_language" value="yes" <?php echo $yes; ?> id="inlineCheckbox1" type="radio"> Yes </label> <label class="checkbox-inline">
													<input name="multi_language" id="inlineCheckbox2" type="radio" value="no"  <?php echo $no; ?>>No </label> 
												</div>
											</div>
											<div class="form-group col-lg-12">
												<label class="control-label mb-10 text-left">Question Text<sup><font color="#FF0000">*</font></sup>:</label>
												<p id="prompt-req-summary" class="prompt-summary prompt-target"></p>
												<textarea type="text" name='question_name' class="validate[required,minSize[3],maxSize[2000],ajax[ajaxQuestionbankQuestionExist]]  form-control summernote" id="question_name" style="resize:none;"  data-prompt-target="prompt-req-summary" data-prompt-position="inline"><?php echo isset($question['qname'])?$question['qname']:""; ?></textarea>
											</div>
											<div class="form-group col-lg-6">
												<label class="control-label mb-10 text-left">Level<sup><font color="#FF0000">*</font></sup>:</label>
												<select class="validate[required]  form-control m-b" name="level_id" id="level_id" onchange="open_scale();">
													<option value="">Select</option>              
													<?php 	        
													//foreach($level as $levels){
														$sel=isset($question['level_id'])?($question['level_id']==$level['level_id'])?'selected="selected"':'':'';?>
														<option  <?php echo $sel; ?> value="<?php echo $level['level_id']; ?>"><?php echo $level['level_name'] ; ?></option>
													<?php 	       
													//} ?> 
												</select>
											</div>
											<div class="form-group col-lg-6">
												<label class="control-label mb-10 text-left">Level Scale<sup><font color="#FF0000">*</font></sup>:</label>
												<select class="validate[required] form-control m-b" name="scale_id" id="scale_id"  data-prompt-position="topLeft:100">
													<option value="">Select</option>
													<?php 	        
													foreach($scalevalue as $scalevalues){
														$sels=isset($question['scale_id'])?($question['scale_id']==$scalevalues['scale_id'])?'selected="selected"':'':'';?>
														<option  <?php echo $sels; ?> value="<?php echo $scalevalues['scale_id']; ?>"><?php echo $scalevalues['scale_name'] ; ?></option>
													<?php 	       
													} ?> 
												</select>
											</div>
											<div class="form-group col-lg-6">
												<label class="control-label mb-10 text-left">Elements:</label>
												<select name="order"  id="order" class="validate[required] form-control m-b">
													<option value="">Select</option>              
													<?php 	        
													foreach($display as $displays ){
														$sel=isset($question['sequence'])?($question['sequence']==$displays['code'])?'selected="selected"':'':'';?>
														<option  <?php echo $sel; ?> value="<?php echo $displays['code']; ?>"><?php echo $displays['name'] ; ?></option>
													<?php 	       
													} ?>  
												</select>
											</div>
											<div class="form-group col-lg-6">
												<label class="control-label mb-10 text-left">Sequence<sup><font color="#FF0000">*</font></sup>:</label>
												<select name="order"  id="order" class="validate[required] form-control m-b">
													<option value="">Select</option>              
													<?php 	        
													foreach($display as $displays ){
														$sel=isset($question['sequence'])?($question['sequence']==$displays['code'])?'selected="selected"':'':'';?>
														<option  <?php echo $sel; ?> value="<?php echo $displays['code']; ?>"><?php echo $displays['name'] ; ?></option>
													<?php 	       
													} ?>  
												</select>
											</div>
											<div class="form-group col-lg-6" id="pointsTab"  <?php echo isset($question['points'])?$question['points']:"style='display:none;'"; ?>>
												<label class="control-label mb-10 text-left">Points:</label>
												<input type="text" id="selectedtype" class="validate[max[25]] form-control" maxlength="2" onkeyup="jm_phonemask(this)" value="<?php echo isset($question['points'])?$question['points']:""; ?>" name='points' id="points">
											</div>
										</div>
										<?php
										$check=isset($question['multi_language'])?($question['multi_language']=="yes")?'display:block':'display:none':'display:none';
										?>
										<div id='multi_lang' style="<?php echo $check; ?>">
											<div class="panel-heading hbuilt">
												<h6 class="txt-dark capitalize-font">Language</h6>
											</div>
											<div class="panel-body">
												
												<div class="table-responsive">
													<div class="pull-right">
														<a class="btn btn-xs btn-primary" onclick="addcompetency()">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp </a>
														<a class="btn btn-danger btn-xs" onclick="deletecompetency()">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp </a>
													</div>
													<div class="clearfix"></div>
													<table id="competencyTab" name="competencyTab" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
														<thead>
														<tr>
															<th>Select</th>
															<th>Language</th>
															<th>Question</th>
														</tr>
														</thead>
														<tbody>
														<?php
															if(isset($ques_lang)){
																$hide_val=array();
																foreach($ques_lang as $key=>$ques_langs){
																	$key1=$key+1; $hide_val[]=$key1;
																?>
																	<tr>
																		<input type="hidden" name="question_id_l" id="question_id_l" value="<?php echo isset($_REQUEST['qid'])?$_REQUEST['qid']:""; ?>" />
																		<input type="hidden" id="comp_lang_id" name="comp_lang_id[]" maxlength="10" value="<?php echo $ques_langs['comp_lang_id'] ?>">
																		<td style='padding-left: 18px;'><input type="checkbox" name="chkbox[]" id="chkbox_<?php echo $key1; ?>" value="<?php echo $ques_langs['comp_lang_id'] ?>" >
																		</td>
																		<td>
																			<select style="width:85%;" name="lang_id[]" id="comp_lang_id_<?php echo $key1; ?>" class="form-control m-b">
																				<option value="">Select</option>
																				<?php 
																				foreach($language as $languages){
																					if($languages['lang_id']!=2){
																					$sel=isset($ques_langs['lang_id'])?($ques_langs['lang_id']==$languages['lang_id'])?'selected="selected"':'':'';
																				?>
																					<option <?php echo $sel; ?> value="<?php echo $languages['lang_id']; ?>"><?php echo $languages['lang_name']; ?></option>
																				<?php
																				}}
																				?>
																			</select>
																		</td>
																		<td>
																			<textarea style="resize:none; width: 90%;" name="lang_question_name[]" id="lang_question_name_<?php echo $key1; ?>" class="form-control"><?php echo isset($ques_langs['lang_question_name'])?$ques_langs['lang_question_name']:""; ?></textarea>
																		</td>
																	</tr> 
																<?php
																}
																$hidden=@implode(',',$hide_val); 
															}
															else{
															?>
																<tr>
																	<td style='padding-left: 18px;'>
																	<input type="hidden" name="question_id_l" id="question_id_l" value="" />
																	<input type="hidden" id="comp_lang_id" name="comp_lang_id[]" value="">
																	<input type="checkbox" name="chkbox[]" id="chkbox_1" value="1" >
																	</td>
																	<td>
																		<select style="width:85%;" name="lang_id[]" id="comp_lang_id_1" class="form-control m-b">
																			<option value="">Select</option>
																			<?php 
																			foreach($language as $languages){
																					if($languages['lang_id']!=2){
																			?>
																				<option value="<?php echo $languages['lang_id']; ?>"><?php echo $languages['lang_name']; ?></option>
																			<?php
																			}}
																			?>
																		</select>
																	</td>
																	<td>
																		<textarea style="resize:none; width: 90%;" name="lang_question_name[]" id="lang_question_name_1" class="form-control" ></textarea>
																	</td>
																</tr> 
															<?php
																$hidden=1;
															}
															?>
									
														</tbody>
													</table>
													<input type="hidden" name="addgroup" id="addgroup" value="<?php echo $hidden; ?>" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
									<input type="hidden" name="step1" value="1">
									<button class="btn btn-danger btn-sm" type="button" onClick="create_link('questions?type=<?php echo $_REQUEST['type']; ?>&id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									<button class="btn btn-primary  btn-sm" type="submit" name="tna_prg_save" id="tna_prg_save" ><i class="fa fa-check"></i> Next</button>
									
								</div>
							</div>
							</form>
						</div>
						<?php
						$step2_a=isset($_REQUEST['step2'])?"active":"";
						?>
						<div id="step2" class="p-m tab-pane <?php echo $step2_a; ?>">
							<form  class="form-horizontal" id="questionvaluesForm" method="post" action="<?php echo BASE_URL?>/admin/comp_question_insert_step_two" >
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
										<?php
										if(isset($_REQUEST['qid'])){
										?>
											<div class="panel-heading hbuilt">
												<h6 class="txt-dark capitalize-font">English</h6>
											</div>
											<div class="panel-body no-padding">
												<table class="table table-hover table-bordered mb-0">
													<tbody>
														<tr>
															<td>Question Name</td>
															<td><?php echo !empty($question['qname'])?$question['qname']:""; ?></td>
														</tr>
														<tr>
															<td>Question Type</td>
															<td><?php echo isset($question['qtype'])?$question['qtype']:""; ?></td>
														</tr>
													</tbody>
												</table>
											</div>
											<?php
											if(count($ques_lang_n)>0){
											?>
											<div class="panel-heading hbuilt">
												<h6 class="txt-dark capitalize-font">Multi language</h6>
											</div>
											<div class="table table-hover table-bordered mb-0">
												<?php 
												foreach($ques_lang_n as $ques_langs){
												?>
													<table class="table table-striped">
														<tbody>
															<tr>
																<td style="width:30%"><?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?></td>
																<td style="width:70%"><?php echo isset($ques_langs['question_name'])?$ques_langs['question_name']:""; ?></td>
															</tr>
														</tbody>
													</table>
												<?php
												}
												?>
											</div>
											<hr class="light-grey-hr">
											<?php 
											}
											} ?>
											
											<?php 
											$qtype=isset($question['type'])?$question['type']:"";
											?>
											<input type="hidden" name="qid" id="qid" value="<?php echo !empty($_REQUEST['qid'])?$_REQUEST['qid']:""; ?>">
											<input type="hidden" name="questiontype" id="questiontype" value="<?php echo $qtype; ?>">
											<div class="panel-heading hbuilt">
												<h6 class="txt-dark capitalize-font">Question Values</h6>
											</div>
											<?php
											if($qtype=='F'){
											?>
											<div class="panel-heading hbuilt">
												<h6 class="panel-title txt-dark">Fill in the Blanks(Text Response)</h6>
											</div>
											<div class="table-responsive">
												<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="radio1Tab">
													<tbody>
													<?php
													if(count($questions)>0){
														$value_id=array();
														$text=array();
														$explanation=array();
														foreach($questions as $question_lang){
															$value_id[]=$question_lang['value_id'];
															$text[]=$question_lang['text'];
															$explanation[]=$question_lang['explanation'];
															$value_id=@implode(',',$value_id);
															$text=@implode(',',$text);
															$explanation=@implode(',',$explanation);
														}
													}
													?>
													<tr style="line-height:60px;">
														<td style="float:right;">
															Answer Text <sup><font color="#FF0000">*</font></sup>
														</td>
														<td><input type="hidden" id="value_id_1"  name="value_id_1" value="<?php echo $value_id=!empty($value_id)?$value_id:""; ?>"/><!--ae_answerText col-xs-12 col-sm-6-->
														<input class="validate[required] form-control"  name="fillquestion[]" type="text" value="<?php echo $text=!empty($text)?$text:""; ?>" title="Type your answer text here" id="qa1"  data-prompt-position="topLeft:100">
														</td>
													</tr>
													<tr><td>&nbsp;</td></tr>
													<tr style="line-height:60px;" >
														<td style="float:right;">Explanation Text</td>
														<td> <input class="ae_answerText form-control"  name="explan[]" type="text" value="<?php echo $explanation=!empty($explanation)?$explanation:""; ?>" title="<?php echo $explanation=!empty($explanation)?$explanation:"Type your explanation text here"; ?>" id="qe1">
														</td>
													</tr>
													</tbody>
												</table>
											</div>
											<?php
											}
											if($qtype=='B'){
												if(count($questions)>0){
													$value_id_b=array();
													$text_b=array();
													$explanation_b=array();
													foreach($questions as $question_lang){
														$value_id_b[]=$question_lang['value_id'];
														$text_b[]=$question_lang['text'];
														$explanation_b[]=$question_lang['explanation'];
														$value_id_b=@implode(',',$value_id_b);
														$text_b=@implode(',',$text_b);
														$explanation_b=@implode(',',$explanation_b);
													}
												}
											?>
											<div class="panel-heading hbuilt">
												<h6 class="panel-title txt-dark">Fill in the Blanks (Numeric Response )</h6>
												
											</div>
											<div class="table-responsive">
												<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="radio2Tab">
													<tbody>
														<tr style="line-height:60px;">
															<td style="float:right;"><input type="hidden" id="value_id_1" name="value_id_1" value="<?php echo $value_id_b=!empty($value_id_b)?$value_id_b:""; ?>"/>Answer Text<sup><font color="#FF0000" style="height:32px">*</font></sup></td>
															<td>
																<input class="ae_answerText form-control"   onkeyup="jm_phonemask(this)" type="text" class="numbers"  maxlength="15" value="<?php echo $text_b=!empty($text_b)?$text_b:""; ?>" title="Type your answer text here"  name="fillquestion[]" id="qan1">
															</td>
														</tr>
														<tr style="line-height:60px;" >
															<td style="float:right;">Explanation Text:</td>
																<td> <input class="ae_answerText form-control" type="text" value="<?php echo $explanation_b=!empty($explanation_b)?$explanation_b:""; ?>" title="<?php echo $explanation_b=!empty($explanation_b)?$explanation_b:"Type your explanation text here"; ?>" name="explan[]" id="qen1">
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<?php
											}
											if($qtype=='T'){
											?>
											<div class="panel-heading hbuilt">
												
												<h6 class="panel-title txt-dark">True or False Response</h6>
											</div>
											<div class="table-responsive">
												<div align="left" style="padding-left:30px;">Select the correct response </div>
												<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="radio3Tab">
													<tbody>
													<?php
													if(count($questions)>0){
														$value_id=array();
														$text=array();
														$explanation=array();
														foreach($questions as $key6=>$question_lang){
															$key5=($key6+1);
															$value_id[]=$question_lang['value_id'];
															$text[]=$question_lang['text'];
															$explanation[]=$question_lang['explanation'];
															$bb=($question_lang['correct_flag']=='Y')?"checked='checked'":'';?>
															
														<tr style='line-height:60px;'>
															<td style="float:right;" class="ae_answerCorrect">
																		<input type="hidden" id="value_id_<?php echo $key5; ?>" name="value_id_<?php echo $key5; ?>" value="<?php echo $question_lang['value_id'];?>"/>
																<input type="radio" name="rad_radio" <?php echo  $bb; ?> value="answer_<?php echo $key5;?>" id="qra<?php echo $key5;?>">Correct Answer
															</td>
															<td  class="ae_answerDefinition">
																<table>
																	<tbody>
																		<tr>
																			<td>Answer Text<sup><font color="#FF0000" style="height:32px">*</font></sup>:</td><!--ae_answerText-->
																			<td><input type="text" maxlength="300"  class="validate[required] mediumtext" value="<?php echo $question_lang['text'];?>" title="Type your answer text here" name="answer_<?php echo $key5;?>"  id="qat<?php echo $key5;?>" style="width:249px;">
																			</td>
																			<td>&nbsp;</td>
																			<td>Explanation Text:</td>
																			<td><input type="text" class="mediumtext" value="<?php echo $question_lang['explanation'];?>"<?php echo empty($question_lang['explanation'])?' title="Type your explanation text here"':'';?> name="explan[]" id="qet<?php echo $key5;?>" style="width:249px;">
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
															
											<?php			}
													}else{
													?>
													<?php
													
													$bb='';
													for($i=1;$i<3;$i++){
														if($i==2){
															$bb="checked='checked'";
														}
														?>
														<tr style='line-height:60px;'>
															<td style="float:right;" class="ae_answerCorrect">
																		<input type="hidden" id="value_id_<?php echo $i; ?>" name="value_id_<?php echo $i; ?>" value=""/>
																<input type="radio" name="rad_radio" <?php echo  $bb; ?> value="answer_<?php echo $i;?>" id="qra<?php echo $i;?>">Correct Answer
															</td>
															<td  class="ae_answerDefinition">
																<table>
																	<tbody>
																		<tr>
																			<td>Answer Text<sup><font color="#FF0000" style="height:32px">*</font></sup>:</td><!--ae_answerText-->
																			<td><input type="text" maxlength="300"  class="validate[required] mediumtext" value="" title="Type your answer text here" name="answer_<?php echo $i;?>"  id="qat<?php echo $i;?>" style="width:249px;">
																			</td>
																			<td>&nbsp;</td>
																			<td>Explanation Text:</td>
																			<td><input type="text" class="ae_answerText mediumtext" value="" title="Type your explanation text here" name="explan[]" id="qet<?php echo $i;?>">
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														<?php 
													}} ?>
													</tbody>
												</table>
												<input type="hidden" name="addgroup_radio" id="addgroup" value="1,2" />
											</div>
											<?php
											}
											if($qtype=='S'){
												
											?>
											<?php 
											$ques_s=($qtype=='S'?"single":"");
											?>
											<div class="panel-heading hbuilt">
												<h6 class="panel-title txt-dark">Multiple Choice for <?php echo $ques_s; ?>Response.</h6>
												
											</div>
											<div class="alert alert-warning">
												<strong>Select the correct response</strong>
											</div>
											
											<div class="table-responsive">
												
												<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="radio4Tab">
													<thead>
														<th width="3%">
														Correct Answer
														</th>
														<?php $c=(count($ques_lang_n)>0)?"40%":"100%" ?>
														<th  width="<?php //echo $c; ?>">English</th>
														<?php 
														if(count($ques_lang_n)>0){
														foreach($ques_lang_n as $ques_langs){
														?>
														<th   class="center"><?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?></th>
														<?php }
														}														?>
													</thead>
													<tbody>
														<?php
														
														if(count($questions)>0){
															$hide_val_l=array();
															foreach($questions as $key6=>$question_lang){
																$key5=($key6+1);
																$hide_val_l[]=$key5;
															?>
															<tr>
																<td>
																	<label class="position-relative">
																		<input type="hidden" id="value_id_<?php echo $key5; ?>" name="value_id_<?php echo $key5; ?>" value="<?php echo $question_lang['value_id']; ?>"/>
																		<input type="radio" id="qar<?php echo $key5; ?>" value="answer_rad_<?php echo $key5; ?>" name="rad_multiple" <?php echo $check=($question_lang['correct_flag']=="Y")?"checked='checked'":""; ?> style="padding-right:30px;">
																		<span class="lbl"></span>
																	</label>
																</td>
																<?php $c1=(count($ques_lang_n)>0)?"520px":"" ?>
																<td width="<?php echo $c1; ?>">
																<div style="overflow-x:auto; width:<?php echo $c1; ?>">
																<textarea  class='summernote' name="answer_rad_<?php echo $key5; ?>" id="qart<?php echo $key5; ?>" /><?php echo $question_lang['text'];?></textarea></div>
																</td>
																<?php
																if(count($ques_lang_n)>0){
																	foreach($ques_lang_n as $ques_langs){
																		$ques_lan=UlsLangQuestionValues::get_all_lang_values_single($question_lang['value_id'],$ques_langs['lang_id']);
																
																		if(!empty($ques_lan)){
																		
																		?>
																		<td width="<?php echo $c1; ?>">
																				
																			<input type="hidden" name="que_lang_id_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>" id="que_lang_id_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_lan['que_lang_id'])?$ques_lan['que_lang_id']:""; ?>">
																			<input type="hidden" name="comp_lang_id_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>" id="comp_lang_id_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_lan['comp_lang_id'])?$ques_lan['comp_lang_id']:""; ?>">
																			<input type="hidden" name="lang_id_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>" id="lang_id_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_lan['lang_id'])?$ques_lan['lang_id']:""; ?>">
																			<div style="overflow-x:auto; width:<?php echo $c1; ?>">
																				<textarea  class='summernote' name="answer_rad_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>" id="qart_<?php echo isset($ques_lan['language_name'])?$ques_lan['language_name']:""; ?>_<?php echo $key5; ?>"/><?php echo isset($ques_lan['text'])?$ques_lan['text']:""; ?></textarea>
																				
																			</div>
																		</td>
																		<?php 
																		}
																		else{
																
																
																	?>
																	<td width="<?php echo $c1; ?>">
																		<input type="hidden" name="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>" id="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>" value="<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>">
																		<input type="hidden" name="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>" id="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>" value="<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>">
																		<input type="hidden" name="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>" id="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>" value="<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>">
																		<div style="overflow-x:auto; width:<?php echo $c1; ?>">
																			<textarea class='summernote' name="answer_rad_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>" id="qart_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5;?>"/></textarea>
																		</div>
																	</td>
																	<?php 
																	}
																
																}	
															}															
																?>
																
															</tr>
															<?php
															}
															$hidden_l=@implode(',',$hide_val_l);
														}
														else{
															$hidden_l=1;
															?>
															<tr>
																<td>
																	<label class="position-relative">
																		<input type="hidden" id="value_id_1"  name="value_id_1" value=""/>
																		<input type="radio" id="qar1" value="answer_rad_1" name="rad_multiple" checked="checked" style="padding-right:30px;">
																		<span class="lbl"></span>
																	</label>
																</td>
	
																<td width="">
																<?php $c1=(count($ques_lang_n)>0)?"220px":"" ?>
																<div style="overflow-x:auto; width:<?php echo $c1; ?>">
																<textarea  class='summernote' name="answer_rad_1" id="qart1" /></textarea></div>
																</td>
																<?php 
																if(!empty($ques_lang_n)){
																	foreach($ques_lang_n as $ques_langs){
																	?>
																	<td width="<?php echo $c1; ?>">
																		<input type="hidden" name="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>">
																		<input type="hidden" name="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>">
																		<input type="hidden" name="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>">
																		<div style="overflow-x:auto; width:<?php echo $c1; ?>">
																			<textarea class='summernote' name="answer_rad_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="qart_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1"/></textarea>
																		</div>
																	</td>
																	<?php 
																	}
																}
																?>
															</tr>
														<?php 
														} 
														?>
													</tbody>
												</table>
												<input type="hidden" name="addgroup_single" id="addgroup_single" value="<?php echo $hidden_l; ?>" />
												
											</div>
											<br style="clear:both">
											<div class="panel-heading hbuilt">
												<div class="pull-left">
													<input type="button"  class="btn btn-xs btn-primary" onclick="multiple_single_choice()" name="multiple_single" id="multiple_single" value="Add" />
													<input type="button" class="btn btn-xs btn-danger"  onclick="deletemultiple_single()"name="delete" id="add" value="Delete" />
												</div>
											</div>
											
											<?php
											}
											if($qtype=='M'){
											?>
											<?php
											$ques_m=($qtype=='M'?"Multiple":"");
											?>
											<div class="panel-heading hbuilt">
												<h6 class="panel-title txt-dark">Multiple Choice for <?php echo $ques_m; ?> Response.</h6>
												
											</div>
											<div class="alert alert-warning">
												<strong>Select the correct response</strong>
											</div>
											
											<div class="table-responsive">
											<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="radio6Tab">
												<thead>
													<th width="12%">
														Correct Answer
													</th>
													<th  width="30%">English</th>
													<?php 
													foreach($ques_lang_n as $ques_langs){
													?>
													<th  width="30%" class="center"><?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?></th>
													<?php } ?>
													
												</thead>
												<tbody>
													<?php
													
													if(count($questions)>0){
														$hide_val_m=array();
														foreach($questions as $key7=>$question_lang){
															$key5=($key7+1);
															$hide_val_m[]=$key5;
														?>
														<tr>
															<td>
																<label class="position-relative">
																	<input type="hidden" id="value_id_<?php echo $key5; ?>" name="value_id_<?php echo $key5; ?>" value="<?php echo $question_lang['value_id']; ?>"/>
																	<input type="checkbox" id="qma<?php echo $key5; ?>" value="answer_rad_<?php echo $key5; ?>" name="chkbox_<?php echo $key5; ?>" <?php echo $check=($question_lang['correct_flag']=="Y")?"checked='checked'":""; ?> style="padding-right:30px;">
																	<span class="lbl"></span>
																</label>
															</td>

															<td>
															<div style="overflow-x:auto;">
															<textarea class='summernote' name="answer_chk_<?php echo $key5; ?>" id="q6a<?php echo $key5; ?>" /><?php echo $question_lang['text'];?></textarea></div>
																<!--<input type="text" value="" maxlength="300" class="largetext" name="answer_rad_1" id="qart1" style="width:220px;">-->
															</td>
															<?php
															$ques_lan=UlsLangQuestionValues::get_all_lang_values($question_lang['value_id']);
															foreach($ques_lan as $ques_langs){
															?>
															<td>
																	
																<input type="hidden" name="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>">
																<input type="hidden" name="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>">
																<input type="hidden" name="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>">
																<div style="overflow-x:auto;">
																	<textarea class='summernote' name="answer_chk_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="q6a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>"/><?php echo isset($ques_langs['text'])?$ques_langs['text']:""; ?></textarea>
																	
																</div>
															</td>
															<?php 
															} 
															?>
															
														</tr>
														<?php
														}
														$hidden_m=@implode(',',$hide_val_m);
													}
													else{
														$hidden_m=1;
													?>
														<tr>
															<td>
																<label class="position-relative">
																	<input type="hidden" id="value_id_1"  name="value_id_1" value=""/>
																	<input type="checkbox" id="qma1" value="1" name="chkbox_1" checked="checked" style="padding-right:30px;">
																	<span class="lbl"></span>
																</label>
															</td>

															<td>
															<div style="overflow-x:auto; ">
															<textarea class='summernote' name="answer_chk_1" id="q6a1" /></textarea></div>
																<!--<input type="text" value="" maxlength="300" class="largetext" name="answer_rad_1" id="qart1" style="width:220px;">-->
															</td>
															<?php 
															if(!empty($ques_lang_n)){
															foreach($ques_lang_n as $ques_langs){
															?>
															<td >
																	
																<input type="hidden" name="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>">
																<input type="hidden" name="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>">
																<input type="hidden" name="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>">
																<div style="overflow-x:auto;">
																	<textarea class='summernote' name="answer_chk_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="q6a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1"/></textarea>
																	<!--<input type="text" value="" maxlength="300" class="largetext" name="answer_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="qart_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" style="width:220px;">-->
																</div>
															</td>
															<?php 
															}
															}
															?>
														</tr>
													<?php } ?>
												</tbody>
											</table>
											<input type="hidden" name="addgroup_multiple" id="addgroup_multiple" value="<?php echo $hidden_m; ?>" />
											</div>
											<br style="clear:both">
											<div class="panel-heading hbuilt">
												<div class="pull-left">
													<input type="button"  class="btn btn-xs btn-primary" onclick="multiple_multple_choice_new()" name="multiple_single" id="multiple_single" value="Add" />
													<input type="button" class="btn btn-xs btn-danger"  onclick="deletemultiple_multple_new()" name="delete" id="add" value="Delete" />
												</div>
											</div>
											
											<?php
											} 
											if(trim($qtype)=='P'){
											?>
											<?php
											$ques_m=($qtype=='P'?"Multiple":"");
											?>
											<div class="panel-heading hbuilt">
												<h6 class="panel-title txt-dark">Please add priority wise Response.</h6>
												
											</div>
											<div class="alert alert-warning">
												<strong>Select the correct response</strong>
											</div>
											
											<div class="table-responsive">
											<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="radio7Tab">
												<thead>
													<th >
														Correct Answer
													</th>
													<th  >English</th>
													<?php 
													foreach($ques_lang_n as $ques_langs){
													?>
													<th  class="center"><?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?></th>
													<?php } ?>
													
												</thead>
												<tbody>
													<?php
													
													if(count($questions)>0){
														$hide_val_m=array();
														foreach($questions as $key7=>$question_lang){
															$key5=($key7+1);
															$hide_val_m[]=$key5;
														?>
														<tr>
															<td>
																<label class="position-relative">
																	<input type="hidden" id="value_id_<?php echo $key5; ?>"  name="value_id_<?php echo $key5; ?>" value="<?php echo $question_lang['value_id']; ?>"/>
																	<input type="checkbox" id="qma<?php echo $key5; ?>" value="answer_rad_<?php echo $key5; ?>" name="chkbox_<?php echo $key5; ?>" <?php echo $check=($question_lang['correct_flag']=="Y")?"checked='checked'":""; ?> style="padding-right:30px;">
																	<span class="lbl"></span>
																</label>
															</td>

															<td >
															<div style="overflow-x:auto;" >
															<textarea class='summernote' name="answer_chk_<?php echo $key5; ?>" id="q7a<?php echo $key5; ?>" /><?php echo $question_lang['text'];?></textarea></div>
																<!--<input type="text" value="" maxlength="300" class="largetext" name="answer_rad_1" id="qart1" style="width:220px;">-->
															</td>
															<?php
															$ques_lan=UlsLangQuestionValues::get_all_lang_values($question_lang['value_id']);
															foreach($ques_lan as $ques_langs){
															?>
															<td>
																	
																<input type="hidden" name="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>">
																<input type="hidden" name="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>">
																<input type="hidden" name="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" value="<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>">
																<div style="overflow-x:auto;" >
																	<textarea class='summernote' name="answer_chk_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>" id="q7a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_<?php echo $key5; ?>"/><?php echo isset($ques_langs['text'])?$ques_langs['text']:""; ?></textarea>
																	
																</div>
															</td>
															<?php 
															} 
															?>
															
														</tr>
														<?php
														}
														$hidden_m=@implode(',',$hide_val_m);
													}
													else{
														$hidden_m=1;
													?>
														<tr>
															<td>
																<label class="position-relative">
																	<input type="hidden" id="value_id_1" name="value_id_1" value=""/>
																	<input type="checkbox" id="qma1" value="1" name="chkbox_1" checked="checked" style="padding-right:30px;">
																	<span class="lbl"></span>
																</label>
															</td>

															<td >
															<div style="overflow-x:auto; ">
															<textarea class='summernote' name="answer_chk_1" id="q7a1" /></textarea></div>
																<!--<input type="text" value="" maxlength="300" class="largetext" name="answer_rad_1" id="qart1" style="width:220px;">-->
															</td>
															<?php 
															if(!empty($ques_lang_n)){
															foreach($ques_lang_n as $ques_langs){
															?>
															<td>
																	
																<input type="hidden" name="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="que_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['que_lang_id'])?$ques_langs['que_lang_id']:""; ?>">
																<input type="hidden" name="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="comp_lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['comp_lang_id'])?$ques_langs['comp_lang_id']:""; ?>">
																<input type="hidden" name="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="lang_id_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" value="<?php echo isset($ques_langs['lang_id'])?$ques_langs['lang_id']:""; ?>">
																<div style="overflow-x:auto;">
																	<textarea class='summernote' name="answer_chk_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="q7a_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1"/></textarea>
																	<!--<input type="text" value="" maxlength="300" class="largetext" name="answer_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" id="qart_<?php echo isset($ques_langs['language_name'])?$ques_langs['language_name']:""; ?>_1" style="width:220px;">-->
																</div>
															</td>
															<?php 
															}
															}
															?>
														</tr>
													<?php } ?>
												</tbody>
											</table>
											<input type="hidden" name="addgroup_priority" id="addgroup_priority" value="<?php echo $hidden_m; ?>" />
											</div>
											<div class="panel-heading hbuilt">
												<div class="pull-left">
													<input type="button"  class="btn btn-xs btn-primary" onclick="multiple_multple_priority_new()" name="multiple_priority" id="multiple_priority" value="Add" />
													<input type="button" class="btn btn-xs btn-danger"  onclick="deletemultiple_multple_new()" name="delete" id="add" value="Delete" />
												</div>
											</div>
											<?php
											}
											if($qtype=='FT'){
											?>
											<div class="panel-heading hbuilt">
												<h6 class="panel-title txt-dark">Free Text.</h6>
												
											</div>
											<div class="form-group"><label class="col-sm-3 control-label">Enter free text :</label>
												<div class="col-sm-5">
												<?php if(count($questions)>0){
														$hide_val_m=array();
														foreach($questions as $key7=>$question_lang){
															$key5=($key7+1);
															$hide_val_m[]=$key5; ?>
														<input type="hidden" id="value_id_<?php echo $key5; ?>"  name="value_id_<?php echo $key5; ?>" value="<?php echo $question_lang['value_id']; ?>"/>
														<textarea class='summernote' name="fillquestion[]" id="fillquestion" /><?php echo $question_lang['text'];?></textarea>
													<?php }
												} else{ ?>
													<input type="hidden" id="value_id_1"  name="value_id_1" value=""/>
													<textarea class='summernote' id="freetext" class='form-control' maxlength="1500" name="fillquestion[]"></textarea>
												<?php } ?>
												</div>
											</div>
											<?php 
											} ?>
										</div>
									</div>
								</div>
								<hr class="light-grey-hr">
								<div class="form-group">
									<div class="col-sm-offset-9">
										<input type="hidden" name="step1" value="1">
										<?php $hash=md5(SECRET.$_REQUEST['id']);?>
										<a class="btn btn-danger btn-sm" href="<?php echo BASE_URL; ?>/admin/question_creation?step1&type=<?php echo $_REQUEST['type']; ?>&qid=<?php echo !empty($_REQUEST['qid'])?$_REQUEST['qid']:""; ?>&id=<?php echo $_REQUEST['id']; ?>&hash=<?php echo $hash; ?>"><i class="fa fa-reply"></i> <span class="bold">Prev</span></a>
										<button class="btn btn-primary btn-sm" type="submit" name="tna_lang_save" id="tna_lang_save"><i class="fa fa-check"></i> Next</button>
									</div>
								</div>
								
							</form>
						</div>
						<?php
						$step3_a=isset($_REQUEST['step3'])?"active":"";
						?>
						<div id="step3" class="p-m tab-pane <?php echo $step3_a; ?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="panel-heading hbuilt">
											<h6 class="txt-dark capitalize-font"><?php echo isset($question['qname'])?$question['qname']:""; ?></h6>
										</div>
										<div class="panel-body no-padding">
											<table class="table table-hover table-bordered mb-0">
												<tbody>
														
												<?php
												if(!empty($questions)){
												if(count($questions)>0){
													foreach($questions as $key6=>$question_lang){
														$type=($qtype=='M')?"checkbox":"radio"; ?>
														<tr>
															<td style="width:2%"><label class="control-label mb-10 text-left"><input type="<?php echo $type; ?>" <?php echo $check=($question_lang['correct_flag']=="Y")?"checked='checked'":""; ?> disabled></label>
															</td><td><?php echo str_replace(array("\\\\","\\r\\n"),array("\\","<br>"),$question_lang['text']);?></td>
															<?php	
															if(count($ques_lang_n)>0){
																foreach($ques_lang_n as $ques_langs){
																	$ques_lan=UlsLangQuestionValues::get_all_lang_values_single($question_lang['value_id'],$ques_langs['lang_id']);
																	?>
																	<td><?php echo $ques_lan['text'];?></td>
																<?php
																}
															}
															?>
														</tr>
													<?php }
												}
												}?>
												</tbody>
											</table>
										</div>
										<?php 
										/*if(!empty($ques_lang_n)){
										foreach($ques_lang_n as $ques_langs){
										?>
										<div class="panel-heading hbuilt">
											<?php echo isset($ques_langs['question_name'])?$ques_langs['question_name']:""; ?>
										</div>
										<div class="panel-body no-padding">
											<table class="table table-hover table-bordered mb-0">
												<tbody>
												<?php
												$question_lang=UlsLangQuestionValues::get_all_lang_details($ques_langs['comp_lang_id']);
												if(count($question_lang)>0){
													foreach($question_lang as $question_langs){
													?>
													<tr>
														
														<td><?php echo $question_langs['text'];?></td>
													</tr>
													<?php }
												}?>
												</tbody>
											</table>
										</div>
										<?php
										}
										}*/
										?>
									</div>
								</div>
							</div>
							<form method="post" action="<?php echo BASE_URL?>/admin/comp_question_insert_step_three">
							<input type="hidden" name="ques_id" id="ques_id" value="<?php echo !empty($_REQUEST['qid'])?$_REQUEST['qid']:""; ?>">
							<?php $hash=md5(SECRET.$_REQUEST['id']);?>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
								<a class="btn btn-danger btn-sm" href="<?php echo BASE_URL; ?>/admin/question_creation?step2&type=<?php echo $_REQUEST['type']; ?>&qid=<?php echo !empty($_REQUEST['qid'])?$_REQUEST['qid']:""; ?>&id=<?php echo $_REQUEST['id']; ?>&hash=<?php echo $hash; ?>"><i class="fa fa-reply"></i> <span class="bold">Prev</span></a>
								<button class="btn btn-primary btn-sm" type="submit" name="tna_publish_save" id="tna_publish_save"><i class="fa fa-check"></i> Publish</button>
							   
								</div>
							</div>
							</form>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

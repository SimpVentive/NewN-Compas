<style>
.formError {
	position:relative !important;
}

</style>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<form action='<?php echo BASE_URL;?>/employee/employee_test_beh' method='post' name='instrumentTest' id='instrumentTest' style="position:relative;">
				<input type='hidden' name='instrument_id' id='instrument_id' value="<?php echo $_REQUEST['instrument_id'];?>" />
				<input type='hidden' name='testid' id='testid' value="<?php echo $ass_details['test_id'];?>" />
				<input type='hidden' name='assid' id='assid' value="<?php echo $ass_details['assessment_id'];?>" />
				<input type='hidden' name='empid' id='empid' value="<?php echo $_SESSION['emp_id'];?>" />
				<input type='hidden' name='ttype' id='ttype' value="<?php echo $ass_details['assessment_type'];?>" /> 
				<input type='hidden' name='ass_test_id' id='ass_test_id' value="<?php echo $ass_details['assess_test_id'];?>"/>
				<input type='hidden' name='timeconsume' id='timeconsume' value='Y' />
				<input type='hidden' name='jid' id='jid' value='<?php echo $_REQUEST['jid']; ?>' />
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">assignment_turned_in</div>
							<div class="test-info">
								<div class="test-name">Instrument </div>
								<p class="test-content red-text">*Please give answers to all questions.</p>
							</div>
						</div>
						<?php
						if(!empty($ass_lang)){
							foreach($ass_lang as $ass_langs){
						?>
						<script>
						var lan="<?php echo $ass_langs['lang_id'];?>";
						 function view_language(){
							var lang=document.getElementById("lang_select").value;
							if(lang==""){
								$(".language").show();
								$(".language"+lan).hide();
								$(".language_d").show();
								$(".language_d"+lan).hide();
							}
							else{
								$(".language").hide();
								$(".language"+lan).show();
								$(".language_d").hide();
								$(".language_d"+lan).show();
							}
						 }
						</script>
						<?php 
							}
						}
						?>
						<!--<div class="time-head">
							<div class="">Select language</div>
							<div class="time-info">
								<select name="lang_select" id="lang_select" class="form-control" onchange="view_language();">
									<option value="">English</option>
									<?php 
									foreach($ass_lang as $ass_langs){
									?>
									<option value="<?php echo $ass_langs['lang_id'];?>"><?php echo $ass_langs['lang_name'];?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>-->
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->
				<?php 
				$instrumenttype=UlsMenu::callpdorow("SELECT * FROM `uls_be_instruments` where instrument_id=".$_REQUEST['instrument_id']);
				?>
				<div class="space-40"></div>
				<p><h6 class='panel-title'>About the Instrument:</h6><?php echo $instrumenttype['instrument_description'];?></p>
				<p><h6 class='panel-title'>Instructions:</h6><?php echo $instrumenttype['instrument_instruction'];?></p>

				<!-- TEST BODY :BEGIN -->
				<div class='test-body'>
				<?php
				$valid='required';
				$data="";
				$respvals=array();
				if(count($testdetails)>0){
					if($instrumenttype['instrument_type']=='BEI_RATING_SINGLE'){
						foreach($testdetails as $keys=>$testdetail){
							$key=$keys+1; 
							$var=($key==1)?"block":"none";
							$data.="
								<div class='case-question-box'>
									<div class='number'>".$key."</div>
									<div class='case-details'>
										<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['ins_subpara_id']."' >
										<input type='hidden' id='par_question_".$key."' name='par_question[".$key."]'  value='".$testdetail['ins_para_id']."' >
										<input type='hidden' name='qtype' id='qtype_". $key."' value=".$testdetail['instrument_type']." />
										<input type='hidden' name='testid' id='testid' value=".$testdetail['assess_test_id']." />
										<input type='hidden' name='instrument_id' id='instrument_id' value=".$testdetail['instrument_id']." />
										<input type='hidden' name='instrument_scale' id='instrument_scale' value=".$testdetail['instrument_scale']." />
										<div class='d-flex align-items-center justify-content-between'>
											<label class='language name' style='font-size:16px;'>".$testdetail['ins_subpara_text']."</label>";
											if(!empty($ass_lang)){
												foreach($ass_lang as $ass_langs){
													$data.="<label class='language".$ass_langs['lang_id']."' style='display:none;font-size:16px;'>".$testdetail['ins_subpara_text_lang']."</label>";
												}
											}
										$data.="</div>
										<div class='d-flex align-items-center justify-content-between'>
											";
											$ss=UlsBeInsRatScaleValues::rating_value($testdetail['instrument_scale']);
											foreach($ss as $key1=>$sss){
											$data.="<div class='radio-group'>
												<input type='radio' value='".$sss['ins_rat_scale_value_number']."' name='answer_".$key."[]' id='answer_".$key ."_".$key1."' class='validate[".$valid."] radio-control'>
												<label for='answer_".$key ."_".$key1."' class='radio-label'>".$sss['ins_rat_scale_value_name']."</label>
											</div>";
											}
										$data.="</div>
									</div>
								</div>";
						}
						$data.="<div class='panel-footer borders'>
							<div class='pull-right'>
								<div class='btn-group'>
									<button class='btn btn-success' onclick='click_submit();' id='submit_ass'>Submit</button>
								</div>
							</div>
						</div>";
					}
					else if($instrumenttype['instrument_type']=='BEI_RATING_TWO'){
						$data.="<table width='100%' class='table '>";
						foreach($testdetails as $keys=>$testdetail){
							$key=$keys+1; 
							$var=($key==1)?"block":"";//<div style='display:".$var.";' id='question_list".$key."' class='open_question_div' >
							$data.="
								
								<tr>
									<td>".$key."</td>
									<td width='35%'>
										<div class='language'>".$testdetail['ins_subpara_text']."</div>";
										if(!empty($ass_lang)){
											foreach($ass_lang as $ass_langs){
												$data.="<div class='language".$ass_langs['lang_id']."' style='display:none;'>".$testdetail['ins_subpara_text_lang']."</div>";
											}
										}
										$data.="
										<input type='hidden' id='question_".$key."' name='question[".$key."]'  value='".$testdetail['ins_subpara_id']."' >
										<input type='hidden' id='par_question_".$key."' name='par_question[".$key."]'  value='".$testdetail['ins_para_id']."' >
										<input type='hidden' name='qtype' id='qtype_". $key."' value=".$testdetail['instrument_type']." />
										<input type='hidden' name='testid' id='testid' value=".$testdetail[	'assess_test_id']." />
										<input type='hidden' name='instrument_id' id='instrument_id' value=".$testdetail['instrument_id']." />
										<input type='hidden' name='instrument_scale' id='instrument_scale' value=".$testdetail['instrument_scale']." />
										
									</td>
									<td>
										<div class=''><label  for='truefalse'> <input type='radio' class='validate[".$valid."]' value='".$testdetail['subpara_left']."' name='answer_".$key."[]' id='answer_".$testdetail['ins_subpara_id']."_".$key."_1'> Statement 1</label></div>
									</td>
									<td>
										<div class=''><label  for='truefalse'> <input type='radio' class='validate[".$valid."]' value='".$testdetail['subpara_right']."' name='answer_".$key."[]' id='answer_".$testdetail['ins_subpara_id']."_".$key."_2'> Statement 2</label></div>
									</td>
									<td width='35%'><div class='language'>".$testdetail['ins_subpara_text_ext']."</div>";
										if(!empty($ass_lang)){
											foreach($ass_lang as $ass_langs){
												$data.="<div class='language".$ass_langs['lang_id']."' style='display:none;'>".$testdetail['ins_subpara_text_ext_lang']."</div>";
											}
										}
									$data.="</td>
								</tr>";
								
								
						}
						$data.="</table>";
						$data.="<div class='panel-footer borders' style='display:".$var.";padding: 6px 22px 40px;' id='question_button". $key."'>";
						$count=count($testdetails);
						$data.="<div class='pull-right'>
							<div class='btn-group'>";
							
							if($key==$count){
								$data.="<button class='btn btn-success' onclick='click_submit();' id='submit_ass'>Submit</button>";
							}
							$data.="</div>";
							//</div>
							$data.="</div>";
					}
				}
				echo $data;
				?>
				</div>
				</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>
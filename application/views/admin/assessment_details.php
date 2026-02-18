<style>
.col-sm-1n {
    width: 1.733%;
}
.col-sm-1 {
    width: 10%;
}
.col-sm-2n {
    width: 10.667%;
}
.vertical-pills .tab-content {
    overflow: hidden;
    padding-left: 0;
}
.nav-pills > li > a {
    border: medium none;
    border-radius: 0;
    color: #878787;
    margin: 0;
    padding: 10px 5px;
    text-transform: capitalize;
}

</style>
<script>
<?php
// To pass the Locations Details to empcreation.js File
    $statusdata='';
    foreach($status as $statuss){
        if($statusdata==''){
            $statusdata=$statuss['code']."*".$statuss['name'];
        }
        else{
            $statusdata=$statusdata.",".$statuss['code']."*".$statuss['name'];
        }
    }
    echo "var status_val='".$statusdata."';";
?>

</script>
<div class="content">
    <div class="row">
        <div class="col-lg-12">			
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<h3><?php echo @$compdetails['assessment_name']; ?> <small>(<?php echo @$compdetails['assessmentstatus']; ?>)</small></h3>
					<div class="col-lg-12">
                        <p>
						<?php echo @$compdetails['assessment_desc']; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			
			<div class="col-lg-12 panel panel-default card-view">
				<div  class="pills-struct vertical-pills">
					<ul role="tablist" class="nav nav-pills ver-nav-pills" id="myTabs_10">
						<?php $j=0; foreach($positions as $position){ 
							if(isset($_REQUEST['pos_id'])){
								if($position['position_id']==$_REQUEST['pos_id']){
									$class="active";
								}
								else{
									$class=""; 
								}
							}
							else{
								$class=($j==0)?"active":""; 
							}
							
							$j++;?>
							<li class="<?php echo $class; ?>"><a data-toggle="tab" href="#tab-<?php echo $position['position_id']; ?>"> <?php echo $position['position_name']; ?></a></li>
						<?php } ?>
					</ul>
					<div class="tab-content" id="myTabContent_10">
						<?php $i=0; 
						foreach($positions as $position){ 
							if(isset($_REQUEST['pos_id'])){
								if($position['position_id']==$_REQUEST['pos_id']){
									$classs="active";
								}
								else{
									$classs=""; 
								}
							}
							else{
								$classs=($i==0)?"active":""; 
							}
							$i++;
							$ass_position=UlsAssessmentPosition::get_assessment_position_info($position['position_id'],$compdetails['assessment_id']);
							?>
						<div id="tab-<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $classs; ?>">
							<div class="">
								<div class="row">
									<div class="col-lg-12">
										<div class="">
											<?php
											$tab_5=!empty($_REQUEST['tab'])?($_REQUEST['tab']==5?"active":""):"";
											$tab_4=!empty($_REQUEST['tab'])?($_REQUEST['tab']==4?"active":""):"";
											$tab_1=!empty($_REQUEST['tab'])?($_REQUEST['tab']==1?"active":""):$classs;
											$tab_2=!empty($_REQUEST['tab'])?($_REQUEST['tab']==2?"active":""):"";
											$tab_3=!empty($_REQUEST['tab'])?($_REQUEST['tab']==3?"active":""):"";
											$tab_6=!empty($_REQUEST['tab'])?($_REQUEST['tab']==6?"active":""):"";
											$tab_7=!empty($_REQUEST['tab'])?($_REQUEST['tab']==7?"active":""):"";
											$tab_8=!empty($_REQUEST['tab'])?($_REQUEST['tab']==8?"active":""):"";
											$tab_9=!empty($_REQUEST['tab'])?($_REQUEST['tab']==9?"active":""):"";
											?>
											<ul class="nav nav-pills" id="myTabs_6">
												<li class="<?php echo $tab_1; ?>"><a data-toggle="tab" href="#tab-compentencies<?php echo $position['position_id']; ?>">Competencies</a></li>
												<li class="<?php echo $tab_4; ?>"><a data-toggle="tab" href="#tab-assessments<?php echo $position['position_id']; ?>">Assessments</a></li>
												<li class="<?php echo $tab_2; ?>"><a data-toggle="tab" href="#tab-employees<?php echo $position['position_id']; ?>"> Employees</a></li>
												<li class="<?php echo $tab_2; ?>"><a data-toggle="tab" href="#tab-assessors<?php echo $position['position_id']; ?>">Assessor</a></li>
												<li class="<?php echo $tab_7; ?>"><a data-toggle="tab" href="#tab-setting<?php echo $position['position_id']; ?>">Settings</a></li>
												<li class="<?php echo $tab_5; ?>"><a data-toggle="tab" href="#tab-tnicomp<?php echo $position['position_id']; ?>">TNI Competencies</a></li>
												<li class="<?php echo $tab_6; ?>"><a data-toggle="tab" href="#tab-tniemp<?php echo $position['position_id']; ?>">TNI Employees</a></li>
												<li class="<?php echo $tab_8; ?>"><a data-toggle="tab" href="#tab-compweight<?php echo $position['position_id']; ?>">Competencies Weightage update</a></li>
												<li class="<?php echo $tab_9; ?>"><a data-toggle="tab" href="#tab-empcompsel<?php echo $position['position_id']; ?>">Employee Competency Selection</a></li>
											</ul>
											<div class="tab-content " id="myTabContent_6">
												<?php $tab_a1=!empty($_REQUEST['tab'])?($_REQUEST['tab']==1?"active":""):""; ?>
												<div id="tab-compentencies<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a1; ?>" style="padding-left: 0px;">
													<form id="case_master<?php echo $position['position_id']; ?>" action="<?php echo BASE_URL;?>/admin/assessment_competency_insert" method="post" enctype="multipart/form-data">
													<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
													<input type="hidden" name="position_id" id="position_id" value="<?php echo $position['position_id']; ?>">
														<div class="panel-body">
															<div class="table-responsive">
																<table id="comp_assess<?php echo $position['position_id']; ?>" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																	<thead>
																	<tr>
																		<th class="col-sm-1n">Select</th>
																		<th class="col-sm-1n">Category</th>
																		<th class="col-sm-3">Competencies</th>
																		<!--<th class="col-sm-2">Level</th>-->
																		<th class="col-sm-2n">Criticality</th>
																		<th class="col-sm-2">Scale</th>
																		<th class="col-sm-2">Method</th>
																		<th class="col-sm-1">Que Count</th>
																		<th class="col-sm-2">Alt Scale</th>
																		<th class="col-sm-2">weightage</th>
																	</tr>
																	</thead>
																	<tbody>
																	<?php /*onchange='open_assessment_weightage(<?php echo $key;?>,<?php echo $_REQUEST['id'];?>);'*/?>
																	<?php
																	$qcount=$qtypes=array();
																	$testtypes=UlsAdminMaster::get_value_names("ASSESSMENT_TYPE");
																	$questionsbanks=UlsCompetencyPositionRequirements::getcompetencypositionqb($position['position_id']);
																	foreach($questionsbanks as $questionsbank){
																		foreach($testtypes as $testtype){
																			if($testtype['code']==$questionsbank['type']){
																				$id=$questionsbank['comp_def_id'];
																				$sid=$questionsbank['scale_id'];
																				$type=$testtype['code'];
																				$qtypes[$id][$sid][$type]=isset($qtypes[$id][$sid][$type])?$qtypes[$id][$sid][$type]+1:1;
																				$qcount[$id][$sid][$type]['q']=isset($qcount[$id][$sid][$type]['q'])?$qcount[$id][$sid][$type]['q']+$questionsbank['qcount']:$questionsbank['qcount'];
																			}
																		}
																	}
																	$test=array();
																	$posdetails=UlsCompetencyPositionRequirements::competencypositionrequirement_details($position['position_id'],$_REQUEST['id']);
																	$total_que=0;
																	$total_we=0;
																	$temp="";
																	if(count($posdetails)>0){
																	foreach($posdetails as $key1=>$posdetail){
																		$total_que+=$posdetail['assessment_que_count'];
																		$total_we+=$posdetail['pos_com_weightage'];
																		$id=$posdetail['comp_def_id'];
																		$sid=$posdetail['scale_id'];
																		$key=$key1+1;
																		
																		if($posdetail['comp_position_id']==$position['position_id']){
																			$aa="";
																			if(isset($qtypes[$id][$sid]['COMP_INTERVIEW'])){
																				$aa.=$qtypes[$id][$sid]['COMP_INTERVIEW']." (".$qcount[$id][$sid]['COMP_INTERVIEW']['q'].") <i class='fa fa-info-circle ' aria-hidden='true' data-toggle='tooltip' title='Interview Question Bank'></i>&nbsp;&nbsp;&nbsp;";
																			}
																			
																			if(isset($qtypes[$id][$sid]['COMP_TEST'])){
																				$aa.=$qtypes[$id][$sid]['COMP_TEST']." (".$qcount[$id][$sid]['COMP_TEST']['q'].") <i class='fa fa-question' aria-hidden='true' data-toggle='tooltip' title='MCQ Question Bank'></i>&nbsp;&nbsp;&nbsp;";
																			}
																			
																			$check=!empty($posdetail['assessment_pos_comp_id'])?"checked='checked'":(!empty($posdetail['type'])?"":"disabled");
																			?>
																			<tr>
																			<td><input type='checkbox' name='check_position[<?php echo $posdetail['comp_def_id'];?>]' id='check_position_<?php echo $position['position_id'].'_'.$key;?>'  <?php echo $check;?> value='<?php echo $posdetail['comp_def_id'];?>' class="validate[required]" >
																			<input type='hidden' name='assessment_pos_comp_id[<?php echo $posdetail['comp_def_id'];?>]' id='assessment_pos_comp_id[]' value='<?php echo $posdetail['assessment_pos_comp_id'];?>'>
																			<input type='hidden' name='assessment_pos_id[<?php echo $posdetail['comp_def_id'];?>]' id='assessment_pos_id[]' value='<?php echo $posdetail['assessment_pos_id'];?>'>
																			<?php /*<input type='hidden' name='assessment_type[]' id='ass_type_<?php echo $key;?>' value='<?php echo $posdetail['type'];?>'>*/ ?>
																			<input type='hidden' name='assessment_pos_level_id[<?php echo $posdetail['comp_def_id'];?>]' id='assessment_pos_level_id[]' value='<?php echo $posdetail['level_id'];?>'>
																			<input type='hidden' name='assessment_pos_level_scale_id[<?php echo $posdetail['comp_def_id'];?>]' id='assessment_pos_level_scale_id[]' value='<?php echo $posdetail['scale_id'];?>'>
																			<input type='hidden' name='assessment_pos_com_id[]' id='assessment_pos_com_id[]' value='<?php echo $posdetail['comp_def_id'];?>'>
																			</td>
																			<td>
																			<?php
																			if($temp!=$posdetail['name']){
																				echo $posdetail['name'];
																				$temp=$posdetail['name'];
																			}
																			?>
																			</td>
																			<td><?php echo $posdetail['comp_def_name'];?></td>
																			<td><?php echo $posdetail['comp_cri_name'];?></td>
																			
																			<td><?php echo $posdetail['scale_name'];?> </td>
																			<td>
																				<table>
																					<tr>
																					<?php echo $aa;?>
																					</tr>
																					<tr>
																					<?php
																					
																					//echo "<br>".$posdetail['assessment_type'];
																					if(!empty($posdetail['type'])){
																					$a_type=explode(",",$posdetail['type']);
																					foreach($a_type as $key_g=>$a_types){
																						$comp_atype=isset($posdetail['assessment_type'])?explode(",",$posdetail['assessment_type']):array();
																						
																						$program_sel=in_array($a_types,$comp_atype)?"checked='checked'":"";
																						$program_sel=!empty($posdetail['assessment_pos_comp_id'])?(count($comp_atype)==0?"checked='checked'":$program_sel):"";
																						?>
																						<td style='padding-right:15px;'>
																						<input type='checkbox' name='assessment_type[<?php echo $posdetail['comp_def_id'];?>][]' id='assessment_type_<?php echo $position['position_id'].$key;?>' value='<?php echo $a_types;?>' class='open_<?php echo $a_types;?>_<?php echo $position['position_id'].'_'.$key;?> comp_<?php echo $position['position_id'].'_'.$key;?>_<?php echo $posdetail['comp_def_id'];?>'  onclick="open_class_ass('<?php echo $a_types;?>','<?php echo $position['position_id'].'_'.$key;?>','<?php echo $posdetail['comp_def_id'];?>')" <?php echo $program_sel; ?>>
																						<?php echo $a_types;?> </td>			
																					<?php	
																					}
																					}
																					?>
																					
																		
		<script type="text/javascript" >
		$(document).ready(function(){	
			$("#case_master<?php echo $position['position_id']; ?>").bind("jqv.form.validating", function(event){
				var fieldsWithValue1 = $('input[id="assessment_type_<?php echo $position['position_id'].$key;?>"]').filter(function(){
				   if($(this).prop("checked")){
						return true;
					}
				});
				if(fieldsWithValue1.length<1){
					$('input[id="assessment_type_<?php echo $position['position_id'].$key;?>"]').addClass('validate[required,funcCall[requiredOneOfGroup1]]');
				}
			});

			$("#case_master<?php echo $position['position_id']; ?>").bind("jqv.form.result", function(event, errorFound){
				$('input[id="assessment_type_<?php echo $position['position_id'].$key;?>"]').removeClass('validate[required,funcCall[requiredOneOfGroup1]]');
			});
		});

		function requiredOneOfGroup1(field, rules, i, options){
			var fieldsWithValue = $('input[id="assessment_type_<?php echo $position['position_id'].$key;?>"]').filter(function(){
				   if($(this).prop("checked")){
						return true;
					}
			});
			if(fieldsWithValue.length<1){
				return "Please select At least one option.";
			}
		}
		</script>		
																					</tr>
																				</table>
																			</td>
																			<td><input type="text" class="validate[required,custom[number]] form-control txtCal<?php echo $position['position_id']?>" name="assessment_que_count[<?php echo $posdetail['comp_def_id'];?>]" id="assessment_que_count_<?php echo $position['position_id']?>_<?php echo $posdetail['comp_def_id'];?>" value="<?php echo isset($posdetail['assessment_que_count'])?$posdetail['assessment_que_count']:"";?>"></td>
																			<td>
																			<?php 
																			if($posdetail['scale_number']!=1){?>
																			<select name="assessment_scale_id[<?php echo $posdetail['comp_def_id'];?>]" id="assessment_scale_id_<?php echo $position['position_id']?>_<?php echo $posdetail['comp_def_id'];?>" style="width:100%;" class="form-control m-b" onchange="open_questioncount(<?php echo $position['position_id']?>,<?php echo $posdetail['comp_def_id'];?>);">
																				<option value="">Select</option>
																				<?php
																				$scaledetails=UlsLevelMasterScale::levelscale(isset($posdetail['level_id'])?$posdetail['level_id']:"");
																				foreach($scaledetails as $scaledetail){
																					if($posdetail['scale_number']>$scaledetail['scale_number']){
																						$method_sels=isset($posdetail['assessment_scale_id'])?($posdetail['assessment_scale_id']==$scaledetail['scale_id'])?"selected='selected'":"":"";?>
																						<option value="<?php echo $scaledetail['scale_id']; ?>"  <?php echo $method_sels; ?>><?php echo $scaledetail['scale_name'];?></option>
																				<?php
																					}
																				}
																				?>
																			</select>
																			<?php 
																			$scale_count="";
																			if(!empty($posdetail['assessment_scale_id'])){
																				$scale_count=UlsQuestionbank::get_questions_scale_count($posdetail['comp_def_id'],$posdetail['assessment_scale_id']);
																				$scale_count=count($scale_count);
																			}
																			else{
																				$scale_count=0;
																			}
																			?>
																			<label id="scale_count_<?php echo $position['position_id']?>_<?php echo $posdetail['comp_def_id'];?>"># of Questions:<?php echo $scale_count; ?> </label>
																			<?php } ?>
																			</td>
																			<td><input type="text" class="validate[required,custom[number],min[1]] form-control txtCal_weight<?php echo $position['position_id']?>" name="pos_com_weightage[<?php echo $posdetail['comp_def_id'];?>]" id="pos_com_weightage<?php echo $position['position_id']?>_<?php echo $posdetail['comp_def_id'];?>" value="<?php echo isset($posdetail['pos_com_weightage'])?$posdetail['pos_com_weightage']:"";?>"></td>
																		</tr>
																		<?php
																		}
																	}
																	}
																	?>
																	<script type="text/javascript" >
																	$(document).ready(function () {
       
																		$("#comp_assess<?php echo $position['position_id']; ?>").on('input', '.txtCal<?php echo $position['position_id']?>', function () {
																		   var calculated_total_sum = 0;
																		 
																		   $("#comp_assess<?php echo $position['position_id']; ?> .txtCal<?php echo $position['position_id']?>").each(function () {
																			   var get_textbox_value = $(this).val();
																			   if ($.isNumeric(get_textbox_value)) {
																				  calculated_total_sum += parseFloat(get_textbox_value);
																				  }                  
																				});
																				  $("#total_sum_value<?php echo $position['position_id']; ?>").html(calculated_total_sum);
																		   });
																	});
																	
																	</script>
																	<tr>
																		<td colspan="6"></td>
																		<td>Total:<b><span style="font-size:16px;" id="total_sum_value<?php echo $position['position_id']; ?>"><?php echo !empty($total_que)?$total_que:"";?></span></b></td>
																		<td></td>
																		<td>Total Weight:<b><span style="font-size:16px;" id="total_sum_value_weight<?php echo $position['position_id']; ?>"><?php echo !empty($total_we)?$total_we:"";?></span></b></td>
																	</tr>
																	</tbody>
																</table>
															</div>
															<?php /*id="assessment_type_details" */ ?>
															<div>
																<div class='panel-heading hbuilt'>
																	You have selected he following competencies for assessment and provide the weightages
																</div>
																<div class='table-responsive'>
																	<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
																		<tbody>
																		<?php
																		$select_ass=array();
																		$weight=UlsAssessmentCompetenciesWeightage::getassessmentcompetencies_weightage($_REQUEST['id'],$position['position_id']);
																		$select_weight=array();
																		if(!empty($weight)){
																			foreach($weight as $weights){
																				$key=$weights['assessment_pos_weightage_id'];
																				$value=$weights['assessment_type'];
																				$weightage=$weights['weightage'];
																				$select_ass[$key]=$value;
																				$pid=$position['position_id'];
																				@$select_weight[$pid."-".$value]=$weightage;
																			}
																		}
																		
																		$posdetails=UlsCompetencyPositionRequirements::competencypositionrequirement_details($position['position_id'],$_REQUEST['id']);
																		$ass_test=$comp_id=array();
																		foreach($posdetails as $key1=>$posdetail){
																			if($posdetail['comp_position_id']==$position['position_id']){
																				$comp_id[]=$posdetail['comp_position_competency_id'];
																				if(!empty($posdetail['type'])){
																					$test=explode(",",$posdetail['type']);
																					foreach($test as $tests){
																						if(!in_array($tests,$ass_test)){
																							$pid=$position['position_id'];
																							$ass_test[$pid."-".$tests]=$tests;
																						}
																					}
																				}
																			}
																		}
																		
																		
																		foreach($ass_test as $key_m=>$ass_tests){
																			$val=array_search($ass_tests,$select_ass);
																			?>
																			<tr id="tr_<?php echo $ass_tests;?>_<?php echo $position['position_id'];?>" >
																				<td>
																				<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='<?php echo $val;?>'>
																				<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='<?php echo  $ass_tests; ?>'>
																				<?php echo $ass_tests; ?></td>
																				<td><input type='text' name='weightage[]' id='weightage[<?php echo $key_m; ?>]' class='form-control validate[required,custom[number]]' data-prompt-position="topLeft" value="<?php echo  !empty($select_weight[$key_m])?$select_weight[$key_m]:0; ?>" ></td>
																			</tr>
																			
																		<?php }
																		$inbasket_position=UlsInbasketMaster::viewinbasket_position($position['position_id']);
																		if(count($inbasket_position)>0){
																			$asstest="INBASKET";
																			$vals=array_search($asstest,$select_ass);
																			$keym=$position['position_id']."-".$asstest;
																			?>
																			
																			<tr id="tr_<?php echo $asstest;?>_<?php echo $position['position_id'];?>" >
																				<td>
																				<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='<?php echo $vals;?>'>
																				<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='<?php echo  $asstest; ?>'>
																				<?php echo $asstest; ?></td>
																				<td><input type='text' name='weightage[]' id='weightage[<?php echo $keym; ?>]' class='form-control validate[required,custom[number]]' data-prompt-position="topLeft" value="<?php echo  !empty($select_weight[$keym])?$select_weight[$keym]:0; ?>" ></td>
																			</tr>
																			<?php
																		}
																		//print_r($comp_id);
																		$comp_ids=implode(",",$comp_id);
																		$casestudy=UlsCaseStudyCompMap::getcasestudycompetencies_count($comp_ids);
																		//echo count($casestudy);
																		if(count($casestudy)>0){
																		$asstest="CASE_STUDY";
																		$asstest_name="CASE STUDY";
																		$vals=array_search($asstest,$select_ass);
																		$keym=$position['position_id']."-".$asstest;
																		?>
																		
																		<tr id="tr_<?php echo $asstest;?>_<?php echo $position['position_id'];?>" >
																			<td>
																			<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='<?php echo $vals;?>'>
																			<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='<?php echo  $asstest; ?>'>
																			<?php echo $asstest_name; ?></td>
																			<td><input type='text' name='weightage[]' id='weightage[<?php echo $keym; ?>]' class='form-control validate[required,custom[number]]' data-prompt-position="topLeft" value="<?php echo  !empty($select_weight[$keym])?$select_weight[$keym]:0; ?>" ></td>
																		</tr>
																		<?php
																		}
																		$comp_ids=implode(",",$comp_id);
																		$fishstudy=UlsFishboneCompMap::getfishbonecompetencies_count($comp_ids);
																		//echo count($casestudy);
																		if(count($fishstudy)>0){
																		$asstest="FISHBONE";
																		$asstest_name="FISHBONE STUDY";
																		$vals=array_search($asstest,$select_ass);
																		$keym=$position['position_id']."-".$asstest;
																		?>
																		
																		<tr id="tr_<?php echo $asstest;?>_<?php echo $position['position_id'];?>" >
																			<td>
																			<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='<?php echo $vals;?>'>
																			<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='<?php echo  $asstest; ?>'>
																			<?php echo $asstest_name; ?></td>
																			<td><input type='text' name='weightage[]' id='weightage[<?php echo $keym; ?>]' class='form-control validate[required,custom[number]]' data-prompt-position="topLeft" value="<?php echo  !empty($select_weight[$keym])?$select_weight[$keym]:0; ?>" ></td>
																		</tr>
																		<?php
																		}
																		if(count($instrument)>0){
																		$asstest_b="BEHAVORIAL_INSTRUMENT";
																		$asstest_bname="BEHAVORIAL INSTRUMENT";
																		$vals=array_search($asstest_b,$select_ass);
																		$keym=$position['position_id']."-".$asstest_b;
																		?>
																			
																		<tr id="tr_<?php echo $asstest_b;?>_<?php echo $position['position_id'];?>">
																			<td>
																			<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='<?php echo $vals;?>'>
																			<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='<?php echo  $asstest_b; ?>'>
																			<?php echo $asstest_bname; ?></td>
																			<td><input type='text' name='weightage[]' id='weightage[<?php echo $keym; ?>]' class='form-control validate[required,custom[number]]' data-prompt-position="topLeft" value="<?php echo  !empty($select_weight[$keym])?$select_weight[$keym]:0; ?>" ></td>
																		</tr>
																		<?php 
																		}
																		$feedback_position=UlsQuestionnaireMaster::viewfeedback_position($position['position_id']);
																		if(count($feedback_position)>0){
																			$asstest="FEEDBACK";
																			$vals=array_search($asstest,$select_ass);
																			$keym=$position['position_id']."-".$asstest;
																			?>
																			
																			<tr id="tr_<?php echo $asstest;?>_<?php echo $position['position_id'];?>" >
																				<td>
																				<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='<?php echo $vals;?>'>
																				<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='<?php echo  $asstest; ?>'>
																				<?php echo $asstest; ?></td>
																				<td><input type='text' name='weightage[]' id='weightage[<?php echo $keym; ?>]' class='form-control validate[required,custom[number]]' data-prompt-position="topLeft" value="<?php echo  !empty($select_weight[$keym])?$select_weight[$keym]:0; ?>" ></td>
																			</tr>
																			<?php
																		}
																		?>
																		<?php
																		$asstest="INTERVIEW";
																		$vals=array_search($asstest,$select_ass);
																		$keym=$position['position_id']."-".$asstest;
																		?>
																			
																			<tr id="tr_<?php echo $asstest;?>_<?php echo $position['position_id'];?>" >
																				<td>
																				<input type='hidden' name='assessment_pos_weightage_id[]' id='assessment_pos_weightage_id[]' value='<?php echo $vals;?>'>
																				<input type='hidden' name='assessment_type_weight[]' id='assessment_type[]' value='<?php echo  $asstest; ?>'>
																				<?php echo $asstest; ?></td>
																				<td><input type='text' name='weightage[]' id='weightage[<?php echo $keym; ?>]' class='form-control validate[required,custom[number]]' data-prompt-position="topLeft" value="<?php echo  !empty($select_weight[$keym])?$select_weight[$keym]:0; ?>" ></td>
																			</tr>
																			<?php
																		
																		?>
																		</tbody>
																	</table>
																	<script>
																	
																	function open_class_ass(class_id,pos_id,comp_id) {
																		var check_ass='input:checkbox.open_'+class_id+'_'+pos_id+':checked';
																		var check_comp='input:checkbox.comp_'+pos_id+'_'+comp_id+':checked';
																		var check_comp_class=$(check_comp).length;
																			  var hasil=pos_id.split('_');
																		var check_class=$('[class^=open_'+class_id+'_'+hasil[0]+']:checked').length;
																		if (check_class>0) {
																			$('#tr_'+class_id+'_'+hasil[0]).show();
																		} 
																		else {
																			//alert("hello");
																			  var hasil=pos_id.split('_');
																			$('#tr_'+class_id+'_'+hasil[0]).hide();
																		}
																		if (check_comp_class>0) {
																			//alert("hi");
																			$('#check_position_'+pos_id).attr('checked', true);
																		} 
																		else {
																			//alert("hello");
																			$('#check_position_'+pos_id).attr('checked', false);
																		} 
																	}
																	</script>
																</div>
															</div>
														</div>
														<?php 
														if($ass_position['assessment_broadcast']!='A'){
														?>
															<hr class="light-grey-hr">
															<div class="form-group">
																<div class="col-sm-offset-8">
																	<button class="btn btn-danger  btn-sm" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
																	<button class="btn btn-primary  btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
																</div>
															</div>
														<?php 
														} ?>
													</form>
												</div>
												<?php 
												$tab_a2=!empty($_REQUEST['tab'])?($_REQUEST['tab']==2?"active":""):""; ?>
												<div id="tab-employees<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a2;?>" style="padding-left: 0px;">
													<div class="panel-body">
														<form method="post" action="<?php echo BASE_URL;?>/admin/assessment_employee_insert" class="form-horizontal"  id="self_emp_enroll<?php echo $position['position_id']; ?>">
															<input type="hidden" name="assessment_id" id="assessment_id_employee_<?php echo $position['position_id']; ?>" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
															<input type="hidden" name="position_id" id="position_id_employee_<?php echo $position['position_id']; ?>" value="<?php echo $position['position_id']; ?>">
															<div class="form-group"><label class="col-sm-3 control-label">Employee Enrollment:</label>
																<div class="col-sm-5">
																	<select name="enroll_type" id="enroll_type_<?php echo $position['position_id']; ?>" onChange='enrolltype(<?php echo $position['position_id']; ?>,"full")'  class="form-control m-b">
																		<option value="">Select</option>
																		<option value="1">Single Enrollment</option>
																		<option value="2">Bulk Enrollment</option>
																	</select>
																</div>
															</div>
															<div class="table-responsive">
																<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																	<thead>
																		<tr>
																			<th>Employee Code</th>
																			<th>Employee name</th>
																			<th>Email-id</th>
																			<th>Location</th>
																			<th>Department</th>
																			<th>Position</th>
																		</tr>
																	</thead>
																	<tbody>
																	<?php
																	foreach($employees as $employee){														
																		if($employee['position_id']==$position['position_id']){
																			echo "<tr><td>".$employee['employee_number']."</td>
																			<td>".$employee['full_name']."</td>
																			<td>".$employee['email']."</td>
																			<td>".$employee['location_name']."</td>
																			<td>".$employee['org_name']."</td>
																			<td>".$employee['position_name']."</td></tr>";
																		}
																	} ?>
																	</tbody>
																</table>
															</div>
															<div id="enrollment_div_<?php echo $position['position_id']; ?>"></div>	
															<div id="bulk_enrollment_div_<?php echo $position['position_id']; ?>" style="display:none;"  >
																<h4 class='header blue bolder smaller'>Bulk Enrollment</h4>
																<div class='row'>
																	<div class='col-xs-12 col-sl-3'>
																		<div class='form-group'>
																			<div class='col-xs-12'>
																				<a href='<?php echo BASE_URL;?>/public/templates/bulk_assessment_template.csv' style='text-decoration:underline;color:#00F' id='bulk_template'>Click here</a> to download sample template
																			</div>
																		</div>
																	</div><br>
																	<div class='col-xs-12 col-sl-3'>
																		<div class='form-group'>
																			<div class='col-xs-3'>
																				<input type='file' name='upload' class="" id='bulkempupload<?php echo $position['position_id']; ?>'>&nbsp;&nbsp;<br>
																			</div>
																		</div>
																	</div>
																	<div class='col-xs-12 col-sl-3'>
																		<input type='button' class='btn btn-sm btn-success bulk_upload' dat="full" name='bulk_upload' id='<?php echo $position['position_id']; ?>' value='Upload'>
																	</div>
																</div>
																<br><br>
																<h4 class='header blue bolder smaller'>Employee Details</h4>
																<div id='bulk_search_data<?php echo $position['position_id']; ?>'>
																	<table id='single_enroll_tab' class='table table-striped table-bordered table-hover'>
																		<thead>
																			<tr>
																				<th>Employee Number</th>
																				<th>Employee Name</th>
																				<th>Department</th>
																				<th>Position</th>
																			</tr>
																		</thead>
																		<tr id='single_enroll0'>
																			<td style='padding-left:20px;'>
																			No Search Data Found</td>
																			<td align='left'>
																			<input type='hidden' name='employee_number[]' id='employee_number[0]' value=''/></td>
																			<td align='left'><input type='hidden' name='employee_name[]' id='employee_name[0]' value=''/></td>

																		</tr>
																	</table>
																</div>
															</div>
															<?php 
															$feedback=UlsAssessmentTest::assessment_test_feedback($_REQUEST['id'],$position['position_id']);
															if(count($feedback)>0){
															?>
															<div id="bulk_feedb_enrollment_div_<?php echo $position['position_id']; ?>"  >
																<h4 class='header blue bolder smaller'>Feedback Bulk Enrollment</h4>
																
																<div class='row'>
																	<div class='col-xs-12 col-sl-3'>
																		<div class='form-group'>
																			<div class='col-xs-12'>
																				<a href='<?php echo BASE_URL;?>/admin/feedback_assessment_template?id=<?php echo $_REQUEST['id']; ?>&pos_id=<?php echo $position['position_id']; ?>' style='text-decoration:underline;color:#00F' id='bulk_template'>Click here</a> to download sample template
																			</div>
																		</div>
																	</div><br>
																	<div class='col-xs-12 col-sl-3'>
																		<div class='form-group'>
																			<div class='col-xs-3'>
																				<input type='file' name='upload' class="" id='bulkempupload_feedback<?php echo $position['position_id']; ?>'>&nbsp;&nbsp;<br>
																			</div>
																		</div>
																	</div>
																	<div class='col-xs-12 col-sl-3'>
																		<input type='button' class='btn btn-sm btn-success bulk_upload_feedback' dat="full" name='bulk_upload' id='<?php echo $position['position_id']; ?>' value='Upload'>
																	</div>
																</div>
																<br><br>
																<h4 class='header blue bolder smaller'>Employee Details</h4>
																<div id='bulk_search_data_feedback<?php echo $position['position_id']; ?>'>
																	
																</div>
																<?php 
																$feedback_details=UlsAssessmentFeedEmployees::getfeed_assessment_details($_REQUEST['id'],$position['position_id']);
																if(count($feedback_details)>0){
																?>
																<div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
																	<?php
																	foreach($feedback_details as $key=>$feedback_detail){
																		$grouping_user=UlsAssessmentFeedEmployees::getfeed_assessment($_REQUEST['id'],$position['position_id'],$feedback_detail['employee_id']);
																		$seeker_status=UlsFeedbackEmployeeRating::seeker_status($grouping_user['group_id'],$feedback_detail['employee_id']);
																		if(!empty($seeker_status)){
																			if($seeker_status['status']=='C'){
																					$col="<span style='color:green'>Completed</span>";
																			}
																			elseif($seeker_status['status']=='W'){
																					$col="<span style='color:orange'>Inprocess</span>";
																				   
																			}	
																		}
																		else{
																			$col="<span style='color:red'>Not Started</span>";
																		}
																	?>
																	<div class="panel panel-default">
																		<div class="panel-heading activestate" role="tab" id="heading_10">
																			<a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_<?php echo $position['position_id'];?>_<?php echo $key; ?>" aria-expanded="true" ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div><?php echo $feedback_detail['employee_number']."-".$feedback_detail['full_name']; ?>-<?php echo $col; ?>
																			<?php
																			$ids="";
																			if(!empty($grouping_user['manager_id'])){
																					$ids=$grouping_user['manager_id'];
																			}
																			
																			if(!empty($grouping_user['peer_id'])){
																					if(!empty($ids)){
																							$ids=$ids.",".$grouping_user['peer_id'];
																					}
																					else{
																							$ids=$grouping_user['peer_id'];
																					}
																			}
																			if(!empty($grouping_user['sub_ordinates_id'])){
																					if(!empty($ids)){
																							$ids=$ids.",".$grouping_user['sub_ordinates_id'];
																					}
																					else{
																							$ids=$grouping_user['sub_ordinates_id'];
																					}
																			}
																			if(!empty($grouping_user['customer_id'])){
																					if(!empty($ids)){
																							$ids=$ids.",".$grouping_user['customer_id'];
																					}
																					else{
																							$ids=$grouping_user['customer_id'];
																					}
																			}
																			//echo $ids;
																			$a=explode(',',$ids);
																			if(!empty($ids)){
																				$ids=str_replace(",,",",",$ids);
																			$other_givers=UlsFeedbackEmployeeRating::giver_dashboard($grouping_user['group_id'],$ids);

																			foreach($other_givers as $others){
																				if(isset($others)){
																					$inproces_users=UlsFeedbackEmployeeRating::inprocess_users_dash($grouping_user['group_id'],$ids);
																					echo "&nbsp;&nbsp;[".count($inproces_users)."][".$others['count_nn']."/".count($a)."]"."[".round((($others['count_nn']/count($a))*100),2)."%]";
																				}
																			}  }
																			?>
																			</a> 
																		</div>
																		<div id="collapse_<?php echo $position['position_id'];?>_<?php echo $key; ?>" class="panel-collapse collapse" role="tabpanel">
																			<div class="panel-body pa-15">  
																			<h6 class='box-title'>Feedback Recipients Details</h6>
																			<div class="table-responsive">
																				<table class="table table-hover table-bordered mb-0">
																					<thead>
																						<tr>
																							<th>Designation</th>
																							<th>Given</th>
																							<th>Inprocess</th>
																							<th>Not Given</th>
																							<th>Total</th>
																						</tr>
																					</thead>
																					<tbody>
																					<?php
																					$users=str_replace(",","*",$grouping_user['manager_id']);
																					?>
																						<tr>
																							<?php
																							if(!empty($grouping_user['manager_id'])){?>
																							<td>
																									<label>
																									<a href='#' role='button' data-toggle='modal' data-target="#feedback_model<?php echo $position['position_id']; ?>" onclick="details(<?php echo $feedback_detail['employee_id'].",". $_REQUEST['id'].",".$position['position_id'].",".$grouping_user['group_id'].",'".$users."' "; ?>,'Managers')">Managers</a>
																									</label>
																							</td>
																							<?php }
																							else{?>
																								   <td> <label>Managers</label>
																								   </td>
																							<?php }
																							$mids=array();
																							$aa=$aa_in=$aa_not=0;
																							if(!empty($grouping_user['manager_id'])){
																									$mids=explode(',',$grouping_user['manager_id']);
																									foreach($mids as $mid){
																											$ss=UlsFeedbackEmployeeRating::giver_rating_status_completed($grouping_user['group_id'],$mid);
																											if(!empty($ss)){
																													$aa=$aa+1;
																											}
																										$ss_in=UlsFeedbackEmployeeRating::giver_rating_status_inprocess($grouping_user['group_id'],$mid);
																										if(!empty($ss_in)){
																											$aa_in=$aa_in+1;
																										}
																										$ss_not=UlsFeedbackEmployeeRating::giver_rating_notstarted($grouping_user['group_id'],$mid);
																										if(!empty($ss_not)){
																											$aa_not=$aa_not+1;
																										}
																									}
																									
																									
																									$mang=count($mids)- $aa - $aa_in;
																									$manger=count($mids);
																									if($aa==0){
																											$aa=0;
																									}
																									if($aa_in==0){
																											$aa_in=0;
																									}
																									if($mang==0){
																											$mang="-";
																									}
																									if($manger==0){
																											$manger="-";
																									}
																							}
																							else{
																									$aa=0;
																									$aa_in=0;
																									$mang="-";
																									$manger="-";
																							}

																							?>
																							<td><label><?php if($aa==0){ echo "-";}else { echo $aa;} ?></label></td>
																							<td><label><?php if($aa_in==0){ echo "-";}else { echo $aa_in;} ?></label></td>
																							<td><label><?php echo $mang; ?></label></td>
																							<td><label><?php echo $manger;?></label></td>
																						</tr>
																						<tr>
																						   <?php 
																						   $users=str_replace(",","*",$grouping_user['peer_id']); 
																						   if(!empty($grouping_user['peer_id'])){?>
																								   <td><label>
																								   <a href='#' role='button'  data-toggle='modal'  data-target="#feedback_model<?php echo $position['position_id']; ?>" onclick="details(<?php echo $feedback_detail['employee_id'].",". $_REQUEST['id'].",".$position['position_id'].",".$grouping_user['group_id'].",'".$users."' "; ?>,'Peers')">Peers</a></label>
																								   </td>
																						   <?php }
																						   else{?>
																								   <td><label>Peers</label></td>
																						   <?php }?>
																						   <?php 
																							//echo $name->peer_id ;

																						   $peer=array();
																						   $ff=$ff_in=$ff_not=0;
																						   if(!empty($grouping_user['peer_id'])){
																									$peer=explode(',',$grouping_user['peer_id']);
																								   foreach($peer as $peer_id){
																										   $sub_p=UlsFeedbackEmployeeRating::giver_rating_status_completed($grouping_user['group_id'],$peer_id);
																										   if(!empty($sub_p)){
																												   $ff=$ff+1;
																										   }
																										   $sub_p_in=UlsFeedbackEmployeeRating::giver_rating_status_inprocess($grouping_user['group_id'],$peer_id);
																										   if(!empty($sub_p_in)){
																												   $ff_in=$ff_in+1;
																										   }
																								   }
																								  $peer_not=count($peer)- $ff-$ff_in;
																								  $peer_given=count($peer);
																								   if($ff==0){
																										   $ff=0;
																								   }
																								   if($ff_in==0){
																										   $ff_in=0;
																								   }
																								   
																								   if($peer_not==0){
																										   $peer_not="-";
																								   }
																								   if($peer_given==0){
																										   $peer_given="-";
																								   }
																						   }
																						   else{
																								   $ff=0;
$ff_in=0;
$ff_not=0;																								   $peer_not="-";
																								   $peer_given="-";
																								   }
																						   ?>
																						   <td><?php if($ff==0){ echo "-";}else {echo $ff; } ?></td>
																						   <td><?php if($ff_in==0){ echo "-";}else {echo $ff_in; } ?></td>
																						   <td><?php echo $peer_not; ;?></td>
																						   <td><?php echo $peer_given;?></td>
																						</tr>
																						<tr>
																						   <?php
																						   $users=str_replace(",","*",$grouping_user['sub_ordinates_id']);
																						   if(!empty($grouping_user['sub_ordinates_id'])){ ?>
																						   <td><label>
																								   <a href='#' role='button' data-toggle='modal' data-target="#feedback_model<?php echo $position['position_id']; ?>" onclick="details(<?php echo $feedback_detail['employee_id'].",". $_REQUEST['id'].",".$position['position_id'].",".$grouping_user['group_id'].",'".$users."' "; ?>,'Sub-Ordinates')">Sub Ordinates</a>
																						   </label>
																						   </td>
																						   <?php }
																						   else{?>
																								   <td><label>Sub Ordinates</label></td>
																						   <?php }?>
																						   <?php
																						   $s_o=array();
																						    $cc=$cc_in=0;
																						   if(!empty($grouping_user['sub_ordinates_id'])){
																									$s_o=explode(',',$grouping_user['sub_ordinates_id']);
																								   foreach($s_o as $s_id){
																										$s_ord=UlsFeedbackEmployeeRating::giver_rating_status_completed($grouping_user['group_id'],$s_id);
																										if(!empty($s_ord)){
																											$cc=$cc+1;
																										}
																										$s_ord_in=UlsFeedbackEmployeeRating::giver_rating_status_inprocess($grouping_user['group_id'],$s_id);
																										if(!empty($s_ord_in)){
																											$cc_in=$cc_in+1;
																										}
																								   }
																								   $sub_ord=count($s_o)- $cc - $cc_in;
																								   $sub_ord_s=count($s_o);
																								   if($cc==0){
																										   $cc=0;
																								   }
																								   if($sub_ord==0){
																										   $sub_ord="-";
																								   }
																								   if($sub_ord_s==0){
																										   $sub_ord_s="-";
																								   }
																						   }
																						   else{
																								   $cc=0;
																								   $sub_ord="-";
																								   $sub_ord_s="-";
																						   }
																						   ?>
																						   <td><?php if($cc==0){ echo "-";}else { echo $cc;}?></td>
																						   <td><?php if($cc_in==0){ echo "-";}else { echo $cc_in;}?></td>
																						   <td><?php echo $sub_ord;?></td>
																						   <td><?php echo $sub_ord_s;?></td>
																						</tr>
																						<tr>
																						   <?php
																						   $users=str_replace(",","*",$grouping_user['customer_id']);
																						   if(!empty($grouping_user['customer_id'])){ ?>
																						   <td><label>
																								   <a href='#' role='button' data-toggle='modal' data-target="#feedback_model<?php echo $position['position_id']; ?>" onclick="details(<?php echo $feedback_detail['employee_id'].",". $_REQUEST['id'].",".$position['position_id'].",".$grouping_user['group_id'].",'".$users."' "; ?>,'Leadership-Team')">Leadership Team</a>
																						   </label>
																						   </td>
																						   <?php }
																						   else{?>
																								   <td><label>Leadership Team</label></td>
																						   <?php }?>
																						   <?php
																						   $s_ol=array();
																						    $ccl=0;
																						   if(!empty($grouping_user['customer_id'])){
																									$s_ol=explode(',',$grouping_user['customer_id']);
																								   foreach($s_ol as $s_idl){
																										$s_ordl=UlsFeedbackEmployeeRating::giver_rating_status_completed($grouping_user['group_id'],$s_idl);
																										if(!empty($s_ordl)){
																											$ccl=$ccl+1;
																										}
																										$s_ordl_in=UlsFeedbackEmployeeRating::giver_rating_status_inprocess($grouping_user['group_id'],$s_idl);
																										if(!empty($s_ordl_in)){
																											$ccl_in=$ccl_in+1;
																										}
																								   }
																								   $sub_ordl=count($s_ol)- $ccl - $ccl_in;
																								   $sub_ord_sl=count($s_ol);
																								   if($ccl==0){
																										   $ccl=0;
																								   }
																								   if($sub_ordl==0){
																										   $sub_ordl="-";
																								   }
																								   if($sub_ord_sl==0){
																										   $sub_ord_sl="-";
																								   }
																						   }
																						   else{
																								   $ccl=0;
																								   $sub_ordl="-";
																								   $sub_ord_sl="-";
																						   }
																						   ?>
																						   <td><?php if($ccl==0){ echo "-";}else { echo $ccl;}?></td>
																						   <td><?php if($ccl_in==0){ echo "-";}else { echo $ccl_in;}?></td>
																						   <td><?php echo $sub_ordl;?></td>
																						   <td><?php echo $sub_ord_sl;?></td>
																						</tr>
																						<tr bgcolor='#8B9ADD'>
																						   <td><b>Total</b></td>
																						   <?php
																						   $total_given=$cc+$ff+$aa+$ccl;
																						   $total_inprocess=$cc_in+$ff_in+$aa_in+$ccl_in;
																						   $total_ng=(count($mids)- $aa - $aa_in)+(count($s_o)- $cc- $cc_in)+(count($peer)- $ff- $ff_in)+(count($s_ol)- $ccl- $ccl_in);
																						   $total_bo=$total_given+$total_ng+$total_inprocess;
																						   if($total_ng==0){ $total_ng="-";}
																						   ?>
																						   <td><b><?php echo ($total_given!=0)?$total_given:"-" ?></b></td>
																						   <td><b><?php echo ($total_inprocess!=0)?$total_inprocess:"-" ?></b></td>
																						   <td><b><?php echo $total_ng;?></b></td>
																						   <td><b><?php echo ($total_bo!=0)? $total_bo : '-';?></b></td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																			</div>
																		</div>
																	</div>
																	<?php } ?>
																</div>
																<?php } ?>
															</div>
															<?php } ?>
														</form>
													</div>
												</div>
												<div class="modal fade" id="feedback_model<?php echo $position['position_id']; ?>" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="color-line"></div>
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																<h6 class="modal-title">Feedback Recipients Details</h6>
															</div>
															<div class='modal-body'>
																<div id="modal_user_<?php echo $position['position_id']; ?>"></div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</div>
												<?php $tab_a3=!empty($_REQUEST['tab'])?($_REQUEST['tab']==3?"active":""):""; ?>
												<div id="tab-assessors<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a3;?>" style="padding-left: 0px;">
													<div class="panel-body">
														<!--<form method="post" action="<?php echo BASE_URL;?>/admin/assessment_assessor_insert" class="form-horizontal"   id="self_emp_assessor<?php echo $position['position_id']; ?>">-->
														<input type="hidden" name="assessment_id_assessor_id" id="assessment_id_assessor_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
														<input type="hidden" name="position_id_assessor_id" id="position_id_assessor_id" value="<?php echo $position['position_id']; ?>">
														
														<div class="panel-heading hbuilt">
															Assessor
															<div class="pull-right">
																<a class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal<?php echo $position['position_id']; ?>" onclick="single_enroll_assessor(<?php echo $position['position_id']; ?>);" >&nbsp <i class="fa fa-plus-circle"></i> Add New Assessor&nbsp </a>
																<a class="btn btn-danger btn-xs" onClick="delete_assessor(<?php echo $position['position_id'];?>)">&nbsp <i class="fa fa-trash-o"></i>  Delete Assessor &nbsp </a>
															</div>
														</div><br style="clear:both">
														<div class="table-responsive">
															<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id='newtableid_<?php echo $position['position_id'];?>'>
																<thead>
																<tr>
																	<th>Select</th>
																	<th>Assessor Name</th>
																	<th>Assessor Email</th>
																	<th>Assessor Mobile</th>
																	<th>Assessor Permission</th>
																</tr>
																</thead>
																<tbody>
																<?php
																$assessors=UlsAssessmentPositionAssessor::getassessment_assessor_info($compdetails['assessment_id'],$position['position_id']);
																$val=array();
																foreach($assessors as $key=>$assessor){
																	$val[]=$key;
																	//$check=!empty($assessor['assessor_id'])?($assessor['assessor_id']==$assessor['ass_name'])?"checked='checked'":"":"";
																?>	
																<tr  id="innerdata_<?php echo $position['position_id'];?>_<?php echo $assessor['assessment_pos_assessor_id']; ?>">
																	<td><input type="checkbox" name="checkbox_assessor[]" id="checkbox_assessor_<?php echo $position['position_id'];?>[<?php echo $key;?>]" value='<?php echo $assessor['assessment_pos_assessor_id']; ?>' <?php //echo $check; ?>>
																	<input type="hidden" name='assessment_pos_assessor_id[]' id='assessment_pos_assessor_id_<?php echo $position['position_id'];?>[<?php echo $assessor['assessment_pos_assessor_id']; ?>]' value='<?php echo $assessor['assessment_pos_assessor_id']; ?>'>
																	<input type="hidden" name='assessor_id[]' id='assessor_id[]' value='<?php echo $assessor['assessor_id']; ?>'>
																	</td>
																	<td><?php echo $assessor['assessor_name'];?></td>
																	<td><?php echo $assessor['assessor_email'];?></td>
																	<td><?php echo $assessor['assessor_mobile'];?></td>
																	<td><?php 
																	if($assessor['assessor_per']=='Y'){
																	?>
																		<a class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal<?php echo $position['position_id']; ?>_<?php echo $assessor['assessment_pos_assessor_id']; ?>" onclick="enroll_employees(<?php echo $position['position_id']; ?>,<?php echo $assessor['assessment_pos_assessor_id']; ?>);" >&nbsp Mapping Employees&nbsp </a>
																	<?php
																	}
																	else{
																	?>
																		Not Mapped
																	<?php
																	}
																	?></td>
																</tr>
																<div class="modal fade" id="myModal<?php echo $position['position_id']; ?>_<?php echo $assessor['assessment_pos_assessor_id']; ?>" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
																	<div class="modal-dialog modal-lg">
																		<div class="modal-content">
																			<div class="color-line"></div>
																			<div class="modal-header">
																				<h6 class="modal-title">Employee Selection</h6>
																			</div>
																			<div class='modal-body'>
																				<div id="employee_div_assessor_<?php echo $position['position_id']; ?>_<?php echo $assessor['assessment_pos_assessor_id']; ?>"></div>
																			</div>
																		</div>
																	</div>
																</div>
																<?php	
																} ?>
																</tbody>
															</table>
															<input type="hidden" name="hidden_val" id="hidden_val_<?php echo $position['position_id'];?>" value="<?php echo @implode(',',$val);?>"> 
														</div>
														
														
														<!--<hr class="light-grey-hr">
														<div class="form-group">
															<div class="col-sm-offset-8">
																<button class="btn btn-danger  btn-sm" type="button" onclick="create_link('assessor_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
																<button class="btn btn-primary  btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
															</div>
														</div>-->
														<!--</form>-->
														<div class="modal fade" id="myModal<?php echo $position['position_id']; ?>" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
															<div class="modal-dialog modal-lg">
																<div class="modal-content">
																	<form method="post" action="assessment_assessor_insert_single" class="form-horizontal" id="self_emp_assessor_single<?php echo $position['position_id']; ?>">
																	<input type="hidden" name="assessment_id_assessor" id="assessment_id_assessor" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
																	<input type="hidden" name="position_id_assessor" id="position_id_assessor" value="<?php echo $position['position_id']; ?>">
																	<div class="color-line"></div>
																	<div class="modal-header">
																		<h6 class="modal-title">Assessor Information</h6>
																	</div>
																	<div id="enrollment_div_assessor_<?php echo $position['position_id']; ?>"></div>
																	</form>
																</div>
															</div>
														</div>
													</div>
												</div>
												
												
												<?php
												$tab_method=!empty($_REQUEST['tab'])?($_REQUEST['tab']==4?"active":""):"";
												?>
												<div id="tab-assessments<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_method; ?>" style="padding-left: 0px;">
													<div class="panel-body">
														<div class="col-lg-4">
															<div class="panel panel-inverse card-view">
																<div class="panel-heading"  style="border: 1px dotted;">
																	Methods
																	
																</div>
																<div class="panel-body float-e-margins">
																	<ul class="list-unstyled">
																		<li>
																			<i class="ace-icon fa fa-caret-right blue"></i>
																			Position:<a onclick="getposdet(<?php echo $position['position_id']; ?>)" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $position['position_name']; ?></a>
																		</li>
																	</ul>
																	
																</div>
																<div class="panel-body float-e-margins">
																	<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
																		<thead>
																		<tr>
																			<th>Method Name</th>
																			<th>Action</th>
																		</tr>
																		</thead>
																		<tbody>
																		<?php 
																		$competencies_weight=UlsAssessmentCompetenciesWeightage::getassessmentcompetencies_weightage_test($compdetails['assessment_id'],$position['position_id']);
																		foreach($competencies_weight as $competencies_weights){
																			if($position['position_id']==$competencies_weights['position_id']){
																			?>
																			<tr>
																				<td><?php echo $competencies_weights['assesstype'] ?></td>
																				<td>
																				<?php
																				if(empty($competencies_weights['assess_test_id'])){
																				?>
																				<button class="btn btn-success btn-circle" type="button" onclick="open_position(<?php echo $competencies_weights['assessment_id']?>,<?php echo $competencies_weights['position_id']; ?>,'<?php echo $competencies_weights['assessment_type']; ?>');"><i class="fa fa-book"></i></button>
																				<?php 
																				}
																				if(!empty($competencies_weights['assess_test_id'])){	
																				?>
																				<button class="btn btn-info btn-circle btn-sm" type="button" onclick="open_position(<?php echo $competencies_weights['assessment_id']?>,<?php echo $competencies_weights['position_id']; ?>,'<?php echo $competencies_weights['assessment_type']; ?>');" style="height: 30px;width:30px;padding: 5px !important;"><i class="fa fa-pencil"></i></button>
																				<button class="btn btn-danger btn-circle btn-sm" type="button" style="height: 30px;width:30px;padding: 5px !important;"><i class="fa fa-trash-o"></i></button>
																				<?php } ?>
																				</td>
																			</tr>
																			<?php 
																			} 
																		}?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														
														<div id="position_details<?php echo $position['position_id']; ?>">
															<div class="col-lg-8">
																<div class="panel panel-inverse card-view">
																	<div class="panel-heading" style="border: 1px dotted;">
																		Instruction
																	</div>
																	<div class="panel-body float-e-margins">
																		<ul class="list-unstyled">
																			<li>
																				<i class="ace-icon fa fa-caret-right blue"></i>
																				Please click On Button to configure Test paper
																			</li>

																			<li>
																				<i class="ace-icon fa fa-caret-right blue"></i>
																				Click on preview to view your questions
																			</li>
																		</ul>
																		
																	</div>
																</div>
															</div>
														</div>
													</div>
													<?php
													if(count($competencies_weight)>0){
														if($ass_position['assessment_broadcast']!='A'){
															?>
															<div class="panel-body">
																<table class="table table-hover table-striped">
																	<tbody>
																	<tr>
																		<td>
																			Note: Please click on Broadcast Button to trigger assessment for this <?php echo $position['position_name']; ?> 
																		</td>
																		<td>
																			<button class="btn btn-success btn-sm demo1" data-target="#workinfoview<?php echo $position['position_id']; ?>" onclick='work_info_view(<?php echo $compdetails['assessment_id'];?>,<?php echo $position['position_id']; ?>)' data-toggle='modal' href='#workinfoview<?php echo $position['position_id']; ?>'>Broadcast</button>
																		</td>
																	</tr>
																	</tbody>
																</table>
															</div>
														<?php 
														}
													}
													?>
												</div>
												
												<?php $tab_a7=!empty($_REQUEST['tab'])?($_REQUEST['tab']==7?"active":""):""; ?>
												<div id="tab-setting<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a7; ?>" style="padding-left: 0px;">
													<h5>Settings</h5>
													<script>
													$(document).ready(function(){
														$("#setting_master<?php echo $position['position_id']; ?>").validationEngine();
													});
													</script>
													<form id="setting_master<?php echo $position['position_id']; ?>" action="<?php echo BASE_URL;?>/admin/assessment_position_setting_insert" method="post" enctype="multipart/form-data">
													<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
													<input type="hidden" name="position_id" id="position_id" value="<?php echo $position['position_id']; ?>">
													<input type="hidden" name="start_date" id="start_date" value="<?php echo date("Y-m-d",strtotime($compdetails['start_date'])); ?>">
													<input type="hidden" name="end_date" id="end_date" value="<?php echo date("Y-m-d",strtotime($compdetails['end_date'])); ?>">
													<div class="panel-body">
														<div class="table-responsive">
															<table id="comp_assess<?php echo $position['position_id']; ?>" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																<thead>
																<tr>
																	<th class="col-sm-3">Method Name</th>
																	<th class="col-sm-2n">Start Date</th>
																	<th class="col-sm-2n">End Date</th>
																	<th class="col-sm-2n"></th>
																	<th class="col-sm-1n"></th>
																</tr>
																</thead>
																<tbody>
																<?php 
																$ass_methods=UlsAssessmentTest::get_assessment_position($compdetails['assessment_id'],$position['position_id']);
																if(count($ass_methods)>0){
																	foreach($ass_methods as $key1=>$ass_methods){
																		if($ass_methods['position_id']==$position['position_id']){
																		?>
																		<script>
																		$(document).ready(function(){
																			$("#datepicker_<?php echo $ass_methods['assess_test_id'];?>").datepicker();
																			$("#datepicker<?php echo $ass_methods['assess_test_id'];?>").datepicker();
																			
																		});
																		</script>
																		<tr>
																			<input type='hidden' name='assess_test_id[]' id='assess_test_id[]' value='<?php echo $ass_methods['assess_test_id'];?>'>
																			<td><?php echo $ass_methods['assess_type'];?></td>
																			<td>
																				<div class="input-group date" id="datepicker_<?php echo $ass_methods['assess_test_id'];?>">
																					<input type="text" class="validate[required,future[#start_date]]  form-control" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="ass_start_date[<?php echo $ass_methods['assess_test_id'];?>]" id="ass_start_date_<?php echo $ass_methods['assess_test_id'];?>" value="<?php if(!empty($ass_methods['ass_start_date'])){ if($ass_methods['ass_start_date']!='0000-00-00' || $ass_methods['ass_start_date']!=NULL){ echo  date('Y-m-d',strtotime($ass_methods['ass_start_date']));}}?>">
																					<span class="input-group-addon">
																						<span class="fa fa-calendar"></span>
																					</span>
																				</div>
																			</td>
																			<td>
																				<div class="input-group date" id="datepicker<?php echo $ass_methods['assess_test_id'];?>">
																					<input type="text" class="validate[required,past[#end_date],future[#ass_start_date_<?php echo $ass_methods['assess_test_id'];?>]] form-control" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="ass_end_date[<?php echo $ass_methods['assess_test_id'];?>]" id="ass_end_date_<?php echo $ass_methods['assess_test_id'];?>" value="<?php if(!empty($ass_methods['ass_end_date'])){ if($ass_methods['ass_end_date']!='0000-00-00' || $ass_methods['ass_end_date']!=NULL){ echo  date('Y-m-d',strtotime($ass_methods['ass_end_date']));}}?>">
																					<span class="input-group-addon">
																						<span class="fa fa-calendar"></span>
																					</span>
																				</div>	
																			</td>
																			<td>
																				<select class="validate form-control m-b" name="lang_process[<?php echo $ass_methods['assess_test_id'];?>]" id="lang_process_<?php echo $ass_methods['assess_test_id'];?>">
																					<option value="">Select</option>
																					<?php 	
																					foreach($language as $languages){
																						$feed_sat_com=(isset($ass_methods['lang_process']))?($ass_methods['lang_process']==$languages['code'])?"selected='selected'":'':''?>
																						<option value="<?php echo $languages['code']?>" <?php echo $feed_sat_com?>><?php echo $languages['name']?></option>
																					<?php 	
																					}?>
																				</select>
																			</td>
																			<td>
																			<input type="text" class="form-control m-b" name="int_que_count[<?php echo $ass_methods['assess_test_id'];?>]" id="int_que_count_<?php echo $ass_methods['assess_test_id'];?>" value="<?php echo !empty($ass_methods['int_que_count'])?$ass_methods['int_que_count']:"";?>">
																			</td>
																		</tr>
																		<script>
																		/* $(document).ready(function(){
																			var date1 = new Date();
																			var date2 = new Date(2039,0,19);
																			var timeDiff = Math.abs(date2.getTime() - date1.getTime());
																			var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
																			
																			var dates = $( "#ass_start_date[<?php echo $ass_methods['assess_test_id'];?>], #ass_end_date[<?php echo $ass_methods['assess_test_id'];?>]" ).datepicker({dateFormat:"dd-mm-yy",
																			defaultDate: "+1w",
																			changeMonth: true,
																			changeYear: true,
																			numberOfMonths: 1,
																			minDate:"",
																			maxDate:difDays,
																			showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
																			buttonImageOnly: true,
																			onSelect: function( selectedDate ) { 
																			var option = this.id === "ass_start_date[<?php echo $ass_methods['assess_test_id'];?>]" ? "minDate" : "maxDate",
																			instance = $( this ).data( "datepicker" ),
																			date = $.datepicker.parseDate(
																			instance.settings.dateFormat ||
																			$.datepicker._defaults.dateFormat,
																			selectedDate, instance.settings );
																			dates.not( this ).datepicker( "option", option, date );
																			}
																			});				   
																		}); */
																		
																	</script>
																		<?php
																		}		
																	}
																}
																
																?>
																</tbody>
															</table>
														</div>
													</div>
													<?php 
													if($ass_position['assessment_broadcast']!='A'){
													?>
														<hr class="light-grey-hr">
														<div class="form-group">
															<div class="col-sm-offset-8">
																<button class="btn btn-danger  btn-sm" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
																<button class="btn btn-primary  btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
															</div>
														</div>
													<?php 
													} ?>
													</form>
												
												</div>
												
												<?php $tab_a5=!empty($_REQUEST['tab'])?($_REQUEST['tab']==5?"active":""):""; ?>
												<div id="tab-tnicomp<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a5; ?>" style="padding-left: 0px;">
													<form id="tni_master<?php echo $position['position_id']; ?>" action="<?php echo BASE_URL;?>/admin/assessment_competency_tna_insert" method="post" enctype="multipart/form-data">
													<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
													<input type="hidden" name="position_id" id="position_id" value="<?php echo $position['position_id']; ?>">
													<div class="panel-body">
														<div class="table-responsive">
															<table id="comp_assess<?php echo $position['position_id']; ?>" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																<thead>
																<tr>
																	<th class="col-sm-3">Competencies</th>
																	<th class="col-sm-2">Scale</th>
																	<th class="col-sm-2n">Competency Sel</th>
																</tr>
																</thead>
																<tbody>
																<?php 
																$posdetails=UlsAssessmentCompetencies::getassessment_competencies($_REQUEST['id'],$position['position_id']);
																if(count($posdetails)>0){
																	foreach($posdetails as $key1=>$posdetail){
																		if($posdetail['position_id']==$position['position_id']){
																		?>
																		<tr>
																			<input type='hidden' name='assessment_pos_comp_id[]' id='assessment_pos_comp_id[]' value='<?php echo $posdetail['assessment_pos_comp_id'];?>'>
																			<td><?php echo $posdetail['comp_def_name'];?></td>
																			<td><?php echo $posdetail['scale_name'];?> </td>
																			<td>
																				<select class="form-control m-b" name="comp_per[<?php echo $posdetail['assessment_pos_comp_id'];?>]" id="comp_per_<?php echo $position['position_id']?>_<?php echo $posdetail['assessment_pos_comp_id'];?>" style="width:100%;">
																					<option value="">Select</option>
																					<?php 
																					
																					foreach($status as $feed_type_com){
																						$methodsels=isset($posdetail['comp_per'])?($posdetail['comp_per']==$feed_type_com['code'])?"selected='selected'":"":"";?>
																						<option value="<?php echo $feed_type_com['code']?>" <?php  echo $methodsels;?>><?php echo $feed_type_com['name']?></option>
																					<?php 	
																					}?>
																				</select>
																				</td>
																		</tr>
																		<?php
																		}		
																	}
																}
																
																?>
																</tbody>
															</table>
														</div>
													</div>
													<?php 
													if($ass_position['assessment_broadcast']!='A'){
													?>
														<hr class="light-grey-hr">
														<div class="form-group">
															<div class="col-sm-offset-8">
																<button class="btn btn-danger  btn-sm" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
																<button class="btn btn-primary  btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
															</div>
														</div>
													<?php 
													} ?>
													</form>
												</div>
												<?php $tab_a6=!empty($_REQUEST['tab'])?($_REQUEST['tab']==6?"active":""):""; ?>
												<div id="tab-tniemp<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a6; ?>" style="padding-left: 0px;">
													<form id="tni_master<?php echo $position['position_id']; ?>" action="<?php echo BASE_URL;?>/admin/assessment_employee_tna_insert" method="post" enctype="multipart/form-data">
														<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
														<input type="hidden" name="position_id" id="position_id" value="<?php echo $position['position_id']; ?>">
														<div class="panel-body">
															<div class="table-responsive">
																<table id="emp_assess<?php echo $position['position_id']; ?>" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																	<thead>
																		<tr>
																			<th>Employee Code</th>
																			<th>Employee name</th>
																			<th>Department</th>
																			<th>Position</th>
																			<th>TNI EMP</th>
																		</tr>
																	</thead>
																	<tbody>
																	<?php
																	foreach($employees as $employee){					
																		if($employee['position_id']==$position['position_id']){
																		?>
																		<tr>
																		<input type='hidden' name='assessment_pos_emp_id[]' id='assessment_pos_emp_id[]' value='<?php echo $employee['assessment_pos_emp_id'];?>'>
																		<td><?php echo $employee['employee_number'];?></td>
																		<td><?php echo $employee['full_name'];?></td>
																		<td><?php echo $employee['org_name'];?></td>
																		<td><?php echo $employee['position_name'];?></td>
																		<td>
																			<select class="form-control m-b" name="tna_status[<?php echo $employee['assessment_pos_emp_id'];?>]" id="tna_status_<?php echo $position['position_id']?>_<?php echo $employee['assessment_pos_emp_id'];?>" style="width:100%;">
																				<option value="">Select</option>
																				<?php 
																				
																				foreach($status as $feed_type_com){
																					$methodsels=isset($employee['tna_status'])?($employee['tna_status']==$feed_type_com['code'])?"selected='selected'":"":"";?>
																					<option value="<?php echo $feed_type_com['code']?>" <?php  echo $methodsels;?>><?php echo $feed_type_com['name']?></option>
																				<?php 	
																				}?>
																			</select>
																		</td>
																		</tr>
																		<?php
																		}
																	} ?>
																	</tbody>
																</table>
															</div>
															<?php 
															if($ass_position['assessment_broadcast']!='A'){
															?>
																<hr class="light-grey-hr">
																<div class="form-group">
																	<div class="col-sm-offset-8">
																		<button class="btn btn-danger  btn-sm" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
																		<button class="btn btn-primary  btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
																	</div>
																</div>
															<?php 
															} ?>
														</div>
													</form>
												</div>
												<?php $tab_a8=!empty($_REQUEST['tab'])?($_REQUEST['tab']==8?"active":""):""; ?>
												<div id="tab-compweight<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a8; ?>" style="padding-left: 0px;">
													<form id="tni_master<?php echo $position['position_id']; ?>" action="<?php echo BASE_URL;?>/admin/assessment_competency_weightage_insert" method="post" enctype="multipart/form-data">
													<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
													<input type="hidden" name="position_id" id="position_id" value="<?php echo $position['position_id']; ?>">
													<div class="panel-body">
														<div class="table-responsive">
															<table id="comp_assess_weight<?php echo $position['position_id']; ?>" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																<thead>
																<tr>
																	<th class="col-sm-3">Competencies</th>
																	<th class="col-sm-2">Scale</th>
																	<th class="col-sm-2n">Competency Weightage</th>
																</tr>
																</thead>
																<tbody>
																<?php 
																$posdetails=UlsAssessmentCompetencies::getassessment_competencies($_REQUEST['id'],$position['position_id']);
																$totalwe=0;
																if(count($posdetails)>0){
																	foreach($posdetails as $key1=>$posdetail){
																		if($posdetail['position_id']==$position['position_id']){
																		$totalwe+=$posdetail['pos_com_weightage'];
																		?>
																		<tr>
																			<input type='hidden' name='assessment_pos_comp_id[]' id='assessment_pos_comp_id[]' value='<?php echo $posdetail['assessment_pos_comp_id'];?>'>
																			<td><?php echo $posdetail['comp_def_name'];?></td>
																			<td><?php echo $posdetail['scale_name'];?> </td>
																			<td>
																				<input type="text" class="validate[required,custom[number],min[1]] form-control txtCalweight<?php echo $position['position_id']?>" name="pos_com_weightage[<?php echo $posdetail['assessment_pos_comp_id'];?>]" id="pos_com_weightage1_<?php echo $position['position_id']?>_<?php echo $posdetail['assessment_pos_comp_id'];?>" value="<?php echo isset($posdetail['pos_com_weightage'])?$posdetail['pos_com_weightage']:""; ?>">
																				
																				</td>
																		</tr>
																		<?php
																		}		
																	}
																}
																
																?>
																<script type="text/javascript" >
																	$(document).ready(function () {
       
																		$("#comp_assess_weight<?php echo $position['position_id']; ?>").on('input', '.txtCalweight<?php echo $position['position_id']?>', function () {
																		   var calculatedtotalsum = 0;
																		 
																		   $("#comp_assess_weight<?php echo $position['position_id']; ?> .txtCalweight<?php echo $position['position_id']?>").each(function () {
																			   var get_textbox_value = $(this).val();
																			   if ($.isNumeric(get_textbox_value)) {
																				  calculatedtotalsum += parseFloat(get_textbox_value);
																				  }                  
																				});
																				  $("#totalsumvalueweight<?php echo $position['position_id']; ?>").html(calculatedtotalsum);
																		   });
																	});
																	
																	</script>
																	
																	<tr>
																		<td></td>
																		<td></td>
																		<td>Total Weight:<b><span style="font-size:16px;" id="totalsumvalueweight<?php echo $position['position_id']; ?>"><?php echo !empty($totalwe)?$totalwe:"";?></span></b></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<?php 
													if($ass_position['assessment_broadcast']!='A'){
													?>
														<hr class="light-grey-hr">
														<div class="form-group">
															<div class="col-sm-offset-8">
																<button class="btn btn-danger  btn-sm" type="button" onclick="create_link('assessment_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
																<button class="btn btn-primary  btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
															</div>
														</div>
													<?php 
													} ?>
													</form>
												</div>
												<?php $tab_a9=!empty($_REQUEST['tab'])?($_REQUEST['tab']==9?"active":""):""; ?>
												<div id="tab-empcompsel<?php echo $position['position_id']; ?>" class="tab-pane <?php echo $tab_a9; ?>" style="padding-left: 0px;">
													<!--<form id="tni_master<?php echo $position['position_id']; ?>" action="#" method="post" enctype="multipart/form-data">-->
														<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo (isset($_REQUEST['id']))?$_REQUEST['id']:''?>">
														<input type="hidden" name="position_id" id="position_id" value="<?php echo $position['position_id']; ?>">
														<div class="panel-body">
															<div class="table-responsive">
																<table id="emp_assess<?php echo $position['position_id']; ?>" cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
																	<thead>
																		<tr>
																			<th>Employee Code</th>
																			<th>Employee name</th>
																			<th>Department</th>
																			<th>Position</th>
																			<th>Mapping</th>
																			<th>Mapping status</th>
																		</tr>
																	</thead>
																	<tbody>
																	<?php
																	foreach($employees as $employee){					
																		if($employee['position_id']==$position['position_id']){
																		?>
																		<tr>
																		<input type='hidden' name='assessment_pos_emp_id[]' id='assessment_pos_emp_id[]' value='<?php echo $employee['assessment_pos_emp_id'];?>'>
																		<td><?php echo $employee['employee_number'];?></td>
																		<td><?php echo $employee['full_name'];?></td>
																		<td><?php echo $employee['org_name'];?></td>
																		<td><?php echo $employee['position_name'];?></td>
																		<td>
																		<a class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal<?php echo $position['position_id']; ?>_<?php echo $employee['assessment_pos_emp_id']; ?>" onclick="enroll_employee_competency(<?php echo $position['position_id']; ?>,<?php echo $employee['assessment_pos_emp_id']; ?>);" >&nbsp Mapping Competency&nbsp </a>	
																		</td>
																		<td>
																		<?php 
																		if(!empty($employee['comp_ids'])){
																			echo "Competency Mapped";
																		}
																		else{
																			echo "Competency Not Mapped";
																		}
																		?>
																		</td>
																		</tr>
																		<div class="modal fade" id="myModal<?php echo $position['position_id']; ?>_<?php echo $employee['assessment_pos_emp_id']; ?>" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
																			<div class="modal-dialog modal-lg">
																				<div class="modal-content">
																					<div class="color-line"></div>
																					<div class="modal-header">
																						<h6 class="modal-title">Employee Competency Selection</h6>
																					</div>
																					<div class='modal-body'>
																						<div id="employee_div_competency_<?php echo $position['position_id']; ?>_<?php echo $employee['assessment_pos_emp_id']; ?>"></div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<?php
																		}
																	} ?>
																	</tbody>
																</table>
															</div>
															
														</div>
													<!--</form>-->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="workinfoview<?php echo $position['position_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
							<div class="modal-dialog modal-lg" style="width:98%">
								<div class="modal-content">
									<div class="color-line"></div>
									<div class="modal-header">
										<h6 class="modal-title">Assessment Broadcast</h6>
										<button type="button" class="btn btn-default pull-right" data-dismiss="modal">X</button>
									</div>
									<div class="modal-body">
										<div id="workinfodetails<?php echo $position['position_id']; ?>" class="modal-body no-padding">
										
										</div>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
						<script type="text/javascript" >
						$(document).ready(function(){
							
							$('#case_master<?php echo $position['position_id']; ?>').validationEngine();
							
							/*$("#case_master<?php echo $position['position_id']; ?>").bind("jqv.form.validating", function(event){
								var fieldsWithValue = $('input[id^="1check_position_"]').filter(function(){
								   if($(this).prop("checked")){
										return true;
									}
								});
								if(fieldsWithValue.length<1){
									$('input[id^="1check_position_"]').addClass('validate[required,funcCall[requiredOneOfGroup]]');
								}
								var fieldsWithValue1 = $('input[id^="assessment_type"]').filter(function(){
								   if($(this).prop("checked")){
										return true;
									}
								});
								if(fieldsWithValue1.length<1){
									$('input[id^="assessment_type"]').addClass('validate[required,funcCall[requiredOneOfGroup1]]');
								}
							});

							$("#case_master<?php echo $position['position_id']; ?>").bind("jqv.form.result", function(event, errorFound){
								$('input[id^="1check_position_"]').removeClass('validate[required,funcCall[requiredOneOfGroup]]');
								$('input[id^="assessment_type"]').removeClass('validate[required,funcCall[requiredOneOfGroup1]]');
							});*/
						});
						</script>
						<?php } ?>					
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php 
/* print_r($this->session->userdata);
if(!empty($this->session->flashdata('assmethod'))){
	if($this->session->flashdata('assmethod')=='TEST'){ */
		
if(!empty($_REQUEST['gen'])){
	if($_REQUEST['gen']=='TEST'){	
?>
<script type="text/javascript" >
$(document).ready(function(){
	open_position(<?php echo $_REQUEST['id']?>,<?php echo @$_REQUEST['pos_id']; ?>,'<?php echo $_REQUEST['gen']; ?>');
});
</script>
<?php
	}
}
if(!empty($_REQUEST['gen'])){
	if($_REQUEST['gen']=='INTERVIEW'){	
	?>
	<script type="text/javascript" >
	$(document).ready(function(){
		open_position(<?php echo $_REQUEST['id']?>,<?php echo @$_REQUEST['pos_id']; ?>,'<?php echo $_REQUEST['gen']; ?>');
	});
	</script>
	<?php
	}
}
//$this->session->unset_userdata('assmethod');
?>

<script>

function get_check_questions(id){
	window.open(BASE_URL+"/admin/questions_view_assessment?assess_test_id="+id,'_blank')
}
function get_check_question(id){
	window.open(BASE_URL+"/admin/questions_view_assessment_view?assess_test_id="+id,'_blank')
}
</script>

<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this inbasket ?
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Competency attached Positions</h5>
			</div>
			<div class="modal-body">
				
				<div id="txtHint" style="margin: 15px;">
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
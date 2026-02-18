<div class="row">
<div class='col-md-12'>
	
	<div class='panel panel-default card-view'>
		<div class="font-bold m-b-sm">
	<h5 class="txt-dark">	Final Summary Sheet of <?php echo $employee_name['full_name']; ?></h5>
	</div>
	<hr class="light-grey-hr">
		<div class='panel-body' style="max-height: none;">
			
			<div class='table-responsive'>
				<form action='' method='post' name="admin_summary_sumbit" id="admin_summary_sumbit">
				<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
				<input type="hidden" name="assessment_id" value="<?php echo $assessment_id;?>" >
				<input type="hidden" name="position_id" value="<?php echo $position_id;?>" >
				<input type="hidden" name="employee_id" value="<?php echo $employee_id;?>" >
				<input type="hidden" name="final_admin_id" value="<?php echo $_SESSION['user_id'];?>" >
				<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
					<thead>
						<tr>
							<th rowspan='2' style="width:20%">Competency name</th>
							<th rowspan='2' style="width:15%">Required Level</th>
							<th colspan='4' scope='colgroup' align='center'>Assessed Level</th>
							
						</tr>
						<tr>
						<?php 
						foreach($ass_info as $ass_infos){
						?>
							<th scope='col'><a class='label label-success' data-target="#assessorview<?php echo $ass_infos['ass_id']; ?>" onclick='ass_info_view(<?php echo $ass_infos['assessment_id']; ?>,<?php echo $ass_infos['position_id']; ?>,<?php echo $ass_infos['employee_id']; ?>,<?php echo $ass_infos['ass_id']; ?>)' data-toggle='modal' href='#assessorview<?php echo $ass_infos['ass_id']; ?>'><?php echo $ass_infos['assessor_name'];?> </a></th>
						<?php 
						} ?>
							<!--<th style="width:20%">Over All</th>-->
							<th style="width:30%">Development </th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$results=$assessor=array();
					foreach($ass_comp_info as $ass_comp_infos){
						$assessor[]=$ass_comp_infos['assessor_id'];
						$assessor_id=$ass_comp_infos['assessor_id'];
						$comp_id=$ass_comp_infos['comp_def_id'];
						$req_scale_id=$ass_comp_infos['req_scale_id'];
						$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
						$results[$comp_id]['req_scale_id']=$ass_comp_infos['req_scale_id'];
						$results[$comp_id]['req_scale_name']=$ass_comp_infos['req_scale_name'];
						$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
						$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
						$results[$comp_id]['employee_id']=$ass_comp_infos['employee_id'];
						$results[$comp_id][$assessor_id]['overall_id']=$ass_comp_infos['final_scaled_id'];
						$results[$comp_id][$assessor_id]['overall_name']=$ass_comp_infos['final_scaled_name'];
						$results[$comp_id][$assessor_id]['development']=$ass_comp_infos['development_area'];
						
					}
					//print_r($results);
					foreach($results as $comp_def_id=>$result){
						$final_admin_id=$_SESSION['user_id'];
						$ass_comp=UlsAssessmentReport::getadminassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
					?>
						<tr>
							<td>
							<input type="hidden" name="competency[]" value="<?php echo $comp_def_id;?>" >
							<?php echo $result['comp_name']; ?></td>
							<td>
							<input type="hidden" name="requiredlevel_<?php echo $comp_def_id;?>" value="<?php echo $result['req_scale_id'];?>" >
							<?php echo $result['req_scale_name']; ?></td>
							<?php 
							foreach($ass_info as $ass_infos){
							$as_id=$ass_infos['ass_id'];
							?>
								<td><?php echo !empty($result[$as_id]['overall_name'])?$result[$as_id]['overall_name']:"-";?></td>
							<?php
							}
							?>
							<!--<td>
							<?php //$data="";
							//$data="
							//<select name='OVERALL_".$comp_def_id."' id='OVERALL_".$comp_def_id."' class='validate[required] form-control m-b' style='width:120px;'>
							//<option value=''>Select</option>";
							//$level_id=UlsCompetencyDefinition::viewcompetency($comp_def_id);
							//$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
							//foreach($scale_overall as $scales){
								//$final_scale=!empty($ass_comp['assessed_scale_id'])?$ass_comp['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
								//$data.="<option value='".$scales['scale_id']."' ".$final_scale.">".$scales['scale_name']."</option>";
							//}
							//$data.="</select>";
							//echo $data; ?>
							</td>-->
							<td><textarea name="development_<?php echo $comp_def_id;?>" class="validate[required]" rows="3" cols="60"><?php echo !empty($ass_comp['development_area'])?$ass_comp['development_area']:""; ?></textarea></td>
						</tr>
					<?php
						
					}
					?>
					</tbody>
				</table>
				<hr class="light-grey-hr">
				<div class="text-left m-t-xs">
				   <button class="btn btn-primary " type="button" name="summary_info_submit" id="summary_info_submit"><i class="fa fa-check"></i> Submit</button>
				</div>
			</form>
			
				<?php
				$beh_asstype="BEHAVORIAL_INSTRUMENT";
				$beh_instrument=UlsAssessmentTest::get_ass_position_test($assessment_id,$position_id,$beh_asstype);
				if(!empty($beh_instrument['assess_test_id'])){
				$ass_detail_casestudy=UlsAssessmentTestBehavorialInst::getbeiassessment($beh_instrument['assess_test_id']);
				if(count($ass_detail_casestudy)>0){
				?>
				<hr class="light-grey-hr">
				<div class="font-bold m-b-sm">
					<h5 class="txt-dark">Behavorial Instrument</h5>
				</div>
				
				
				<div class='table-responsive'>
					<table class='table table-hover table-bordered table-striped'>
						<thead>
							<tr>
								<th>BEHAVORIAL INSTRUMENT Name</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($ass_detail_casestudy as $ass_detail_casestudies){
								$getpretest_inbasket=UlsBeiAttemptsAssessment::getattemptvalus_beh($assessment_id,$employee_id,$beh_asstype,$beh_instrument['assess_test_id'],$ass_detail_casestudies['instrument_id']);
						?>
							<tr>
								<td><span class='label label-success' data-target='#workinfoview_case<?php echo $ass_detail_casestudies['instrument_id'];?>' onclick='work_info_view_casestudy(<?php echo  $ass_detail_casestudies['instrument_id'];?>)' data-toggle='modal' href='#workinfoview_case<?php echo $ass_detail_casestudies['instrument_id'];?>'><?php echo $ass_detail_casestudies['instrument_name'];?></span></td>
								<td><?php echo $status=empty($getpretest_inbasket['attempt_status'])?'In Process':'Completed';?></td>
								<td class='text-center'>
								<?php if(empty($getpretest_inbasket['attempt_status'])){ ?>
								<a href='#' class='btn btn-danger btn-xs' onclick='alertmsg()' >Not Completed</a>
								<?php } else{ ?>
								<a class='btn btn-info btn-xs' data-toggle='modal' data-target='#myModal5_bei' onclick='mytest_details_bei(<?php echo $beh_instrument['assess_test_id'];?>,<?php echo $assessment_id;?>,<?php echo $ass_detail_casestudies['beh_inst_id'];?>,<?php echo $employee_id;?>,"<?php echo $beh_asstype;?>",<?php echo $ass_detail_casestudies['instrument_id'];?>);'> View</a>
								<?php } ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<?php } 
				}?>
				
			</div>
			<div class='table-responsive'>
				<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
					<thead>
						<tr>
							<th rowspan='2' style="width:20%">Assessor Methods</th>
							<th colspan='6' scope='colgroup' align='center' style="width:70%">Assessed Names</th>
						</tr>
						<tr>
						<?php 
						foreach($ass_info as $ass_infos){
						?>
							<th scope='col'><?php echo $ass_infos['assessor_name'];?></th>
							
						<?php 
						} ?>
							<th style="width:20%">OverAll Average</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$rresults=$rassessor=array();
						foreach($ass_info_rating as $ass_info_ratings){
							$rassessor[]=$ass_info_ratings['assessor_id'];
							$assessor_id=$ass_info_ratings['assessor_id'];
							$ass_id=$ass_info_ratings['assessment_type'];
							$attempt=$ass_info_ratings['attempt_id'];
							$req_scale_id=$ass_info_ratings['scale_id'];
							$rresults[$attempt]['attempt_id']=$ass_info_ratings['attempt_id'];
							$rresults[$attempt][$assessor_id]['ass_id']=$ass_info_ratings['assessor_id'];
							$rresults[$attempt][$assessor_id]['assessment_type']=$ass_info_ratings['assessment_type'];
							$rresults[$attempt][$assessor_id]['ass_name']=$ass_info_ratings['assessment_type'];
							$rresults[$attempt][$assessor_id]['assessment_id']=$ass_info_ratings['assessment_id'];
							$rresults[$attempt][$assessor_id]['position_id']=$ass_info_ratings['position_id'];
							$rresults[$attempt][$assessor_id]['employee_id']=$ass_info_ratings['employee_id'];
							$rresults[$attempt][$assessor_id]['scale_id']=$ass_info_ratings['scale_id'];
							$rresults[$attempt][$assessor_id]['rating_name_scale']=$ass_info_ratings['rating_name_scale'];
							$rresults[$attempt][$assessor_id]['rating_number']=$ass_info_ratings['rating_number'];
							
						}
						
						?>
						<?php 
						/* echo "<pre>";
						print_r($rresults); */
						foreach($rresults as $comp_def_id=>$rresult){$scale_val=0;
							
							$att_id=$rresult['attempt_id'];
							?>
							<tr>
							<?php
							$i=0;
							foreach($ass_info as $ass_infos){
								
								$assid=$ass_infos['ass_id'];
								if($i==0){ 
								if(isset($rresult[$assid]['assessment_type'])){
								?>
								<td><?php echo @$rresult[$assid]['assessment_type']; ?></td>
								<?php 
								
									
								
								$i++;}
								} 
							}
							foreach($ass_info as $ass_infos){
								$assid=$ass_infos['ass_id'];
								$scale_val+=isset($rresult[$assid]['rating_number'])?$rresult[$assid]['rating_number']:0;
							?>
								<td><?php echo isset($rresult[$assid]['rating_name_scale'])?!empty($rresult[$assid]['rating_name_scale'])?$rresult[$assid]['rating_name_scale']:"":""; ?></td>
								
							<?php }
							?>

							<td><?php echo ($scale_val/count($ass_info)); ?></td>
							</tr>
							<?php
							
							
						}
						
						?>
					</tbody>
				</table>
			</div>
		</div>
		
	</div>
</div>
</div>
<?php
if(count($ass_info)>0){
foreach($ass_info as $ass_infos){
	?>
<div id="assessorview<?php echo $ass_infos['ass_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header">
				<h6 class="modal-title">Assessor Summary Information </h6>
			</div>
			<div class="modal-body">
				<div id="assessorviewdetails<?php echo $ass_infos['ass_id']; ?>" class="modal-body no-padding">
				
				</div>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<?php 
}
}
?>

<div class="modal fade" id="myModal5_bei" tabindex="-1" role="dialog"  aria-hidden="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header">
				<h4 class="modal-title">BEHAVORIAL INSTRUMENT</h4>
			</div>
			<div class="modal-body">
				<div id="testdiv_bei"></div>

			</div>
			
		</div>
	</div>
</div>
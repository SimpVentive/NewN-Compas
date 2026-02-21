
<div class='col-md-12'>
	<div class="font-bold m-b-sm">
		Final Summary Sheet of <?php echo $employee_name['full_name']; ?>
	</div>
	<div class='panel panel-default card-view'>
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
							<th style="width:40%">Competency name</th>
							<th style="width:20%">Required Level</th>
							<th style="width:20%">Assessed Level</th>
							<th style="width:20%">Admin Assessed Level </th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$results=$assessor=array();
					foreach($ass_comp_info as $ass_comp_infos){
						$assessor[]=$ass_comp_infos['final_admin_id'];
						$assessor_id=$ass_comp_infos['final_admin_id'];
						$comp_id=$ass_comp_infos['comp_def_id'];
						$req_scale_id=$ass_comp_infos['req_scale_id'];
						$results[$comp_id]['comp_name']=$ass_comp_infos['comp_def_name'];
						$results[$comp_id]['req_scale_id']=$ass_comp_infos['req_scale_id'];
						$results[$comp_id]['req_scale_name']=$ass_comp_infos['req_scale_name'];
						$results[$comp_id]['assessment_id']=$ass_comp_infos['assessment_id'];
						$results[$comp_id]['position_id']=$ass_comp_infos['position_id'];
						$results[$comp_id]['employee_id']=$ass_comp_infos['employee_id'];
						$results[$comp_id]['assessed_scale']=$ass_comp_infos['final_scaled_name'];
						$results[$comp_id][$assessor_id]['overall_id']=$ass_comp_infos['final_scaled_id'];
						$results[$comp_id][$assessor_id]['overall_name']=$ass_comp_infos['final_scaled_name'];
						
					}
					//print_r($results);
					foreach($results as $comp_def_id=>$result){
						$final_admin_id=$_SESSION['user_id'];
						$ass_comp=UlsSelfAssessmentReport::getadminselfassessment_competencies_insert($result['assessment_id'],$result['position_id'],$result['employee_id'],$final_admin_id,$comp_def_id);
					?>
						<tr>
							<td>
								<input type="hidden" name="competency[]" value="<?php echo $comp_def_id;?>" >
								<?php echo $result['comp_name']; ?>
							</td>
							<td>
								<input type="hidden" name="requiredlevel_<?php echo $comp_def_id;?>" value="<?php echo $result['req_scale_id'];?>" >
								<?php echo $result['req_scale_name']; ?>
							</td>
							<td><?php echo $result['assessed_scale']; ?></td>
							<td>
							<?php $data="";
							$data="
							<select name='OVERALL_".$comp_def_id."' id='OVERALL_".$comp_def_id."' class='validate[required] form-control m-b' style='width:120px;'>
							<option value=''>Select</option>";
							$level_id=UlsCompetencyDefinition::viewcompetency($comp_def_id);
							$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
							foreach($scale_overall as $scales){
								$final_scale=!empty($ass_comp['admin_assessed_scale_id'])?$ass_comp['admin_assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
								$data.="<option value='".$scales['scale_id']."' ".$final_scale.">".$scales['scale_name']."</option>";
							}
							$data.="</select>";
							echo $data; ?>
							</td>
							
						</tr>
					<?php
						
					}
					?>
					</tbody>
				</table>
				<div class="text-left m-t-xs">
				   <button class="btn btn-primary " type="button" name="summary_info_submit" id="summary_info_submit"><i class="fa fa-check"></i> Submit</button>
				</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
